<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_e')) {
    function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
$author_url_raw = (isset($uri) && $uri) ? (string)$uri : '';
$author_url_attr = htmlspecialchars($author_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$author_name_raw = isset($author) ? (string)$author : '';
$author_name_html = ss_e($author_name_raw);
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
      $seo_title = $author_name_raw . '作品大全_' . SITE_NAME;
  }
  if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
      $seo_keywords = $author_name_raw . ',作品大全,' . SITE_NAME;
  }
  if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
      $seo_description = '作者' . $author_name_raw . '作品列表与最新章节，尽在' . SITE_NAME . '。';
  }
  $author_ld = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
          ['@type' => 'ListItem', 'position' => 2, 'name' => $author_name_raw . '作品大全', 'item' => $author_url_raw !== '' ? $author_url_raw : $site_home_url_raw],
      ],
  ];
  ?>
  <title><?=ss_e($seo_title)?></title>
  <meta name="keywords" content="<?=ss_e($seo_keywords)?>">
  <meta name="description" content="<?=ss_e($seo_description)?>">
  <?php if ($author_url_raw !== ''): ?>
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$author_url_attr?>">
  <link rel="canonical" href="<?=$author_url_attr?>">
  <meta property="og:url" content="<?=$author_url_attr?>">
  <?php endif; ?>
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=ss_e($seo_title)?>">
  <meta property="og:description" content="<?=ss_e($seo_description)?>">
  <script type="application/ld+json"><?=json_encode($author_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1><?=$author_name_html?></h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="<?=$site_home_url_attr?>" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once 'tpl_search_form.php'; ?>

  <div id="content">
    <div class="article">
      <h2><span>作者作品</span></h2>
      <div class="block">
        <p>作者「<?=$author_name_html?>」共有 <?=$author_count_int?> 部作品</p>
      </div>
    </div>

    <div class="cover" id="jieqi_page_contents">
      <?php if (is_array($res) && !empty($res)): ?>
        <?php foreach($res as $k => $v): ?>
          <?php
          $info_url_attr = htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8');
          $img_url_attr = htmlspecialchars((string)($v['img_url'] ?? ''), ENT_QUOTES, 'UTF-8');
          $title_html = htmlspecialchars((string)($v['articlename'] ?? ''), ENT_QUOTES, 'UTF-8');
          $intro_html = htmlspecialchars((string)($v['intro_des'] ?? ''), ENT_QUOTES, 'UTF-8');
          $sort_html = htmlspecialchars((string)($v['sortname_2'] ?? ''), ENT_QUOTES, 'UTF-8');
          $status_html = htmlspecialchars((string)($v['isfull'] ?? ''), ENT_QUOTES, 'UTF-8');
          $words_html = htmlspecialchars((string)($v['words_w'] ?? ''), ENT_QUOTES, 'UTF-8');
          $lastupdate_html = htmlspecialchars((string)Text::ss_lastupdate($v['lastupdate'] ?? ''), ENT_QUOTES, 'UTF-8');
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
              <p class="book-meta">作者：<?=$author_name_html?></p>
              <p class="book-meta">分类：<?=$sort_html?> / <?=$status_html?></p>
              <p class="book-meta">字数：<?=$words_html?>万字 / 更新：<?=$lastupdate_html?></p>
              <p class="book-desc"><?=$intro_html?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="article">
          <h2><span>暂无作品</span></h2>
          <div class="block">
            <p>当前作者暂无可展示作品。</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
