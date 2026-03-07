<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif (isset($articleid) && $articleid && class_exists('Url') && method_exists('Url', 'index_url')) {
    $index_url_safe = Url::index_url($articleid);
}
$latest12 = (!empty($lastchapter_arr) && is_array($lastchapter_arr)) ? array_slice($lastchapter_arr, 0, 12) : [];
$latest50 = (!empty($preview_chapters) && is_array($preview_chapters)) ? array_slice($preview_chapters, 0, 50) : [];
$info_url_safe = (isset($uri) && $uri) ? $uri : ((isset($info_url) && $info_url) ? $info_url : '');
$site_home_url_safe = !empty($site_url) ? rtrim($site_url, '/') . '/' : '/';
$article_title_html = htmlspecialchars($articlename, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars($author_url, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars($author, ENT_QUOTES, 'UTF-8');
$sort_url_attr = htmlspecialchars(Sort::ss_sorturl($sortid), ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars($sortname, ENT_QUOTES, 'UTF-8');
$status_html = htmlspecialchars($isfull, ENT_QUOTES, 'UTF-8');
$words_html = htmlspecialchars($words_w, ENT_QUOTES, 'UTF-8');
$last_url_attr = htmlspecialchars($last_url, ENT_QUOTES, 'UTF-8');
$lastchapter_html = htmlspecialchars($lastchapter, ENT_QUOTES, 'UTF-8');
$lastupdate_cn_html = htmlspecialchars($lastupdate_cn, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars($first_url, ENT_QUOTES, 'UTF-8');
$index_url_attr = htmlspecialchars($index_url_safe, ENT_QUOTES, 'UTF-8');
$info_url_attr = htmlspecialchars($info_url_safe, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8');
$intro_plain = !empty($intro_p) ? trim(strip_tags($intro_p)) : trim(strip_tags(!empty($intro) ? $intro : $intro_des));
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $articlename . '最新章节目录_' . $author . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $articlename . ',' . $author . ',' . SITE_NAME . ',最新章节,全文阅读';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = '《' . $articlename . '》作者：' . $author . '，简介：' . (!empty($intro_p) ? $intro_p : $intro_des);
}

$info_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_safe],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => Sort::ss_sorturl($sortid)],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url_safe !== '' ? $info_url_safe : $info_url],
    ],
];
$info_book_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'Book',
    'name' => $articlename,
    'author' => ['@type' => 'Person', 'name' => $author],
    'bookFormat' => 'EBook',
    'datePublished' => (string)$lastupdate,
    'numberOfPages' => (string)$chapters,
    'publisher' => ['@type' => 'Organization', 'name' => SITE_NAME],
    'image' => $img_url,
    'description' => $intro_plain,
    'url' => $info_url_safe !== '' ? $info_url_safe : $info_url,
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$info_url_attr?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="canonical" href="<?=$info_url_attr?>">
<script type="application/ld+json"><?=json_encode($info_book_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<script type="application/ld+json"><?=json_encode($info_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<meta property="og:type" content="novel">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$info_url_attr?>">
<meta property="og:image" content="<?=$img_url_attr?>">
<meta property="og:image:alt" content="<?=$article_title_html?>封面">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="<?=htmlspecialchars($site_home_url_safe, ENT_QUOTES, 'UTF-8')?>">首页</a> &gt; <a href="<?=$sort_url_attr?>"><?=$sortname_html?></a> &gt; <span><?=$article_title_html?></span>
        </div>
        <div class="novel-basic-info">
            <div class="novel-cover">
                <img src="<?=$img_url_attr?>" alt="<?=$article_title_html?>" loading="lazy" width="120" height="168" onerror="this.src='/static/<?=htmlspecialchars($theme_dir, ENT_QUOTES, 'UTF-8')?>/nocover.jpg'; this.onerror=null;">
            </div>
            <div class="novel-meta">
                <h1><?=$article_title_html?></h1>
                <div class="novel-meta-grid">
                    <div class="meta-pair"><span class="meta-label">作者：</span><a href="<?=$author_url_attr?>"><?=$author_html?></a></div>
                    <div class="meta-pair"><span class="meta-label">分类：</span><a href="<?=$sort_url_attr?>"><?=$sortname_html?></a></div>
                    <div class="meta-pair"><span class="meta-label">状态：</span><span class="meta-value"><?=$status_html?></span></div>
                    <div class="meta-pair"><span class="meta-label">字数：</span><span class="meta-value"><?=$words_html?>万</span></div>
                </div>
                <div class="novel-latest-row">
                    <span class="meta-label">最新章节：</span>
                    <a href="<?=$last_url_attr?>"><?=$lastchapter_html?></a>
                </div>
                <div class="novel-latest-time"><?=$lastupdate_cn_html?></div>
                <div class="book-actions">
                    <a href="<?=$first_url_attr?>"><i class="fa fa-play-circle"></i> 开始阅读</a>
                    <a href="<?=$index_url_attr?>"><i class="fa fa-list"></i> 查看目录</a>
                </div>
            </div>
        </div>

        <div class="section section-info-block">
            <h2 class="sub_title">作品简介</h2>
            <?php $intro_html = !empty($intro) ? $intro : (!empty($intro_p) ? $intro_p : $intro_des); ?>
            <div class="intro"><?=$intro_html?></div>
        </div>

        <div class="section section-info-block">
            <div class="catalog-header info-catalog-header">
                <div>
                    <h2 class="block-title">最新章节</h2>
                    <div class="page-info">共 <?=intval($chapters)?> 章</div>
                </div>
                <div><a href="<?=$index_url_attr?>" class="back-link"><i class="fa fa-list"></i> 全部目录</a></div>
            </div>
            <div class="latest-single-row">
                <span class="latest-label">最新章节</span>
                <a href="<?=$last_url_attr?>"><?=$lastchapter_html?></a>
                <em><?=$lastupdate_cn_html?></em>
            </div>

            <?php if (!empty($latest12)): ?>
            <div class="info-chapter-block">
                <h3 class="info-mini-title">最新 12 章</h3>
                <ul class="info-chapter-list latest12-list">
                    <?php foreach ($latest12 as $v): $cid_url_attr = htmlspecialchars($v['cid_url'], ENT_QUOTES, 'UTF-8'); $cname_html = htmlspecialchars($v['cname'], ENT_QUOTES, 'UTF-8'); ?>
                        <li class="chapter-item"><a href="<?=$cid_url_attr?>"><?=$cname_html?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (!empty($latest50)): ?>
            <div class="info-chapter-block">
                <h3 class="info-mini-title">前 50 章</h3>
                <ul class="info-chapter-list latest50-list">
                    <?php foreach ($latest50 as $v): $cid_url_attr = htmlspecialchars($v['cid_url'], ENT_QUOTES, 'UTF-8'); $cname_html = htmlspecialchars($v['cname'], ENT_QUOTES, 'UTF-8'); ?>
                        <li class="chapter-item"><a href="<?=$cid_url_attr?>"><?=$cname_html?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>

        <?php if (isset($is_langtail) && $is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)): ?>
        <div class="section section-info-block">
            <h2 class="sub_title">相关推荐</h2>
            <div class="langtail-box">
                <?php foreach ($langtailrows as $v): $langtail_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8'); $langname_html = htmlspecialchars($v['langname'], ENT_QUOTES, 'UTF-8'); ?>
                    <a href="<?=$langtail_url_attr?>"><?=$langname_html?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
