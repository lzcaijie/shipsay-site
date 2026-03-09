<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $year = isset($year) && $year ? $year : date('Y'); ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('category');
$sortname_raw = isset($sortname) && $sortname !== '' ? (string)$sortname : '全部小说';
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = $sortname_raw . (isset($page) && (int)$page > 1 ? '_第' . (int)$page . '页' : '') . '_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = $sortname_raw . ',小说,' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = $sortname_raw . '小说列表，尽在' . SITE_NAME . '。';
}
$category_url_raw = (isset($uri) && $uri) ? (string)$uri : (string)Sort::ss_sorturl((int)$sortid);
$category_url_attr = htmlspecialchars($category_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$e = function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$category_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname_raw, 'item' => $category_url_raw],
    ],
];
?>
<title><?=$e($seo_title)?></title>
<meta name="keywords" content="<?=$e($seo_keywords)?>">
<meta name="description" content="<?=$e($seo_description)?>">
<meta name="mobile-agent" content="format=html5;url=<?=$category_url_attr?>">
<link rel="canonical" href="<?=$category_url_attr?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$e($seo_title)?>">
<meta property="og:description" content="<?=$e($seo_description)?>">
<meta property="og:url" content="<?=$category_url_attr?>">
<script type="application/ld+json"><?=json_encode($category_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="biquge-category-page">
<div class="container">
    <div class="bread_crumbs"><a href="<?=$site_home_url_attr?>">首页</a> &gt; <span><?=$e($sortname_raw)?></span></div>
</div>
<div class="container flex flex-wrap">
    <div class="border3 commend flex flex-between category-commend">
        <?php if (!empty($retarr) && is_array($retarr)): ?>
            <?php foreach ($retarr as $k => $v): ?><?php if ($k < 6): ?>
                <div class="category-div">
                    <a href="<?=$e($v['info_url'] ?? '')?>">
                        <img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$e($v['img_url'] ?? '')?>" alt="<?=$e($v['articlename'] ?? '')?>" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;">
                    </a>
                    <div>
                        <div class="flex flex-between commend-title"><a href="<?=$e($v['info_url'] ?? '')?>"><h3><?=$e($v['articlename'] ?? '')?></h3></a> <span><?=$e($v['author'] ?? '')?></span></div>
                        <div class="intro indent"><?=$e($v['intro_des'] ?? '')?></div>
                    </div>
                </div>
            <?php endif; ?><?php endforeach; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无内容</div>
        <?php endif; ?>
    </div>
</div>

<div class="container flex flex-wrap section-bottom mb20">
    <div class="border3-1 lastupdate">
        <p><?php if (!empty($sortname_raw)): ?>最后更新的<?=$e($sortname_raw)?>小说<?php else: ?>最后更新<?php endif; ?></p>
        <?php if (!empty($retarr) && is_array($retarr)): ?>
            <?php $has_more_update = false; ?>
            <?php foreach ($retarr as $k => $v): ?><?php if ($k >= 6): $has_more_update = true; ?>
                <div class="list-out">
                    <span class="flex w80"><em>[<?=$e($v['sortname'] ?? '')?>]</em><em><a href="<?=$e($v['info_url'] ?? '')?>"><?=$e($v['articlename'] ?? '')?></a></em><em><a href="<?=$e($v['last_url'] ?? '')?>"><?=$e($v['lastchapter'] ?? '')?></a></em></span>
                    <span class="gray dispc"><?=$e($v['author'] ?? '')?>&nbsp;&nbsp;<?=$e(!empty($v['lastupdate']) ? date('m-d', (int)$v['lastupdate']) : '')?></span>
                </div>
            <?php endif; ?><?php endforeach; ?>
            <?php if (!$has_more_update): ?><div class="biquge-page-empty">暂无更多更新</div><?php endif; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无更新内容</div>
        <?php endif; ?>
    </div>

    <div class="border3-1 popular">
        <p><?php if (!empty($sortname_raw)): ?>最新<?=$e($sortname_raw)?>小说<?php else: ?>最新入库<?php endif; ?></p>
        <?php if (!empty($sort_postdate) && is_array($sort_postdate)): ?>
            <?php $limit = max(0, count($sort_postdate) - 6); $has_postdate = false; ?>
            <?php foreach ($sort_postdate as $k => $v): ?>
                <?php if ($k < $limit): $has_postdate = true; ?>
                    <div class="list-out">
                        <span>[<?=$e($v['sortname_2'] ?? '')?>] <a href="<?=$e($v['info_url'] ?? '')?>"><?=$e($v['articlename'] ?? '')?></a></span>
                        <span class="gray"><?=$e($v['author'] ?? '')?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (!$has_postdate): ?><div class="biquge-page-empty">暂无入库内容</div><?php endif; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无入库内容</div>
        <?php endif; ?>
    </div>
</div>
</div>
<script>$('nav a:nth-child(<?=$sortid + 1?>)').addClass('orange');</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
