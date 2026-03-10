<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
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
        <h1 class="h2" style="margin:0;"><?=$sortname?>小说</h1>
        <span class="muted">第 <?=$page?> / <?=$allpage?> 页</span>
      </div>

      <div class="books-grid" style="margin-top:10px;">
        <?php if(!empty($retarr)): foreach($retarr as $v): ?>
          <?php
            $info_url = !empty($v['info_url']) ? $v['info_url'] : '#';
            $img_url  = !empty($v['img_url']) ? $v['img_url'] : '';
            $title    = isset($v['articlename']) ? $v['articlename'] : '';
            $author   = isset($v['author']) ? $v['author'] : '';
            $isfull   = isset($v['isfull']) ? $v['isfull'] : '';
            $words_w  = isset($v['words_w']) ? $v['words_w'] : '';
            $lastup   = isset($v['lastupdate']) ? $v['lastupdate'] : '';
          ?>
          <a class="book" href="<?=$info_url?>" title="<?=$title?>">
            <img class="cover" src="<?=ss_nocover_url()?>"<?php if($img_url!=''): ?> data-src="<?=$img_url?>"<?php endif; ?> alt="<?=$title?>" onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
            <div class="meta">
              <div class="t"><?=$title?></div>
              <div class="s"><?=$author?><?php if($isfull!='' || $words_w!=''): ?> · <?=$isfull?><?php if($words_w!=''): ?> · <?=$words_w?>万字<?php endif; ?><?php endif; ?></div>
              <div class="s">更新：<?=$lastup?></div>
            </div>
          </a>
        <?php endforeach; endif; ?>
      </div>

      <div class="pager" style="margin-top:14px;">
        <?php if($page>1 && !empty($pre_url)): ?><a href="<?=$pre_url?>">上一页</a><?php else: ?><span class="muted">上一页</span><?php endif; ?>
        <span class="muted">第 <?=$page?> / <?=$allpage?> 页</span>
        <?php if($page<$allpage && !empty($next_url)): ?><a href="<?=$next_url?>">下一页</a><?php else: ?><span class="muted">下一页</span><?php endif; ?>
      </div>
    </section>
  </div>

  <aside class="sidecol">
    <section class="card">
      <div class="card-hd">
        <h2 class="h2">分类</h2>
      </div>
      <div class="tags" style="margin-top:10px;">
        <?php foreach(Sort::ss_sorthead() as $v): ?>
          <a class="tag" href="<?=$v['sorturl']?>"><?=$v['sortname']?></a>
        <?php endforeach; ?>
      </div>
    </section>
  </aside>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
