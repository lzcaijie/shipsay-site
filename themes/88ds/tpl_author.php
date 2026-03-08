<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_e')) {
  function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
$author_url_raw = (isset($uri) && $uri) ? (string)$uri : '';
$author_url_attr = htmlspecialchars($author_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$author_count_int = isset($author_count) ? intval($author_count) : (is_array($res) ? count($res) : 0);
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
  if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
      $seo_title = $author . '作品大全_' . SITE_NAME;
  }
  if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
      $seo_keywords = $author . ',作品大全,' . SITE_NAME;
  }
  if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
      $seo_description = '作者' . $author . '作品列表与最新章节，尽在' . SITE_NAME . '。';
  }
  $author_ld = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
          ['@type' => 'ListItem', 'position' => 2, 'name' => $author . '作品大全', 'item' => $author_url_raw],
      ],
  ];
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <?php if ($author_url_raw !== ''): ?>
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$author_url_attr?>">
  <link rel="canonical" href="<?=$author_url_attr?>">
  <meta property="og:url" content="<?=$author_url_attr?>">
  <?php endif; ?>
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <script type="application/ld+json"><?=json_encode($author_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>

  <div class="container">
    <div class="bread">
      <a href="<?=$site_home_url_attr?>"><?=ss_e(SITE_NAME)?></a> &gt; <span>作者作品</span> &gt; <h1><?=ss_e($author)?></h1>
    </div>
    <div class="article"><h2><span>作者「<?=ss_e($author)?>」共有 <?=$author_count_int?> 部作品</span></h2></div>

    <div class="cover" id="jieqi_page_contents">
      <?php if (is_array($res)): ?>
        <?php $__i=0; ?>
        <?php foreach($res as $k => $v): $__i++; if($__i>50) break; ?>
          <?php
          $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
          $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8');
          $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
          $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8');
          $sort_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8');
          $status_html = htmlspecialchars((string)$v['isfull'], ENT_QUOTES, 'UTF-8');
          $words_html = htmlspecialchars((string)$v['words_w'], ENT_QUOTES, 'UTF-8');
          ?>
          <div class="block">
            <div class="block_img">
              <a href="<?=$info_url_attr?>">
                <img src="<?=$img_url_attr?>" alt="<?=$title_html?>" loading="lazy"
                     onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
              </a>
            </div>
            <div class="block_txt">
              <p class="block_tit"><a href="<?=$info_url_attr?>"><?=$title_html?></a></p>
              <p class="block_desc"><?=$intro_html?></p>
              <p class="block_meta"><span><?=$sort_html?></span><span><?=$status_html?></span><span><?=$words_html?>万字</span></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
