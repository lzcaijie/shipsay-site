<?php
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Forbidden');
}

define('__ROOT_DIR__', str_replace('\\', '/', dirname(dirname(__DIR__))));
include_once __ROOT_DIR__ . '/shipsay/configs/config.ini.php';

require_once __ROOT_DIR__ . '/shipsay/class/Page.php';
require_once __ROOT_DIR__ . '/shipsay/class/Db.php';
require_once __ROOT_DIR__ . '/shipsay/class/Text.php';

if (!empty($authcode)) $dbarr['host'] = $authcode;

$dbarr = array_merge([
    'pre' => $sys_ver < 5 ? 'jieqi_' : 'shipsay_',
    'words' => $sys_ver < 2.4 ? 'size' : 'words',
    'is_multiple' => $is_multiple,
    'sortarr' => isset($sortarr) ? $sortarr : [],
], $dbarr);

$db = new Db($dbarr);

$LIMIT = 30;
$DEBUG = 0;

global $argv;
if (is_array($argv)) {
    foreach ($argv as $a) {
        if (strpos($a, '--limit=') === 0) {
            $LIMIT = intval(substr($a, 8));
        } elseif ($a === '--debug') {
            $DEBUG = 1;
        }
    }
}
if ($LIMIT <= 0) $LIMIT = 30;

$pre = $dbarr['pre'];
$task_table    = $pre . 'article_langtail_task';
$lang_table    = $pre . 'article_langtail';
$article_table = $pre . 'article_article';

$run_log   = __DIR__ . '/langtail_cron_run.log';
$debug_log = __DIR__ . '/langtail_cron_debug.log';

function ss_log_line($file, $msg)
{
    @file_put_contents($file, '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n", FILE_APPEND);
}

function ss_addslashes($s)
{
    return str_replace(["\\", "\0", "\n", "\r", "'", '"', "\x1a"], ["\\\\", "\\0", "\\n", "\\r", "\\'", '\\"', "\\Z"], $s);
}

function ss_baidu_suggest($keyword_utf8, &$http_code, &$errno, &$err, &$raw_snip)
{
    $http_code = 0;
    $errno = 0;
    $err = '';
    $raw_snip = '';

    $kw = trim($keyword_utf8);
    if ($kw === '') return [[], ''];

    // 百度接口：返回一般是 GBK（你已经用 iconv 验证）
    $url = 'https://suggestion.baidu.com/su?wd=' . rawurlencode($kw) . '&cb=cb';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_ENCODING, ''); // 支持 gzip
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 35);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

    $body = curl_exec($ch);
    $errno = curl_errno($ch);
    $err = curl_error($ch);
    $http_code = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
    curl_close($ch);

    if ($body === false || $errno) return [[], $url];
    if ($http_code !== 200) {
        $raw_snip = substr($body, 0, 200);
        return [[], $url];
    }

    // 转 UTF-8（你站里 Text::ss_toutf8 应该是 iconv 的封装）
    $body_utf8 = Text::ss_toutf8($body);
    $raw_snip = substr($body_utf8, 0, 200);

    // 解析 s:[...]
    if (!preg_match('/s:\\s*\\[(.*?)\\]/is', $body_utf8, $m)) {
        return [[], $url];
    }

    $json = '[' . $m[1] . ']';
    $arr = json_decode($json, true);

    if (!is_array($arr)) {
        $tmp = trim($m[1]);
        $tmp = trim($tmp, " \t\n\r\0\x0B\"");
        if ($tmp === '') return [[], $url];
        $arr = explode('","', $tmp);
    }

    $out = [];
    $seen = [];
    foreach ($arr as $v) {
        $v = trim($v);
        if ($v === '') continue;
        if (isset($seen[$v])) continue;
        $seen[$v] = 1;
        $out[] = $v;
        if (count($out) >= 30) break;
    }

    return [$out, $url];
}

$now = time();

