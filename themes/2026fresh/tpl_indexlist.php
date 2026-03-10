<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$total_pages = (isset($rico_arr) && is_array($rico_arr)) ? count($rico_arr) : 1;
if (!isset($pid) || $pid < 1) $pid = 1;
if ($total_pages < 1) $total_pages = 1;

$sort_link = '';
if (!empty($sorturl)) {
  $sort_link = $sorturl;
} elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'ss_sorturl')) {
  $sort_link = Sort::ss_sorturl($sortid);
} elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'category_url')) {
  $sort_link = Sort::category_url($sortid, 1);
}

if (!function_exists('ss_indexlist_page_url')) {
  function ss_indexlist_page_url($articleid, $pageNo){
    if (class_exists('Url') && method_exists('Url', 'index_url')) {
      return Url::index_url($articleid, $pageNo);
    }
    return '';
  }
}
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="<?=$site_home_url_attr?>"><?=$site_name_html?></a>
    <form class="search" method="get"<?php if($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
      <input type="text" name="searchkey" placeholder="<?=$search_placeholder_attr?>" autocomplete="off">
      <button type="submit"<?php if($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
    </form>
    <?php if($recentread_url_raw !== ''): ?><a class="link" href="<?=$recentread_url_attr?>">记录</a><?php else: ?><span class="link" aria-disabled="true">记录</span><?php endif; ?>
  </div>
</header>

<main class="wrap layout">
  <div class="maincol">
    <section class="card">
      <div class="card-hd">
        <h1 class="h1"><?=$articlename?></h1>
        <span class="muted">共 <?=$chapters?> 章</span>
      </div>
      <div class="list">
        <?php if(!empty($list_arr)): foreach($list_arr as $v): ?>
          <a class="item" href="<?=$v['cid_url']?>"><?=$v['cname']?></a>
        <?php endforeach; else: ?>
          <div class="muted">暂无章节</div>
        <?php endif; ?>
      </div>

      <?php
        $prev_page_url = $pid > 1 ? ss_indexlist_page_url($articleid, $pid - 1) : '';
        $next_page_url = $pid < $total_pages ? ss_indexlist_page_url($articleid, $pid + 1) : '';
      ?>
      <div class="pager">
        <?php if($pid > 1 && $prev_page_url !== ''): ?>
          <a href="<?=$prev_page_url?>">上一页</a>
        <?php else: ?>
          <span class="muted">上一页</span>
        <?php endif; ?>

        <span class="muted">第 <?=$pid?> / <?=$total_pages?> 页</span>

        <?php if($pid < $total_pages && $next_page_url !== ''): ?>
          <a href="<?=$next_page_url?>">下一页</a>
        <?php else: ?>
          <span class="muted">下一页</span>
        <?php endif; ?>

        <?php if($total_pages > 1): ?>
          <span class="select">
            <select onchange="if(this.value){location.href=this.value}">
              <?php for($i=1;$i<=$total_pages;$i++): ?>
                <?php $page_url = ss_indexlist_page_url($articleid, $i); ?>
                <option value="<?=$page_url?>"<?=$i==$pid?' selected':''?><?php if($page_url===''): ?> disabled="disabled"<?php endif; ?>>第 <?=$i?> 页</option>
              <?php endfor; ?>
            </select>
          </span>
        <?php endif; ?>
      </div>
    </section>
  </div>

  <aside class="sidecol">
    <section class="card">
      <div class="bookhead">
        <img class="coverbig" loading="lazy" src="<?=ss_nocover_url()?>" data-src="<?=$img_url?>" onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
        <div class="info">
          <div class="h2" style="margin-bottom:6px;"><?=$articlename?></div>
          <div class="muted">作者：<?php if(!empty($author_url)): ?><a href="<?=$author_url?>"><?=$author?></a><?php else: ?><?=$author?><?php endif; ?></div>
          <div class="muted">分类：<?php if(!empty($sort_link)): ?><a href="<?=$sort_link?>"><?=$sortname?></a><?php else: ?><?=$sortname?><?php endif; ?></div>
        </div>
      </div>
      <div class="btnrow" style="margin-top:10px;">
        <?php if(!empty($info_url)): ?><a class="btn primary" href="<?=$info_url?>">详情页</a><?php else: ?><span class="btn primary" aria-disabled="true">详情页</span><?php endif; ?>
        <?php if($recentread_url_raw !== ''): ?><a class="btn" href="<?=$recentread_url_attr?>">阅读记录</a><?php else: ?><span class="btn" aria-disabled="true">阅读记录</span><?php endif; ?>
      </div>
    </section>
  </aside>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
