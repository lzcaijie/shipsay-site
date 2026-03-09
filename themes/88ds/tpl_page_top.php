<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$page_title_raw = isset($page_title) && trim((string)$page_title) !== '' ? (string)$page_title : (string)SITE_NAME;
$page_title_html = htmlspecialchars($page_title_raw, ENT_QUOTES, 'UTF-8');
$page_back_url_raw = isset($page_back_url) ? trim((string)$page_back_url) : '';
$page_back_url_attr = htmlspecialchars($page_back_url_raw, ENT_QUOTES, 'UTF-8');
$page_back_label_raw = isset($page_back_label) && trim((string)$page_back_label) !== '' ? (string)$page_back_label : '返回';
$page_back_label_html = htmlspecialchars($page_back_label_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = isset($site_home_url_raw) && $site_home_url_raw ? (string)$site_home_url_raw : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$rank_entry_raw = isset($rank_entry_url) && $rank_entry_url ? (string)$rank_entry_url : (function_exists('ss_top_url') ? (string)ss_top_url() : ((isset($fake_top) && $fake_top) ? (string)$fake_top : ''));
$rank_entry_attr = htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_raw = isset($full_allbooks_url) && $full_allbooks_url ? (string)$full_allbooks_url : ((isset($allbooks_url) && $allbooks_url) ? ('/quanben' . (string)$allbooks_url) : '');
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_raw = function_exists('ss_recentread_url') ? (string)ss_recentread_url() : ((isset($fake_recentread) && $fake_recentread) ? (string)$fake_recentread : '');
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
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
      <?php $sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8'); $sort_name_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8'); ?>
      <li><a href="<?=$sort_url_attr?>"><?=$sort_name_html?></a></li>
    <?php endforeach; ?>
    <div class="cc"></div>
  </ul>
</div>

<?php require __THEME_DIR__ . '/tpl_search_form.php'; ?>
