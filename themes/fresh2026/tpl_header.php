<?php if (!defined('__ROOT_DIR__')) exit;

// 统一的基础函数（避免模板内重复定义）
if (!function_exists('ss_h')) {
  function ss_h($s){
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
  }
}
if (!function_exists('ss_home_url')) {
  function ss_home_url(){
    return '/';
  }
}
if (!function_exists('ss_search_url')) {
  function ss_search_url(){
    global $fake_search;
    return !empty($fake_search) ? $fake_search : '/search/';
  }
}
if (!function_exists('ss_recentread_url')) {
  function ss_recentread_url(){
    global $fake_recentread;
    return !empty($fake_recentread) ? $fake_recentread : '/history.html';
  }
}
if (!function_exists('ss_top_url')) {
  function ss_top_url(){
    return '/rank/allvisit/';
  }
}
if (!function_exists('ss_nocover_url')) {
  function ss_nocover_url(){
    global $theme_dir;
    return '/static/'.$theme_dir.'/nocover.jpg';
  }
}
if (!function_exists('ss_asset_ver')) {
  function ss_asset_ver(){
    return defined('SITE_VERSION') ? SITE_VERSION : date('Ymd');
  }
}
?>
<meta name="applicable-device" content="pc,mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php $v = ss_asset_ver(); ?>
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/main.css?v=<?=$v?>">
