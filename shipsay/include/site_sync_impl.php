<?php
/**
 * ShipSay CMS - site sync implementation (v6.2)
 * Impl: /shipsay/include/site_sync_impl.php (loaded by /www/api/site_sync.php)
 */
header('Content-Type: application/json; charset=utf-8');

function ss_resp($arr){
  echo json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
  exit;
}

function ss_log_line($path, $line){
  if (!$path) return;
  @file_put_contents($path, '['.date('Y-m-d H:i:s').'] '.$line."\n", FILE_APPEND);
}

function ss_rrmdir($dir){
  if (!is_dir($dir)) return;
  $it = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::CHILD_FIRST
  );
  foreach ($it as $f){
    $p = $f->getPathname();
    if ($f->isDir()) @rmdir($p);
    else @unlink($p);
  }
  @rmdir($dir);
}

function ss_clean_nonce_files($bakdir, $ttl){
  $ttl = (int)$ttl;
  if ($ttl < 60) $ttl = 600;
  $now = time();
  $files = glob($bakdir . '/nonce_*');
  if (!$files) return;
  foreach ($files as $f){
    if (!is_file($f)) continue;
    $age = $now - @filemtime($f);
    if ($age > $ttl * 5) @unlink($f);
  }
}

function ss_clean_old_bundles($bakdir, $keep = 30){
  $keep = (int)$keep;
  if ($keep < 3) $keep = 3;
  $dirs = glob($bakdir . '/bundle_*');
  if (!$dirs) return;
  $dirs = array_values(array_filter($dirs, 'is_dir'));
  if (count($dirs) <= $keep) return;
  rsort($dirs);
  $del = array_slice($dirs, $keep);
  foreach ($del as $d) ss_rrmdir($d);
}


// ----------------- v6：模板分发（themes/<theme>/ + www/static/<theme>/） -----------------

function ss_copydir($src, $dst){
  if (!is_dir($src)) return false;
  if (!is_dir($dst) && !@mkdir($dst, 0755, true)) return false;
  $it = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
  );
  foreach ($it as $f){
    $rel = substr($f->getPathname(), strlen($src));
    $rel = ltrim(str_replace('\\', '/', $rel), '/');
    $to = rtrim($dst, '/').'/'.$rel;
    if ($f->isDir()) {
      if (!is_dir($to)) @mkdir($to, 0755, true);
    } else {
      @mkdir(dirname($to), 0755, true);
      @copy($f->getPathname(), $to);
    }
  }
  return true;
}

function ss_tpl_state_file($bakdir){
  return rtrim($bakdir,'/').'/tpl_current.json';
}

function ss_tpl_load_state($bakdir){
  $f = ss_tpl_state_file($bakdir);
  if (!is_file($f)) return [];
  $j = json_decode((string)@file_get_contents($f), true);
  return is_array($j) ? $j : [];
}

