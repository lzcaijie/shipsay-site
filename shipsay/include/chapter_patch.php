<?php
/**
 * ShipSay CMS 4.2 - Chapter Patch (兜底补章/短章补全)
 *
 * 目的：
 * - 主章节（主 txt / 主章节表）永远优先；
 * - 只有在“缺章/短章（默认<100字）”时，才会：
 *   1) 读取本库补丁表（{$dbarr['pre']}article_chapter_patch）
 *   2) 若无有效补丁，则调用 Hub 获取候选来源，再调用来源站点的 chapter_get 拉取正文
 *   3) 写入本库补丁表（不改主章节表）
 *
 * 设计要点：
 * - 总控（Hub）尽量低读写：Hub 只读 sources 列表；sources 结果本地文件缓存
 * - 兜底写入只发生在用户/蜘蛛访问触发时（且有节流/过期控制）
 * - 资源站后期采集补全后会自动回归主章节（因为主章节优先）
 *
 * MODLOG:
 * - 2026-02-12 by jie cai: 初版（方案B：写补丁表，不动主表）
 * - 2026-02-27 by jie cai: Hub sources 支持 pool_no(=redisdb) + discover=1（索引缺失时按需发现并回写索引）
 */

if (!defined('__ROOT_DIR__')) { exit; }

$chapter_patch_enable = 1;                       // 1=启用；0=关闭
$chapter_patch_min_len = 100;                    // 触发兜底阈值（去空白后字符数）
$chapter_patch_expire = 7 * 86400;               // 补丁有效期（秒）
$chapter_patch_source_limit = 3;                 // 最多尝试来源数
$chapter_patch_http_timeout = 4;                 // 远端请求超时（秒）
$chapter_patch_hub_url = 'https://zongkong.112book.com/panel/api/novel_hub.php'; // Hub sources 接口
$chapter_patch_cache_ttl = 86400;                // sources 缓存（秒）
$chapter_patch_fail_cooldown_base = 300;         // 失败冷却基准（秒）：首次失败后等待多久再尝试远端
$chapter_patch_fail_cooldown_max = 3600;         // 失败冷却上限（秒）
$chapter_patch_fail_ttl = 2 * 86400;            // 失败状态文件保留（秒，防止 _bak 堆积）
$chapter_patch_insecure_ssl = 0;                 // 1=关闭 SSL 校验（不建议）
$chapter_patch_log = __ROOT_DIR__ . '/shipsay/configs/_bak/chapter_patch.log';   // 可选日志

// 可选覆盖：/shipsay/configs/chapter_patch.php
$chapter_patch_cfg = __ROOT_DIR__ . '/shipsay/configs/chapter_patch.php';
if (is_file($chapter_patch_cfg)) { include $chapter_patch_cfg; }

function ss_cp_log($msg){
  global $chapter_patch_log;
  if (empty($chapter_patch_log)) return;
  @file_put_contents($chapter_patch_log, '['.date('Y-m-d H:i:s').'] '.$msg."\n", FILE_APPEND);
}

function ss_cp_norm($s){
  $s = (string)$s;
  $s = trim($s);
  $s = preg_replace('/\s+/u', '', $s);
  $s = mb_strtolower($s, 'UTF-8');
  return $s;
}

function ss_cp_fp($articlename, $author){
  return md5(ss_cp_norm($articlename).'|'.ss_cp_norm($author));
}

function ss_cp_pool_no(){
  // 约定：pool_no=redisdb（0-15），用于 Hub 按库池返回 sources（同库多站共享/跨库隔离）
  $pn = 0;
  if (isset($GLOBALS['config']) && is_array($GLOBALS['config'])) {
    if (isset($GLOBALS['config']['redisdb'])) $pn = (int)$GLOBALS['config']['redisdb'];
  }
  if (isset($GLOBALS['redisdb'])) $pn = (int)$GLOBALS['redisdb'];
  if ($pn < 0) $pn = 0;
  if ($pn > 15) $pn = 15;
  return $pn;
}


