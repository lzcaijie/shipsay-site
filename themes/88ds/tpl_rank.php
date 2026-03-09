<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__ . '/shipsay/seo.php';
  list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('rank');
  $rank_entry_url_raw = isset($rank_entry_url) && $rank_entry_url ? rtrim((string)$rank_entry_url, '/') . '/' : ((isset($fake_top) && $fake_top) ? rtrim((string)$fake_top, '/') . '/' : '');
  $rank_entry_url_attr = htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8');
  $rank_detail_base_raw = isset($rank_detail_base) && $rank_detail_base ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
  $title_arr = isset($title_arr) && is_array($title_arr) ? $title_arr : [
    'allvisit'   => '总点击榜',
    'monthvisit' => '月点击榜',
    'weekvisit'  => '周点击榜',
    'dayvisit'   => '日点击榜',
    'allvote'    => '总推荐榜',
    'monthvote'  => '月推荐榜',
    'weekvote'   => '周推荐榜',
    'dayvote'    => '日推荐榜',
    'goodnum'    => '收藏榜'
  ];
  $current_query = isset($query) && trim((string)$query) !== '' ? trim((string)$query) : 'allvisit';
  $current_title = isset($title_arr[$current_query]) ? (string)$title_arr[$current_query] : ((isset($page_title) && $page_title) ? (string)$page_title : '排行榜');
  $page_title = $current_title;
  $site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
  $site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
  $canonical_url_raw = (isset($uri) && $uri) ? (string)$uri : ($rank_detail_base_raw . $current_query . '/');
  $canonical_url_attr = htmlspecialchars($canonical_url_raw, ENT_QUOTES, 'UTF-8');
  if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
      $seo_title = $current_title . '_' . SITE_NAME;
  }
  if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
      $seo_keywords = $current_title . ',排行榜,' . SITE_NAME;
  }
  if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
      $seo_description = $current_title . '榜单，尽在' . SITE_NAME . '。';
  }
  $rank_breadcrumb_ld = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
          ['@type' => 'ListItem', 'position' => 2, 'name' => '排行榜', 'item' => $rank_entry_url_raw !== '' ? $rank_entry_url_raw : $site_home_url_raw],
          ['@type' => 'ListItem', 'position' => 3, 'name' => $current_title, 'item' => $canonical_url_raw],
      ],
  ];
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <link rel="canonical" href="<?=$canonical_url_attr?>">
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$canonical_url_attr?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:url" content="<?=$canonical_url_attr?>">
  <script type="application/ld+json"><?=json_encode($rank_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
  <style>
    .rank-switch-list{display:flex;flex-wrap:wrap;margin:0;padding:0;}
    .rank-switch-list li{width:50%;box-sizing:border-box;border-bottom:none;white-space:normal;line-height:1.4;padding:0;}
    .rank-switch-list a{display:block;margin:4px;padding:10px 12px;border:1px solid #dfeaea;border-radius:4px;background:#fff;color:#333;}
    .rank-switch-list a.active{background:#208181;border-color:#208181;color:#fff;font-weight:700;}
    .rank-list-items li{white-space:normal;overflow:hidden;text-overflow:ellipsis;}
    .rank-list-items li a{color:#208181;}
    @media (max-width:480px){
      .rank-switch-list a{padding:9px 10px;font-size:14px;}
    }
  </style>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1><?=htmlspecialchars((string)$page_title, ENT_QUOTES, 'UTF-8')?></h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="<?=$site_home_url_attr?>" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once 'tpl_search_form.php'; ?>

  <div id="content">
    <div class="article">
      <h2><span>榜单切换</span></h2>
      <div class="block">
        <ul class="rank-switch-list">
          <?php if ($rank_entry_url_raw !== ''): ?><li><a href="<?=$rank_entry_url_attr?>">聚合排行</a></li><?php endif; ?>
          <?php foreach ($title_arr as $k => $t): ?>
            <?php $tab_url_attr = htmlspecialchars($rank_detail_base_raw . $k . '/', ENT_QUOTES, 'UTF-8'); ?>
            <li><a href="<?=$tab_url_attr?>"<?=$current_query === $k ? ' class="active"' : ''?>><?=htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8')?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="article">
      <h2><span><?=htmlspecialchars((string)$page_title, ENT_QUOTES, 'UTF-8')?></span></h2>
      <div class="block">
        <ul class="rank-list-items">
          <?php if (!empty($articlerows) && is_array($articlerows)): ?>
            <?php foreach ($articlerows as $k => $v): ?><?php if ($k < 48): ?>
              <?php
                $info_url = isset($v['info_url']) ? (string)$v['info_url'] : '';
                $name = isset($v['articlename']) ? (string)$v['articlename'] : '';
                $author = isset($v['author']) ? (string)$v['author'] : '';
                if ($info_url === '' || $name === '') continue;
              ?>
              <li><span><?=($k + 1)?>.</span> <a href="<?=htmlspecialchars($info_url, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?></a><?php if ($author !== ''): ?> / <?=htmlspecialchars($author, ENT_QUOTES, 'UTF-8')?><?php endif; ?></li>
            <?php endif; ?><?php endforeach; ?>
          <?php else: ?>
            <li>暂无排行榜数据</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
