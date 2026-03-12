<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/include/neighbor.php';

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

$current_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($index_url) && $index_url) ? (string)$index_url : '');
$current_url_attr = htmlspecialchars($current_url_raw, ENT_QUOTES, 'UTF-8');
$canonical_url = $current_url_raw;
if ($canonical_url !== '' && !preg_match('#^https?://#i', $canonical_url) && !empty($site_url)) {
  $canonical_url = rtrim((string)$site_url, '/') . $canonical_url;
}

$prev_page_url = '';
$next_page_url = '';
$prev_page_url_attr = '';
$next_page_url_attr = '';

$per_page_now = (!empty($list_arr) && is_array($list_arr)) ? count($list_arr) : 0;
$per_page_base = (!empty($rico_arr) && is_array($rico_arr) && !empty($rico_arr[0]) && is_array($rico_arr[0])) ? count($rico_arr[0]) : $per_page_now;
if ($per_page_base <= 0) $per_page_base = $per_page_now;
$range_start = $per_page_now > 0 ? (($pid - 1) * $per_page_base + 1) : 0;
$range_end = $per_page_now > 0 ? min(intval($chapters), $range_start + $per_page_now - 1) : 0;

$latest_rows = array();
if (!empty($lastchapter_arr) && is_array($lastchapter_arr)) {
  $latest_rows = array_slice($lastchapter_arr, 0, 12);
} elseif (!empty($lastarr) && is_array($lastarr)) {
  $latest_rows = array_slice($lastarr, 0, 12);
}

$related_rows = array();
if (isset($is_langtail) && intval($is_langtail) === 1 && !empty($langtailrows) && is_array($langtailrows)) {
  $related_rows = array_slice($langtailrows, 0, 12);
}

$hot_rows = array();
if (!empty($postdate) && is_array($postdate)) {
  $hot_rows = $postdate;
} elseif (!empty($neighbor) && is_array($neighbor)) {
  $hot_rows = $neighbor;
}