function ss_cp_strlen_trim($s){
  $s = (string)$s;
  // 去掉所有空白（包含全角空格/换行/tab）
  $s2 = preg_replace('/\s+/u', '', $s);
  if (function_exists('mb_strlen')) return (int)mb_strlen($s2, 'UTF-8');
  return (int)strlen($s2);
}

function ss_cp_is_short($content, $min_len){
  $min_len = (int)$min_len;
  if ($min_len <= 0) $min_len = 100;
  if ($content === null) return true;
  if ((string)$content === '') return true;
  $n = ss_cp_strlen_trim($content);
  return $n < $min_len;
}

function ss_cp_db(){
  global $dbarr;
  static $mysqli = null;
  if ($mysqli instanceof mysqli) return $mysqli;

  $host = (string)($dbarr['host'] ?? '127.0.0.1');
  $port = (int)($dbarr['port'] ?? 3306);
  if ($port <= 0) $port = 3306;
  $user = (string)($dbarr['user'] ?? '');
  $pass = (string)($dbarr['pass'] ?? '');
  $name = (string)($dbarr['name'] ?? '');

  mysqli_report(MYSQLI_REPORT_OFF);
  $mysqli = @new mysqli($host, $user, $pass, $name, $port);
  if ($mysqli->connect_errno) {
    ss_cp_log('db_connect_failed: '.$mysqli->connect_error);
    $mysqli = null;
    return null;
  }
  @$mysqli->set_charset('utf8mb4');
  return $mysqli;
}

function ss_cp_patch_table(){
  global $dbarr;
  $pre = (string)($dbarr['pre'] ?? 'shipsay_');
  return $pre.'article_chapter_patch';
}

function ss_cp_patch_get($articleid, $chapterorder){
  $db = ss_cp_db();
  if (!$db) return null;
  $tbl = ss_cp_patch_table();
  $now = time();

  $sql = "SELECT content, content_len, expire_at FROM `{$tbl}` WHERE articleid=? AND chapterorder=? AND (expire_at=0 OR expire_at>?) LIMIT 1";
  $st = @$db->prepare($sql);
  if (!$st) return null;
  $st->bind_param('iii', $articleid, $chapterorder, $now);
  if (!$st->execute()) { $st->close(); return null; }
  $res = $st->get_result();
  $row = $res ? $res->fetch_assoc() : null;
  $st->close();
  if (!$row) return null;

  // hit 计数（失败也不影响主流程）
  $u = @$db->prepare("UPDATE `{$tbl}` SET hit_count=hit_count+1, last_hit=? WHERE articleid=? AND chapterorder=?");
  if ($u) {
    $u->bind_param('iii', $now, $articleid, $chapterorder);
    @$u->execute();
    $u->close();
  }

  return (string)($row['content'] ?? '');
}

