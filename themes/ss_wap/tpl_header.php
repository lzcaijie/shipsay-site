<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_h')) {
    function ss_h($s){
        return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
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
        if (!empty($rank_entry_url)) return (string)$rank_entry_url;
        return !empty($fake_top) ? (string)$fake_top : '';
    }
}
$theme_dir_attr = ss_h(isset($theme_dir) ? $theme_dir : 'ss_wap');
?>
<!-- header -->
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta name="MobileOptimized" content="240" />
<meta name="applicable-device" content="pc,mobile">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/style.css">
<script src="/static/<?=$theme_dir_attr?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/common.js"></script>
</head>
<!-- /header -->
