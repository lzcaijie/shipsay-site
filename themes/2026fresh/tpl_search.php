<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$searchkey_safe = isset($searchkey) ? htmlspecialchars((string)$searchkey, ENT_QUOTES, 'UTF-8') : '';
$search_count_safe = intval(isset($search_count) ? $search_count : 0);
$search_page_url_raw = !empty($uri) ? (string)$uri : '';
$search_page_url_attr = htmlspecialchars($search_page_url_raw, ENT_QUOTES, 'UTF-8');
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
$seo_title_html = htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8');
$seo_keywords_html = htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8');
$seo_description_html = htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$seo_title_html?></title>
<meta name="keywords" content="<?=$seo_keywords_html?>">
<meta name="description" content="<?=$seo_description_html?>">
<?php if ($search_page_url_raw !== ''): ?><meta property="og:url" content="<?=$search_page_url_attr?>"><?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$seo_title_html?>">
<meta property="og:description" content="<?=$seo_description_html?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="<?=$site_home_url_attr?>"><?=$site_name_html?></a>
    <form class="search" method="get"<?php if($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
      <input type="text" name="searchkey" value="<?=$searchkey_safe?>" placeholder="<?=$search_placeholder_attr?>" autocomplete="off">
      <button type="submit"<?php if($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
    </form>
    <?php if($recentread_url_raw !== ''): ?><a class="link" href="<?=$recentread_url_attr?>">记录</a><?php else: ?><span class="link" aria-disabled="true">记录</span><?php endif; ?>
  </div>
</header>

<main class="wrap">
  <section class="card">
    <div class="muted" style="margin-bottom:10px;line-height:1.7;"><a href="<?=$site_home_url_attr?>">首页</a> &gt; <span>搜索</span></div>

    <?php if($searchkey_safe !== ''): ?>
      <div class="muted" style="margin-top:4px;">
        关键词：<b><?=$searchkey_safe?></b>，
        共找到 <b><?=$search_count_safe?></b> 条
      </div>

      <div class="books-grid" style="margin-top:12px;">
        <?php if(!empty($search_res) && is_array($search_res)): ?>
          <?php foreach($search_res as $v):
            if(empty($v) || !is_array($v)) continue;
            $u_raw = !empty($v['info_url']) ? (string)$v['info_url'] : '';
            $n_raw = !empty($v['articlename']) ? (string)$v['articlename'] : '';
            if($u_raw === '' || $n_raw === '') continue;
            $u_attr = htmlspecialchars($u_raw, ENT_QUOTES, 'UTF-8');
            $n_html = htmlspecialchars($n_raw, ENT_QUOTES, 'UTF-8');
            $img_attr = htmlspecialchars(!empty($v['img_url']) ? (string)$v['img_url'] : '', ENT_QUOTES, 'UTF-8');
            $sn_html = htmlspecialchars(!empty($v['sortname']) ? (string)$v['sortname'] : '', ENT_QUOTES, 'UTF-8');
            $au_html = htmlspecialchars(!empty($v['author']) ? (string)$v['author'] : '', ENT_QUOTES, 'UTF-8');
            $ds_html = htmlspecialchars(!empty($v['intro_des']) ? (string)$v['intro_des'] : '', ENT_QUOTES, 'UTF-8');
          ?>
            <a class="book-card" href="<?=$u_attr?>">
              <span class="book-cover">
                <img loading="lazy"
                     src="<?=ss_nocover_url()?>"
                     data-src="<?=$img_attr?>"
                     alt="<?=$n_html?>"
                     onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
              </span>
              <span class="book-meta">
                <span class="book-title"><?=$n_html?></span>
                <?php if($sn_html !== '' || $au_html !== ''): ?>
                  <span class="book-sub">
                    <?=$sn_html?><?php if($sn_html !== '' && $au_html !== ''): ?> · <?php endif; ?><?=$au_html?>
                  </span>
                <?php endif; ?>
                <?php if($ds_html !== ''): ?><span class="book-desc"><?=$ds_html?></span><?php endif; ?>
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

  <?php if($searchkey_safe === '' && !empty($articlerows) && is_array($articlerows)): ?>
  <section class="card">
    <div class="card-hd"><h2 class="h2">热门推荐</h2></div>
    <div class="list">
      <?php $i=0; foreach($articlerows as $v):
        $i++; if($i>10) break;
        if(empty($v) || !is_array($v)) continue;
        $u_raw = !empty($v['info_url']) ? (string)$v['info_url'] : '';
        $n_raw = !empty($v['articlename']) ? (string)$v['articlename'] : '';
        $a_raw = !empty($v['author']) ? (string)$v['author'] : '';
        if($u_raw === '' || $n_raw === '') continue;
      ?>
        <a class="item" href="<?=htmlspecialchars($u_raw, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($n_raw, ENT_QUOTES, 'UTF-8')?><?php if($a_raw !== ''): ?> <span class="muted">/ <?=htmlspecialchars($a_raw, ENT_QUOTES, 'UTF-8')?></span><?php endif; ?></a>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