function ss_tpl_save_state($bakdir, $state){
  $f = ss_tpl_state_file($bakdir);
  @mkdir(dirname($f), 0755, true);
  @file_put_contents($f, json_encode($state, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
}

function ss_tpl_list_backups($bakdir){
  $dirs = glob(rtrim($bakdir,'/').'/tpl_bundle_*');
  if (!$dirs) return [];
  $dirs = array_values(array_filter($dirs, 'is_dir'));
  rsort($dirs);
  return $dirs;
}

function ss_tpl_clean_old($bakdir, $keep){
  $keep = (int)$keep;
  if ($keep < 1) $keep = 1;
  if ($keep > 60) $keep = 60;
  $dirs = ss_tpl_list_backups($bakdir);
  if (count($dirs) <= $keep) return;
  $del = array_slice($dirs, $keep);
  foreach ($del as $d) ss_rrmdir($d);
}


// ----------------- v6.1：核心程序状态（只读：core_status） -----------------
function ss_site_sync_meta($ver, $client_ip, $allow_ips, $trust_proxy, $sign_readonly){
  return [
    'ver' => (string)$ver,
    'ip'  => (string)$client_ip,
    'allow_ips_cnt' => is_array($allow_ips) ? count($allow_ips) : 0,
    'trust_proxy_ip' => $trust_proxy ? 1 : 0,
    'sign_readonly' => $sign_readonly ? 1 : 0,
  ];
}

function ss_core_state_file($bakdir){
  return rtrim($bakdir,'/').'/core_current.json';
}
function ss_core_load_state($bakdir){
  $f = ss_core_state_file($bakdir);
  if (!is_file($f)) return [];
  $j = json_decode((string)@file_get_contents($f), true);
  return is_array($j) ? $j : [];
}

function ss_core_save_state($bakdir, $state){
  $f = ss_core_state_file($bakdir);
  @mkdir(dirname($f), 0755, true);
  @file_put_contents($f, json_encode($state, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
}

function ss_core_clean_old($bakdir, $keep){
  $keep = (int)$keep;
  if ($keep < 1) $keep = 1;
  if ($keep > 60) $keep = 60;
  $dirs = ss_core_list_backups($bakdir);
  if (count($dirs) <= $keep) return;
  $del = array_slice($dirs, $keep);
  foreach ($del as $d) ss_rrmdir($d);
}


// ----------------- v6.3：核心策略（core_policy.json） -----------------

function ss_core_policy_file($bakdir){
  return rtrim($bakdir,'/').'/core_policy.json';
}

function ss_core_policy_default(){
  // 默认策略：与 v6.2.2 的核心 skip 逻辑一致
  return [
    'policy_ver' => 1,
    'updated_at' => time(),
    'skip' => [
      'protect_site_sync' => 1,
      'ban_prefix' => [
        'shipsay/configs/',
        'themes/',
        'www/static/',
        'www/caijie/',
        'www/uploads/',
      ],
      'ban_seg' => ['runtime','cache','logs','uploads'],
      'allow_root' => ['shipsay/','www/'],
    ],
  ];
}

function ss_core_policy_normalize($p){
  if (!is_array($p)) $p = [];
  if (empty($p['skip']) || !is_array($p['skip'])) $p['skip'] = [];
  $p['skip']['ban_prefix'] = isset($p['skip']['ban_prefix']) && is_array($p['skip']['ban_prefix']) ? array_values($p['skip']['ban_prefix']) : [];
  $p['skip']['ban_seg'] = isset($p['skip']['ban_seg']) && is_array($p['skip']['ban_seg']) ? array_values($p['skip']['ban_seg']) : [];
  $p['skip']['allow_root'] = isset($p['skip']['allow_root']) && is_array($p['skip']['allow_root']) ? array_values($p['skip']['allow_root']) : ['shipsay/','www/'];
  $p['skip']['ban_prefix'] = array_values(array_filter(array_map('trim', $p['skip']['ban_prefix']), function($v){ return $v!==''; }));
  $p['skip']['ban_seg'] = array_values(array_filter(array_map('trim', $p['skip']['ban_seg']), function($v){ return $v!==''; }));
  $p['skip']['allow_root'] = array_values(array_filter(array_map('trim', $p['skip']['allow_root']), function($v){ return $v!==''; }));
  $p['skip']['ban_prefix'] = array_map(function($v){ return rtrim((string)$v,'/').'/'; }, $p['skip']['ban_prefix']);
  $p['skip']['allow_root'] = array_map(function($v){ return rtrim((string)$v,'/').'/'; }, $p['skip']['allow_root']);
  $p['skip']['protect_site_sync'] = isset($p['skip']['protect_site_sync']) ? (int)$p['skip']['protect_site_sync'] : 1;
  if (empty($p['policy_ver'])) $p['policy_ver'] = 1;
  if (empty($p['updated_at'])) $p['updated_at'] = time();
  return $p;
}

function ss_core_policy_load($bakdir, &$err){
  $err = '';
  $f = ss_core_policy_file($bakdir);
  if (!is_file($f)) return ss_core_policy_default();
  $raw = @file_get_contents($f);
  $j = json_decode((string)$raw, true);
  if (!is_array($j)) { $err = 'bad_json'; return null; }
  if (empty($j['skip']) || !is_array($j['skip'])) { $err = 'bad_policy'; return null; }
  return ss_core_policy_normalize($j);
}

function ss_core_policy_list_backups($bakdir){
  $dirs = glob(rtrim($bakdir,'/').'/core_policy_*');
  if (!$dirs) return [];
  $dirs = array_values(array_filter($dirs, 'is_dir'));
  rsort($dirs);
  return $dirs;
}
function ss_core_policy_clean_old($bakdir, $keep){
  $keep = (int)$keep;
  if ($keep < 1) $keep = 1;
  if ($keep > 60) $keep = 60;
  $dirs = ss_core_policy_list_backups($bakdir);
  if (count($dirs) <= $keep) return;
  $del = array_slice($dirs, $keep);
  foreach ($del as $d) ss_rrmdir($d);
}

function ss_core_policy_summary($bakdir){
  $f = ss_core_policy_file($bakdir);
  $raw = is_file($f) ? (string)@file_get_contents($f) : '';
  $sha1 = $raw !== '' ? (string)sha1($raw) : '';
  $size = (int)strlen($raw);
  $applied_at = is_file($f) ? (int)filemtime($f) : 0;
  $bak = ss_core_policy_list_backups($bakdir);
  return [
    'sha1' => $sha1,
    'size' => $size,
    'applied_at' => $applied_at,
    'backup_count' => count($bak),
    'latest_backup' => ($bak ? basename($bak[0]) : ''),
    'exists' => is_file($f) ? 1 : 0,
  ];
}

function ss_core_policy_write($bakdir, $policy, $keep, &$err){
  $err = '';
  if (!is_array($policy)) { $err = 'bad_policy'; return false; }
  $policy = ss_core_policy_normalize($policy);
  $f = ss_core_policy_file($bakdir);

  // backup old
  if (is_file($f)) {
    $bak_name = 'core_policy_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(5)), 0, 8);
    $bak_dir = rtrim($bakdir,'/').'/'.$bak_name;
    @mkdir($bak_dir, 0755, true);
    @copy($f, $bak_dir . '/core_policy.json');
  }

  $policy['updated_at'] = time();
  $out = json_encode($policy, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
  if ($out === false) { $err = 'encode_failed'; return false; }
  if (@file_put_contents($f, $out) === false) { $err = 'write_failed'; return false; }

  ss_core_policy_clean_old($bakdir, $keep);
  return true;
}


function ss_core_list_backups($bakdir){
  $dirs = glob(rtrim($bakdir,'/').'/core_bundle_*');
  if (!$dirs) return [];
  $dirs = array_values(array_filter($dirs, 'is_dir'));
  rsort($dirs);
  return $dirs;
}


function ss_http_download_to_file($url, $to_file, &$err){
  $err = '';
  $url = (string)$url;
  if ($url === '') { $err='empty_url'; return false; }
  @mkdir(dirname($to_file), 0755, true);

  // 1) allow_url_fopen
  if (ini_get('allow_url_fopen')) {
    $ctx = stream_context_create(['http'=>['timeout'=>30], 'https'=>['timeout'=>30]]);
    $in = @fopen($url, 'rb', false, $ctx);
    if ($in) {
      $out = @fopen($to_file, 'wb');
      if (!$out) { @fclose($in); $err='open_to_file_failed'; return false; }
      stream_copy_to_stream($in, $out);
      @fclose($in); @fclose($out);
      return is_file($to_file) && filesize($to_file) > 0;
    }
  }

  // 2) curl fallback
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    $fp = @fopen($to_file, 'wb');
    if (!$fp) { $err='open_to_file_failed'; return false; }
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $ok = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $ce = curl_error($ch);
    curl_close($ch);
    @fclose($fp);

    if (!$ok || $code >= 400) {
      $err = 'curl_fail:'.$code.($ce?(':'.$ce):'');
      return false;
    }
    return is_file($to_file) && filesize($to_file) > 0;
  }

  $err = 'download_failed';
  return false;
}

function ss_tpl_extract_tar($tar_gz, $dest, &$err){
  $err = '';
  @mkdir($dest, 0755, true);

  // 优先：系统 tar（更稳，支持 .tar.gz）
  if (function_exists('shell_exec') && !in_array('shell_exec', array_map('trim', explode(',', (string)ini_get('disable_functions'))), true)) {
    $cmd = 'tar -xzf '.escapeshellarg($tar_gz).' -C '.escapeshellarg($dest).' 2>&1';
    $out = @shell_exec($cmd);
    if (is_dir($dest) && count(glob($dest.'/*'))>0) return true;
    $err = 'tar_extract_failed'.($out?(':'.trim($out)):'');
  } else {
    $err = 'shell_exec_disabled';
  }
  return false;
}

function ss_tpl_locate_root($extract_dir, $theme){
  $extract_dir = rtrim($extract_dir,'/');
  $cands = [$extract_dir];

  // 若只有一个顶级目录，允许多一层
  $tops = glob($extract_dir.'/*');
  $tops = $tops ? array_values(array_filter($tops, 'is_dir')) : [];
  if (count($tops) === 1) $cands[] = $tops[0];

  foreach ($cands as $base) {
    $t1 = $base.'/themes/'.$theme;
    $s1 = $base.'/www/static/'.$theme;
    if (is_dir($t1) && is_dir($s1)) return $base;
  }
  return '';
}

function ss_tpl_diff_count($src_dir, $dst_dir){
  $n_new=0; $n_over=0;
  if (!is_dir($src_dir)) return [$n_new,$n_over];
  $it = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($src_dir, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
  );
  foreach ($it as $f){
    if ($f->isDir()) continue;
    $rel = substr($f->getPathname(), strlen($src_dir));
    $rel = ltrim(str_replace('\\','/',$rel),'/');
    $to = rtrim($dst_dir,'/').'/'.$rel;
    if (is_file($to)) $n_over++;
    else $n_new++;
  }
  return [$n_new,$n_over];
}


function ss_php_sq($s){
  $s = (string)$s;
  $s = str_replace('\\', '/', $s); // 与后台一致：root_dir 统一 /
  $s = str_replace(['\\', "'"], ['\\\\', "\\'"], $s);
  return $s;
}

function ss_mask_snapshot($snap){
  if (!is_array($snap)) return $snap;
  $out = $snap;
  if (!empty($out['config']) && is_array($out['config'])) {
    if (isset($out['config']['dbpass'])) $out['config']['dbpass'] = '***';
    if (isset($out['config']['db_pass'])) $out['config']['db_pass'] = '***';
  }
  return $out;
}

function ss_get_client_ip($trust_proxy){
  $ip = $_SERVER['REMOTE_ADDR'] ?? '';
  if ($trust_proxy) {
    $xff = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
    if ($xff) {
      $parts = array_map('trim', explode(',', $xff));
      if (!empty($parts[0])) $ip = $parts[0];
    }
  }
  return (string)$ip;
}

function ss_is_empty($v){
  return $v === '' || $v === null;
}

function ss_tristate_keep($v){
  return is_numeric($v) && (int)$v === -1;
}

function ss_extract_sortarr_src($config_file){
  if (!is_file($config_file)) return '';
  $txt = @file_get_contents($config_file);
  if ($txt === false) return '';
  if (preg_match('~//\s*分类设置\s*\R(.*?)\R\s*//\s*redis缓存设置~su', $txt, $m)) {
    return trim($m[1]);
  }
  return '';
}

function ss_load_override($override_file){
  $site_name = null; $theme_dir = null; $kw_pack_id = null; $enable_protect = null;
  if (is_file($override_file)) {
    include $override_file;
  }
  return [
    'site_name' => $site_name,
    'theme_dir' => $theme_dir,
    'kw_pack_id' => $kw_pack_id,
    'enable_protect' => $enable_protect,
  ];
}

function ss_load_config_ini($root){
  if (!defined('__ROOT_DIR__')) define('__ROOT_DIR__', $root);
  $file = $root . '/shipsay/configs/config.ini.php';

  // defaults
  $dbarr = ['host'=>'','port'=>'3306','name'=>'','user'=>'','pass'=>'','pconnect'=>0];
  $authcode = '';
  $sys_ver = '';
  $root_dir = '';
  $txt_url = '';
  $txt_get_mode = 1;
  $remote_img_url = '';
  $local_img = 0;
  $is_attachment = 0;
  $att_url = '';
  $site_url = '';
  $use_js = 1;
  $use_gzip = 1;
  $enable_down = 0;
  $is_ft = 0;

  $theme_dir = '';
  $is_3in1 = 0;
  $commend_ids = '';
  $category_per_page = 20;
  $readpage_split_mode = 0;
  $readpage_split_lines = 800;
  $vote_perday = 3;
  $count_visit = 0;

  $fake_info_url = '';
  $fake_chapter_url = '';
  $use_orderid = '0';
  $fake_sort_url = '';
  $fake_top = '';
  $fake_recentread = '';
  $fake_indexlist = '';
  $per_indexlist = 0;

  $sortarr = [];

  $use_redis = 0;
  $redisarr = ['host'=>'','port'=>'6379','db'=>'0','pass'=>''];
  $home_cache_time = 1200;
  $info_cache_time = 7200;
  $category_cache_time = 3600;
  $cache_time = 1800;

  $is_multiple = 0;
  $ss_newid = '$id';
  $ss_sourceid = '$id';

  $is_langtail = 0;
  $langtail_catch_cycle = 180;
  $langtail_cache_time = 2592000;
  $fake_langtail_info = '';
  $fake_langtail_indexlist = '';

  $is_keywords = 0;
  $keywords_num = 5;

  if (is_file($file)) {
    include $file;
  }

  $sitename = defined('SITE_NAME') ? SITE_NAME : '';

  $sortarr_src = ss_extract_sortarr_src($file);
  if ($sortarr_src === '' && !empty($sortarr) && is_array($sortarr)) {
    // fallback: 由数组重建
    $lines = [];
    foreach ($sortarr as $id=>$it) {
      if (!is_array($it)) continue;
      $code = $it['code'] ?? '';
      $cap = $it['caption'] ?? '';
      $lines[] = "\$sortarr[".(int)$id."] = ['code' => '".ss_php_sq($code)."', 'caption' => '".ss_php_sq($cap)."'];";
    }
    $sortarr_src = implode("\n", $lines);
  }

  return [
    'sitename' => $sitename,
    'dbhost' => (string)($dbarr['host'] ?? ''),
    'dbport' => (string)($dbarr['port'] ?? '3306'),
    'dbname' => (string)($dbarr['name'] ?? ($dbarr['dbname'] ?? '')),
    'dbuser' => (string)($dbarr['user'] ?? ''),
    'dbpass' => (string)($dbarr['pass'] ?? ''),
    'db_pconnect' => (int)($dbarr['pconnect'] ?? 0),

    'authcode' => (string)$authcode,
    'sys_ver' => (string)$sys_ver,
    'root_dir' => (string)$root_dir,
    'txt_url' => (string)$txt_url,
    'txt_get_mode' => (int)$txt_get_mode,
    'remote_img_url' => (string)$remote_img_url,
    'local_img' => (int)$local_img,
    'is_attachment' => (int)$is_attachment,
    'att_url' => (string)$att_url,
    'site_url' => (string)$site_url,
    'use_js' => (int)$use_js,
    'use_gzip' => (int)$use_gzip,
    'enable_down' => (int)$enable_down,
    'is_ft' => (int)$is_ft,

    'theme_dir' => (string)$theme_dir,
    'is_3in1' => (int)$is_3in1,
    'commend_ids' => (string)$commend_ids,
    'category_per_page' => (int)$category_per_page,
    'readpage_split_mode' => (int)$readpage_split_mode,
    'readpage_split_lines' => (int)$readpage_split_lines,
    'vote_perday' => (int)$vote_perday,
    'count_visit' => (int)$count_visit,

    'fake_info_url' => (string)$fake_info_url,
    'fake_chapter_url' => (string)$fake_chapter_url,
    'use_orderid' => (string)$use_orderid,
    'fake_sort_url' => (string)$fake_sort_url,
    'fake_top' => (string)$fake_top,
    'fake_recentread' => (string)$fake_recentread,
    'fake_indexlist' => (string)$fake_indexlist,
    'per_indexlist' => (int)$per_indexlist,

    'sortarr' => (string)$sortarr_src,

    'use_redis' => (int)$use_redis,
    'redishost' => (string)($redisarr['host'] ?? ''),
    'redisport' => (string)($redisarr['port'] ?? ''),
    'redisdb' => (string)($redisarr['db'] ?? ''),
    'redispass' => (string)($redisarr['pass'] ?? ''),
    'home_cache_time' => (int)$home_cache_time,
    'info_cache_time' => (int)$info_cache_time,
    'category_cache_time' => (int)$category_cache_time,
    'cache_time' => (int)$cache_time,

    'is_multiple' => (int)$is_multiple,
    'ss_newid' => (string)$ss_newid,
    'ss_sourceid' => (string)$ss_sourceid,

    'is_langtail' => (int)$is_langtail,
    'langtail_catch_cycle' => (int)$langtail_catch_cycle,
    'langtail_cache_time' => (int)$langtail_cache_time,
    'fake_langtail_info' => (string)$fake_langtail_info,
    'fake_langtail_indexlist' => (string)$fake_langtail_indexlist,

    'is_keywords' => (int)$is_keywords,
    'keywords_num' => (int)$keywords_num,
  ];
}

function ss_load_filter($file){
  $ShipSayFilter = ['is_filter'=>0,'filter_ini'=>''];
  if (is_file($file)) include $file;
  return [
    'is_filter' => (int)($ShipSayFilter['is_filter'] ?? 0),
    'filter_ini' => (string)trim((string)($ShipSayFilter['filter_ini'] ?? ''), "\r\n"),
  ];
}

function ss_load_link($file){
  $ShipSayLink = ['is_link'=>0,'link_ini'=>''];
  if (is_file($file)) include $file;
  return [
    'is_link' => (int)($ShipSayLink['is_link'] ?? 0),
    'link_ini' => (string)trim((string)($ShipSayLink['link_ini'] ?? ''), "\r\n"),
  ];
}

function ss_load_report($file){
  $ShipSayReport = ['on'=>false,'delay'=>30];
  if (is_file($file)) include $file;
  return [
    'report_on' => !empty($ShipSayReport['on']) ? 1 : 0,
    'report_delay' => (int)($ShipSayReport['delay'] ?? 30),
  ];
}

function ss_load_search($file){
  $ShipSaySearch = ['delay'=>5,'limit'=>50,'min_words'=>2,'cache_time'=>86400,'is_record'=>0];
  if (is_file($file)) include $file;
  return [
    'delay' => (int)($ShipSaySearch['delay'] ?? 5),
    'limit' => (int)($ShipSaySearch['limit'] ?? 50),
    'min_words' => (int)($ShipSaySearch['min_words'] ?? 2),
    'cache_time' => (int)($ShipSaySearch['cache_time'] ?? 86400),
    'is_record' => (int)($ShipSaySearch['is_record'] ?? 0),
  ];
}

function ss_load_count($file){
  $count = [];
  if (is_file($file)) include $file;
  $c1 = $count[1] ?? ['enable'=>0,'html'=>''];
  $c2 = $count[2] ?? ['enable'=>0,'html'=>''];
  $c3 = $count[3] ?? ['enable'=>0,'html'=>''];
  return [
    'count1_enable' => (int)($c1['enable'] ?? 0),
    'count1_html' => (string)($c1['html'] ?? ''),
    // 内部保留（回写时需要）
    '_count2_enable' => (int)($c2['enable'] ?? 0),
    '_count2_html' => (string)($c2['html'] ?? ''),
    '_count3_enable' => (int)($c3['enable'] ?? 0),
    '_count3_html' => (string)($c3['html'] ?? ''),
  ];
}

function ss_effective_snapshot($root){
  $cfg = ss_load_config_ini($root);
  $override_file = $root . '/shipsay/configs/override_pre.php';
$sync_cfg_file = $root . '/shipsay/configs/site_sync.php';
  $ov = ss_load_override($override_file);

  // override_pre 优先（仅覆盖明确给出的字段）
  if (!ss_is_empty($ov['site_name'])) $cfg['sitename'] = (string)$ov['site_name'];
  if (!ss_is_empty($ov['theme_dir'])) $cfg['theme_dir'] = (string)$ov['theme_dir'];

  $snap = [
    'config' => $cfg,
    'override' => [
      'site_name' => (string)($ov['site_name'] ?? ''),
      'theme_dir' => (string)($ov['theme_dir'] ?? ''),
      'kw_pack_id' => (int)($ov['kw_pack_id'] ?? 0),
      'enable_protect' => (int)($ov['enable_protect'] ?? 0),
    ],
    'filter' => ss_load_filter($root . '/shipsay/configs/filter.ini.php'),
    'link' => ss_load_link($root . '/shipsay/configs/link.ini.php'),
    'count' => ss_load_count($root . '/shipsay/configs/count.ini.php'),
    'report' => ss_load_report($root . '/shipsay/configs/report.ini.php'),
    'search' => ss_load_search($root . '/shipsay/configs/search.ini.php'),
  ];
  return $snap;
}

function ss_patch_has_db($patch){
  if (empty($patch['config']) || !is_array($patch['config'])) return false;
  $keys = ['dbhost','dbport','dbname','dbuser','dbpass','db_pconnect'];
  foreach ($keys as $k){
    if (array_key_exists($k, $patch['config'])) return true;
  }
  return false;
}

function ss_test_db($cfg){
  $h = (string)($cfg['dbhost'] ?? '');
  $port = (int)($cfg['dbport'] ?? 0);
  $dbn = (string)($cfg['dbname'] ?? '');
  $u = (string)($cfg['dbuser'] ?? '');
  $p = (string)($cfg['dbpass'] ?? '');
  if ($h==='' || $port<=0 || $dbn==='' || $u==='') {
    return [false, 'db_fields_incomplete'];
  }
  if (!function_exists('mysqli_init')) return [false, 'no_mysqli'];
  $mysqli = @mysqli_init();
  if (!$mysqli) return [false, 'mysqli_init_fail'];
  @mysqli_options($mysqli, MYSQLI_OPT_CONNECT_TIMEOUT, 3);
  $ok = @mysqli_real_connect($mysqli, $h, $u, $p, $dbn, $port);
  if (!$ok) {
    $e = @mysqli_connect_error();
    @mysqli_close($mysqli);
    return [false, 'db_connect_failed:'.$e];
  }
  @mysqli_close($mysqli);
  return [true, 'ok'];
}

function ss_merge_section(&$base, $patch, $toggles = []){
  if (!is_array($patch)) return;
  foreach ($patch as $k=>$v){
    if (!is_string($k)) continue;

    // 三态开关：-1=保持
    if (in_array($k, $toggles, true) && ss_tristate_keep($v)) {
      continue;
    }

    // 空值不下发
    if (ss_is_empty($v)) {
      continue;
    }

    $base[$k] = $v;
  }
}

function ss_render_config_ini($cfg){
  // 与 /www/caijie/savecfgs.php do=base 的拼接结构对齐
  $sortarr_src = (string)($cfg['sortarr'] ?? '');
  $sortarr_src = trim($sortarr_src);

  $ss_newid_expr = trim((string)($cfg['ss_newid'] ?? '$id'));
  $ss_sourceid_expr = trim((string)($cfg['ss_sourceid'] ?? '$id'));

  $tmp_readpage_split_mode = isset($cfg['readpage_split_mode']) ? (int)$cfg['readpage_split_mode'] : 0;

  $saveStr = "<?php if (!defined('__ROOT_DIR__')) exit;\r\n";
  $saveStr .= "error_reporting(0);\r\n";
  $saveStr .= "date_default_timezone_set('Asia/ChongQing');\r\n";
  $saveStr .= "include_once __ROOT_DIR__ . '/shipsay/version.php';\r\n";
  $saveStr .= "define('SITE_NAME', '".ss_php_sq($cfg['sitename'] ?? '')."');\r\n";
  $saveStr .= "\$dbarr = [\r\n";
  $saveStr .= "     'host' => '".ss_php_sq($cfg['dbhost'] ?? '')."'\r\n";
  $saveStr .= "    ,'port' => '".ss_php_sq($cfg['dbport'] ?? '')."'\r\n";
  $saveStr .= "    ,'name' => '".ss_php_sq($cfg['dbname'] ?? '')."'\r\n";
  $saveStr .= "    ,'user' => '".ss_php_sq($cfg['dbuser'] ?? '')."'\r\n";
  $saveStr .= "    ,'pass' => '".ss_php_sq($cfg['dbpass'] ?? '')."'\r\n";
  $saveStr .= "    ,'pconnect' => ".(int)($cfg['db_pconnect'] ?? 0)."\r\n";
  $saveStr .= "];\r\n";
  $saveStr .= "\$authcode = '".ss_php_sq($cfg['authcode'] ?? '')."';\r\n\r\n";

  $saveStr .= "\$sys_ver = '".ss_php_sq($cfg['sys_ver'] ?? '')."';\r\n";
  $saveStr .= "\$root_dir = '".ss_php_sq($cfg['root_dir'] ?? '')."';\r\n";
  $saveStr .= "\$txt_url = '".ss_php_sq($cfg['txt_url'] ?? '')."';              \r\n";
  $saveStr .= "\$txt_get_mode = ".(int)($cfg['txt_get_mode'] ?? 1).";              \r\n";
  $saveStr .= "\$remote_img_url = '".ss_php_sq($cfg['remote_img_url'] ?? '')."';\r\n";
  $saveStr .= "\$local_img = ".(int)($cfg['local_img'] ?? 0).";            \r\n";
  $saveStr .= "\$is_attachment = ".(int)($cfg['is_attachment'] ?? 0).";    \r\n";
  $saveStr .= "\$att_url = '".ss_php_sq($cfg['att_url'] ?? '')."';              \r\n";
  $saveStr .= "\$site_url = '".ss_php_sq($cfg['site_url'] ?? '')."';\r\n";
  $saveStr .= "\$use_js = ".(int)($cfg['use_js'] ?? 1).";\r\n";
  $saveStr .= "\$use_gzip = ".(int)($cfg['use_gzip'] ?? 1).";\r\n";
  $saveStr .= "\$enable_down = ".(int)($cfg['enable_down'] ?? 0).";\r\n";
  $saveStr .= "\$is_ft = ".(int)($cfg['is_ft'] ?? 0)."; \r\n\r\n";

  $saveStr .= "\$theme_dir = '".ss_php_sq($cfg['theme_dir'] ?? '')."';\r\n";
  $saveStr .= "\$is_3in1 = ".(int)($cfg['is_3in1'] ?? 0).";\r\n";
  $saveStr .= "\$commend_ids = '".ss_php_sq($cfg['commend_ids'] ?? '')."';\r\n";
  $saveStr .= "\$category_per_page = ".(int)($cfg['category_per_page'] ?? 20).";\r\n";
  $saveStr .= "\$readpage_split_mode = ".$tmp_readpage_split_mode.";\r\n";
  $saveStr .= "\$readpage_split_lines = ".(int)($cfg['readpage_split_lines'] ?? 800).";\r\n";
  $saveStr .= "\$vote_perday = ".(int)($cfg['vote_perday'] ?? 3).";\r\n";
  $saveStr .= "\$count_visit = ".(int)($cfg['count_visit'] ?? 0).";\r\n\r\n";

  $saveStr .= "\$fake_info_url = '".ss_php_sq($cfg['fake_info_url'] ?? '')."';      \r\n";
  $saveStr .= "\$fake_chapter_url = '".ss_php_sq($cfg['fake_chapter_url'] ?? '')."';\r\n";
  $saveStr .= "\$use_orderid = '".ss_php_sq($cfg['use_orderid'] ?? '0')."';\r\n";
  $saveStr .= "\$fake_sort_url = '".ss_php_sq($cfg['fake_sort_url'] ?? '')."';      \r\n";
  $saveStr .= "\$fake_top = '".ss_php_sq($cfg['fake_top'] ?? '')."';        \r\n";
  $saveStr .= "\$fake_recentread = '".ss_php_sq($cfg['fake_recentread'] ?? '')."';\r\n";
  $saveStr .= "\$fake_indexlist = '".ss_php_sq($cfg['fake_indexlist'] ?? '')."';  \r\n";
  $saveStr .= "\$per_indexlist = ".(int)($cfg['per_indexlist'] ?? 0).";\r\n\r\n";

  $saveStr .= "//分类设置\r\n" . $sortarr_src . "\r\n\r\n";

  $saveStr .= "//redis缓存设置\r\n";
  $saveStr .= "\$use_redis = ".(int)($cfg['use_redis'] ?? 0).";\r\n";
  $saveStr .= "\$redisarr = [\r\n";
  $saveStr .= "     'host' => '".ss_php_sq($cfg['redishost'] ?? '')."' \r\n";
  $saveStr .= "    ,'port' => '".ss_php_sq($cfg['redisport'] ?? '')."' \r\n";
  $saveStr .= "    ,'db' => '".ss_php_sq($cfg['redisdb'] ?? '')."'\r\n";
  $saveStr .= "    ,'pass' => '".ss_php_sq($cfg['redispass'] ?? '')."'\r\n";
  $saveStr .= "];\r\n";
  $saveStr .= "\$home_cache_time = ".(int)($cfg['home_cache_time'] ?? 1200).";        \r\n";
  $saveStr .= "\$info_cache_time = ".(int)($cfg['info_cache_time'] ?? 7200).";        \r\n";
  $saveStr .= "\$category_cache_time = ".(int)($cfg['category_cache_time'] ?? 3600).";\r\n";
  $saveStr .= "\$cache_time = ".(int)($cfg['cache_time'] ?? 1800).";                  \r\n\r\n";

  $saveStr .= "//ID混淆\r\n";
  $saveStr .= "\$is_multiple = ".(int)($cfg['is_multiple'] ?? 0).";\r\n";
  $saveStr .= "\$ss_newid = '".ss_php_sq($ss_newid_expr)."';\r\n";
  $saveStr .= "function ss_newid(\$id){\r\n";
  $saveStr .= "    return ".$ss_newid_expr.";\r\n";
  $saveStr .= "}\r\n";
  $saveStr .= "\$ss_sourceid = '".ss_php_sq($ss_sourceid_expr)."';\r\n";
  $saveStr .= "function ss_sourceid(\$id){\r\n";
  $saveStr .= "    return ".$ss_sourceid_expr.";\r\n";
  $saveStr .= "}\r\n\r\n";

  $saveStr .= "\$is_langtail = ".(int)($cfg['is_langtail'] ?? 0).";\r\n";
  $saveStr .= "\$langtail_catch_cycle = ".(int)($cfg['langtail_catch_cycle'] ?? 180).";\r\n";
  $saveStr .= "\$langtail_cache_time = ".(int)($cfg['langtail_cache_time'] ?? 2592000).";\r\n";
  $saveStr .= "\$fake_langtail_info = '".ss_php_sq($cfg['fake_langtail_info'] ?? '')."';\r\n";
  $saveStr .= "\$fake_langtail_indexlist = '".ss_php_sq($cfg['fake_langtail_indexlist'] ?? '')."';\r\n\r\n";

  $saveStr .= "\$is_keywords = ".(int)($cfg['is_keywords'] ?? 0).";\r\n";
  $saveStr .= "\$keywords_num = ".(int)($cfg['keywords_num'] ?? 5).";\r\n";

  return $saveStr;
}

function ss_render_filter_ini($v){
  $ini = (string)($v['filter_ini'] ?? '');
  $ini = str_replace("'", "\\'", $ini);
  $saveStr = "<?php\r\n\$ShipSayFilter['is_filter'] = ".(int)($v['is_filter'] ?? 0)."; \r\n\$ShipSayFilter['filter_ini'] = '\r\n".$ini."\r\n';";
  return $saveStr;
}

function ss_render_link_ini($v){
  $ini = (string)($v['link_ini'] ?? '');
  $ini = str_replace("'", "\\'", $ini);
  $saveStr = "<?php\r\n\$ShipSayLink['is_link'] = ".(int)($v['is_link'] ?? 0)."; \r\n\$ShipSayLink['link_ini'] = ' \r\n".$ini."\r\n';";
  return $saveStr;
}

function ss_render_report_ini($v){
  $on = !empty($v['report_on']) ? 'true' : 'false';
  $delay = (int)($v['report_delay'] ?? 30);
  return "<?php\r\n\$ShipSayReport['on'] = ".$on."; \r\n\$ShipSayReport['delay'] = ".$delay."; \r\n";
}

function ss_render_search_ini($v){
  return "<?php\r\n\r\n\$ShipSaySearch = [\r\n    'delay' => ".(int)($v['delay'] ?? 5)." \r\n    ,'limit' => ".(int)($v['limit'] ?? 50)."\r\n    ,'min_words' => ".(int)($v['min_words'] ?? 2)."\r\n    ,'cache_time' => ".(int)($v['cache_time'] ?? 86400)."\r\n    ,'is_record' => ".(int)($v['is_record'] ?? 0)."\r\n];\r\n";
}

function ss_render_count_ini($cur_count, $patch_count){
  // 只写 count[1]
  $c1_enable = isset($patch_count['count1_enable']) ? (int)$patch_count['count1_enable'] : (int)($cur_count['count1_enable'] ?? 0);
  $c1_html = isset($patch_count['count1_html']) ? (string)$patch_count['count1_html'] : (string)($cur_count['count1_html'] ?? '');

  $c2_enable = (int)($cur_count['_count2_enable'] ?? 0);
  $c2_html = (string)($cur_count['_count2_html'] ?? '');
  $c3_enable = (int)($cur_count['_count3_enable'] ?? 0);
  $c3_html = (string)($cur_count['_count3_html'] ?? '');

  $c1_html = str_replace("'", "\\'", $c1_html);
  $c2_html = str_replace("'", "\\'", $c2_html);
  $c3_html = str_replace("'", "\\'", $c3_html);

  $saveStr = "<?php\r\n\r\n\$count[1] = [\r\n    'enable' => ".$c1_enable.",\r\n    'html' => '".$c1_html."'\r\n];\r\n\$count[2] = [\r\n    'enable' => ".$c2_enable.",\r\n    'html' => '".$c2_html."'\r\n];\r\n\$count[3] = [\r\n    'enable' => ".$c3_enable.",\r\n    'html' => '".$c3_html."'\r\n];\r\n";
  return $saveStr;
}

function ss_render_override_pre($ov){
  $site_name = ss_php_sq($ov['site_name'] ?? '');
  $theme_dir = ss_php_sq($ov['theme_dir'] ?? '');
  $kw = (int)($ov['kw_pack_id'] ?? 0);
  $ep = (int)($ov['enable_protect'] ?? 0);

  $s = "<?php\n";
  $s .= "// generated by site_sync at ".date('Y-m-d H:i:s')."\n\n";
  $s .= "\$site_name = '".$site_name."';\n";
  $s .= "\$theme_dir = '".$theme_dir."';\n";
  $s .= "\$kw_pack_id = ".$kw.";\n";
  $s .= "\$enable_protect = ".$ep.";\n";
  return $s;
}

function ss_write_atomic($path, $content){
  $dir = dirname($path);
  if (!is_dir($dir)) @mkdir($dir, 0755, true);
  $tmp = $path . '.tmp_' . bin2hex(random_bytes(3));
  if (@file_put_contents($tmp, $content) === false) return false;
  return @rename($tmp, $path);
}

function ss_backup_files($root, $bakdir, $files){
  $id = 'bundle_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(3)),0,6);
  $bundle = $bakdir . '/' . $id;
  @mkdir($bundle, 0755, true);

  $manifest = ['id'=>$id,'ts'=>time(),'files'=>[]];
  foreach ($files as $abs){
    if (!is_string($abs) || $abs==='') continue;
    if (!is_file($abs)) continue;
    $rel = ltrim(str_replace($root, '', $abs), '/');
    $dst = $bundle . '/' . $rel;
    $dstdir = dirname($dst);
    if (!is_dir($dstdir)) @mkdir($dstdir, 0755, true);
    if (@copy($abs, $dst)) {
      $manifest['files'][] = $rel;
    }
  }
  @file_put_contents($bundle . '/manifest.json', json_encode($manifest, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
  return $bundle;
}

function ss_find_latest_bundle($bakdir){
  $dirs = glob($bakdir . '/bundle_*');
  if (!$dirs) return '';
  $dirs = array_filter($dirs, 'is_dir');
  if (!$dirs) return '';
  rsort($dirs);
  return $dirs[0];
}

function ss_rollback_bundle($root, $bundle){
  $mfile = $bundle . '/manifest.json';
  $manifest = [];
  if (is_file($mfile)) {
    $manifest = json_decode((string)file_get_contents($mfile), true);
  }
  $files = [];
  if (is_array($manifest) && !empty($manifest['files']) && is_array($manifest['files'])) {
    $files = $manifest['files'];
  } else {
    // fallback: restore all php files in bundle
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($bundle, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f){
      if ($f->isFile()) {
        $rel = ltrim(str_replace($bundle.'/', '', $f->getPathname()), '/');
        if (substr($rel,-4)==='.php') $files[] = $rel;
      }
    }
  }

  foreach ($files as $rel){
    $src = $bundle . '/' . $rel;
    $dst = $root . '/' . $rel;
    if (!is_file($src)) continue;
    $dstdir = dirname($dst);
    if (!is_dir($dstdir)) @mkdir($dstdir, 0755, true);
    @copy($src, $dst);
  }
}


// ----------------- site_sync cfg（allow_ips 等） -----------------
function ss_load_site_sync_cfg($file){
  // 默认值
  $site_sync_enable = 1;
  $site_sync_secret = '';
  $site_sync_allow_ips = [];
  $site_sync_trust_proxy_ip = 0;
  $site_sync_ts_window = 600;
  $site_sync_nonce_ttl = 600;
  $site_sync_log = '';
  $site_sync_sign_readonly = 0;

  if (is_file($file)) include $file;

  $allow = [];
  if (isset($site_sync_allow_ips) && is_array($site_sync_allow_ips)) $allow = $site_sync_allow_ips;
  $allow = array_values(array_filter(array_map('trim', $allow), function($v){
    if ($v==='') return false;
    if (!filter_var($v, FILTER_VALIDATE_IP)) return false;
    return true;
  }));
  // 去重保持顺序
  $seen = []; $allow2 = [];
  foreach ($allow as $ip) {
    if (isset($seen[$ip])) continue;
    $seen[$ip] = 1;
    $allow2[] = $ip;
  }

  return [
    'enable' => (int)($site_sync_enable ?? 0),
    'secret' => (string)($site_sync_secret ?? ''),
    'allow_ips' => $allow2,
    'trust_proxy_ip' => !empty($site_sync_trust_proxy_ip) ? 1 : 0,
    'ts_window' => (int)($site_sync_ts_window ?? 600),
    'nonce_ttl' => (int)($site_sync_nonce_ttl ?? 600),
    'log' => (string)($site_sync_log ?? ''),
    'sign_readonly' => !empty($site_sync_sign_readonly) ? 1 : 0,
  ];
}

function ss_norm_allow_ips($v){
  $ips = [];
  if (is_array($v)) {
    foreach ($v as $ip) {
      if (!is_string($ip) && !is_numeric($ip)) continue;
      $ip = trim((string)$ip);
      if ($ip==='' || !filter_var($ip, FILTER_VALIDATE_IP)) continue;
      $ips[] = $ip;
    }
  } else {
    $raw = trim((string)$v);
    if ($raw !== '') {
      $lines = preg_split('~\R~u', $raw);
      foreach ((array)$lines as $ln) {
        $ln = trim((string)$ln);
        if ($ln==='' || $ln[0]==='#') continue;
        $ln = preg_replace('~\s+#.*$~', '', $ln);
        $ln = trim((string)$ln);
        if ($ln==='' || !filter_var($ln, FILTER_VALIDATE_IP)) continue;
        $ips[] = $ln;
      }
    }
  }
  $seen = []; $out = [];
  foreach ($ips as $ip) {
    if (isset($seen[$ip])) continue;
    $seen[$ip] = 1;
    $out[] = $ip;
  }
  return $out;
}

function ss_render_site_sync_cfg($cur){
  $enable = (int)($cur['enable'] ?? 0);
  $secret = ss_php_sq($cur['secret'] ?? '');
  $trust = (int)($cur['trust_proxy_ip'] ?? 0);
  $tsw = (int)($cur['ts_window'] ?? 600);
  $ntl = (int)($cur['nonce_ttl'] ?? 600);
  $log = ss_php_sq($cur['log'] ?? '');
  $sign_ro = (int)($cur['sign_readonly'] ?? 0);

  $allow = (array)($cur['allow_ips'] ?? []);
  $allow_lines = "";
  foreach ($allow as $ip) {
    $allow_lines .= "  '".ss_php_sq($ip)."',\n";
  }
  if ($allow_lines === "") $allow_lines = "  // 为空：表示不限制（不建议）\n";

  $s = "<?php\n";
  $s .= "// 开关：1=启用\n";
  $s .= "\$site_sync_enable = ".$enable.";\n\n";
  $s .= "// 分站同步密钥：必须与总控面板该站保存的 secret 完全一致（可空）\n";
  $s .= "\$site_sync_secret = '".$secret."';\n\n";
  $s .= "// 允许访问的总控服务器公网IP（allow_ips；每行一个 IP）\n";
  $s .= "\$site_sync_allow_ips = [\n".$allow_lines."];\n\n";
  $s .= "// 是否信任反代头（没走反代就 0；走了 Nginx/CF 反代再改 1）\n";
  $s .= "\$site_sync_trust_proxy_ip = ".$trust.";\n\n";
  $s .= "// 时间窗口（秒）：总控和分站时间差超过这个就拒绝\n";
  $s .= "\$site_sync_ts_window = ".$tsw.";\n\n";
  $s .= "// nonce 过期（秒）：防重放\n";
  $s .= "\$site_sync_nonce_ttl = ".$ntl.";\n\n";
  $s .= "// 只读接口是否也要求签名：0=不验签（仅 allow_ips），1=验签（secret 有值时）\n";
  $s .= "\$site_sync_sign_readonly = ".$sign_ro.";\n\n";
  $s .= "// 可选：分站侧日志\n";
  if ($log !== '') {
    $s .= "\$site_sync_log = '".$log."';\n";
  } else {
    $s .= "\$site_sync_log = __ROOT_DIR__ . '/shipsay/configs/_bak/site_sync.log';\n";
  }
  return $s;
}


// ----------------- bootstrap / security -----------------
$root = defined('__ROOT_DIR__') ? __ROOT_DIR__ : realpath(__DIR__ . '/../..');
if (!$root) ss_resp(['ok'=>0,'error'=>'bad_root']);
if (!defined('__ROOT_DIR__')) define('__ROOT_DIR__', $root);

$sync_cfg = $root . '/shipsay/configs/site_sync.php';
if (!is_file($sync_cfg)) ss_resp(['ok'=>0,'error'=>'no_site_sync_cfg']);
require $sync_cfg;

if (empty($site_sync_enable)) ss_resp(['ok'=>0,'error'=>'disabled']);
// [MODLOG 2026-02-12] secret 可空：兼容历史 v5（建议配 allow_ips；若设置 secret 则走签名校验）
// if (empty($site_sync_secret)) ss_resp(['ok'=>0,'error'=>'empty_secret']);

$trust_proxy = !empty($site_sync_trust_proxy_ip);
$client_ip = ss_get_client_ip($trust_proxy);
$allow_ips = isset($site_sync_allow_ips) && is_array($site_sync_allow_ips) ? $site_sync_allow_ips : [];
$allow_ips = array_values(array_filter(array_map('trim', $allow_ips), function($v){
  if ($v==='') return false;
  if (strpos($v,'你的')!==false) return false;
  return true;
}));
if (!empty($allow_ips) && !in_array($client_ip, $allow_ips, true)) {
  ss_resp(['ok'=>0,'error'=>'bad_ip','ip'=>$client_ip]);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) ss_resp(['ok'=>0,'error'=>'bad_json']);

$bakdir = $root . '/shipsay/configs/_bak';
if (!is_dir($bakdir)) @mkdir($bakdir, 0755, true);

// [MODLOG 2026-02-13] 签名策略：
// - secret 为空：不验签（仅 allow_ips）
// - secret 有值：写接口（apply/rollback）必验签；只读接口（novel_search/chapter_get/pull）默认不验签（可通过 site_sync_sign_readonly=1 强制验签）
$sign_readonly = !empty($site_sync_sign_readonly);
$is_readonly = !empty($data['novel_search']) || !empty($data['chapter_get']) || !empty($data['pull']) || !empty($data['tpl_status']) || !empty($data['core_status']) || !empty($data['core_check_only']);
if (!empty($site_sync_secret) && (!$is_readonly || $sign_readonly)) {
  $ts = $_SERVER['HTTP_X_SS_TS'] ?? '';
  $nonce = $_SERVER['HTTP_X_SS_NONCE'] ?? '';
  $sign = $_SERVER['HTTP_X_SS_SIGN'] ?? '';
  if ($ts==='' || $nonce==='' || $sign==='') ss_resp(['ok'=>0,'error'=>'missing_headers']);
  $ts_i = (int)$ts;
  $ts_window = isset($site_sync_ts_window) ? (int)$site_sync_ts_window : 600;
  if ($ts_window <= 0) $ts_window = 600;
  if ($ts_i<=0 || abs(time()-$ts_i) > $ts_window) ss_resp(['ok'=>0,'error'=>'bad_ts']);

  $body_hash = hash('sha256', $raw);
  $base = "POST\n/api/site_sync.php\n{$ts}\n{$nonce}\n{$body_hash}";
  $good = hash_hmac('sha256', $base, $site_sync_secret);
  if (!hash_equals($good, (string)$sign)) ss_resp(['ok'=>0,'error'=>'bad_sign']);

  // nonce 防重放（文件）
  $nonce_ttl = isset($site_sync_nonce_ttl) ? (int)$site_sync_nonce_ttl : 600;
  if ($nonce_ttl < 60) $nonce_ttl = 600;
  $nonce_file = $bakdir . '/nonce_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', (string)$nonce);
  if (is_file($nonce_file)) {
    $age = time() - filemtime($nonce_file);
    if ($age >= 0 && $age < $nonce_ttl) ss_resp(['ok'=>0,'error'=>'replay_nonce']);
  }
  @file_put_contents($nonce_file, (string)time());
  // 清理过期 nonce 文件（避免 _bak 目录越堆越大）
  ss_clean_nonce_files($bakdir, $nonce_ttl);
}

$log_path = isset($site_sync_log) ? (string)$site_sync_log : '';
$op = 'apply';
if (!empty($data['novel_search'])) $op = 'novel_search';
else if (!empty($data['chapter_get'])) $op = 'chapter_get';
else if (!empty($data['pull'])) $op = 'pull';
else if (!empty($data['tpl_status'])) $op = 'tpl_status';
else if (!empty($data['core_status'])) $op = 'core_status';
else if (!empty($data['core_check_only'])) $op = 'core_check_only';
else if (!empty($data['core_apply'])) $op = 'core_apply';
else if (!empty($data['core_policy_apply'])) $op = 'core_policy_apply';
else if (!empty($data['core_rollback'])) $op = 'core_rollback';
else if (!empty($data['tpl_apply'])) $op = 'tpl_apply';
else if (!empty($data['tpl_rollback'])) $op = 'tpl_rollback';
else if (!empty($data['rollback'])) $op = 'rollback';
ss_log_line($log_path, $client_ip.' '.json_encode(['op'=>$op], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

// ----------------- operations -----------------

// [MODLOG 2026-02-12] Novel search / Chapter get（只读接口：供跨库“能看/能搜”与兜底补章使用）
function ss_novel_pre($sys_ver){
  $v = (float)$sys_ver;
  return $v < 5 ? 'jieqi_' : 'shipsay_';
}
function ss_novel_words_col($sys_ver){
  $v = (float)$sys_ver;
  return $v < 2.4 ? 'size' : 'words';
}
function ss_novel_chapter_table($articleid, $sys_ver, $pre){
  $v = (float)$sys_ver;
  if ($v < 5) return $pre.'article_chapter';
  return $pre.'article_chapter_'.(int)ceil(((int)$articleid)/10000);
}
function ss_novel_db_connect($cfg){
  mysqli_report(MYSQLI_REPORT_OFF);
  $host = (string)($cfg['dbhost'] ?? '127.0.0.1');
  $port = (int)($cfg['dbport'] ?? 3306); if ($port<=0) $port = 3306;
  $user = (string)($cfg['dbuser'] ?? '');
  $pass = (string)($cfg['dbpass'] ?? '');
  $name = (string)($cfg['dbname'] ?? '');
  $db = @new mysqli($host, $user, $pass, $name, $port);
  if ($db->connect_errno) return null;
  @$db->set_charset('utf8mb4');
  return $db;
}

// Novel search：按关键词/作者模糊搜索书（用于总控聚合“能搜”）
if (!empty($data['novel_search'])) {
  $cfg = ss_load_config_ini($root);
  $db = ss_novel_db_connect($cfg);
  if (!$db) ss_resp(['ok'=>0,'error'=>'db_connect_failed']);

  $pre = ss_novel_pre($cfg['sys_ver'] ?? '');
  $words_col = ss_novel_words_col($cfg['sys_ver'] ?? '');

  $q = trim((string)($data['q'] ?? $data['keyword'] ?? $data['kw'] ?? ''));
  $author = trim((string)($data['author'] ?? ''));
  $limit = (int)($data['limit'] ?? 20);
  if ($limit<1) $limit = 20;
  if ($limit>50) $limit = 50;

  if ($q==='') ss_resp(['ok'=>0,'error'=>'empty_keyword']);

  $q_esc = $db->real_escape_string($q);
  $a_esc = $db->real_escape_string($author);

  $where = "(articlename LIKE '%{$q_esc}%' OR author LIKE '%{$q_esc}%')";
  if ($author!=='') $where = "(articlename LIKE '%{$q_esc}%' AND author LIKE '%{$a_esc}%')";

  $sql = "SELECT articleid,articlename,author,lastchapter,lastchapterid,lastupdate,{$words_col} AS words FROM {$pre}article_article
          WHERE display <> 1 AND {$words_col} >= 0 AND {$where}
          ORDER BY lastupdate DESC LIMIT {$limit}";
  $res = $db->query($sql);
  $list = [];
  if ($res && $res->num_rows) {
    while ($row = $res->fetch_assoc()) {
      $list[] = [
        'articleid' => (int)$row['articleid'],
        'articlename' => (string)$row['articlename'],
        'author' => (string)$row['author'],
        'lastchapter' => (string)$row['lastchapter'],
        'lastchapterid' => (int)$row['lastchapterid'],
        'lastupdate' => (string)$row['lastupdate'],
        'words' => (int)$row['words'],
      ];
    }
  }
  $db->close();
  ss_resp(['ok'=>1,'v'=>5,'list'=>$list,'count'=>count($list)]);
}

// Chapter get：按（书名+作者+chapterorder）取正文（用于兜底补章）
if (!empty($data['chapter_get'])) {
  $cfg = ss_load_config_ini($root);
  $db = ss_novel_db_connect($cfg);
  if (!$db) ss_resp(['ok'=>0,'error'=>'db_connect_failed']);

  $pre = ss_novel_pre($cfg['sys_ver'] ?? '');
  $sys_ver = (string)($cfg['sys_ver'] ?? '');
  $txt_url = (string)($cfg['txt_url'] ?? '');

  $articlename = trim((string)($data['articlename'] ?? ''));
  $author = trim((string)($data['author'] ?? ''));
  $chapterorder = (int)($data['chapterorder'] ?? 0);
  $min_len = (int)($data['min_len'] ?? 100);
  if ($min_len<=0) $min_len = 100;

  if ($articlename==='' || $author==='' || $chapterorder<=0 || $txt_url==='') {
    $db->close();
    ss_resp(['ok'=>0,'error'=>'bad_params']);
  }

  $an = $db->real_escape_string($articlename);
  $au = $db->real_escape_string($author);

  // 先精确匹配；再 fallback 为模糊匹配（避免少量编码/空格差异）
  $sql = "SELECT articleid,articlename,author,lastupdate FROM {$pre}article_article
          WHERE display <> 1 AND articlename = '{$an}' AND author = '{$au}'
          ORDER BY lastupdate DESC LIMIT 1";
  $row = null;
  $res = $db->query($sql);
  if ($res && $res->num_rows) $row = $res->fetch_assoc();

  if (!$row) {
    $sql = "SELECT articleid,articlename,author,lastupdate FROM {$pre}article_article
            WHERE display <> 1 AND articlename LIKE '%{$an}%' AND author LIKE '%{$au}%'
            ORDER BY lastupdate DESC LIMIT 1";
    $res = $db->query($sql);
    if ($res && $res->num_rows) $row = $res->fetch_assoc();
  }

  if (!$row) {
    $db->close();
    ss_resp(['ok'=>0,'error'=>'novel_not_found']);
  }

  $aid = (int)$row['articleid'];
  $ctbl = ss_novel_chapter_table($aid, $sys_ver, $pre);

  $sql = "SELECT chapterid,chapterorder,chaptername FROM {$ctbl}
          WHERE articleid = {$aid} AND chaptertype = 0 AND chapterorder = {$chapterorder} LIMIT 1";
  $c = null;
  $res = $db->query($sql);
  if ($res && $res->num_rows) $c = $res->fetch_assoc();
  if (!$c) {
    $db->close();
    ss_resp(['ok'=>0,'error'=>'chapter_not_found']);
  }

  $cid = (int)$c['chapterid'];
  $subaid = (int)($aid/1000);
  $txtfile = rtrim($txt_url,'/').'/'.$subaid.'/'.$aid.'/'.$cid.'.txt';
  $content = @file_get_contents($txtfile);
  if ($content === false) $content = '';

  // 简单判空/短章（不做编码处理，留给调用端 ss_toutf8）
  $content2 = preg_replace('/\s+/u','',(string)$content);
  $len = function_exists('mb_strlen') ? (int)mb_strlen($content2,'UTF-8') : (int)strlen($content2);

  $db->close();

  if ($len < $min_len) {
    ss_resp(['ok'=>0,'error'=>'content_too_short','len'=>$len,'txtfile'=>$txtfile]);
  }

  ss_resp([
    'ok'=>1,
    'v'=>5,
    'article'=>['articleid'=>$aid,'articlename'=>(string)$row['articlename'],'author'=>(string)$row['author']],
    'chapter'=>['chapterid'=>$cid,'chapterorder'=>(int)$c['chapterorder'],'chaptername'=>(string)$c['chaptername']],
    'content'=>$content,
    'len'=>$len,
  ]);
}



// ----------------- v6：模板分发 -----------------

// 仅查看模板状态（只读）：返回当前模板信息与备份数量
if (!empty($data['tpl_status'])) {
  $state = ss_tpl_load_state($bakdir);
  $bak = ss_tpl_list_backups($bakdir);
  ss_resp(['ok'=>1,'v'=>6,'tpl'=>[
    'current'=>$state,
    'backup_count'=>count($bak),
    'latest_backup'=>($bak ? basename($bak[0]) : ''),
  ]]);
}

// 仅查看核心程序状态（只读）：返回当前核心包信息与备份数量
// 说明：core_current.json 由后续 core_apply 写操作维护；未接入时 current 可能为空
if (!empty($data['core_status'])) {
  $state = ss_core_load_state($bakdir);
  $bak = ss_core_list_backups($bakdir);
  $meta = ss_site_sync_meta('6.3.0-impl', $client_ip, $allow_ips, $trust_proxy, $sign_readonly);
  ss_resp([
    'ok'=>1,
    'v'=>63,
    'core'=>[
      'current'=>$state,
      'backup_count'=>count($bak),
      'latest_backup'=>($bak ? basename($bak[0]) : ''),
    ],
    'site_sync'=>$meta,
    'policy'=>ss_core_policy_summary($bakdir),
  ]);
}




// 核心策略下发（写操作）：写入 core_policy.json，并备份旧版本
if (!empty($data['core_policy_apply'])) {
  if (empty($site_sync_secret)) ss_resp(['ok'=>0,'error'=>'core_need_secret']); // 写操作强制签名
  $policy = $data['policy'] ?? null;
  $keep = (int)($data['keep'] ?? 10);
  if ($keep < 1) $keep = 1;
  if ($keep > 60) $keep = 60;

  if (!is_array($policy)) ss_resp(['ok'=>0,'error'=>'bad_policy']);

  $werr = '';
  if (!ss_core_policy_write($bakdir, $policy, $keep, $werr)) {
    ss_resp(['ok'=>0,'error'=>'policy_write_failed','detail'=>$werr ?: 'unknown']);
  }

  $meta = ss_site_sync_meta('6.3.0-impl', $client_ip, $allow_ips, $trust_proxy, $sign_readonly);
  ss_resp([
    'ok'=>1,
    'v'=>63,
    'policy'=>ss_core_policy_summary($bakdir),
    'site_sync'=>$meta,
  ]);
}



// 核心包预演（只读）：下载 bundle → 解压到临时目录 → 统计将新增/覆盖/跳过文件数
function ss_guess_bundle_ext($url, $fallback=''){
  $ext = '';
  $p = parse_url((string)$url, PHP_URL_PATH);
  $p = (string)$p;
  $p = strtolower($p);
  if (preg_match('~\.zip$~', $p)) $ext = 'zip';
  else if (preg_match('~\.tar$~', $p)) $ext = 'tar';
  else if (preg_match('~\.(tar\.gz|tgz)$~', $p)) $ext = 'tar.gz';
  if ($ext === '') $ext = (string)$fallback;
  if (!in_array($ext, ['zip','tar','tar.gz'], true)) $ext = '';
  return $ext;
}

function ss_extract_bundle($archive_file, $ext, $dest_dir, &$err){
  $err = '';
  $archive_file = (string)$archive_file;
  $dest_dir = (string)$dest_dir;
  if (!is_file($archive_file)) { $err='bundle_not_found'; return false; }
  if (!is_dir($dest_dir)) @mkdir($dest_dir, 0755, true);

  if ($ext === 'zip') {
    if (class_exists('ZipArchive')) {
      $zip = new ZipArchive();
      if ($zip->open($archive_file) !== true) { $err='zip_open_failed'; return false; }
      if (!$zip->extractTo($dest_dir)) { $zip->close(); $err='zip_extract_failed'; return false; }
      $zip->close();
      return true;
    }
    $cmd = 'unzip -oq '.escapeshellarg($archive_file).' -d '.escapeshellarg($dest_dir).' 2>&1';
    $out = @shell_exec($cmd);
    if (!is_dir($dest_dir)) { $err='unzip_failed'; return false; }
    return true;
  }

  $flag = ($ext === 'tar.gz') ? 'z' : '';
  $cmd = 'tar -x'.$flag.'f '.escapeshellarg($archive_file).' -C '.escapeshellarg($dest_dir).' 2>&1';
  $out = @shell_exec($cmd);
  if (!is_dir($dest_dir)) { $err='tar_extract_failed'; return false; }
  return true;
}

function ss_locate_extract_root($dir){
  $dir = rtrim((string)$dir, '/');
  if (!is_dir($dir)) return $dir;
  $items = array_values(array_diff(scandir($dir), ['.','..']));
  if (count($items) === 1) {
    $one = $dir . '/' . $items[0];
    if (is_dir($one)) return $one;
  }
  return $dir;
}

function ss_relpath_safe($rel){
  $rel = str_replace('\\', '/', (string)$rel);
  $rel = ltrim($rel, '/');
  if ($rel === '') return false;
  if (strpos($rel, "\0") !== false) return false;
  $parts = explode('/', $rel);
  foreach ($parts as $seg) {
    if ($seg === '' || $seg === '.' || $seg === '..') return false;
  }
  return true;
}

function ss_core_skip_reason($rel, $overwrite_site_sync, $policy, &$is_site_sync){
  $is_site_sync = false;
  $rel = ltrim(str_replace('\\','/', (string)$rel), '/');

  // 默认不允许覆盖 site_sync 壳文件
  if ($rel === 'www/api/site_sync.php') {
    $is_site_sync = true;
    $skip = (is_array($policy) && isset($policy['skip']) && is_array($policy['skip'])) ? $policy['skip'] : [];
    $protect = isset($skip['protect_site_sync']) ? (int)$skip['protect_site_sync'] : 1;
    if ($protect && !(int)$overwrite_site_sync) return 'site_sync';
    return '';
  }

  $skip = (is_array($policy) && isset($policy['skip']) && is_array($policy['skip'])) ? $policy['skip'] : [];

  $ban_prefix = isset($skip['ban_prefix']) && is_array($skip['ban_prefix']) ? $skip['ban_prefix'] : [
    'shipsay/configs/',
    'themes/',
    'www/static/',
    'www/caijie/',
    'www/uploads/',
  ];
  foreach ($ban_prefix as $pre) {
    if (strpos($rel, $pre) === 0) return $pre;
  }

  // 运行时目录：只要命中路径片段就跳过
  $ban_seg = isset($skip['ban_seg']) && is_array($skip['ban_seg']) ? $skip['ban_seg'] : ['runtime','cache','logs','uploads'];
  foreach ($ban_seg as $seg) {
    if (preg_match('~(^|/)'.preg_quote($seg, '~'). '(/|$)~', $rel)) return $seg;
  }

  // 仅允许 allow_root（其余视为无关文件）
  $allow_root = isset($skip['allow_root']) && is_array($skip['allow_root']) ? $skip['allow_root'] : ['shipsay/','www/'];
  $ok_root = false;
  foreach ($allow_root as $r) {
    $r = rtrim((string)$r,'/').'/';
    if ($r!=='' && strpos($rel, $r) === 0) { $ok_root = true; break; }
  }
  if (!$ok_root) return 'outside_root';

  return '';
}

// core_check_only：只读预演（不会写 core_current.json / 不覆盖任何线上文件）
if (!empty($data['core_check_only'])) {
  $core = $data['core'] ?? null;
  if (!is_array($core)) ss_resp(['ok'=>0,'error'=>'bad_core']);

  $bundle_id = trim((string)($core['id'] ?? ''));
  $version = trim((string)($core['version'] ?? ''));
  $sha1 = strtolower(trim((string)($core['sha1'] ?? '')));
  $url = trim((string)($core['url'] ?? ''));
  $ext_in = trim((string)($core['ext'] ?? ''));
  $overwrite_site_sync = (int)($core['overwrite_site_sync'] ?? 0);

  // v6.3：加载核心策略（core_policy.json）
  $perr = '';
  $policy = ss_core_policy_load($bakdir, $perr);
  if (!$policy) ss_resp(['ok'=>0,'error'=>'policy_invalid','detail'=>$perr ?: 'bad_policy']);


  if ($url === '') ss_resp(['ok'=>0,'error'=>'core_url_empty']);

  $ext = ss_guess_bundle_ext($url, $ext_in);
  if ($ext === '') ss_resp(['ok'=>0,'error'=>'core_bad_ext']);

  $tmp = $bakdir . '/core_check_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(6)), 0, 8);
  @mkdir($tmp, 0755, true);
  $bundle_file = $tmp . '/bundle.' . ($ext === 'tar.gz' ? 'tar.gz' : $ext);
  $xdir = $tmp . '/x';

  $err = '';
  if (!ss_http_download_to_file($url, $bundle_file, $err)) {
    ss_rrmdir($tmp);
    ss_resp(['ok'=>0,'error'=>'core_download_failed','detail'=>$err]);
  }

  if ($sha1 !== '') {
    $got = @sha1_file($bundle_file);
    if (!$got || strtolower($got) !== $sha1) {
      ss_rrmdir($tmp);
      ss_resp(['ok'=>0,'error'=>'core_sha1_mismatch','detail'=>($got?:'')]);
    }
  }

  $eerr = '';
  if (!ss_extract_bundle($bundle_file, $ext, $xdir, $eerr)) {
    ss_rrmdir($tmp);
    ss_resp(['ok'=>0,'error'=>'core_extract_failed','detail'=>$eerr]);
  }

  $base = ss_locate_extract_root($xdir);

  $total=0; $add=0; $overwrite=0; $skip=0; $site_sync_files=0;
  $skip_by = [];
  $skip_samples = [];

  $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS));
  foreach ($it as $f) {
    if (!$f->isFile()) continue;
    $abs = $f->getPathname();
    $rel = substr($abs, strlen($base) + 1);
    $rel = str_replace('\\','/',$rel);
    $rel = ltrim($rel, '/');
    if (!ss_relpath_safe($rel)) {
      $skip++;
      $skip_by['unsafe'] = (int)($skip_by['unsafe'] ?? 0) + 1;
      if (count($skip_samples) < 30) $skip_samples[] = $rel;
      continue;
    }

    $total++;

    $is_site_sync = false;
    $why = ss_core_skip_reason($rel, $overwrite_site_sync, $policy, $is_site_sync);
    if ($is_site_sync) $site_sync_files++;

    if ($why !== '') {
      $skip++;
      $skip_by[$why] = (int)($skip_by[$why] ?? 0) + 1;
      if (count($skip_samples) < 30) $skip_samples[] = $rel;
      continue;
    }

    $dest = $root . '/' . $rel;
    if (is_file($dest)) $overwrite++;
    else $add++;
  }

  ss_rrmdir($tmp);

  $meta = ss_site_sync_meta('6.3.0-impl', $client_ip, $allow_ips, $trust_proxy, $sign_readonly);
  ss_resp([
    'ok'=>1,
    'v'=>63,
    'current'=>ss_effective_snapshot($root),
    'core_check'=>[
      'id'=>$bundle_id,
      'version'=>$version,
      'sha1'=>$sha1,
      'ext'=>$ext,
      'overwrite_site_sync'=>$overwrite_site_sync ? 1 : 0,
      'total_files'=>$total,
      'add_files'=>$add,
      'overwrite_files'=>$overwrite,
      'skipped_files'=>$skip,
      'site_sync_files'=>$site_sync_files,
      'skipped_by'=>$skip_by,
      'skipped_samples'=>$skip_samples,
    ],
    'site_sync'=>$meta,
  ]);
}


// 模板应用：下载 bundle（tar.gz）→ 校验 sha1 → 解压 → 备份现有主题目录 → 覆盖 themes/<theme>/ 与 www/static/<theme>/
// v6.2：核心下发（写操作：core_apply）
// - 分站下载 core bundle → 校验 sha1 → 解包 → 备份将被覆盖的文件 → 覆盖写入
// - 永远不覆盖：shipsay/configs/、themes/、www/static/、www/caijie/ 以及 runtime/cache/logs/uploads 等
// - 默认不覆盖：www/api/site_sync.php（除非 overwrite_site_sync=1）
if (!empty($data['core_apply'])) {
  if (empty($site_sync_secret)) ss_resp(['ok'=>0,'error'=>'core_need_secret']); // 写操作强制签名

  $core = $data['core'] ?? null;
  if (!is_array($core)) ss_resp(['ok'=>0,'error'=>'bad_core']);

  $bundle_id = trim((string)($core['id'] ?? ''));
  $version = trim((string)($core['version'] ?? ''));
  $sha1 = strtolower(trim((string)($core['sha1'] ?? '')));
  $url = trim((string)($core['url'] ?? ''));
  $ext_in = trim((string)($core['ext'] ?? ''));
  $overwrite_site_sync = (int)($core['overwrite_site_sync'] ?? 0);

  // v6.3：加载核心策略（core_policy.json）
  $perr = '';
  $policy = ss_core_policy_load($bakdir, $perr);
  if (!$policy) ss_resp(['ok'=>0,'error'=>'policy_invalid','detail'=>$perr ?: 'bad_policy']);

  $keep = (int)($core['keep'] ?? 3);
  if ($keep < 1) $keep = 1;
  if ($keep > 60) $keep = 60;

  if ($url === '') ss_resp(['ok'=>0,'error'=>'bad_url']);

  $ext = ss_guess_bundle_ext($url, $ext_in);
  if (!in_array($ext, ['zip','tar','tar.gz'], true)) ss_resp(['ok'=>0,'error'=>'core_bad_ext']);

  $tmp = $bakdir . '/core_apply_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(6)), 0, 8);
  @mkdir($tmp, 0755, true);
  $bundle_file = $tmp . '/bundle.' . ($ext === 'tar.gz' ? 'tar.gz' : $ext);
  $xdir = $tmp . '/x';

  $err = '';
  if (!ss_http_download_to_file($url, $bundle_file, $err)) {
    ss_rrmdir($tmp);
    ss_resp(['ok'=>0,'error'=>'core_download_failed','detail'=>$err]);
  }

  if ($sha1 !== '') {
    $got = @sha1_file($bundle_file);
    if (!$got || strtolower($got) !== $sha1) {
      ss_rrmdir($tmp);
      ss_resp(['ok'=>0,'error'=>'core_sha1_mismatch','detail'=>($got?:'')]);
    }
  }

  $eerr = '';
  if (!ss_extract_bundle($bundle_file, $ext, $xdir, $eerr)) {
    ss_rrmdir($tmp);
    ss_resp(['ok'=>0,'error'=>'core_extract_failed','detail'=>$eerr]);
  }

  $base = ss_locate_extract_root($xdir);

  // 应用前状态（用于回滚恢复）
  $before = ss_core_load_state($bakdir);

  // 备份目录（只备份会被覆盖的文件 + meta.json）
  $ver_safe = $version !== '' ? preg_replace('~[^a-z0-9_\-\.]+~i', '_', $version) : 'v';
  $bak_name = 'core_bundle_' . date('Ymd_His') . '_' . $ver_safe . '_' . substr(bin2hex(random_bytes(5)), 0, 8);
  $bak = $bakdir . '/' . $bak_name;
  @mkdir($bak, 0755, true);

  $total=0; $add=0; $overwrite=0; $skip=0; $site_sync_files=0;
  $skip_by = [];
  $skip_samples = [];
  $add_files = [];
  $overwrite_files = [];

  $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS));
  foreach ($it as $f) {
    if (!$f->isFile()) continue;

    $src = (string)$f->getPathname();
    $rel = substr($src, strlen($base) + 1);
    $rel = str_replace('\\','/',$rel);
    $rel = ltrim($rel, '/');

    if (!ss_relpath_safe($rel)) {
      $skip++;
      $skip_by['unsafe'] = (int)($skip_by['unsafe'] ?? 0) + 1;
      if (count($skip_samples) < 30) $skip_samples[] = $rel;
      continue;
    }

    $total++;

    $is_site_sync = false;
    $why = ss_core_skip_reason($rel, $overwrite_site_sync, $policy, $is_site_sync);
    if ($is_site_sync) $site_sync_files++;

    if ($why !== '') {
      $skip++;
      $skip_by[$why] = (int)($skip_by[$why] ?? 0) + 1;
      if (count($skip_samples) < 30) $skip_samples[] = $rel;
      continue;
    }

    $dst = $root . '/' . $rel;

    // 备份：仅备份将被覆盖的文件
    if (is_file($dst)) {
      $overwrite++;
      $overwrite_files[] = $rel;
      $bak_dst = $bak . '/' . $rel;
      @mkdir(dirname($bak_dst), 0755, true);
      if (!@copy($dst, $bak_dst)) {
        ss_rrmdir($tmp);
        ss_resp(['ok'=>0,'error'=>'core_backup_failed','file'=>$rel,'bak'=>$bak_name]);
      }
    } else {
      $add++;
      $add_files[] = $rel;
    }

    // 覆盖写入
    @mkdir(dirname($dst), 0755, true);
    if (!@copy($src, $dst)) {
      ss_rrmdir($tmp);
      ss_resp(['ok'=>0,'error'=>'core_write_failed','file'=>$rel]);
    }
  }

  // 记录 meta（供回滚）
  $meta = [
    'created_at' => date('c'),
    'bundle_id' => $bundle_id,
    'version' => $version,
    'sha1' => $sha1,
    'ext' => $ext,
    'overwrite_site_sync' => $overwrite_site_sync ? 1 : 0,
    'before' => $before,
    'add_files' => $add_files,
    'overwrite_files' => $overwrite_files,
    'stat' => [
      'total_files' => $total,
      'add_files' => $add,
      'overwrite_files' => $overwrite,
      'skipped_files' => $skip,
      'site_sync_files' => $site_sync_files,
      'skipped_by' => $skip_by,
    ],
  ];
  @file_put_contents($bak . '/meta.json', json_encode($meta, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));

  // 落盘 core_current.json（正式写入）
  $st = [
    'id' => $bundle_id,
    'version' => $version,
    'sha1' => $sha1,
    'applied_at' => time(),
    'latest_backup' => $bak_name,
  ];
  ss_core_save_state($bakdir, $st);

  // 控量清理
  ss_core_clean_old($bakdir, $keep);

  ss_rrmdir($tmp);

  $meta2 = ss_site_sync_meta('6.3.0-impl', $client_ip, $allow_ips, $trust_proxy, $sign_readonly);
  ss_resp([
    'ok' => 1,
    'v'  => 62,
    'core' => [
      'current' => ss_core_load_state($bakdir),
      'backup_count' => count(ss_core_list_backups($bakdir)),
      'latest_backup' => (string)$bak_name,
      'apply' => [
        'id' => $bundle_id,
        'version' => $version,
        'sha1' => $sha1,
        'ext' => $ext,
        'overwrite_site_sync' => $overwrite_site_sync ? 1 : 0,
        'backup' => (string)$bak_name,
        'total_files' => $total,
        'add_files' => $add,
        'overwrite_files' => $overwrite,
        'skipped_files' => $skip,
        'site_sync_files' => $site_sync_files,
        'skipped_by' => $skip_by,
        'skipped_samples' => array_slice($skip_samples, 0, 30),
        'add_samples' => array_slice($add_files, 0, 20),
        'overwrite_samples' => array_slice($overwrite_files, 0, 20),
      ],
    ],
    'site_sync' => $meta2,
  ]);
}

// v6.2：核心回滚（写操作：core_rollback；回滚到最近一次 core_bundle_* 备份）
if (!empty($data['core_rollback'])) {
  if (empty($site_sync_secret)) ss_resp(['ok'=>0,'error'=>'core_need_secret']); // 写操作强制签名

  $keep = 60;
  if (!empty($data['core']) && is_array($data['core']) && isset($data['core']['keep'])) {
    $keep = (int)$data['core']['keep'];
    if ($keep < 1) $keep = 1;
    if ($keep > 60) $keep = 60;
  }

  $dirs = ss_core_list_backups($bakdir);
  if (!$dirs) ss_resp(['ok'=>0,'error'=>'core_no_backup']);
  $bak = $dirs[0];
  $bak_name = basename($bak);

  $meta_file = $bak . '/meta.json';
  if (!is_file($meta_file)) ss_resp(['ok'=>0,'error'=>'core_backup_incomplete','detail'=>'meta_missing','bak'=>$bak_name]);
  $meta = json_decode((string)@file_get_contents($meta_file), true);
  if (!is_array($meta)) ss_resp(['ok'=>0,'error'=>'core_backup_incomplete','detail'=>'meta_bad_json','bak'=>$bak_name]);

  $add_files = isset($meta['add_files']) && is_array($meta['add_files']) ? $meta['add_files'] : [];
  $overwrite_files = isset($meta['overwrite_files']) && is_array($meta['overwrite_files']) ? $meta['overwrite_files'] : [];
  $before = isset($meta['before']) && is_array($meta['before']) ? $meta['before'] : [];

  // 先恢复被覆盖的文件
  foreach ($overwrite_files as $rel) {
    $rel = (string)$rel;
    if ($rel === '') continue;
    $src = $bak . '/' . $rel;
    $dst = $root . '/' . $rel;
    if (!is_file($src)) continue;
    @mkdir(dirname($dst), 0755, true);
    if (!@copy($src, $dst)) {
      ss_resp(['ok'=>0,'error'=>'core_restore_failed','file'=>$rel,'bak'=>$bak_name]);
    }
  }

  // 再删除新增文件
  foreach ($add_files as $rel) {
    $rel = (string)$rel;
    if ($rel === '') continue;
    $dst = $root . '/' . $rel;
    if (is_file($dst)) @unlink($dst);
  }

  // 恢复 core_current.json 到 before（首次安装可能为空）
  ss_core_save_state($bakdir, $before);

  // 控量清理
  ss_core_clean_old($bakdir, $keep);

  $meta2 = ss_site_sync_meta('6.3.0-impl', $client_ip, $allow_ips, $trust_proxy, $sign_readonly);
  ss_resp([
    'ok' => 1,
    'v'  => 62,
    'core' => [
      'current' => ss_core_load_state($bakdir),
      'backup_count' => count(ss_core_list_backups($bakdir)),
      'latest_backup' => basename((string)($dirs[0] ?? '')),
      'rollback' => [
        'used_backup' => $bak_name,
        'restore_files' => count($overwrite_files),
        'delete_files' => count($add_files),
        'bak_meta' => [
          'bundle_id' => (string)($meta['bundle_id'] ?? ''),
          'version' => (string)($meta['version'] ?? ''),
          'sha1' => (string)($meta['sha1'] ?? ''),
          'created_at' => (string)($meta['created_at'] ?? ''),
        ],
      ],
    ],
    'site_sync' => $meta2,
  ]);
}
if (!empty($data['tpl_apply'])) {
  if (empty($site_sync_secret)) ss_resp(['ok'=>0,'error'=>'tpl_need_secret']); // 写操作强制签名

  $tpl = $data['tpl'] ?? null;
  if (!is_array($tpl)) ss_resp(['ok'=>0,'error'=>'bad_tpl']);

  $theme = trim((string)($tpl['theme'] ?? ''));
  $url = trim((string)($tpl['url'] ?? ''));
  $want_sha1 = strtolower(trim((string)($tpl['sha1'] ?? '')));
  $bundle_id = trim((string)($tpl['id'] ?? ''));
  $version = trim((string)($tpl['version'] ?? ''));
  $keep = (int)($tpl['keep'] ?? 3);
  if ($keep < 1) $keep = 1;
  if ($keep > 30) $keep = 30;

  if ($theme==='' || $url==='') ss_resp(['ok'=>0,'error'=>'tpl_params_missing']);

  $tmp = $bakdir.'/tpl_tmp_'.date('Ymd_His').'_'.mt_rand(1000,9999);
  @mkdir($tmp, 0755, true);

  $tar = $tmp.'/bundle.tar.gz';
  $err = '';
  if (!ss_http_download_to_file($url, $tar, $err)) {
    ss_rrmdir($tmp);
    ss_resp(['ok'=>0,'error'=>'tpl_download_failed','detail'=>$err]);
  }

  if ($want_sha1 !== '' && preg_match('/^[a-f0-9]{40}$/', $want_sha1)) {
    $got = @sha1_file($tar);
    if (!$got || strtolower($got) !== $want_sha1) {
      ss_rrmdir($tmp);
      ss_resp(['ok'=>0,'error'=>'tpl_sha1_mismatch','want'=>$want_sha1,'got'=>$got ?: '']);
    }
  }

  $extract = $tmp.'/x';
  if (!ss_tpl_extract_tar($tar, $extract, $err)) {
    ss_rrmdir($tmp);
    ss_resp(['ok'=>0,'error'=>'tpl_extract_failed','detail'=>$err]);
  }

  $base = ss_tpl_locate_root($extract, $theme);
  if ($base === '') {
    ss_rrmdir($tmp);
    ss_resp(['ok'=>0,'error'=>'tpl_bad_structure','need'=>"themes/{$theme}/ + www/static/{$theme}/"]);
  }

  $src_theme = $base.'/themes/'.$theme;
  $src_static = $base.'/www/static/'.$theme;

  $dst_theme = $root.'/themes/'.$theme;
  $dst_static = $root.'/www/static/'.$theme;

  [$new_t, $over_t] = ss_tpl_diff_count($src_theme, $dst_theme);
  [$new_s, $over_s] = ss_tpl_diff_count($src_static, $dst_static);

  // check_only：不落盘，只返回差异统计
  if (!empty($data['check_only'])) {
    $snap = ss_effective_snapshot($root);
    $snap['site_sync'] = ss_load_site_sync_cfg($sync_cfg);
    $state = ss_tpl_load_state($bakdir);
    ss_rrmdir($tmp);
    ss_resp([
      'ok'=>1,'v'=>6,'check_only'=>1,
      'tpl'=>[
        'bundle_id'=>$bundle_id,'theme'=>$theme,'version'=>$version,
        'new_files'=>($new_t+$new_s),'overwrite_files'=>($over_t+$over_s),
        'themes'=>['new'=>$new_t,'overwrite'=>$over_t],
        'static'=>['new'=>$new_s,'overwrite'=>$over_s],
        'current'=>$state,
      ],
      'current'=>ss_mask_snapshot($snap),
    ]);
  }

  // 备份现有主题目录
  $before = ss_tpl_load_state($bakdir);
  $backup_dir = $bakdir.'/tpl_bundle_'.date('Ymd_His').'_'.$theme.'_'.mt_rand(1000,9999);
  @mkdir($backup_dir, 0755, true);
  if (is_dir($dst_theme)) ss_copydir($dst_theme, $backup_dir.'/themes/'.$theme);
  if (is_dir($dst_static)) ss_copydir($dst_static, $backup_dir.'/www/static/'.$theme);

  $meta = [
    'created_at'=>date('c'),
    'theme'=>$theme,
    'before'=>$before,
    'apply'=>[
      'id'=>$bundle_id,'version'=>$version,'sha1'=>$want_sha1,
      'applied_at'=>time(),
    ],
  ];
  @file_put_contents($backup_dir.'/meta.json', json_encode($meta, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

  // 先 stage，再覆盖（降低失败风险）
  $stage = $bakdir.'/tpl_stage_'.date('Ymd_His').'_'.mt_rand(1000,9999);
  @mkdir($stage, 0755, true);
  ss_copydir($src_theme, $stage.'/themes/'.$theme);
  ss_copydir($src_static, $stage.'/www/static/'.$theme);

  // 覆盖
  if (is_dir($dst_theme)) ss_rrmdir($dst_theme);
  @mkdir(dirname($dst_theme), 0755, true);
  if (!@rename($stage.'/themes/'.$theme, $dst_theme)) {
    ss_copydir($stage.'/themes/'.$theme, $dst_theme);
    ss_rrmdir($stage.'/themes/'.$theme);
  }

  if (is_dir($dst_static)) ss_rrmdir($dst_static);
  @mkdir(dirname($dst_static), 0755, true);
  if (!@rename($stage.'/www/static/'.$theme, $dst_static)) {
    ss_copydir($stage.'/www/static/'.$theme, $dst_static);
    ss_rrmdir($stage.'/www/static/'.$theme);
  }

  ss_rrmdir($stage);
  ss_rrmdir($tmp);

  // 记录当前模板状态 + 清理旧备份
  $state = [
    'id'=>$bundle_id,
    'theme'=>$theme,
    'version'=>$version,
    'sha1'=>$want_sha1,
    'applied_at'=>time(),
    'backup_dir'=>basename($backup_dir),
  ];
  ss_tpl_save_state($bakdir, $state);
  ss_tpl_clean_old($bakdir, $keep);

  $snap = ss_effective_snapshot($root);
  $snap['site_sync'] = ss_load_site_sync_cfg($sync_cfg);
  ss_resp([
    'ok'=>1,'v'=>6,
    'tpl_applied'=>1,
    'tpl'=>[
      'bundle_id'=>$bundle_id,'theme'=>$theme,'version'=>$version,
      'new_files'=>($new_t+$new_s),'overwrite_files'=>($over_t+$over_s),
      'backup_dir'=>basename($backup_dir),
    ],
    'current'=>ss_mask_snapshot($snap),
    'applied'=>ss_mask_snapshot($snap),
  ]);
}

// 模板回滚：回滚到最近一次模板备份
if (!empty($data['tpl_rollback'])) {
  if (empty($site_sync_secret)) ss_resp(['ok'=>0,'error'=>'tpl_need_secret']); // 写操作强制签名

  $bak = ss_tpl_list_backups($bakdir);
  if (!$bak) ss_resp(['ok'=>0,'error'=>'no_tpl_backup']);
  $latest = $bak[0];
  $meta_file = $latest.'/meta.json';
  $meta = is_file($meta_file) ? json_decode((string)@file_get_contents($meta_file), true) : [];
  $theme = (string)($meta['theme'] ?? '');
  if ($theme==='') ss_resp(['ok'=>0,'error'=>'bad_tpl_backup_meta']);

  $src_theme = $latest.'/themes/'.$theme;
  $src_static = $latest.'/www/static/'.$theme;
  if (!is_dir($src_theme) || !is_dir($src_static)) ss_resp(['ok'=>0,'error'=>'tpl_backup_incomplete','used'=>basename($latest)]);

  $dst_theme = $root.'/themes/'.$theme;
  $dst_static = $root.'/www/static/'.$theme;

  if (is_dir($dst_theme)) ss_rrmdir($dst_theme);
  @mkdir(dirname($dst_theme), 0755, true);
  ss_copydir($src_theme, $dst_theme);

  if (is_dir($dst_static)) ss_rrmdir($dst_static);
  @mkdir(dirname($dst_static), 0755, true);
  ss_copydir($src_static, $dst_static);

  $before = (is_array($meta) && isset($meta['before']) && is_array($meta['before'])) ? $meta['before'] : [];
  if ($before) $before['rolled_back_at'] = time();
  ss_tpl_save_state($bakdir, $before);

  $snap = ss_effective_snapshot($root);
  $snap['site_sync'] = ss_load_site_sync_cfg($sync_cfg);
  ss_resp([
    'ok'=>1,'v'=>6,
    'tpl_rollback'=>1,
    'used'=>basename($latest),
    'current'=>ss_mask_snapshot($snap),
    'applied'=>ss_mask_snapshot($snap),
  ]);
}


// Pull
if (!empty($data['pull'])) {
  $snap = ss_effective_snapshot($root);
  $snap['site_sync'] = ss_load_site_sync_cfg($sync_cfg);
  ss_resp(['ok'=>1,'v'=>5,'current'=>ss_mask_snapshot($snap)]);
}

// Rollback
if (!empty($data['rollback'])) {
  $bundle = ss_find_latest_bundle($bakdir);
  if (!$bundle) ss_resp(['ok'=>0,'error'=>'no_bundle_backup']);
  ss_rollback_bundle($root, $bundle);
  $snap = ss_effective_snapshot($root);
  $snap['site_sync'] = ss_load_site_sync_cfg($sync_cfg);
  ss_resp(['ok'=>1,'v'=>5,'rollback'=>1,'used'=>$bundle,'current'=>ss_mask_snapshot($snap),'applied'=>ss_mask_snapshot($snap)]);
}

$check_only = !empty($data['check_only']);

// normalize patch
$patch = [];
if (!empty($data['patch']) && is_array($data['patch'])) {
  $patch = $data['patch'];
} else {
  // 兼容：扁平字段（不建议使用）
  if (!empty($data['config']) && is_array($data['config'])) $patch['config'] = $data['config'];
  if (!empty($data['filter']) && is_array($data['filter'])) $patch['filter'] = $data['filter'];
  if (!empty($data['link']) && is_array($data['link'])) $patch['link'] = $data['link'];
  if (!empty($data['count']) && is_array($data['count'])) $patch['count'] = $data['count'];
  if (!empty($data['report']) && is_array($data['report'])) $patch['report'] = $data['report'];
  if (!empty($data['search']) && is_array($data['search'])) $patch['search'] = $data['search'];
  if (!empty($data['override']) && is_array($data['override'])) $patch['override'] = $data['override'];
}

if (!$patch) {
  ss_resp(['ok'=>1,'v'=>5,'check_only'=>$check_only?1:0,'would_apply'=>[]]);
}

$cur = ss_effective_snapshot($root);
$cur['site_sync'] = ss_load_site_sync_cfg($sync_cfg);
$next = $cur;
$next['site_sync'] = $cur['site_sync'];

// site_sync merge（allow_ips / trust_proxy_ip / sign_readonly）
// 空值不下发；allow_ips 为空数组则忽略
if (!empty($patch['site_sync']) && is_array($patch['site_sync'])) {
  $p = $patch['site_sync'];

  if (array_key_exists('allow_ips', $p)) {
    $ips = ss_norm_allow_ips($p['allow_ips']);
    if (!empty($ips)) $next['site_sync']['allow_ips'] = $ips;
  }

  foreach (['trust_proxy_ip','sign_readonly','enable'] as $k) {
    if (!array_key_exists($k, $p)) continue;
    $v = $p[$k];
    if (ss_tristate_keep($v)) continue;
    if (ss_is_empty($v)) continue;
    $next['site_sync'][$k] = (int)$v ? 1 : 0;
  }

  if (array_key_exists('secret', $p)) {
    $v = (string)$p['secret'];
    // 空值不下发
    if ($v !== '') $next['site_sync']['secret'] = $v;
  }
}


// config merge
$cfg_toggles = ['use_js','use_gzip','enable_down','is_ft','is_3in1','count_visit','local_img','is_attachment','use_redis','is_multiple','is_langtail','is_keywords'];
if (!empty($patch['config']) && is_array($patch['config'])) {
  // dbpass: *** 不修改
  if (isset($patch['config']['dbpass'])) {
    $v = (string)$patch['config']['dbpass'];
    if ($v==='' || $v==='***') unset($patch['config']['dbpass']);
  }
  ss_merge_section($next['config'], $patch['config'], $cfg_toggles);
}

// override merge (kw_pack_id / enable_protect 三态)
if (!empty($patch['override']) && is_array($patch['override'])) {
  foreach (['kw_pack_id','enable_protect'] as $k){
    if (!array_key_exists($k, $patch['override'])) continue;
    $v = $patch['override'][$k];
    if (ss_tristate_keep($v)) continue;
    if (ss_is_empty($v)) continue;
    $next['override'][$k] = (int)$v;
  }
  // 允许通过 override 直接传 site_name/theme_dir（可选）
  foreach (['site_name','theme_dir'] as $k){
    if (!array_key_exists($k, $patch['override'])) continue;
    $v = $patch['override'][$k];
    if (ss_is_empty($v)) continue;
    $next['override'][$k] = (string)$v;
  }
}

// 其它模块
if (!empty($patch['filter']) && is_array($patch['filter'])) ss_merge_section($next['filter'], $patch['filter'], ['is_filter']);
if (!empty($patch['link']) && is_array($patch['link'])) ss_merge_section($next['link'], $patch['link'], ['is_link']);
if (!empty($patch['report']) && is_array($patch['report'])) ss_merge_section($next['report'], $patch['report'], ['report_on']);
if (!empty($patch['search']) && is_array($patch['search'])) ss_merge_section($next['search'], $patch['search'], ['is_record']);
if (!empty($patch['count']) && is_array($patch['count'])) ss_merge_section($next['count'], $patch['count'], ['count1_enable']);

// 同步：config.sitename/theme_dir -> override 保持一致
$next['override']['site_name'] = (string)($next['config']['sitename'] ?? '');
$next['override']['theme_dir'] = (string)($next['config']['theme_dir'] ?? '');

// check DB if needed
if (ss_patch_has_db($patch)) {
  [$ok,$detail] = ss_test_db($next['config']);
  if (!$ok) ss_resp(['ok'=>0,'error'=>'db_check_failed','detail'=>$detail]);
}

if ($check_only) {
  ss_resp(['ok'=>1,'v'=>5,'check_only'=>1,'would_apply'=>ss_mask_snapshot($next),'current'=>ss_mask_snapshot($cur)]);
}

// determine files to write
$write_files = [];
$cfg_file = $root . '/shipsay/configs/config.ini.php';
$filter_file = $root . '/shipsay/configs/filter.ini.php';
$link_file = $root . '/shipsay/configs/link.ini.php';
$count_file = $root . '/shipsay/configs/count.ini.php';
$report_file = $root . '/shipsay/configs/report.ini.php';
$search_file = $root . '/shipsay/configs/search.ini.php';
$override_file = $root . '/shipsay/configs/override_pre.php';
$sync_cfg_file = $root . '/shipsay/configs/site_sync.php';

if (!empty($patch['config'])) $write_files[] = $cfg_file;
if (!empty($patch['filter'])) $write_files[] = $filter_file;
if (!empty($patch['link'])) $write_files[] = $link_file;
if (!empty($patch['count'])) $write_files[] = $count_file;
if (!empty($patch['report'])) $write_files[] = $report_file;
if (!empty($patch['search'])) $write_files[] = $search_file;
if (!empty($patch['override']) || !empty($patch['config'])) $write_files[] = $override_file;
if (!empty($patch['site_sync'])) $write_files[] = $sync_cfg_file;

$bundle = ss_backup_files($root, $bakdir, $write_files);
// 清理旧的 bundle 备份（保留最近 30 份）
ss_clean_old_bundles($bakdir, 30);

// write config.ini.php
if (in_array($cfg_file, $write_files, true)) {
  $str = ss_render_config_ini($next['config']);
  if (!ss_write_atomic($cfg_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'config.ini.php']);
}

if (in_array($filter_file, $write_files, true)) {
  $str = ss_render_filter_ini($next['filter']);
  if (!ss_write_atomic($filter_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'filter.ini.php']);
}

if (in_array($link_file, $write_files, true)) {
  $str = ss_render_link_ini($next['link']);
  if (!ss_write_atomic($link_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'link.ini.php']);
}

if (in_array($report_file, $write_files, true)) {
  $str = ss_render_report_ini($next['report']);
  if (!ss_write_atomic($report_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'report.ini.php']);
}

if (in_array($search_file, $write_files, true)) {
  $str = ss_render_search_ini($next['search']);
  if (!ss_write_atomic($search_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'search.ini.php']);
}

if (in_array($count_file, $write_files, true)) {
  $str = ss_render_count_ini($cur['count'], $patch['count'] ?? []);
  if (!ss_write_atomic($count_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'count.ini.php']);
  // 重新加载 count2/3 内部保留
  $next['count'] = ss_load_count($count_file);
}

if (in_array($override_file, $write_files, true)) {
  $str = ss_render_override_pre($next['override']);
  if (!ss_write_atomic($override_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'override_pre.php']);
}

if (in_array($sync_cfg_file, $write_files, true)) {
  $str = ss_render_site_sync_cfg($next['site_sync']);
  if (!ss_write_atomic($sync_cfg_file, $str)) ss_resp(['ok'=>0,'error'=>'write_failed','file'=>'site_sync.php']);
}

$final = ss_effective_snapshot($root);
$final['site_sync'] = ss_load_site_sync_cfg($sync_cfg_file);
ss_resp(['ok'=>1,'v'=>5,'bundle'=>$bundle,'applied'=>ss_mask_snapshot($final),'current'=>ss_mask_snapshot($final)]);
