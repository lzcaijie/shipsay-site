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
        if (!empty($fake_search)) return (string)$fake_search;
        return '/search/';
    }
}
if (!function_exists('ss_recentread_url')) {
    function ss_recentread_url(){
        global $recentread_url, $fake_recentread;
        if (!empty($recentread_url)) return (string)$recentread_url;
        if (!empty($fake_recentread)) return (string)$fake_recentread;
        return '';
    }
}
if (!function_exists('ss_top_url')) {
    function ss_top_url(){
        global $rank_entry_url, $fake_top;
        if (!empty($rank_entry_url)) return (string)$rank_entry_url;
        if (!empty($fake_top)) return (string)$fake_top;
        return '';
    }
}
if (!function_exists('ss_full_allbooks_url')) {
    function ss_full_allbooks_url(){
        global $full_allbooks_url, $allbooks_url;
        if (!empty($full_allbooks_url)) return (string)$full_allbooks_url;
        if (!empty($allbooks_url)) return '/quanben' . (string)$allbooks_url;
        return '';
    }
}
if (!function_exists('ss_sort_items')) {
    function ss_sort_items(){
        $items = [];
        $rank_url = rtrim((string)ss_top_url(), '/');
        foreach (Sort::ss_sorthead() as $v) {
            $sort_url = isset($v['sorturl']) ? rtrim((string)$v['sorturl'], '/') : '';
            $sort_name = isset($v['sortname']) ? (string)$v['sortname'] : '';
            if ($sort_url !== '' && $sort_url === $rank_url) continue;
            if ($sort_name !== '' && mb_strpos($sort_name, '排行') !== false) continue;
            $items[] = $v;
        }
        return $items;
    }
}
if (!function_exists('ss_submit_search_js')) {
    function ss_submit_search_js(){
        static $done = false;
        if ($done) return;
        $done = true;
        echo '<script>function ssSubmitSearch(form){if(!form){return false;}var input=form.querySelector("input[name=searchkey]");if(!input){return false;}input.value=(input.value||"").replace(/^\s+|\s+$/g,"");if(input.value===""){alert("请输入书名或作者");input.focus();return false;}return true;}</script>';
    }
}
if (!function_exists('ss_render_search_form')) {
    function ss_render_search_form($options = []){
        global $searchkey, $theme_dir_attr;
        $search_url_raw = (string)ss_search_url();
        $search_url_attr = ss_h($search_url_raw);
        $searchkey_value_raw = array_key_exists('searchkey', $options)
            ? (string)$options['searchkey']
            : (isset($searchkey) ? (string)$searchkey : '');
        $searchkey_value_attr = ss_h($searchkey_value_raw);
        $placeholder_raw = array_key_exists('placeholder', $options) && trim((string)$options['placeholder']) !== ''
            ? (string)$options['placeholder']
            : '输入书名/作者';
        $placeholder_attr = ss_h($placeholder_raw);
        $wrapper_class = array_key_exists('wrapper_class', $options) ? trim((string)$options['wrapper_class']) : 'search';
        $wrapper_class_attr = ss_h($wrapper_class);
        $method = array_key_exists('method', $options) ? strtolower((string)$options['method']) : 'get';
        if ($method !== 'post' && $method !== 'get') $method = 'get';
        ss_submit_search_js();
        ?>
<div class="<?=$wrapper_class_attr?>">
<form id="t_frmsearch" name="t_frmsearch" method="<?=$method?>"<?php if ($search_url_raw !== ""): ?> action="<?=$search_url_attr?>" onsubmit="return ssSubmitSearch(this);"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
    <table cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
            <td style="width:50px;"><div id="type" class="type">综合</div></td>
            <td style="background-color:#fff; border:1px solid #CCC;">
                <input id="s_key" name="searchkey" type="text" class="key" value="<?=$searchkey_value_attr?>" placeholder="<?=$placeholder_attr?>" maxlength="50" required>
                <input type="hidden" name="searchtype" value="all">
            </td>
            <td style="width:35px; background-color:#0080C0; background-image:url('/static/<?=$theme_dir_attr?>/search.png'); background-repeat:no-repeat; background-position:center">
                <input name="t_btnsearch" type="submit" value="" class="go"<?php if ($search_url_raw === ""): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>
            </td>
        </tr>
    </table><span id="s_tips"></span>
</form>
</div>
        <?php
    }
}
if (!function_exists('ss_render_common_nav')) {
    function ss_render_common_nav(){
        $home_url_raw = ss_home_url();
        $home_url_attr = ss_h($home_url_raw);
        $recentread_url_raw = ss_recentread_url();
        $recentread_url_attr = ss_h($recentread_url_raw);
        $rank_url_raw = ss_top_url();
        $rank_url_attr = ss_h($rank_url_raw);
        $full_url_raw = ss_full_allbooks_url();
        $full_url_attr = ss_h($full_url_raw);
        $sort_items = ss_sort_items();
        ?>
<div class="page-subnav">
    <a href="<?=$home_url_attr?>">首页</a>
    <a href="javascript:;" onclick="toggleSort();" rel="nofollow">分类</a>
    <?php if ($rank_url_raw !== ''): ?><a href="<?=$rank_url_attr?>">排行榜</a><?php endif; ?>
    <?php if ($full_url_raw !== ''): ?><a href="<?=$full_url_attr?>">完本</a><?php endif; ?>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow">阅读记录</a><?php endif; ?>
</div>
<div class="sort c_sort sort-panel" id="submenu" style="display:none;">
    <ul>
        <?php foreach ($sort_items as $v): ?>
            <li><a href="<?=ss_h((string)$v['sorturl'])?>"><?=ss_h((string)$v['sortname_2'])?></a></li>
        <?php endforeach; ?>
        <div class="cc"></div>
    </ul>
</div>
        <?php
    }
}
if (!function_exists('ss_render_page_top')) {
    function ss_render_page_top($options = []){
        $page_title_raw = isset($options['page_title']) && trim((string)$options['page_title']) !== '' ? (string)$options['page_title'] : (string)SITE_NAME;
        $page_title_html = ss_h($page_title_raw);
        $back_url_raw = isset($options['page_back_url']) ? trim((string)$options['page_back_url']) : '';
        $back_url_attr = ss_h($back_url_raw);
        $back_label_html = ss_h(isset($options['page_back_label']) && trim((string)$options['page_back_label']) !== '' ? (string)$options['page_back_label'] : '返回');
        $show_back = !empty($options['show_back']);
        ?>
<div class="page-head">
    <?php if ($show_back): ?>
        <?php if ($back_url_raw !== ''): ?><a href="<?=$back_url_attr?>" class="back"><?=$back_label_html?></a><?php else: ?><a href="javascript:history.go(-1);" class="back"><?=$back_label_html?></a><?php endif; ?>
    <?php endif; ?>
    <h1><?=$page_title_html?></h1>
</div>
<?php ss_render_common_nav(); ?>
        <?php
    }
}
$theme_dir_attr = ss_h(isset($theme_dir) ? $theme_dir : 'ss_wap');
?>
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
