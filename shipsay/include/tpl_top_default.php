<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__ . '/shipsay/seo.php';
$page_title = '排行榜';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('rank');

$rank_entry_url_raw = '';
if (isset($rank_entry_url) && $rank_entry_url) {
    $rank_entry_url_raw = (string)$rank_entry_url;
} elseif (isset($fake_top) && $fake_top) {
    $rank_entry_url_raw = (string)$fake_top;
}
$rank_detail_base_raw = isset($rank_detail_base) && $rank_detail_base ? (string)$rank_detail_base : $rank_entry_url_raw;
$rank_page_title = '排行榜';
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = $rank_page_title . '_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = '排行榜,日榜,周榜,月榜,总榜,推荐榜,收藏榜,' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = SITE_NAME . '小说排行榜聚合页，查看日榜、周榜、月榜、总榜、推荐榜、收藏榜。';
}
$top_url_raw = $rank_entry_url_raw;
$top_url_attr = htmlspecialchars($top_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
$use_theme_header = defined('__THEME_DIR__') && is_file(__THEME_DIR__ . '/tpl_header.php');
$use_theme_footer = defined('__THEME_DIR__') && is_file(__THEME_DIR__ . '/tpl_footer.php');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($top_url_raw !== ''): ?>
<link rel="canonical" href="<?=$top_url_attr?>">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=xhtml;url=<?=$top_url_attr?>">
<meta property="og:url" content="<?=$top_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": <?=json_encode($seo_title, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
  "description": <?=json_encode($seo_description, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
  "url": <?=json_encode($top_url_raw, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>
}
</script>
<?php if ($use_theme_header): ?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<?php else: ?>
</head>
<body>
<?php endif; ?>
<div class="container" style="max-width:1200px;margin:0 auto;padding:12px;">
  <div class="bread_crumbs" style="margin:10px 0;">
    <a href="<?=$site_home_url_attr?>">首页</a> &gt; <span>排行榜</span>
  </div>
  <h1 style="font-size:18px;margin:10px 0;"><?=htmlspecialchars($rank_page_title, ENT_QUOTES, 'UTF-8')?></h1>
  <?php if (!empty($rank_sections)): ?>
  <div style="margin:10px 0;display:flex;flex-wrap:wrap;gap:8px;">
    <?php foreach ($rank_sections as $key => $conf): ?>
      <?php
      $more_raw = isset($conf['more']) ? (string)$conf['more'] : '';
      $more_attr = htmlspecialchars($more_raw, ENT_QUOTES, 'UTF-8');
      $title_html = htmlspecialchars((string)(isset($conf['title']) ? $conf['title'] : ''), ENT_QUOTES, 'UTF-8');
      ?>
      <?php if ($more_raw !== ''): ?>
      <a href="<?=$more_attr?>" rel="nofollow"><?=$title_html?></a>
      <?php else: ?>
      <span style="opacity:.7;"><?=$title_html?></span>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php foreach ($rank_sections as $key => $conf): ?>
    <?php
    $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
    $more_raw = isset($conf['more']) ? (string)$conf['more'] : '';
    $more_attr = htmlspecialchars($more_raw, ENT_QUOTES, 'UTF-8');
    $title_html = htmlspecialchars((string)(isset($conf['title']) ? $conf['title'] : ''), ENT_QUOTES, 'UTF-8');
    ?>
    <div style="margin:14px 0;padding:12px;border:1px solid #eee;border-radius:8px;">
      <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
        <strong><?=$title_html?></strong>
        <?php if ($more_raw !== ''): ?>
        <a href="<?=$more_attr?>" rel="nofollow">更多</a>
        <?php else: ?>
        <span style="opacity:.7;">更多</span>
        <?php endif; ?>
      </div>
      <ol style="margin:10px 0 0 18px;line-height:1.8;">
        <?php if (!empty($list)): ?>
          <?php foreach (array_slice($list, 0, $rank_limit) as $i => $v): ?>
            <?php
            $info_url_raw = isset($v['info_url']) ? (string)$v['info_url'] : '';
            $info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
            $title_item_html = htmlspecialchars((string)(isset($v['articlename']) ? $v['articlename'] : ''), ENT_QUOTES, 'UTF-8');
            $author_html = htmlspecialchars((string)(isset($v['author']) ? $v['author'] : ''), ENT_QUOTES, 'UTF-8');
            ?>
            <li>
              <span style="display:inline-block;min-width:24px;"><?=intval($i) + 1?>.</span>
              <?php if ($info_url_raw !== ''): ?>
              <a href="<?=$info_url_attr?>" title="<?=$title_item_html?>"><?=$title_item_html?></a>
              <?php else: ?>
              <span><?=$title_item_html?></span>
              <?php endif; ?>
              <?php if ($author_html !== ''): ?>
              <span style="opacity:.7;margin-left:8px;"><?=$author_html?></span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li style="opacity:.7;">暂无数据</li>
        <?php endif; ?>
      </ol>
    </div>
  <?php endforeach; ?>
</div>

<?php if ($use_theme_footer): ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
<?php else: ?>
</body>
</html>
<?php endif; ?>
