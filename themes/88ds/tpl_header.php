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
if (!function_exists('ss_render_search_form')) {
    function ss_render_search_form($options = []){
        global $searchkey, $search_placeholder, $fake_search;
        $search_url_raw = function_exists('ss_search_url')
            ? (string)ss_search_url()
            : (!empty($fake_search) ? (string)$fake_search : '');
        $search_url_attr = ss_h($search_url_raw);
        $searchkey_value_raw = array_key_exists('searchkey', $options)
            ? (string)$options['searchkey']
            : (isset($searchkey) ? (string)$searchkey : '');
        $searchkey_value_attr = ss_h($searchkey_value_raw);
        $search_placeholder_raw = array_key_exists('placeholder', $options) && (string)$options['placeholder'] !== ''
            ? (string)$options['placeholder']
            : (isset($search_placeholder) && (string)$search_placeholder !== '' ? (string)$search_placeholder : '输入书名/作者');
        $search_placeholder_attr = ss_h($search_placeholder_raw);
        $search_form_submit = $search_url_raw !== '' ? 'return ssSubmitSearch(this);' : 'return false;';
        ?>
<form id="post" name="t_frmsearch" method="post" class="search" action="<?=$search_url_attr?>" data-action="<?=$search_url_attr?>" onsubmit="<?=$search_form_submit?>">
  <input
    name="searchkey"
    id="s_key"
    value="<?=$searchkey_value_attr?>"
    placeholder="<?=$search_placeholder_attr?>"
    type="text"
    class="searchinput"
    autocomplete="off"
    maxlength="50"
    required
  >
  <input name="searchtype" id="type" type="hidden" value="all">
  <input type="submit" name="t_btnsearch" value="搜索" class="go"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>
</form>
        <?php
    }
}
if (!function_exists('ss_render_page_top')) {
    function ss_render_page_top($options = []){
        global $site_url, $rank_entry_url, $fake_top, $full_allbooks_url, $allbooks_url;
        $page_title_raw = isset($options['page_title']) && trim((string)$options['page_title']) !== '' ? (string)$options['page_title'] : (string)SITE_NAME;
        $page_title_html = ss_h($page_title_raw);
        $page_back_url_raw = isset($options['page_back_url']) ? trim((string)$options['page_back_url']) : '';
        $page_back_url_attr = ss_h($page_back_url_raw);
        $page_back_label_raw = isset($options['page_back_label']) && trim((string)$options['page_back_label']) !== '' ? (string)$options['page_back_label'] : '返回';
        $page_back_label_html = ss_h($page_back_label_raw);
        $site_home_url_raw = isset($options['site_home_url']) && trim((string)$options['site_home_url']) !== ''
            ? (string)$options['site_home_url']
            : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
        $site_home_url_attr = ss_h($site_home_url_raw);
        $rank_entry_raw = isset($options['rank_entry_url']) && trim((string)$options['rank_entry_url']) !== ''
            ? (string)$options['rank_entry_url']
            : (!empty($rank_entry_url) ? (string)$rank_entry_url : (function_exists('ss_top_url') ? (string)ss_top_url() : (!empty($fake_top) ? (string)$fake_top : '')));
        $rank_entry_attr = ss_h($rank_entry_raw);
        $full_allbooks_url_raw = isset($options['allbooks_url']) && trim((string)$options['allbooks_url']) !== ''
            ? (string)$options['allbooks_url']
            : (!empty($full_allbooks_url) ? (string)$full_allbooks_url : (!empty($allbooks_url) ? '/quanben' . (string)$allbooks_url : ''));
        $full_allbooks_url_attr = ss_h($full_allbooks_url_raw);
        $recentread_url_raw = function_exists('ss_recentread_url') ? (string)ss_recentread_url() : '';
        $recentread_url_attr = ss_h($recentread_url_raw);
        ?>
<div class="header">
  <div class="back">
    <?php if ($page_back_url_raw !== ''): ?>
      <a href="<?=$page_back_url_attr?>"><?=$page_back_label_html?></a>
    <?php else: ?>
      <a href="javascript:history.go(-1);"><?=$page_back_label_html?></a>
    <?php endif; ?>
  </div>
  <h1><?=$page_title_html?></h1>
  <div class="reg">
    <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
    <a href="<?=$site_home_url_attr?>" class="login_topbtn c_index_login">首页</a>
  </div>
</div>

<div class="nav page-mini-nav">
  <ul>
    <li><a href="javascript:;" onclick="return toggleSort();" rel="nofollow">分类</a></li>
    <li><?php if ($rank_entry_raw !== ''): ?><a href="<?=$rank_entry_attr?>">排行</a><?php else: ?><span>排行</span><?php endif; ?></li>
    <li><?php if ($full_allbooks_url_raw !== ''): ?><a href="<?=$full_allbooks_url_attr?>">全本</a><?php else: ?><span>全本</span><?php endif; ?></li>
    <li><?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow">足迹</a><?php else: ?><span>足迹</span><?php endif; ?></li>
  </ul>
</div>

<div class="sort c_sort" id="submenu" style="display:none;">
  <ul>
    <?php foreach (Sort::ss_sorthead() as $v): ?>
      <?php $sort_url_attr = ss_h((string)$v['sorturl']); $sort_name_html = ss_h((string)$v['sortname_2']); ?>
      <li><a href="<?=$sort_url_attr?>"><?=$sort_name_html?></a></li>
    <?php endforeach; ?>
    <div class="cc"></div>
  </ul>
</div>

<?php ss_render_search_form(); ?>
        <?php
    }
}
$theme_dir_raw = isset($theme_dir) ? (string)$theme_dir : '88ds';
$theme_dir_attr = htmlspecialchars($theme_dir_raw, ENT_QUOTES, 'UTF-8');
$v = defined('SITE_VERSION') ? SITE_VERSION : date('Ymd');
?>
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta name="MobileOptimized" content="240" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<base target="_self">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/style.css?v=<?=$v?>">
<script src="/static/<?=$theme_dir_attr?>/js/jquery.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir_attr?>/common.js?v=<?=$v?>"></script>
</head>
