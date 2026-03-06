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
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$uri?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="canonical" href="<?=$uri?>">
<script type="application/ld+json">{"@context":"https://schema.org","@type":"Book","name":"<?=$articlename?>","author":{"@type":"Person","name":"<?=$author?>"},"bookFormat":"EBook","datePublished":"<?=$lastupdate?>","numberOfPages":"<?=$chapters?>","publisher":{"@type":"Organization","name":"<?=SITE_NAME?>"},"image":"<?=$img_url?>","description":"<?=$intro_p?>"}</script>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"<?=SITE_NAME?>","item":"<?=$site_url?>"},{"@type":"ListItem","position":2,"name":"<?=$sortname?>","item":"<?=Sort::ss_sorturl($sortid)?>"},{"@type":"ListItem","position":3,"name":"<?=$articlename?>","item":"<?=$info_url?>"}]}</script>
<meta property="og:type" content="novel">
<meta property="og:title" content="<?=$articlename?>">
<meta property="og:description" content="《<?=$articlename?>》最新章节由<?=$author?>创作，<?=$intro_p?>">
<meta property="og:url" content="<?=$info_url?>">
<meta property="og:image" content="<?=$img_url?>">
<meta property="og:image:alt" content="<?=$articlename?>封面">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="/">首页</a> &gt; <a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a> &gt; <span><?=$articlename?></span>
        </div>
        <div class="novel-basic-info">
            <div class="novel-cover">
                <img src="<?=$img_url?>" alt="<?=$articlename?>" loading="lazy" width="120" height="168" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
            </div>
            <div class="novel-meta">
                <h1><?=$articlename?></h1>
                <p>
                    <span>作者：<a href="<?=$author_url?>"><?=$author?></a></span>
                    <span>分类：<a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></span>
                    <span>状态：<?=$isfull?></span>
                    <span>字数：<?=$words_w?>万</span>
                </p>
                <p>最新章节：<a href="<?=$last_url?>"><?=$lastchapter?></a> <em class="meta-time"><?=$lastupdate_cn?></em></p>
                <div class="book-actions">
                    <a href="<?=$first_url?>"><i class="fa fa-play-circle"></i> 开始阅读</a>
                    <a href="<?=$index_url_safe?>"><i class="fa fa-list"></i> 查看目录</a>
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
                    <div class="page-info">共 <?=$chapters?> 章</div>
                </div>
                <div><a href="<?=$index_url_safe?>" class="back-link"><i class="fa fa-list"></i> 全部目录</a></div>
            </div>
            <div class="latest-single-row">
                <span class="latest-label">最新章节</span>
                <a href="<?=$last_url?>"><?=$lastchapter?></a>
                <em><?=$lastupdate_cn?></em>
            </div>

            <?php if (!empty($latest12)): ?>
            <div class="info-chapter-block">
                <h3 class="info-mini-title">最新 12 章</h3>
                <ul class="info-chapter-list latest12-list">
                    <?php foreach ($latest12 as $v): ?>
                        <li class="chapter-item"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (!empty($latest50)): ?>
            <div class="info-chapter-block">
                <h3 class="info-mini-title">前 50 章</h3>
                <ul class="info-chapter-list latest50-list">
                    <?php foreach ($latest50 as $v): ?>
                        <li class="chapter-item"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>

        <?php if (isset($is_langtail) && $is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)): ?>
        <div class="section section-info-block">
            <h2 class="sub_title">相关推荐</h2>
            <div class="langtail-box">
                <?php foreach ($langtailrows as $v): ?>
                    <a href="<?=$v['info_url']?>"><?=$v['langname']?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
