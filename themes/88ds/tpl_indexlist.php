<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_e')) { function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
$pid = (isset($pid) && (int)$pid>0) ? (int)$pid : 1;
$indexlist_url_raw = (isset($uri) && $uri) ? (string)$uri : ((isset($index_url) && $index_url) ? (string)$index_url : '');
$indexlist_url_attr = htmlspecialchars($indexlist_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$sort_url_raw = (string)Sort::ss_sorturl($sortid);
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$index_back_url_raw = $sort_url_raw !== '' ? $sort_url_raw : $site_home_url_raw;
$index_back_url_attr = htmlspecialchars($index_back_url_raw, ENT_QUOTES, 'UTF-8');
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
  if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
      $seo_title = '《' . $articlename . '》章节目录' . ($pid > 1 ? '_第' . $pid . '页' : '') . '_' . SITE_NAME;
  }
  if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
      $seo_keywords = $articlename . ',章节目录,' . $author . ',' . SITE_NAME;
  }
  if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
      $seo_description = '《' . $articlename . '》完整章节目录，作者：' . $author . '，共' . intval($chapters) . '章。';
  }
  $indexlist_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
      ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => $sort_url_raw],
      ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => (string)$info_url],
      ['@type' => 'ListItem', 'position' => 4, 'name' => '章节目录' . ($pid > 1 ? '第' . $pid . '页' : ''), 'item' => $indexlist_url_raw],
    ],
  ];
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$indexlist_url_attr?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="canonical" href="<?=$indexlist_url_attr?>" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:url" content="<?=$indexlist_url_attr?>">
  <script type="application/ld+json"><?php
$itemlist_elements = [];
if (!empty($list_arr)) {
  foreach ($list_arr as $i => $v) {
    $itemlist_elements[] = [
      '@type'=>'ListItem',
      'position'=>($pid-1)*50 + $i + 1,
      'name'=>(string)($v['cname'] ?? ''),
      'url'=>(string)($site_home_url_raw . ltrim((string)($v['cid_url'] ?? ''), '/')),
    ];
  }
}
echo json_encode([
  '@context'=>'https://schema.org',
  '@type'=>'ItemList',
  'name'=>'《'.$articlename.'》章节目录',
  'description'=>'《'.$articlename.'》完整章节目录，作者：'.$author,
  'numberOfItems'=>(string)$chapters,
  'itemListElement'=>$itemlist_elements,
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
?></script>
  <script type="application/ld+json"><?=json_encode($indexlist_breadcrumb_ld, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>

  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<body>
    <div class="header">
      <div class="back">
        <a href="<?=$index_back_url_attr?>">返回</a>
      </div>
      <h1><?php if ($info_url_raw !== ''): ?><a href="<?=$info_url_attr?>"><?=$article_title_html?></a><?php else: ?><?=$article_title_html?><?php endif; ?></h1>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
		<a href="<?=$site_home_url_attr?>" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>

	<div class="cover">
      <div class="read">
        <h3><?=$article_title_html?> - 章节目录<?php if ($pid > 1): ?>（第<?=$pid?>页）<?php endif; ?></h3>
        <span>共<?=intval($chapters)?>章，当前显示<?=($pid-1)*50+1?>-<?=min($pid*50, intval($chapters))?>章</span>
      </div>
      <ul class="chapter">
	    <?php foreach($list_arr as $v): ?>
          <?php $cid_url_attr = htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8'); $cname_html = htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8'); ?>
        <li><a href="<?=$cid_url_attr?>"><?=$cname_html?></a></li>
		<?php endforeach ?>
      </ul>
    </div>
	<div class="index-container"><?=$htmltitle?></div>

    <?php if (isset($is_langtail) && $is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)): ?>
    <div class="article">
      <h2><span>相关推荐</span></h2>
      <div class="block">
        <?php foreach ($langtailrows as $v): ?>
          <?php $langtail_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $langname_html = htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8'); ?>
          <a href="<?=$langtail_url_attr?>"><?=$langname_html?></a>&nbsp;
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
