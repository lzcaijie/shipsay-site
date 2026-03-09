<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('author');
$author_raw = isset($author) ? (string)$author : '';
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = ($author_raw !== '' ? $author_raw . '作品大全_' : '作者作品_') . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = ($author_raw !== '' ? $author_raw . ',' : '') . '作者,作品集,小说,' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = ($author_raw !== '' ? '作者' . $author_raw . '的作品列表与最新章节，' : '作者作品列表，') . '尽在' . SITE_NAME . '。';
}
$author_url_raw = (isset($uri) && $uri) ? (string)$uri : '';
$author_url_attr = htmlspecialchars($author_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$author_count_safe = isset($author_count) ? (int)$author_count : 0;
$e = function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$author_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => ($author_raw !== '' ? $author_raw . '作品大全' : '作者作品'), 'item' => $author_url_raw],
    ],
];
?>
<title><?=$e($seo_title)?></title>
<meta name="keywords" content="<?=$e($seo_keywords)?>">
<meta name="description" content="<?=$e($seo_description)?>">
<?php if ($author_url_raw !== ''): ?>
<meta name="mobile-agent" content="format=html5;url=<?=$author_url_attr?>">
<link rel="canonical" href="<?=$author_url_attr?>">
<meta property="og:url" content="<?=$author_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$e($seo_title)?>">
<meta property="og:description" content="<?=$e($seo_description)?>">
<script type="application/ld+json"><?=json_encode($author_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="biquge-author-page">
<div class="container">
    <div class="bread_crumbs"><a href="<?=$site_home_url_attr?>">首页</a> &gt; <span>作者作品</span></div>
</div>
<div class="container flex flex-wrap mb20">
    <div class="border3 commend flex flex-between category-commend">
        <div class="biquge-page-title">作者“<?=$e($author_raw)?>”共有 <?=$author_count_safe?> 部作品</div>
        <?php if (!empty($res) && is_array($res)): ?>
            <?php foreach($res as $k => $v): ?>	
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
            <div class="biquge-page-empty">暂无作品</div>
        <?php endif;?>
    </div>
</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