function ss_cp_patch_save($params){
  global $chapter_patch_expire;
  $db = ss_cp_db();
  if (!$db) return false;
  $tbl = ss_cp_patch_table();

  $now = time();
  $expire = (int)$chapter_patch_expire;
  if ($expire < 3600) $expire = 7 * 86400;
  $expire_at = $now + $expire;

  $articleid = (int)($params['articleid'] ?? 0);
  $chapterorder = (int)($params['chapterorder'] ?? 0);
  $fp = (string)($params['fp'] ?? '');
  $chaptername = (string)($params['chaptername'] ?? '');
  $content = (string)($params['content'] ?? '');
  $content_len = (int)($params['content_len'] ?? 0);
  $content_hash = (string)($params['content_hash'] ?? '');
  $source_site_id = (int)($params['source_site_id'] ?? 0);
  $source_base_url = (string)($params['source_base_url'] ?? '');
  $source_articleid = (int)($params['source_articleid'] ?? 0);
  $fetched_at = (int)($params['fetched_at'] ?? $now);

  if ($articleid<=0 || $chapterorder<0 || $content==='') return false;
  if ($fp==='') $fp = md5($articleid.'|'.$chapterorder);
  if ($content_hash==='') $content_hash = sha1($content);
  if ($content_len<=0) $content_len = ss_cp_strlen_trim($content);

  $sql = "INSERT INTO `{$tbl}` (articleid,chapterorder,fp,chaptername,content,content_len,content_hash,source_site_id,source_base_url,source_articleid,fetched_at,updated_at,expire_at,hit_count,last_hit)
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,0,0)
          ON DUPLICATE KEY UPDATE
            fp=VALUES(fp),
            chaptername=VALUES(chaptername),
            content=VALUES(content),
            content_len=VALUES(content_len),
            content_hash=VALUES(content_hash),
            source_site_id=VALUES(source_site_id),
            source_base_url=VALUES(source_base_url),
            source_articleid=VALUES(source_articleid),
            fetched_at=VALUES(fetched_at),
            updated_at=VALUES(updated_at),
            expire_at=VALUES(expire_at)";
  $st = @$db->prepare($sql);
  if (!$st) return false;

  $st->bind_param(
    'iisssisisiiii',
    $articleid,$chapterorder,$fp,$chaptername,$content,$content_len,$content_hash,$source_site_id,$source_base_url,$source_articleid,$fetched_at,$now,$expire_at
  );
  $ok = @$st->execute();
  $st->close();
  return (bool)$ok;
}

function ss_cp_http_post_json($url, $data, $headers = [], $timeout = 4, $insecure_ssl = 0){
  $body = json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
  if ($body === false) $body = '{}';

  $h = [
    'Content-Type: application/json; charset=utf-8',
    'Content-Length: '.strlen($body),
  ];
  foreach ($headers as $x) $h[] = $x;

  $opts = [
    'http' => [
      'method' => 'POST',
      'header' => implode("\r\n", $h),
      'content' => $body,
      'timeout' => (int)$timeout,
      'ignore_errors' => true,
    ],
  ];
  if (stripos($url, 'https://') === 0) {
    $opts['ssl'] = [
      'verify_peer' => $insecure_ssl ? false : true,
      'verify_peer_name' => $insecure_ssl ? false : true,
    ];
  }
  $ctx = stream_context_create($opts);
  $ret = @file_get_contents($url, false, $ctx);
  $code = 0;
  if (isset($http_response_header) && is_array($http_response_header)) {
    foreach ($http_response_header as $line) {
      if (preg_match('~^HTTP/\S+\s+(\d+)~', $line, $m)) { $code = (int)$m[1]; break; }
    }
  }
  return [$ret, $code];
}

function ss_cp_sign_headers($raw_json, $secret){
  $secret = (string)$secret;
  if ($secret==='') return [];
  $ts = time();
  $nonce = bin2hex(random_bytes(8));
  $body_hash = hash('sha256', (string)$raw_json);
  $base = "POST\n/api/site_sync.php\n{$ts}\n{$nonce}\n{$body_hash}";
  $sign = hash_hmac('sha256', $base, $secret);
  return [
    'X-SS-TS: '.$ts,
    'X-SS-NONCE: '.$nonce,
    'X-SS-SIGN: '.$sign,
  ];
}

function ss_cp_fail_file($articleid, $chapterorder){
  $dir = __ROOT_DIR__.'/shipsay/configs/_bak';
  if (!is_dir($dir)) @mkdir($dir, 0755, true);
  return $dir.'/chapter_patch_fail_'.(int)$articleid.'_'.(int)$chapterorder.'.json';
}

function ss_cp_fail_state_get($articleid, $chapterorder){
  global $chapter_patch_fail_ttl;
  $file = ss_cp_fail_file($articleid, $chapterorder);
  if (!is_file($file)) return null;

  $ttl = (int)$chapter_patch_fail_ttl;
  if ($ttl < 3600) $ttl = 2 * 86400;

  $age = time() - (int)@filemtime($file);
  if ($age > $ttl) { @unlink($file); return null; }

  $txt = @file_get_contents($file);
  $j = json_decode((string)$txt, true);
  return is_array($j) ? $j : null;
}

