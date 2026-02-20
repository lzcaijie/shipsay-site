<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$author?>作品大全_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$author?>,<?=$author?>作品,小说">
<meta name="description" content="<?=$author?>作品大全：最新章节免费阅读。">
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

<main class="wrap">
  <section class="card">
    <div class="card-hd"><h2 class="h2"><?=$author?> 的作品</h2></div>

    <div class="books-grid">
      <?php if(!empty($res) && is_array($res)): foreach($res as $v):
        if(empty($v) || !is_array($v)) continue;
        $u = !empty($v['info_url']) ? $v['info_url'] : '';
        if(empty($u)) continue;
        $img = !empty($v['img_url']) ? $v['img_url'] : '';
        $name = !empty($v['articlename']) ? $v['articlename'] : '';
        $sort = !empty($v['sortname']) ? $v['sortname'] : '';
        $au = !empty($v['author']) ? $v['author'] : '';
        $desc = !empty($v['intro_des']) ? $v['intro_des'] : '';
      ?>
        <a class="book-card" href="<?=$u?>">
          <span class="book-cover">
            <img loading="lazy"
                 src="<?=ss_nocover_url()?>"
                 data-src="<?=$img?>"
                 alt="<?=$name?>"
                 onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
          </span>
          <span class="book-meta">
            <span class="book-title"><?=$name?></span>
            <span class="book-sub"><?=$sort?><?php if(!empty($au)): ?> · <?=$au?><?php endif; ?></span>
            <?php if(!empty($desc)): ?><span class="book-desc"><?=$desc?></span><?php endif; ?>
          </span>
        </a>
      <?php endforeach; else: ?>
        <div class="muted">暂无作品。</div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php require_once 'tpl_footer.php'; ?>
</body>
</html>
