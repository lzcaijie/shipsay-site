<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_entry_url_raw = '';
if (isset($rank_entry_url) && $rank_entry_url) {
    $rank_entry_url_raw = rtrim((string)$rank_entry_url, '/') . '/';
} elseif (isset($fake_top) && $fake_top) {
    $rank_entry_url_raw = rtrim((string)$fake_top, '/') . '/';
}
$rank_detail_base_raw = isset($rank_detail_base) && $rank_detail_base ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
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
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $current_title . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $current_title . ',' . SITE_NAME . ',排行榜,热门小说';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = $current_title . '榜单，尽在' . SITE_NAME . '。';
}
$rank_url_raw = (isset($uri) && $uri) ? (string)$uri : ($rank_detail_base_raw !== '' ? $rank_detail_base_raw . $current_query . '/' : '');
$rank_url_attr = htmlspecialchars($rank_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$current_title_html = htmlspecialchars($current_title, ENT_QUOTES, 'UTF-8');
$rank_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '排行榜', 'item' => $rank_entry_url_raw],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $current_title, 'item' => $rank_url_raw],
    ],
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<?php if ($rank_url_raw !== ''): ?>
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$rank_url_attr?>">
<link rel="canonical" href="<?=$rank_url_attr?>">
<meta property="og:url" content="<?=$rank_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<script type="application/ld+json"><?=json_encode($rank_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="<?=$site_home_url_attr?>">首页</a> &gt; <span><?=$current_title_html?></span>
        </div>
        <div class="rank-page-head">
            <h1><?=$current_title_html?></h1>
        </div>
        <div class="rank-tabs">
            <?php foreach ($title_arr as $key => $label): ?>
                <?php $tab_url_attr = htmlspecialchars($rank_detail_base_raw . $key . '/', ENT_QUOTES, 'UTF-8'); $tab_label_html = htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                <a href="<?=$tab_url_attr?>" class="<?=$current_query === $key ? 'active' : ''?>"><?=$tab_label_html?></a>
            <?php endforeach; ?>
        </div>
        <ol class="rank-page-list">
            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
                <?php foreach ($articlerows as $k => $v): ?>
                    <?php
                    $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
                    $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8');
                    $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
                    $author_url_attr = htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8');
                    $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8');
                    $sort_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8');
                    $status_html = htmlspecialchars((string)$v['isfull'], ENT_QUOTES, 'UTF-8');
                    $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8');
                    ?>
                    <li>
                        <span class="rank-page-num"><?=$k + 1?></span>
                        <div class="rank-page-cover"><a href="<?=$info_url_attr?>"><img src="<?=$img_url_attr?>" alt="<?=$title_html?>" loading="lazy"></a></div>
                        <div class="rank-page-info">
                            <h2><a href="<?=$info_url_attr?>"><?=$title_html?></a></h2>
                            <p class="rank-page-meta">
                                <span><?=$sort_html?> / <?=$status_html?></span>
                                <a href="<?=$author_url_attr?>"><?=$author_html?></a>
                            </p>
                            <p class="rank-page-intro"><?=$intro_html?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="rank-empty">暂无数据</li>
            <?php endif; ?>
        </ol>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
