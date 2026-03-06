<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$total_pages_safe = 1;
if (isset($chapters) && isset($per_page) && intval($per_page) > 0) {
    $total_pages_safe = max(1, (int)ceil($chapters / $per_page));
} elseif (isset($pid) && $pid > 1) {
    $total_pages_safe = (int)$pid;
}
$indexlist_url_safe = (isset($uri) && $uri) ? $uri : ((isset($index_url) && $index_url) ? $index_url : '');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $articlename . '章节目录' . (($pid > 1) ? '_第' . intval($pid) . '页' : '') . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $articlename . ',章节目录,' . $author . ',' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = '《' . $articlename . '》章节目录，作者：' . $author . '，共' . intval($chapters) . '章。';
}
$indexlist_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => !empty($site_url) ? $site_url : '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => Sort::ss_sorturl($sortid)],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url],
        ['@type' => 'ListItem', 'position' => 4, 'name' => '章节目录' . (($pid > 1) ? '第' . intval($pid) . '页' : ''), 'item' => $indexlist_url_safe !== '' ? $indexlist_url_safe : $uri],
    ],
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$indexlist_url_safe?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="canonical" href="<?=$indexlist_url_safe?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$indexlist_url_safe?>">
<script type="application/ld+json"><?=json_encode($indexlist_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="/">首页</a> &gt; <a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a> &gt; <a href="<?=$info_url?>"><?=$articlename?></a> &gt; <span>目录</span>
        </div>
        <div class="novel-basic-info">
            <div class="novel-cover">
                <img src="<?=$img_url?>" alt="<?=$articlename?>" loading="lazy" width="100" height="140" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
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
                <p>总章节：<?=$chapters?>章</p>
            </div>
        </div>
        <div class="catalog-header">
            <div>
                <h2 class="block-title">《<?=$articlename?>》章节目录</h2>
                <div class="page-info">当前第 <?=$pid?> 页，共 <?=$total_pages_safe?> 页</div>
            </div>
            <div class="catalog-actions">
                <a href="<?=$first_url?>" class="back-link"><i class="fa fa-book"></i> 开始阅读</a>
                <a href="<?=$info_url?>" class="back-link"><i class="fa fa-arrow-left"></i> 返回详情</a>
            </div>
        </div>
        <div class="chapter-list-container">
            <ul class="chapter-grid">
                <?php if (isset($list_arr) && !empty($list_arr)): ?>
                    <?php foreach ($list_arr as $v): ?>
                        <?php if (isset($v['chaptertype']) && $v['chaptertype'] == 1): ?>
                            <li class="volume-title"><?=$v['cname']?></li>
                        <?php else: ?>
                            <li class="chapter-item"><a href="<?=$v['cid_url']?>" title="<?=$articlename?> <?=$v['cname']?>"><?=$v['cname']?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="chapter-item chapter-item-empty">暂无章节数据</li>
                <?php endif; ?>
            </ul>
            <div class="index-container"><?=$htmltitle?></div>
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
