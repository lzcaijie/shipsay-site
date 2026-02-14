<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>《<?=$articlename?>》目录_<?=$author?>_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$articlename?>,<?=$author?>,目录">
<meta name="description" content="<?=$articlename?>章节目录，最新章节列表。">
<?php require_once 'tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="/"><?=SITE_NAME?></a>
    <form class="search" action="<?=ss_search_url()?>" method="get">
      <input type="text" name="searchkey" placeholder="书名 / 作者" autocomplete="off">
      <button type="submit">搜索</button>
    </form>
    <a class="link" href="<?=ss_recentread_url()?>">记录</a>
  </div>
</header>

<?php
  $total_pages = (isset($rico_arr) && is_array($rico_arr)) ? count($rico_arr) : 1;
  if (!isset($pid) || $pid < 1) $pid = 1;
  if ($total_pages < 1) $total_pages = 1;
?>

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

      <div class="pager">
        <?php if($pid>1): ?>
          <a href="<?=Url::index_url($articleid, $pid-1)?>">上一页</a>
        <?php else: ?>
          <span class="muted">上一页</span>
        <?php endif; ?>

        <span class="muted">第 <?=$pid?> / <?=$total_pages?> 页</span>

        <?php if($pid<$total_pages): ?>
          <a href="<?=Url::index_url($articleid, $pid+1)?>">下一页</a>
        <?php else: ?>
          <span class="muted">下一页</span>
        <?php endif; ?>

        <?php if($total_pages>1): ?>
          <span class="select">
            <select onchange="location.href=this.value">
              <?php for($i=1;$i<=$total_pages;$i++): ?>
                <option value="<?=Url::index_url($articleid,$i)?>"<?=$i==$pid?' selected':''?>>第 <?=$i?> 页</option>
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
          <div class="muted">作者：<a href="<?=$author_url?>"><?=$author?></a></div>
          <div class="muted">分类：<a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></div>
        </div>
      </div>
      <div class="btnrow" style="margin-top:10px;">
        <a class="btn primary" href="<?=$info_url?>">详情页</a>
        <a class="btn" href="<?=ss_recentread_url()?>">阅读记录</a>
      </div>
    </section>
  </aside>
</main>

<?php require_once 'tpl_footer.php'; ?>
</body>
</html>
