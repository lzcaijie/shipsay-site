<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>搜索_<?=SITE_NAME?></title>
<meta name="keywords" content="搜索,小说,<?=SITE_NAME?>">
<meta name="description" content="<?=SITE_NAME?>小说搜索。">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="/"><?=SITE_NAME?></a>
    <form class="search" action="<?=ss_search_url()?>" method="get">
      <input type="text" name="searchkey" value="<?=!empty($searchkey)?ss_h($searchkey):''?>" placeholder="书名 / 作者" autocomplete="off">
      <button type="submit">搜索</button>
    </form>
    <a class="link" href="<?=ss_recentread_url()?>">记录</a>
  </div>
</header>

<main class="wrap">
  <section class="card">

    <?php if(!empty($searchkey)): ?>
      <div class="muted" style="margin-top:4px;">
        关键词：<b><?=ss_h($searchkey)?></b>，
        共找到 <b><?=isset($search_count)?intval($search_count):0?></b> 条
      </div>

      <div class="books-grid" style="margin-top:12px;">
        <?php if(!empty($search_res) && is_array($search_res)): ?>
          <?php foreach($search_res as $v):
            if(empty($v) || !is_array($v)) continue;
            $u = !empty($v['info_url']) ? $v['info_url'] : '';
            $n = !empty($v['articlename']) ? $v['articlename'] : '';
            if(empty($u) || empty($n)) continue;
            $img = !empty($v['img_url']) ? $v['img_url'] : '';
            $sn = !empty($v['sortname']) ? $v['sortname'] : '';
            $au = !empty($v['author']) ? $v['author'] : '';
            $ds = !empty($v['intro_des']) ? $v['intro_des'] : '';
          ?>
            <a class="book-card" href="<?=$u?>">
              <span class="book-cover">
                <img loading="lazy"
                     src="<?=ss_nocover_url()?>"
                     data-src="<?=$img?>"
                     alt="<?=ss_h($n)?>"
                     onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
              </span>
              <span class="book-meta">
                <span class="book-title"><?=ss_h($n)?></span>
                <?php if(!empty($sn) || !empty($au)): ?>
                  <span class="book-sub">
                    <?=!empty($sn)?ss_h($sn):''?><?php if(!empty($sn) && !empty($au)): ?> · <?php endif; ?><?=!empty($au)?ss_h($au):''?>
                  </span>
                <?php endif; ?>
                <?php if(!empty($ds)): ?><span class="book-desc"><?=ss_h($ds)?></span><?php endif; ?>
              </span>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="muted">暂无相关结果。</div>
        <?php endif; ?>
      </div>

    <?php else: ?>
      <div class="muted" style="margin-top:4px;">请输入关键词进行搜索。</div>
    <?php endif; ?>

  </section>

  <?php if(empty($searchkey) && !empty($articlerows) && is_array($articlerows)): ?>
  <section class="card">
    <div class="card-hd"><h2 class="h2">热门推荐</h2></div>
    <div class="list">
      <?php $i=0; foreach($articlerows as $v):
        $i++; if($i>10) break;
        if(empty($v) || !is_array($v)) continue;
        $u = !empty($v['info_url']) ? $v['info_url'] : '';
        $n = !empty($v['articlename']) ? $v['articlename'] : '';
        $a = !empty($v['author']) ? $v['author'] : '';
        if(empty($u) || empty($n)) continue;
      ?>
        <a class="item" href="<?=$u?>"><?=ss_h($n)?><?php if(!empty($a)): ?> <span class="muted">/ <?=ss_h($a)?></span><?php endif; ?></a>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
