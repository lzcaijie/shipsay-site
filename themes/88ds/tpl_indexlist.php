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
$info_url_attr = htmlspecialchars((string)$info_url, ENT_QUOTES, 'UTF-8');
$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8');
$last_url_attr = htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8');
$lastchapter_html = htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8');
$lastupdate_html = htmlspecialchars((string)$lastupdate, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$latest_rows = [];
if (!empty($lastarr) && is_array($lastarr)) $latest_rows = $lastarr;
elseif (!empty($lastchapter_arr) && is_array($lastchapter_arr)) $latest_rows = array_slice($lastchapter_arr, 0, 12);
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
  <script type="application/ld+json"><?=json_encode($indexlist_breadcrumb_ld, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
    <?php
    $page_title = $articlename;
    $page_back_url = !empty($info_url) ? (string)$info_url : ($sort_url_raw !== '' ? $sort_url_raw : $site_home_url_raw);
    $page_back_label = '返回详情';
    ss_render_page_top(['page_title' => $page_title, 'page_back_url' => $page_back_url, 'page_back_label' => $page_back_label, 'site_home_url' => $site_home_url_raw]);
    ?>

    <div id="content">
      <div class="cover">
        <div class="block">
          <div class="block_img">
            <img src="<?=$img_url_attr?>" alt="<?=$article_title_html?>" loading="lazy" width="120" height="160" style="background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); object-fit: cover;" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg'; this.onerror=null;">
          </div>
          <div class="block_txt">
            <h2 id="bookname"><a href="<?=$info_url_attr?>"><?=$article_title_html?></a></h2>
            <p>作者：<a href="<?=$author_url_attr?>"><?=$author_html?></a></p>
            <p>分类：<a href="<?=$sort_url_attr?>"><?=$sortname_html?></a></p>
            <p>状态：<?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?></p>
            <p>更新：<?=$lastupdate_html?></p>
            <p>最新：<a href="<?=$last_url_attr?>"><?=$lastchapter_html?></a></p>
          </div>
        </div>
        <div class="clear"></div>
        <div class="ablum_read" id="chapterlist">
          <span class="left"><a href="<?=$first_url_attr?>">开始阅读</a></span>
          <span><a href="<?=$info_url_attr?>">返回详情</a></span>
          <span><a href="<?=$site_home_url_attr?>">返回首页</a></span>
        </div>
        <?php if (!empty($latest_rows)): ?>
        <div class="intro"><?=$article_title_html?> 最新12章</div>
        <ul class="chapter" id="chapterlist2">
          <?php foreach($latest_rows as $k => $v): $cid_url_attr = htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8'); $cname_html = htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8'); ?>
          <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=$cid_url_attr?>"><?=$cname_html?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <div class="intro"><?=$article_title_html?> 章节目录<?php if ($pid > 1): ?>（第<?=$pid?>页）<?php endif; ?></div>
        <div class="intro_info">共<?=intval($chapters)?>章，当前显示<?=($pid-1)*50+1?>-<?=min($pid*50, intval($chapters))?>章</div>
        <ul class="chapter">
          <?php foreach($list_arr as $v): $cid_url_attr = htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8'); $cname_html = htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8'); ?>
            <li><a href="<?=$cid_url_attr?>"><?=$cname_html?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
    <div class="index-container"><?=$htmltitle?></div>

    <?php if (isset($is_langtail) && $is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)): ?>
    <div class="article">
      <h2><span>相关推荐</span></h2>
      <div class="block">
        <?php foreach ($langtailrows as $v): $langtail_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $langname_html = htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8'); ?>
          <a href="<?=$langtail_url_attr?>"><?=$langname_html?></a>&nbsp;
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
