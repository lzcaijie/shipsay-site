<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$year = isset($year) ? $year : date('Y');
$category_name_raw = isset($sortname) && trim((string)$sortname) !== '' ? (string)$sortname : '全部小说';
$category_heading_html = htmlspecialchars($category_name_raw, ENT_QUOTES, 'UTF-8');
$category_url_raw = (isset($uri) && $uri) ? (string)$uri : (string)Sort::ss_sorturl($sortid);
$category_url_attr = htmlspecialchars($category_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
  if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
      $seo_title = $category_name_raw . '_'.$year.'最新小说列表_' . SITE_NAME;
  }
  if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
      $seo_keywords = $category_name_raw . ',小说列表,' . SITE_NAME;
  }
  if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
      $seo_description = $category_name_raw . '小说列表与最新更新，尽在' . SITE_NAME . '。';
  }
  $category_ld = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
          ['@type' => 'ListItem', 'position' => 2, 'name' => $category_name_raw, 'item' => $category_url_raw],
      ],
  ];
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$category_url_attr?>">
  <link rel="canonical" href="<?=$category_url_attr?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:url" content="<?=$category_url_attr?>">
  <script type="application/ld+json"><?=json_encode($category_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
  <?php
  $page_title = $category_name_raw;
  $page_back_url = $site_home_url_raw;
  require __THEME_DIR__ . '/tpl_page_top.php';
  ?>

  <div id="content">
    <div class="cover">
      <?php if(is_array($retarr)):?><?php foreach($retarr as $k => $v): ?>
      <?php
      $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
      $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8');
      $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
      $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8');
      $lastupdate_html = htmlspecialchars((string)Text::ss_lastupdate($v['lastupdate']), ENT_QUOTES, 'UTF-8');
      $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8');
      ?>
      <div class="block">
        <div class="block_img">
          <a href="<?=$info_url_attr?>">
            <img src="<?=$img_url_attr?>" alt="<?=$title_html?>" loading="lazy"
                 onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
          </a>
        </div>
        <div class="block_txt">
          <h2 class="book-title"><a href="<?=$info_url_attr?>"><?=$title_html?></a></h2>
          <p class="book-meta">作者：<?=$author_html?></p>
          <p class="book-meta">更新：<?=$lastupdate_html?></p>
          <p class="book-desc"><?=$intro_html?></p>
        </div>
      </div>
      <?php endforeach ?><?php endif ?>
    </div>

    <div class="index-container"><?=$jump_html_wap?></div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
