<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__ . '/shipsay/seo.php';
  list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('rank');
  $rank_entry_url_raw = isset($rank_entry_url) && $rank_entry_url ? (string)$rank_entry_url : ((isset($fake_top) && $fake_top) ? (string)$fake_top : '');
  $rank_entry_url_attr = htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8');
  $site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
  $site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
  $rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
  $rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
  if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
      $seo_title = '小说排行榜_' . SITE_NAME;
  }
  if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
      $seo_keywords = '小说排行榜,热门小说,日榜,周榜,月榜,' . SITE_NAME;
  }
  if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
      $seo_description = SITE_NAME . '小说排行榜聚合页，查看日榜、周榜、月榜、总榜、推荐榜、收藏榜。';
  }
  $rank_ld = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
          ['@type' => 'ListItem', 'position' => 2, 'name' => '排行榜', 'item' => $rank_entry_url_raw],
      ],
  ];
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <?php if ($rank_entry_url_raw !== ''): ?>
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$rank_entry_url_attr?>">
  <link rel="canonical" href="<?=$rank_entry_url_attr?>">
  <meta property="og:url" content="<?=$rank_entry_url_attr?>">
  <?php endif; ?>
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <script type="application/ld+json"><?=json_encode($rank_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1>小说排行榜</h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="<?=$site_home_url_attr?>" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once 'tpl_search_form.php'; ?>

  <div id="content">
    <div class="article">
      <div class="article">
        <h2><span>榜单导航</span></h2>
        <div class="block">
          <ul>
            <?php foreach ($rank_sections as $key => $conf): ?>
              <?php $more_attr = htmlspecialchars((string)$conf['more'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8'); ?>
              <li><a href="<?=$more_attr?>"><?=$title_html?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <?php foreach ($rank_sections as $key => $conf): ?>
        <?php
          $title = isset($conf['title']) ? (string)$conf['title'] : '';
          $more  = isset($conf['more']) ? (string)$conf['more'] : '#';
          $list  = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
          $more_attr = htmlspecialchars($more, ENT_QUOTES, 'UTF-8');
          $title_html = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        ?>
        <div class="article">
          <h2><span><a href="<?=$more_attr?>"><?=$title_html?></a></span><a style="float:right;font-size:12px;font-weight:normal;color:#999;" href="<?=$more_attr?>">更多 &gt;</a></h2>
          <div class="block">
            <ul>
              <?php if (!empty($list)): ?>
                <?php foreach (array_slice($list, 0, 10) as $k => $v): ?>
                  <?php
                    $info_url = (isset($v['info_url']) && $v['info_url']) ? (string)$v['info_url'] : '';
                    $name = (isset($v['articlename']) && $v['articlename']) ? (string)$v['articlename'] : '';
                    $author = (isset($v['author']) && $v['author']) ? (string)$v['author'] : '';
                    if ($info_url === '' || $name === '') continue;
                  ?>
                  <li><span style="color:#999;margin-right:6px;"><?=($k+1)?>.</span><a href="<?=htmlspecialchars($info_url, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?></a><?php if ($author !== ''): ?> / <?=htmlspecialchars($author, ENT_QUOTES, 'UTF-8')?><?php endif; ?></li>
                <?php endforeach; ?>
              <?php else: ?>
                <li>暂无数据</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
