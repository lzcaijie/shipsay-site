<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_h')) {
    function ss_h($s){
        return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('ss_home_url')) {
    function ss_home_url(){
        global $site_home_url, $site_url;
        if (!empty($site_home_url)) return (string)$site_home_url;
        if (!empty($site_url)) return rtrim((string)$site_url, '/') . '/';
        return '/';
    }
}
if (!function_exists('ss_site_base_url')) {
    function ss_site_base_url(){
        global $site_url;
        if (!empty($site_url)) return rtrim((string)$site_url, '/');
        $home = ss_home_url();
        if ($home === '/' || $home === '') return '';
        return rtrim((string)$home, '/');
    }
}
if (!function_exists('ss_abs_url')) {
    function ss_abs_url($url){
        $url = trim((string)$url);
        if ($url === '') return '';
        if (preg_match('#^https?://#i', $url)) return $url;
        if (strpos($url, '//') === 0) return 'https:' . $url;
        $base = ss_site_base_url();
        if ($base === '') return $url;
        if ($url[0] === '/') return $base . $url;
        return $base . '/' . ltrim($url, '/');
    }
}
if (!function_exists('ss_search_url')) {
    function ss_search_url(){
        global $search_url, $fake_search;
        if (!empty($search_url)) return (string)$search_url;
        return !empty($fake_search) ? (string)$fake_search : '';
    }
}
if (!function_exists('ss_recentread_url')) {
    function ss_recentread_url(){
        global $recentread_url, $fake_recentread;
        if (!empty($recentread_url)) return (string)$recentread_url;
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
if (!function_exists('ss_full_allbooks_url')) {
    function ss_full_allbooks_url(){
        global $full_allbooks_url, $allbooks_url;
        if (!empty($full_allbooks_url)) return (string)$full_allbooks_url;
        return !empty($allbooks_url) ? '/quanben' . (string)$allbooks_url : '';
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