// ① 回收卡死的“处理中”任务（防止 status=2 永久挂死）
// 这里设置：30分钟没更新就认为卡死
$stale_sec = 1800;
$db->ss_query("UPDATE {$task_table}
               SET status=0
               WHERE status=2 AND last_try>0 AND last_try < " . ($now - $stale_sec));

// ② 拉取待执行任务：status=0 且 next_try 到期
$sql = "SELECT id,sourceid,attempts
        FROM {$task_table}
        WHERE status=0 AND next_try <= {$now}
        ORDER BY id ASC
        LIMIT {$LIMIT}";
$res = $db->ss_query($sql);

$tasks = [];
if ($res && $res->num_rows) {
    while ($row = mysqli_fetch_assoc($res)) {
        $tasks[] = $row;
    }
}

if (!$tasks) {
    ss_log_line($run_log, "DONE no task due");
    exit(0);
}

foreach ($tasks as $t) {
    $id = intval($t['id']);
    $sourceid = intval($t['sourceid']);
    $attempts = intval($t['attempts']);
    $now = time();

    // ③ 抢锁：把 status=0 → status=2（处理中），避免并发重复跑
    $db->ss_query("UPDATE {$task_table}
                   SET status=2, attempts=attempts+1, last_try={$now}, updated_at={$now}
                   WHERE id={$id} AND status=0");

    // 兜底判断：没抢到锁就跳过
    $st = $db->ss_getone("SELECT status FROM {$task_table} WHERE id={$id} LIMIT 1");
    if (!isset($st['status']) || intval($st['status']) !== 2) {
        continue;
    }

    // 拉书名
    $row = $db->ss_getone("SELECT articlename FROM {$article_table} WHERE articleid={$sourceid} LIMIT 1");
    $sourcename = isset($row['articlename']) ? trim($row['articlename']) : '';
    if ($sourcename === '') {
        $retry = 3600;
        $db->ss_query("UPDATE {$task_table}
                       SET status=0, next_try=" . ($now + $retry) . ", updated_at={$now}
                       WHERE id={$id}");
        if ($DEBUG) ss_log_line($debug_log, "NO_BOOKNAME id={$id} sourceid={$sourceid}");
        continue;
    }

    $http_code = 0; $errno = 0; $err = ''; $snip = '';
    list($suggests, $url) = ss_baidu_suggest($sourcename, $http_code, $errno, $err, $snip);

    if (!$suggests) {
        $attempts2 = $attempts + 1;

        if ($attempts2 >= 10) {
               $clean_after = 180 * 24 * 3600;
               $db->ss_query("UPDATE {$task_table}
               SET status=9, attempts=0, next_try=" . ($now + $clean_after) . ", updated_at={$now}
               WHERE id={$id}");
        } else {
            $retry = 3600;
            $db->ss_query("UPDATE {$task_table}
                           SET status=0, next_try=" . ($now + $retry) . ", updated_at={$now}
                           WHERE id={$id}");
        }

        if ($DEBUG) {
            ss_log_line($debug_log, "CURL_FAIL id={$id} sourceid={$sourceid} book={$sourcename} http={$http_code} errno={$errno} err={$err} url={$url} snip={$snip}");
        }
        continue;
    }

    // 入库（INSERT IGNORE + (sourceid,langname) 唯一约束 => 不会重复插）
    $uptime = time();
    $sn = ss_addslashes($sourcename);

    $vals = [];
    foreach ($suggests as $v) {
        $v = trim($v);
        if ($v === '') continue;
        $vv = ss_addslashes($v);
        $vals[] = "({$sourceid},'{$vv}','{$sn}',{$uptime})";
        if (count($vals) >= 200) break;
    }

    if (!$vals) {
        $retry = 3600;
        $db->ss_query("UPDATE {$task_table}
                       SET status=0, next_try=" . ($now + $retry) . ", updated_at={$now}
                       WHERE id={$id}");
        if ($DEBUG) ss_log_line($debug_log, "EMPTY_AFTER_CLEAN id={$id} sourceid={$sourceid}");
        continue;
    }

    $ins = "INSERT IGNORE INTO {$lang_table} (sourceid,langname,sourcename,uptime) VALUES " . implode(',', $vals);
    $ok = $db->ss_query($ins);

    if ($ok) {
        // 成功：删除任务（你要的效果）
        $db->ss_query("DELETE FROM {$task_table} WHERE id={$id} LIMIT 1");
        if ($DEBUG) ss_log_line($debug_log, "OK_DEL id={$id} sourceid={$sourceid} n=" . count($vals));
    } else {
        // DB 失败：回到待跑
        $retry = 3600;
        $db->ss_query("UPDATE {$task_table}
                       SET status=0, next_try=" . ($now + $retry) . ", updated_at={$now}
                       WHERE id={$id}");
        if ($DEBUG) ss_log_line($debug_log, "DB_FAIL id={$id} sourceid={$sourceid}");
    }
}

ss_log_line($run_log, "DONE limit={$LIMIT}");
exit(0);
