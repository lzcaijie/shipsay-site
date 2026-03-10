<?php if (!defined('__ROOT_DIR__')) exit;

if (!function_exists('ss_h')) {
  function ss_h($s){
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
  }
}
if (!function_exists('ss_home_url')) {
  function ss_home_url(){
    global $site_url;
    return !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
  }
}
if (!function_exists('ss_search_url')) {
  function ss_search_url(){
    global $fake_search;
    return !empty($fake_search) ? (string)$fake_search : '';
  }
}
if (!function_exists('ss_recentread_url')) {
  function ss_recentread_url(){
    global $fake_recentread;
    return !empty($fake_recentread) ? (string)$fake_recentread : '';
  }
}
if (!function_exists('ss_top_url')) {
  function ss_top_url(){
    global $rank_entry_url, $fake_top;
    if (!empty($rank_entry_url)) {
      return (string)$rank_entry_url;
    }
    return !empty($fake_top) ? (string)$fake_top : '';
  }
}
if (!function_exists('ss_nocover_url')) {
  function ss_nocover_url(){
    global $theme_dir;
    return '/static/' . (string)$theme_dir . '/nocover.jpg';
  }
}
if (!function_exists('ss_asset_ver')) {
  function ss_asset_ver(){
    return defined('SITE_VERSION') ? SITE_VERSION : date('Ymd');
  }
}

$theme_dir_raw = isset($theme_dir) ? (string)$theme_dir : '';
$theme_dir_attr = ss_h($theme_dir_raw);
$site_home_url_raw = ss_home_url();
$site_home_url_attr = ss_h($site_home_url_raw);
$search_url_raw = ss_search_url();
$search_url_attr = ss_h($search_url_raw);
$recentread_url_raw = ss_recentread_url();
$recentread_url_attr = ss_h($recentread_url_raw);
$rank_entry_raw = ss_top_url();
$rank_entry_attr = ss_h($rank_entry_raw);
$search_placeholder_raw = isset($search_placeholder) && $search_placeholder !== '' ? (string)$search_placeholder : '输入书名/作者';
$search_placeholder_attr = ss_h($search_placeholder_raw);
$site_name_html = ss_h(defined('SITE_NAME') ? SITE_NAME : '');
$site_url_text_html = ss_h(defined('SITE_URL') ? SITE_URL : $site_home_url_raw);
$v = ss_asset_ver();
?>
<meta name="robots" content="all">
<meta name="applicable-device" content="pc,mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="Cache-Control" content="no-transform">
<base target="_self">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/css/main.css?v=<?=$v?>">
