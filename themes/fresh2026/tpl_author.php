<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
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

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
