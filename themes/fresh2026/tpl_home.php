<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="/"><?=SITE_NAME?></a>
    <form class="search" action="<?=ss_search_url()?>" method="get">
      <input type="text" name="searchkey" placeholder="书名 / 作者" autocomplete="off">
      <button type="submit">搜索</button>
    </form>
    <a class="topbtn" href="<?=ss_recentread_url()?>">记录</a>
  </div>
</header>

<main class="wrap layout">
  <div class="maincol">

    <section class="card">
      <div class="card-hd">
        <h2 class="h2">热门推荐</h2>
        <a class="more" href="<?=ss_top_url()?>">更多排行</a>
      </div>
      <div class="books-grid">
        <?php if(!empty($commend)): $i=0; foreach($commend as $v): $i++; if($i>6) break; ?>
          <a class="book" href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
            <img class="cover" loading="lazy" src="<?=ss_nocover_url()?>" data-src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
            <div class="meta">
              <div class="t"><?=$v['articlename']?></div>
              <div class="s"><?=$v['author']?></div>
              <div class="d"><?=$v['intro_des']?></div>
            </div>
          </a>
        <?php endforeach; endif; ?>
      </div>
    </section>

    <section class="card">
      <div class="card-hd">
        <h2 class="h2">最新更新</h2>
        <?php if(isset($allbooks_url)): ?><a class="more" href="<?=$allbooks_url?>">最近更多</a><?php endif; ?>
      </div>
      <div class="list">
        <?php if(!empty($lastupdate)): foreach($lastupdate as $v): ?>
          <div class="item">
            <div class="row">
              <a class="t" href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
              <span class="muted"> / <a href="<?=$v['author_url']?>"><?=$v['author']?></a> / <a href="<?=$v['sorturl']?>"><?=$v['sortname']?></a></span>
            </div>
            <div class="muted" style="margin-top:4px;">
              最新：<a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a>
              <span class="muted"> · <?=$v['lastupdate_cn']?></span>
            </div>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </section>

  </div>

  <aside class="sidecol">
    <section class="card">
      <h2 class="h2">快捷入口</h2>
      <div class="tabs" style="margin-top:10px;">
        <a href="<?=ss_top_url()?>">排行</a>
        <a href="<?=ss_recentread_url()?>">记录</a>
        <a href="<?=ss_search_url()?>">搜索</a>
      </div>
    </section>

    <section class="card">
      <div class="card-hd">
        <h2 class="h2">分类</h2>
        <?php if(isset($allbooks_url)): ?><a class="more" href="<?=$allbooks_url?>">全部</a><?php endif; ?>
      </div>
      <div class="tags">
        <?php foreach(Sort::ss_sorthead() as $v): ?>
          <a class="tag" href="<?=$v['sorturl']?>"><?=$v['sortname']?></a>
        <?php endforeach; ?>
      </div>
    </section>

    <?php if(!empty($popular)): ?>
    <section class="card">
      <h2 class="h2">经典推荐</h2>
      <div class="list" style="margin-top:10px;">
        <?php $k=0; foreach($popular as $v): $k++; if($k>10) break; ?>
          <a class="item" href="<?=$v['info_url']?>"><?=$v['articlename']?> <span class="muted">/ <?=$v['author']?></span></a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
  </aside>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
