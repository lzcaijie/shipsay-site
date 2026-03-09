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
    $seo_keywords = '排行榜,总榜,周榜,月榜,推荐榜,收藏榜,' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = SITE_NAME . '排行榜聚合页，查看总榜、周榜、月榜、推荐榜、收藏榜。';
}
$top_url_attr = htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$title_arr = [
    'weekvisit' => '周榜',
    'monthvisit' => '月榜',
    'allvisit' => '总榜',
    'goodnum' => '收藏榜',
    'allvote' => '推荐榜',
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($rank_entry_url_raw !== ''): ?><link rel="canonical" href="<?=$top_url_attr?>"><?php endif; ?>
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
<div class="container autoheight">
  <ol class="navigator">
    <li><a href="<?=$site_home_url_attr?>">首页</a></li>
    <li class="active">排行榜</li>
  </ol>

  <div class="rank-switch">
    <div class="rank-switch-title">切换榜单</div>
    <div class="rank-switch-list">
      <?php if ($rank_entry_url_raw !== ''): ?><a href="<?=$top_url_attr?>" class="active">聚合榜</a><?php else: ?><a class="active" aria-disabled="true">聚合榜</a><?php endif; ?>
      <?php foreach($title_arr as $key => $label): ?>
        <?php if ($rank_detail_base_raw !== ''): ?>
          <a href="<?=htmlspecialchars($rank_detail_base_raw . $key . '/', ENT_QUOTES, 'UTF-8')?>"><?=$label?></a>
        <?php else: ?>
          <a aria-disabled="true"><?=$label?></a>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <?php $sortCount = is_array($sortarr) ? count($sortarr) : 0; ?>
  <?php for($i = 1; $i <= $sortCount; $i++): ?>
    <?php $tmp = 'allvisit' . $i; $list = isset($$tmp) ? $$tmp : []; ?>
    <div class="rank-list" style="margin-top:1rem;">
      <div class="rank-title">
        <h2><?=Sort::ss_sortname($i, 1)?>榜</h2>
        <span><?php if ($rank_detail_base_raw !== ''): ?><a href="<?=htmlspecialchars(Sort::ss_sorturl($i), ENT_QUOTES, 'UTF-8')?>" rel="nofollow">更多</a><?php endif; ?></span>
      </div>
      <?php if(!empty($list) && is_array($list)): ?>
        <?php foreach($list as $k => $v): if($k >= 10) break; ?>
          <div class="rank-item">
            <a class="cover" href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
              <img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" width="120" height="150" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;">
              <em>No.<?=($k+1)?></em>
            </a>
            <div class="info">
              <div class="name"><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></div>
              <div class="meta"><span><?=$v['author']?></span></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="padding:20px;color:#888;">暂无排行榜数据</div>
      <?php endif; ?>
    </div>
  <?php endfor; ?>
</div>
<style>
.rank-switch-title{font-size:16px;font-weight:700;padding:0 0 10px;border-bottom:1px solid #f0f0f0;margin:12px 0}.rank-switch-list{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:18px}.rank-switch-list a{display:inline-flex;align-items:center;height:34px;padding:0 14px;border:1px solid #e9e9e9;background:#fff;border-radius:18px;white-space:nowrap;line-height:34px;color:#333;text-decoration:none}.rank-switch-list a.active{background:#ff4a4a;border-color:#ff4a4a;color:#fff;font-weight:700}.rank-title{display:flex;align-items:flex-end;justify-content:space-between;margin:8px 0 14px}.rank-title h2{font-size:18px;font-weight:700;margin:0}.rank-title span{color:#999}.rank-item{width:49%;margin-right:2%;margin-bottom:16px;float:left;box-sizing:border-box;display:flex;gap:12px;align-items:flex-start}.rank-item:nth-child(2n){margin-right:0}.rank-item .cover{width:120px;height:150px;border-radius:8px;overflow:hidden;flex:0 0 120px;position:relative}.rank-item .cover img{width:120px;height:150px;object-fit:cover;display:block}.rank-item .cover em{position:absolute;left:0;bottom:0;padding:3px 8px;background:rgba(0,0,0,.55);color:#fff;font-style:normal;font-size:12px}.rank-item .info{flex:1 1 auto}.rank-item .name a{font-size:16px;font-weight:700;line-height:1.3;color:#222;text-decoration:none;display:block;max-height:2.6em;overflow:hidden}.rank-item .meta{margin:6px 0 0;color:#888}.rank-list:after{content:"";display:block;clear:both}@media (max-width:767px){.rank-item{width:100%;margin-right:0}.rank-switch-list{gap:8px}.rank-switch-list a{height:32px;padding:0 12px}}
</style>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
