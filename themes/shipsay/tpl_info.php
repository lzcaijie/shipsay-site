<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif (isset($articleid) && $articleid && class_exists('Url') && method_exists('Url', 'index_url')) {
    $index_url_safe = Url::index_url($articleid);
}
$recent_chapters = [];
if (!empty($lastarr) && is_array($lastarr)) {
    $recent_chapters = $lastarr;
} elseif (!empty($lastchapter_arr) && is_array($lastchapter_arr)) {
    $recent_chapters = $lastchapter_arr;
}
$langtail_list = (!empty($langtailrows) && is_array($langtailrows)) ? $langtailrows : [];
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
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
<link rel="prefetch" href="<?=$index_url_safe?>" as="document">
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

        <div class="section sub-section section-info-block">
            <h2 class="sub_title">作品简介</h2>
            <div class="intro"><?=$intro?></div>
        </div>

        <div class="section sub-section section-info-block">
            <div class="catalog-header">
                <div>
                    <h2 class="block-title">最新章节</h2>
                    <div class="page-info">共 <?=$chapters?> 章，默认展示最近 12 章</div>
                </div>
                <div><a href="<?=$index_url_safe?>" class="back-link"><i class="fa fa-list"></i> 全部目录</a></div>
            </div>
            <div class="chapter-list-container compact-list">
                <ul class="chapter-grid chapter-grid-single">
                    <?php if (!empty($recent_chapters)): ?>
                        <?php foreach ($recent_chapters as $v): ?>
                            <li class="chapter-item"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="chapter-item"><a href="<?=$last_url?>"><?=$lastchapter?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <?php if (!empty($langtail_list)): ?>
        <div class="section sub-section section-info-block">
            <div class="catalog-header">
                <div>
                    <h2 class="block-title">相关推荐</h2>
                    <div class="page-info">与《<?=$articlename?>》相关的长尾页入口</div>
                </div>
            </div>
            <div class="tail-link-list">
                <?php foreach ($langtail_list as $v): ?>
                    <a href="<?=$v['info_url']?>"><?=$v['langname']?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