function ss_cp_fail_allowed($articleid, $chapterorder){
  $st = ss_cp_fail_state_get($articleid, $chapterorder);
  if (!$st) return true;
  $next = (int)($st['next_try'] ?? 0);
  if ($next > 0 && time() < $next) return false;
  return true;
}

function ss_cp_fail_record($articleid, $chapterorder, $error = ''){
  global $chapter_patch_fail_cooldown_base, $chapter_patch_fail_cooldown_max;
  $articleid = (int)$articleid;
  $chapterorder = (int)$chapterorder;
  if ($articleid<=0 || $chapterorder<0) return;

  $now = time();
  $st = ss_cp_fail_state_get($articleid, $chapterorder);
  $fail = (int)($st['fail_count'] ?? 0);
  $fail++;

  $base = (int)$chapter_patch_fail_cooldown_base;
  if ($base < 30) $base = 300;
  $max = (int)$chapter_patch_fail_cooldown_max;
  if ($max < $base) $max = 3600;

  // 指数退避：base * 2^(fail-1)，封顶 max
  $wait = $base * (1 << min($fail-1, 10));
  if ($wait > $max) $wait = $max;

  $next_try = $now + $wait;

  $file = ss_cp_fail_file($articleid, $chapterorder);
  $payload = [
    'articleid' => $articleid,
    'chapterorder' => $chapterorder,
    'fail_count' => $fail,
    'last_try' => $now,
    'next_try' => $next_try,
    'last_error' => (string)$error,
  ];
  @file_put_contents($file, json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
}

function ss_cp_fail_clear($articleid, $chapterorder){
  $file = ss_cp_fail_file($articleid, $chapterorder);
  if (is_file($file)) @unlink($file);
}

/**
 * 读取/拉取正文（主库缺章/短章才会调用）
 *
 * @return string 正文；失败返回 ''
 */
function ss_cp_get_or_fetch($articleid, $chapterorder, $articlename, $author, $chaptername = ''){
  global $chapter_patch_enable, $chapter_patch_min_len, $chapter_patch_source_limit, $chapter_patch_http_timeout,
         $chapter_patch_hub_url, $chapter_patch_cache_ttl, $chapter_patch_insecure_ssl;

  if (empty($chapter_patch_enable)) return '';
  $articleid = (int)$articleid;
  $chapterorder = (int)$chapterorder;
  if ($articleid<=0 || $chapterorder<0) return '';

  // 1) 优先读补丁表
  $patch = ss_cp_patch_get($articleid, $chapterorder);
  if (!ss_cp_is_short($patch, $chapter_patch_min_len)) {
    ss_cp_fail_clear($articleid, $chapterorder);
    return $patch;
  }

  // 2) 调 Hub sources（本地缓存）
  $fp = ss_cp_fp($articlename, $author);
  $pool_no = ss_cp_pool_no();
  $sources = ss_cp_get_sources_cached($fp, $pool_no, $articlename, $author);
  if (empty($sources)) return '';

  // 2.5) 失败冷却：短时间内反复失败时，避免把来源站点打满
  if (!ss_cp_fail_allowed($articleid, $chapterorder)) return '';

  // 3) 依次拉取来源站点章节
  $limit = (int)$chapter_patch_source_limit;
  if ($limit<1) $limit = 3;
  if ($limit>20) $limit = 20;
  $sources = array_slice($sources, 0, $limit);

  // 读本地 site_sync_secret（用于签名；若来源站点允许 IP 白名单，也可不签）
  $secret = '';
  $cfg = __ROOT_DIR__.'/shipsay/configs/site_sync.php';
  if (is_file($cfg)) {
    // 避免污染同名变量：include 前先备份
    $site_sync_secret = null;
    include $cfg;
    if (!empty($site_sync_secret)) $secret = (string)$site_sync_secret;
  }

  foreach ($sources as $src){
    $base_url = (string)($src['base_url'] ?? '');
    if ($base_url==='') continue;
    $api = rtrim($base_url, '/').'/api/site_sync.php';

    $payload = [
      'chapter_get' => 1,
      'articlename' => (string)$articlename,
      'author' => (string)$author,
      'chapterorder' => $chapterorder,
      'min_len' => (int)$chapter_patch_min_len,
    ];
    $raw = json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    if ($raw === false) $raw = '{}';
    $hdrs = ss_cp_sign_headers($raw, $secret);

    [$ret, $code] = ss_cp_http_post_json($api, $payload, $hdrs, $chapter_patch_http_timeout, $chapter_patch_insecure_ssl);
    if ($code !== 200 || !$ret) continue;

    $j = json_decode((string)$ret, true);
    if (!is_array($j) || empty($j['ok'])) continue;

    $content = (string)($j['content'] ?? '');
    if (ss_cp_is_short($content, $chapter_patch_min_len)) continue;

    // 保存补丁
    ss_cp_patch_save([
      'articleid' => $articleid,
      'chapterorder' => $chapterorder,
      'fp' => $fp,
      'chaptername' => (string)($chaptername ?: ($j['chapter']['chaptername'] ?? '')),
      'content' => $content,
      'content_len' => ss_cp_strlen_trim($content),
      'content_hash' => sha1($content),
      'source_site_id' => (int)($src['site_id'] ?? 0),
      'source_base_url' => (string)($src['base_url'] ?? ''),
      'source_articleid' => (int)($src['articleid'] ?? 0),
      'fetched_at' => time(),
    ]);

    ss_cp_fail_clear($articleid, $chapterorder);
    return $content;
  }

  ss_cp_fail_record($articleid, $chapterorder, 'all_sources_failed');
  return '';
}

function ss_cp_sources_cache_file($fp, $pool_no){
  $dir = __ROOT_DIR__.'/shipsay/configs/_bak';
  if (!is_dir($dir)) @mkdir($dir, 0755, true);
  $pn = (int)$pool_no;
  if ($pn < 0) $pn = 0;
  if ($pn > 15) $pn = 15;
  return $dir.'/hub_sources_p'.$pn.'_'.$fp.'.json';
}


function ss_cp_get_sources_cached($fp, $pool_no, $articlename = '', $author = ''){
  global $chapter_patch_hub_url, $chapter_patch_cache_ttl, $chapter_patch_insecure_ssl;
  $fp = (string)$fp;
  if ($fp==='') return [];

  $pn = (int)$pool_no;
  if ($pn < 0) $pn = 0;
  if ($pn > 15) $pn = 15;

  $file = ss_cp_sources_cache_file($fp, $pn);
  $ttl = (int)$chapter_patch_cache_ttl;
  if ($ttl < 60) $ttl = 86400;

  if (is_file($file)) {
    $age = time() - (int)@filemtime($file);
    if ($age >= 0 && $age < $ttl) {
      $txt = @file_get_contents($file);
      $j = json_decode((string)$txt, true);
      if (is_array($j) && isset($j['sources']) && is_array($j['sources'])) return $j['sources'];
    }
  }

  // 调 Hub（支持 pool_no 过滤；支持 discover=1：索引缺失时按需远程发现并回写索引）
  $payload = ['mode'=>'sources','fp'=>$fp,'limit'=>20];
  if ($pn > 0) $payload['pool_no'] = $pn;
  $articlename = (string)$articlename;
  $author = (string)$author;
  if ($articlename !== '' && $author !== '') {
    $payload['articlename'] = $articlename;
    $payload['author'] = $author;
    $payload['discover'] = 1;
  }

  [$ret, $code] = ss_cp_http_post_json((string)$chapter_patch_hub_url, $payload, [], 4, $chapter_patch_insecure_ssl);
  if ($code !== 200 || !$ret) return [];
  $j = json_decode((string)$ret, true);
  if (!is_array($j) || empty($j['ok']) || empty($j['sources']) || !is_array($j['sources'])) return [];

  @file_put_contents($file, json_encode(['pool_no'=>$pn,'sources'=>$j['sources'],'saved_at'=>time()], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
  return $j['sources'];
}

