<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
$page_title = '排行榜';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_entry_url_raw = '';
if (!empty($rank_entry_url)) {
  $rank_entry_url_raw = rtrim((string)$rank_entry_url, '/') . '/';
} elseif (!empty($fake_top)) {
  $rank_entry_url_raw = rtrim((string)$fake_top, '/') . '/';
}
$rank_detail_base_raw = !empty($rank_detail_base) ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
  $seo_title = $page_title . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
  $seo_keywords = '排行榜,日榜,周榜,月榜,总榜,推荐榜,收藏榜,' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
  $seo_description = SITE_NAME . '排行榜聚合页，查看日榜、周榜、月榜、总榜、推荐榜、收藏榜。';
}
$top_url_attr = htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8');
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($rank_entry_url_raw !== ''): ?>
<link rel="canonical" href="<?=$top_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$top_url_attr?>">
<meta property="og:url" content="<?=$top_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
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
  <?php if (!empty($rank_sections)): ?>
  <section class="card">
    <div class="chips">
      <?php if ($rank_entry_url_raw !== ''): ?><a class="chip active" href="<?=$top_url_attr?>">聚合榜</a><?php else: ?><span class="chip active" aria-disabled="true">聚合榜</span><?php endif; ?>
      <?php foreach ($rank_sections as $key => $conf): ?>
        <?php $more_raw = isset($conf['more']) ? (string)$conf['more'] : ''; ?>
        <?php $title_html = htmlspecialchars(isset($conf['title']) ? (string)$conf['title'] : '', ENT_QUOTES, 'UTF-8'); ?>
        <?php if ($more_raw !== ''): ?>
          <a class="chip" href="<?=htmlspecialchars($more_raw, ENT_QUOTES, 'UTF-8')?>"><?=$title_html?></a>
        <?php else: ?>
          <span class="chip" aria-disabled="true"><?=$title_html?></span>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="top-rank-grid">
    <?php foreach ($rank_sections as $key => $conf): ?>
      <?php
      $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
      $more_raw = isset($conf['more']) ? (string)$conf['more'] : '';
      $more_attr = htmlspecialchars($more_raw, ENT_QUOTES, 'UTF-8');
      $title_html = htmlspecialchars(isset($conf['title']) ? (string)$conf['title'] : '', ENT_QUOTES, 'UTF-8');
      ?>
      <section class="card top-card">
        <div class="top-card-head">
          <h2><?=$title_html?></h2>
          <?php if ($more_raw !== ''): ?><a href="<?=$more_attr?>">更多</a><?php else: ?><span aria-disabled="true">更多</span><?php endif; ?>
        </div>
        <ol class="top-card-list">
          <?php if (!empty($list)): ?>
            <?php foreach (array_slice($list, 0, $rank_limit) as $i => $v): ?>
              <?php
              $info_url_attr = htmlspecialchars(isset($v['info_url']) ? (string)$v['info_url'] : '', ENT_QUOTES, 'UTF-8');
              $title_item_html = htmlspecialchars(isset($v['articlename']) ? (string)$v['articlename'] : '', ENT_QUOTES, 'UTF-8');
              $author_html = htmlspecialchars(isset($v['author']) ? (string)$v['author'] : '', ENT_QUOTES, 'UTF-8');
              ?>
              <li>
                <span class="rank-num"><?=$i + 1?></span>
                <div class="rank-main">
                  <?php if ($info_url_attr !== ''): ?>
                    <a href="<?=$info_url_attr?>" class="rank-bookname"><?=$title_item_html?></a>
                  <?php else: ?>
                    <span class="rank-bookname no-link"><?=$title_item_html?></span>
                  <?php endif; ?>
                  <em><?=$author_html?></em>
                </div>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="rank-empty">暂无数据</li>
          <?php endif; ?>
        </ol>
      </section>
    <?php endforeach; ?>
  </section>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
