<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('search');
$searchkey_raw = isset($searchkey) ? (string)$searchkey : '';
$search_count_safe = isset($search_count) ? (int)$search_count : 0;
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = ($searchkey_raw !== '' ? $searchkey_raw . '_搜索结果_' : '搜索结果_') . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = ($searchkey_raw !== '' ? $searchkey_raw . ',' : '') . '搜索,小说,' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = ($searchkey_raw !== '' ? '与“' . $searchkey_raw . '”相关的小说搜索结果，' : '小说搜索结果，') . '尽在' . SITE_NAME . '。';
}
$search_url_raw = (isset($uri) && $uri) ? (string)$uri : (!empty($fake_search) ? (string)$fake_search : '');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$e = function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
?>
<title><?=$e($seo_title)?></title>
<meta name="keywords" content="<?=$e($seo_keywords)?>">
<meta name="description" content="<?=$e($seo_description)?>">
<?php if ($search_url_raw !== ''): ?>
<meta name="mobile-agent" content="format=html5;url=<?=$search_url_attr?>">
<link rel="canonical" href="<?=$search_url_attr?>">
<meta property="og:url" content="<?=$search_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$e($seo_title)?>">
<meta property="og:description" content="<?=$e($seo_description)?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="biquge-search-page">
<div class="container">
    <div class="bread_crumbs"><a href="<?=$site_home_url_attr?>">首页</a> &gt; <span>搜索结果</span></div>
</div>
<div class="container flex flex-wrap mb20">
    <div class="border3 commend flex flex-between category-commend">
        <div class="biquge-page-title">搜索“<?=$e($searchkey_raw)?>”共有 <?=$search_count_safe?> 条结果</div>
        <?php if (!empty($search_count) && !empty($search_res) && is_array($search_res)) :?>
            <?php foreach($search_res as $k => $v): ?>
            <div class="category-div">
                <a href="<?=$e($v['info_url'] ?? '')?>">
                    <img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$e($v['img_url'] ?? '')?>" alt="<?=$e($v['articlename'] ?? '')?>" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;">
                </a>
                <div>
                    <div class="flex flex-between commend-title"><a href="<?=$e($v['info_url'] ?? '')?>"><h3><?=$e($v['articlename'] ?? '')?></h3></a> <span><?=$e($v['author'] ?? '')?></span></div>
                    <div class="intro indent"><?=$e($v['intro_des'] ?? '')?></div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无搜索结果</div>
        <?php endif;?>
    </div>
</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
