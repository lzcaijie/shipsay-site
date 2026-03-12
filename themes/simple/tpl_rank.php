<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_entry_url_raw = !empty($rank_entry_url) ? rtrim((string)$rank_entry_url, '/') . '/' : (!empty($fake_top) ? rtrim((string)$fake_top, '/') . '/' : '');
$rank_detail_base_raw = !empty($rank_detail_base) ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
$title_arr = [
    'allvisit' => '总点击榜',
    'monthvisit' => '月点击榜',
    'weekvisit' => '周点击榜',
    'dayvisit' => '日点击榜',
    'allvote' => '总推荐榜',
    'monthvote' => '月推荐榜',
    'weekvote' => '周推荐榜',
    'dayvote' => '日推荐榜',
    'goodnum' => '收藏榜',
];
$current_query = isset($query) && $query ? (string)$query : 'allvisit';
$current_title = isset($title_arr[$current_query]) ? $title_arr[$current_query] : '排行榜';
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = $current_title . '_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = $current_title . ',' . SITE_NAME . ',排行榜,热门小说';
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = $current_title . '榜单，尽在' . SITE_NAME . '。';
}
$rank_url_raw = (isset($uri) && $uri) ? (string)$uri : ($rank_detail_base_raw !== '' ? $rank_detail_base_raw . $current_query . '/' : '');
$rank_url_attr = htmlspecialchars($rank_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$rank_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '排行榜', 'item' => $rank_entry_url_raw !== '' ? $rank_entry_url_raw : $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $current_title, 'item' => $rank_url_raw !== '' ? $rank_url_raw : $site_home_url_raw],
    ],
];
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($rank_url_raw !== ''): ?>
<link rel="canonical" href="<?=$rank_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$rank_url_attr?>">
<meta property="og:url" content="<?=$rank_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<script type="application/ld+json"><?=json_encode($rank_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<style>
.simple-rank-tabs{display:flex;flex-wrap:wrap;gap:10px;margin:12px 0 16px}
.simple-rank-tabs a{display:inline-block;padding:8px 14px;border:1px solid #ddd;background:#fff;color:#333;text-decoration:none}
.simple-rank-tabs a.active{background:#5e8e9e;border-color:#5e8e9e;color:#fff}
.simple-rank-head{margin:12px 0 16px}.simple-rank-head h1{font-size:24px;margin:0}
.simple-rank-list{margin:0;padding:0;list-style:none;border:1px solid #ddd;background:#fff}
.simple-rank-list li{display:flex;gap:10px;align-items:center;padding:12px;border-bottom:1px dashed #e3e3e3}
.simple-rank-list li:last-child{border-bottom:none}.simple-rank-list .num{width:28px;color:#999}.simple-rank-list .name{flex:1;min-width:0}.simple-rank-list .name a{text-decoration:none;color:#333}.simple-rank-list .author{width:120px;color:#999;text-align:right}.simple-rank-list .date{width:60px;color:#999;text-align:right}
@media (max-width:768px){.simple-rank-list li{flex-wrap:wrap}.simple-rank-list .author,.simple-rank-list .date{width:auto;text-align:left}}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="content">
        <ol class="breadcrumb">
            <li><a href="<?=$site_home_url_attr?>">首页</a></li>
            <li><?php if ($rank_entry_url_raw !== ''): ?><a href="<?=htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8')?>">排行榜</a><?php else: ?>排行榜<?php endif; ?></li>
            <li class="active"><?=htmlspecialchars($current_title, ENT_QUOTES, 'UTF-8')?></li>
        </ol>
        <div class="simple-rank-head"><h1><?=htmlspecialchars($current_title, ENT_QUOTES, 'UTF-8')?></h1></div>
        <div class="simple-rank-tabs">
            <?php foreach ($title_arr as $key => $label): ?>
                <?php if ($rank_detail_base_raw !== ''): ?>
                <a href="<?=htmlspecialchars($rank_detail_base_raw . $key . '/', ENT_QUOTES, 'UTF-8')?>" class="<?=$current_query === $key ? 'active' : ''?>"><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <ul class="simple-rank-list">
            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
                <?php foreach ($articlerows as $k => $v): ?>
                    <li>
                        <span class="num"><?=$k + 1?></span>
                        <span class="name"><a href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)($v['articlename'] ?? ''), ENT_QUOTES, 'UTF-8')?></a></span>
                        <span class="author"><?=htmlspecialchars((string)($v['author'] ?? ''), ENT_QUOTES, 'UTF-8')?></span>
                        <span class="date"><?=(isset($v['lastupdate']) && $v['lastupdate']) ? date('m-d', (int)$v['lastupdate']) : ''?></span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li><span class="name">暂无榜单数据</span></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
