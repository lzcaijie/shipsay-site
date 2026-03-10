<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$author_raw = isset($author) ? (string)$author : '';
$author_html = htmlspecialchars($author_raw, ENT_QUOTES, 'UTF-8');
$author_count_safe = intval(isset($author_count) ? $author_count : (is_array($res ?? null) ? count($res) : 0));
$author_page_url_raw = !empty($uri) ? (string)$uri : '';
$author_page_url_attr = htmlspecialchars($author_page_url_raw, ENT_QUOTES, 'UTF-8');
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
  $seo_title = ($author_raw !== '' ? $author_raw . '的作品' : '作者作品') . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
  $seo_keywords = ($author_raw !== '' ? $author_raw . ',' : '') . '作者作品,小说,' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
  $seo_description = ($author_raw !== '' ? $author_raw . '的全部作品' : '作者作品列表') . '，尽在' . SITE_NAME . '。';
}
$seo_title_html = htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8');
$seo_keywords_html = htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8');
$seo_description_html = htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8');
$author_breadcrumb_ld = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
  ],
];
if ($author_page_url_raw !== '') {
  $author_breadcrumb_ld['itemListElement'][] = ['@type' => 'ListItem', 'position' => 2, 'name' => $author_raw !== '' ? $author_raw : '作者作品', 'item' => $author_page_url_raw];
}
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$seo_title_html?></title>
<meta name="keywords" content="<?=$seo_keywords_html?>">
<meta name="description" content="<?=$seo_description_html?>">
<?php if ($author_page_url_raw !== ''): ?>
<link rel="canonical" href="<?=$author_page_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$author_page_url_attr?>">
<meta property="og:url" content="<?=$author_page_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$seo_title_html?>">
<meta property="og:description" content="<?=$seo_description_html?>">
<script type="application/ld+json"><?=json_encode($author_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
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

<main class="wrap">
  <section class="card">
    <div class="muted" style="margin-bottom:10px;line-height:1.7;"><a href="<?=$site_home_url_attr?>">首页</a> &gt; <span><?=$author_html !== '' ? $author_html : '作者作品'?></span></div>
    <div class="card-hd">
      <h1 class="h2"><?=$author_html !== '' ? $author_html : '作者'?> 的作品</h1>
      <span class="muted">共 <?=$author_count_safe?> 本</span>
    </div>

    <div class="books-grid">
      <?php if(!empty($res) && is_array($res)): foreach($res as $v):
        if(empty($v) || !is_array($v)) continue;
        $u_raw = !empty($v['info_url']) ? (string)$v['info_url'] : '';
        if($u_raw === '') continue;
        $u_attr = htmlspecialchars($u_raw, ENT_QUOTES, 'UTF-8');
        $img_attr = htmlspecialchars(!empty($v['img_url']) ? (string)$v['img_url'] : '', ENT_QUOTES, 'UTF-8');
        $name_html = htmlspecialchars(!empty($v['articlename']) ? (string)$v['articlename'] : '', ENT_QUOTES, 'UTF-8');
        $sort_html = htmlspecialchars(!empty($v['sortname']) ? (string)$v['sortname'] : '', ENT_QUOTES, 'UTF-8');
        $au_html = htmlspecialchars(!empty($v['author']) ? (string)$v['author'] : '', ENT_QUOTES, 'UTF-8');
        $desc_html = htmlspecialchars(!empty($v['intro_des']) ? (string)$v['intro_des'] : '', ENT_QUOTES, 'UTF-8');
      ?>
        <a class="book-card" href="<?=$u_attr?>">
          <span class="book-cover">
            <img loading="lazy"
                 src="<?=ss_nocover_url()?>"
                 data-src="<?=$img_attr?>"
                 alt="<?=$name_html?>"
                 onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
          </span>
          <span class="book-meta">
            <span class="book-title"><?=$name_html?></span>
            <span class="book-sub"><?=$sort_html?><?php if($sort_html !== '' && $au_html !== ''): ?> · <?php endif; ?><?=$au_html?></span>
            <?php if($desc_html !== ''): ?><span class="book-desc"><?=$desc_html?></span><?php endif; ?>
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