$intro_html = !empty($intro_p) ? $intro_p : (!empty($intro) ? $intro : '<p>暂无简介</p>');
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
<?php if ($canonical_url !== ''): ?><link rel="canonical" href="<?=htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8')?>"><?php endif; ?>
<?php if($prev_page_url !== ''): ?><link rel="prev" href="<?=$prev_page_url_attr?>"><?php endif; ?>
<?php if($next_page_url !== ''): ?><link rel="next" href="<?=$next_page_url_attr?>"><?php endif; ?>
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
    <section class="card bookhead">
      <img class="coverbig" loading="lazy"
           src="<?=ss_nocover_url()?>"
           data-src="<?=$img_url?>"
           alt="<?=$articlename?>"
           onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
      <div class="info">
        <h1 class="h1"><?=$articlename?></h1>
        <div class="line">作者：<?php if(!empty($author_url)): ?><a href="<?=$author_url?>"><?=$author?></a><?php else: ?><?=$author?><?php endif; ?></div>
        <div class="line">分类：<?php if(!empty($sort_link)): ?><a href="<?=$sort_link?>"><?=$sortname?></a><?php else: ?><?=$sortname?><?php endif; ?></div>
        <div class="line">状态：<?=$isfull?> · <?=$words_w?>万字 · 共 <?=$chapters?> 章</div>
        <div class="line">更新：<?=$lastupdate_cn?> · <?php if(!empty($last_url)): ?><a href="<?=$last_url?>"><?=$lastchapter?></a><?php else: ?><?=$lastchapter?><?php endif; ?></div>
        <div class="btnrow">
          <?php if(!empty($first_url)): ?><a class="btn primary" href="<?=$first_url?>">开始阅读</a><?php else: ?><span class="btn primary" aria-disabled="true">开始阅读</span><?php endif; ?>
          <?php if(!empty($info_url)): ?><a class="btn" href="<?=$info_url?>">返回详情</a><?php else: ?><span class="btn" aria-disabled="true">返回详情</span><?php endif; ?>
        </div>
      </div>
    </section>

    <section class="card">
      <h2 class="h2">最新章节信息</h2>
      <div class="kv">
        <div><span>更新时间</span><b><?=$lastupdate_cn?></b></div>
        <div><span>最新章节</span><b><?php if(!empty($last_url)): ?><a href="<?=$last_url?>"><?=$lastchapter?></a><?php else: ?><?=$lastchapter?><?php endif; ?></b></div>
      </div>
    </section>

    <section class="card">
      <h2 class="h2">内容简介</h2>
      <div class="p"><?=$intro_html?></div>
    </section>

    <section class="card chaptercard">
      <div class="card-hd">
        <h2 class="h2">顺序目录分页</h2>
        <span class="muted"><?php if($range_start > 0): ?>当前 <?=$range_start?> - <?=$range_end?> 章<?php else: ?>共 <?=$chapters?> 章<?php endif; ?></span>
      </div>
      <div class="list">
        <?php if(!empty($list_arr) && is_array($list_arr)): foreach($list_arr as $v): ?>
          <?php if(isset($v['chaptertype']) && intval($v['chaptertype']) === 1): ?>
            <div class="item muted"><?=$v['cname']?></div>
          <?php else: ?>
            <a class="item" href="<?=$v['cid_url']?>"><?=$v['cname']?></a>
          <?php endif; ?>
        <?php endforeach; else: ?>
          <div class="muted">暂无章节</div>
        <?php endif; ?>
      </div>

      <div class="pager">
        <span class="muted">第 <?=$pid?> / <?=$total_pages?> 页</span>
        <?php if(isset($htmltitle) && trim((string)$htmltitle) !== ""): ?>
          <div class="index-container"><?=$htmltitle?></div>
        <?php endif; ?>
      </div>
    </section>
  </div>

  <aside class="sidecol">
    <section class="card">
      <h2 class="h2">书籍信息区</h2>
      <div class="kv">
        <div><span>作者</span><b><?php if(!empty($author_url)): ?><a href="<?=$author_url?>"><?=$author?></a><?php else: ?><?=$author?><?php endif; ?></b></div>
        <div><span>分类</span><b><?php if(!empty($sort_link)): ?><a href="<?=$sort_link?>"><?=$sortname?></a><?php else: ?><?=$sortname?><?php endif; ?></b></div>
        <div><span>状态</span><b><?=$isfull?></b></div>
        <div><span>总章节</span><b><?=$chapters?></b></div>
        <div><span>当前页</span><b>第 <?=$pid?> / <?=$total_pages?> 页</b></div>
      </div>
      <div class="btnrow" style="margin-top:10px;">
        <?php if($recentread_url_raw !== ''): ?><a class="btn" href="<?=$recentread_url_attr?>">阅读记录</a><?php else: ?><span class="btn" aria-disabled="true">阅读记录</span><?php endif; ?>
        <?php if(!empty($info_url)): ?><a class="btn" href="<?=$info_url?>">详情页</a><?php else: ?><span class="btn" aria-disabled="true">详情页</span><?php endif; ?>
      </div>
    </section>

    <?php if(!empty($latest_rows) && is_array($latest_rows)): ?>
    <section class="card">
      <div class="card-hd">
        <h2 class="h2">最新12章</h2>
        <?php if(!empty($last_url)): ?><a class="more" href="<?=$last_url?>">阅读最新</a><?php else: ?><span class="more" aria-disabled="true">阅读最新</span><?php endif; ?>
      </div>
      <div class="list">
        <?php foreach($latest_rows as $v):
          if(empty($v) || !is_array($v)) continue;
          $n = isset($v['cname']) ? $v['cname'] : (isset($v['name']) ? $v['name'] : '');
          $u = isset($v['cid_url']) ? $v['cid_url'] : (isset($v['url']) ? $v['url'] : '');
          if(empty($n) || empty($u)) continue;
        ?>
          <a class="item" href="<?=$u?>"><?=$n?></a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($related_rows)): ?>
    <section class="card">
      <h2 class="h2">相关小说推荐</h2>
      <div class="tags">
        <?php foreach ($related_rows as $v) :
          if(empty($v) || !is_array($v)) continue;
          if(empty($v['info_url']) || empty($v['langname'])) continue;
        ?>
          <a class="tag" href="<?=$v['info_url']?>"><?=$v['langname']?></a>
        <?php endforeach ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($hot_rows) && is_array($hot_rows)): ?>
    <section class="card">
      <h2 class="h2">人气小说推荐</h2>
      <div class="list" style="margin-top:10px;">
        <?php $r=0; foreach($hot_rows as $v):
          $r++; if($r>10) break;
          if(empty($v) || !is_array($v)) continue;
          $u = isset($v['info_url']) ? $v['info_url'] : '';
          $n = isset($v['articlename']) ? $v['articlename'] : (isset($v['title']) ? $v['title'] : '');
          $a = isset($v['author']) ? $v['author'] : '';
          if(empty($u) || empty($n)) continue;
        ?>
          <a class="item" href="<?=$u?>"><?=$n?><?php if(!empty($a)): ?> <span class="muted">/ <?=$a?></span><?php endif; ?></a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
  </aside>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
