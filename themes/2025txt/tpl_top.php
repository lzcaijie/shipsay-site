<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
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
$site_home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
$top_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => $seo_title,
    'description' => $seo_description,
    'url' => $rank_entry_url_raw,
];
?>
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
<script type="application/ld+json"><?=json_encode($top_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20251207" />
</head>
<body>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container autoheight rank-top-page">
  <ol class="navigator">
    <li><a href="<?=$site_home_url_attr?>">首页</a></li>
    <li class="active">排行榜</li>
  </ol>

  <?php if (!empty($rank_sections)): ?>
  <div class="rank-switch">
    <div class="rank-switch-title">切换榜单</div>
    <div class="rank-switch-list">
      <?php if ($rank_entry_url_raw !== ''): ?><a href="<?=$top_url_attr?>" class="active">聚合榜</a><?php else: ?><a class="active" aria-disabled="true">聚合榜</a><?php endif; ?>
      <?php foreach ($rank_sections as $key => $conf): ?>
        <?php $more_raw = isset($conf['more']) ? (string)$conf['more'] : ''; ?>
        <?php $title_html = htmlspecialchars(isset($conf['title']) ? (string)$conf['title'] : '', ENT_QUOTES, 'UTF-8'); ?>
        <?php if ($more_raw !== ''): ?>
          <a href="<?=htmlspecialchars($more_raw, ENT_QUOTES, 'UTF-8')?>"><?=$title_html?></a>
        <?php else: ?>
          <a aria-disabled="true"><?=$title_html?></a>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <div class="top-rank-grid">
    <?php foreach ($rank_sections as $key => $conf): ?>
      <?php
      $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
      $more_raw = isset($conf['more']) ? (string)$conf['more'] : '';
      $more_attr = htmlspecialchars($more_raw, ENT_QUOTES, 'UTF-8');
      $title_html = htmlspecialchars(isset($conf['title']) ? (string)$conf['title'] : '', ENT_QUOTES, 'UTF-8');
      ?>
      <section class="top-card">
        <div class="top-card-head">
          <h2><?=$title_html?></h2>
          <?php if ($more_raw !== ''): ?><a href="<?=$more_attr?>">更多</a><?php else: ?><span>更多</span><?php endif; ?>
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
  </div>
</div>
<style>
.rank-switch-title{font-size:16px;font-weight:700;padding:0 0 10px;border-bottom:1px solid #f0f0f0;margin:12px 0}
.rank-switch-list{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:18px}
.rank-switch-list a{display:inline-flex;align-items:center;height:34px;padding:0 14px;border:1px solid #e9e9e9;background:#fff;border-radius:18px;white-space:nowrap;line-height:34px;color:#333;text-decoration:none}
.rank-switch-list a.active{background:#ff4a4a;border-color:#ff4a4a;color:#fff;font-weight:700}
.top-rank-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;margin-top:4px}
.top-card{background:#fff;border:1px solid #efefef;border-radius:12px;overflow:hidden}
.top-card-head{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #f3f3f3;gap:12px}
.top-card-head h2{margin:0;font-size:18px;line-height:1.3;color:#222;font-weight:700}
.top-card-head a,.top-card-head span{font-size:14px;color:#666;text-decoration:none;white-space:nowrap}
.top-card-list{list-style:none;margin:0;padding:0}
.top-card-list li{display:flex;align-items:flex-start;gap:12px;padding:12px 16px;border-top:1px dashed #f1f1f1}
.top-card-list li:first-child{border-top:none}
.rank-num{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:#f5f5f5;color:#555;font-weight:700;flex:0 0 28px;font-style:normal}
.top-card-list li:nth-child(1) .rank-num{background:#ffede8;color:#ff5a36}
.top-card-list li:nth-child(2) .rank-num{background:#fff3df;color:#f59a23}
.top-card-list li:nth-child(3) .rank-num{background:#eef4ff;color:#4b6bfb}
.rank-main{min-width:0;flex:1 1 auto;display:flex;flex-direction:column;gap:4px}
.rank-bookname{display:block;font-size:16px;line-height:1.45;color:#222;text-decoration:none;font-weight:700;word-break:break-all}
.rank-bookname.no-link{color:#666}
.rank-main em{font-style:normal;font-size:13px;line-height:1.4;color:#888;word-break:break-all}
.rank-empty{color:#888;justify-content:center;padding:18px 16px}
@media (max-width:767px){
  .top-rank-grid{grid-template-columns:1fr;gap:12px}
  .rank-switch-list{gap:8px}
  .rank-switch-list a{height:32px;padding:0 12px}
  .top-card-head{padding:12px 14px}
  .top-card-head h2{font-size:17px}
  .top-card-list li{padding:11px 14px}
  .rank-bookname{font-size:15px}
}
</style>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
