<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_e')) {
    function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
$searchkey_raw = isset($searchkey) ? (string)$searchkey : '';
$searchkey_safe = htmlspecialchars($searchkey_raw, ENT_QUOTES, 'UTF-8');
$search_count_safe = isset($search_count) ? intval($search_count) : (is_array($search_res) ? count($search_res) : 0);
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$search_url_page_raw = (isset($uri) && $uri) ? (string)$uri : $search_url_raw;
$search_url_page_attr = htmlspecialchars($search_url_page_raw, ENT_QUOTES, 'UTF-8');
$search_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '搜索结果', 'item' => $search_url_page_raw !== '' ? $search_url_page_raw : $site_home_url_raw],
    ],
];
$search_lower = function ($text) {
    return function_exists('mb_strtolower') ? mb_strtolower((string)$text, 'UTF-8') : strtolower((string)$text);
};
$search_highlight = function ($text) use ($searchkey_raw, $search_lower) {
    $text = (string)$text;
    if ($searchkey_raw === '') return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $parts = preg_split('/(' . preg_quote($searchkey_raw, '/') . ')/iu', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
    if (!is_array($parts)) return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $out = '';
    $needle = $search_lower($searchkey_raw);
    foreach ($parts as $part) {
        $safe = htmlspecialchars($part, ENT_QUOTES, 'UTF-8');
        if ($part !== '' && $search_lower($part) === $needle) {
            $out .= '<span class="hot">' . $safe . '</span>';
        } else {
            $out .= $safe;
        }
    }
    return $out;
};
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <?php if ($search_url_page_raw !== ''): ?>
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$search_url_page_attr?>">
  <link rel="canonical" href="<?=$search_url_page_attr?>">
  <meta property="og:url" content="<?=$search_url_page_attr?>">
  <?php endif; ?>
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <script type="application/ld+json"><?=json_encode($search_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
  <?php
  $page_title = '搜索结果';
  $page_back_url = $site_home_url_raw;
  require __THEME_DIR__ . '/tpl_page_top.php';
  ?>

  <div id="content">
    <div class="article">
      <h2><span>“<?=$searchkey_safe?>” 共找到 <?=$search_count_safe?> 条结果</span></h2>
      <div class="block">
        <p style="color:#666;line-height:1.8;margin:0;">搜索词：<?=$searchkey_safe !== '' ? $searchkey_safe : '未填写关键词'?></p>
      </div>
    </div>

    <div class="cover" id="jieqi_page_contents">
      <?php if (is_array($search_res) && !empty($search_res)): ?>
        <?php foreach($search_res as $k => $v): ?>
          <?php
          $info_url_attr = htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8');
          $img_url_attr = htmlspecialchars((string)($v['img_url'] ?? ''), ENT_QUOTES, 'UTF-8');
          $title_raw = (string)($v['articlename'] ?? '');
          $author_raw = (string)($v['author'] ?? '');
          $sortname_raw = (string)($v['sortname'] ?? '');
          $intro_raw = (string)($v['intro_des'] ?? '');
          ?>
          <div class="block">
            <div class="block_img">
              <a href="<?=$info_url_attr?>">
                <img src="<?=$img_url_attr?>" alt="<?=htmlspecialchars($title_raw, ENT_QUOTES, 'UTF-8')?>" loading="lazy"
                     onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
              </a>
            </div>
            <div class="block_txt">
              <h2 class="book-title"><a href="<?=$info_url_attr?>"><?=$search_highlight($title_raw)?></a></h2>
              <p class="book-meta">作者：<?=$search_highlight($author_raw)?></p>
              <p class="book-meta">分类：<?=htmlspecialchars($sortname_raw, ENT_QUOTES, 'UTF-8')?></p>
              <p class="book-desc"><?=$search_highlight($intro_raw)?></p>
            </div>
          </div>
        <?php endforeach ?>
      <?php else: ?>
        <div class="article">
          <h2><span>暂无搜索结果</span></h2>
          <div class="block">
            <p style="color:#666;line-height:1.8;margin:0;">没有找到与“<?=$searchkey_safe?>”相关的内容，请尝试更换书名、作者名或更短的关键词。</p>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
