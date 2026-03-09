<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
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
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) $seo_title = $current_title . '_' . SITE_NAME;
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) $seo_keywords = $current_title . ',' . SITE_NAME . ',排行榜';
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) $seo_description = SITE_NAME . $current_title . '页面。';
$rank_entry_url_raw = isset($rank_entry_url) && $rank_entry_url ? rtrim((string)$rank_entry_url, '/') . '/' : ((isset($fake_top) && $fake_top) ? rtrim((string)$fake_top, '/') . '/' : '');
$rank_detail_base_raw = isset($rank_detail_base) && $rank_detail_base ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$rank_url_raw = (isset($uri) && $uri) ? (string)$uri : ($rank_detail_base_raw !== '' ? $rank_detail_base_raw . $current_query . '/' : '');
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
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
<title><?=$h($seo_title)?></title>
<meta name="keywords" content="<?=$h($seo_keywords)?>">
<meta name="description" content="<?=$h($seo_description)?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<?php if ($rank_url_raw !== ''): ?>
<meta name="mobile-agent" content="format=html5;url=<?=$h($rank_url_raw)?>">
<link rel="canonical" href="<?=$h($rank_url_raw)?>">
<meta property="og:url" content="<?=$h($rank_url_raw)?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$h($seo_title)?>">
<meta property="og:description" content="<?=$h($seo_description)?>">
<script type="application/ld+json"><?=json_encode($rank_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container rank-detail-page">
    <div class="border3-2 mt8 mb20">
        <div class="info-title">
            <a href="<?=$h($site_home_url_raw)?>">首页</a> &gt; <?php if ($rank_entry_url_raw !== ''): ?><a href="<?=$h($rank_entry_url_raw)?>">排行榜</a><?php else: ?>排行榜<?php endif; ?> &gt; <?=$h($current_title)?>
        </div>
        <div class="info-chapters-title"><strong><?=$h($current_title)?></strong></div>
        <div class="info-commend rank-switches top-rank-links">
            <?php foreach ($title_arr as $key => $label): ?>
                <?php $is_active = $current_query === $key; ?>
                <a href="<?=$h($rank_detail_base_raw . $key . '/')?>" class="<?=$is_active ? 'active' : ''?>"><?=$h($label)?></a>
            <?php endforeach; ?>
        </div>
        <div class="popular">
            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
                <?php foreach ($articlerows as $k => $v): ?>
                <?php
                $info_url = isset($v['info_url']) ? (string)$v['info_url'] : '';
                $articlename = isset($v['articlename']) ? (string)$v['articlename'] : '';
                $author_url = isset($v['author_url']) ? (string)$v['author_url'] : '';
                $author_name = isset($v['author']) ? (string)$v['author'] : '';
                $lastupdate_text = isset($v['lastupdate']) ? Text::ss_lastupdate($v['lastupdate']) : '';
                ?>
                <div class="list-out">
                    <span>
                        <em>[<?=($k + 1)?>]</em>
                        <em><a href="<?=$h($info_url)?>"><?=$h($articlename)?></a></em>
                        <em class="dispc"><a href="<?=$h($author_url)?>"><?=$h($author_name)?></a></em>
                    </span>
                    <span class="gray"><?=$h($lastupdate_text)?></span>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="biquge-page-empty rank-empty">暂无排行榜数据</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
