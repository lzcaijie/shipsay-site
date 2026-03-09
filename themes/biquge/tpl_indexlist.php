<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$chaptersPerPage = isset($per_page) && (int)$per_page > 0 ? (int)$per_page : (isset($per_indexlist) && (int)$per_indexlist > 0 ? (int)$per_indexlist : 50);
$chapters_safe = isset($chapters) ? max(0, (int)$chapters) : 0;
$totalPages = $chapters_safe > 0 ? (int)ceil($chapters_safe / $chaptersPerPage) : 1;
$currentPage = isset($pid) ? (int)$pid : 1;
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $totalPages) $currentPage = $totalPages;
$startChapter = $chapters_safe > 0 ? (($currentPage - 1) * $chaptersPerPage + 1) : 0;
$endChapter = $chapters_safe > 0 ? min($currentPage * $chaptersPerPage, $chapters_safe) : 0;
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$indexlist_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($index_url) && $index_url) ? (string)$index_url : '');
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$sort_url_raw = isset($sortid) ? (string)Sort::ss_sorturl($sortid) : '';
$theme_dir_attr = $h(isset($theme_dir) ? $theme_dir : 'biquge');
$article_title = isset($articlename) ? (string)$articlename : '';
$author_name = isset($author) ? (string)$author : '';
$sort_name = isset($sortname) ? (string)$sortname : '';
$list_rows = !empty($list_arr) && is_array($list_arr) ? $list_arr : [];
$langtail_rows = !empty($langtailrows) && is_array($langtailrows) ? $langtailrows : [];

require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('indexlist');
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) $seo_title = '《' . $article_title . '》章节目录' . ($currentPage > 1 ? '第' . $currentPage . '页_' : '_') . $author_name . '_' . SITE_NAME;
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) $seo_keywords = $article_title . '章节目录,' . $article_title . '最新章节,' . $author_name . ',' . $sort_name . ',' . SITE_NAME;
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = '《' . $article_title . '》章节目录';
    if ($currentPage > 1) $seo_description .= '第' . $currentPage . '页';
    $seo_description .= '，作者：' . $author_name . '，共' . $chapters_safe . '章。';
}
$index_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sort_name, 'item' => $sort_url_raw],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $article_title, 'item' => $info_url_raw !== '' ? $info_url_raw : $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 4, 'name' => '章节目录' . ($currentPage > 1 ? '第' . $currentPage . '页' : ''), 'item' => $indexlist_url_raw !== '' ? $indexlist_url_raw : $site_home_url_raw],
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
    <?php if ($indexlist_url_raw !== ''): ?>
    <link rel="canonical" href="<?=$h($indexlist_url_raw)?>">
    <meta name="mobile-agent" content="format=html5;url=<?=$h($indexlist_url_raw)?>">
    <meta property="og:url" content="<?=$h($indexlist_url_raw)?>">
    <?php endif; ?>
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?=$h($seo_title)?>">
    <meta property="og:description" content="<?=$h($seo_description)?>">
    <script type="application/ld+json"><?=json_encode($index_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
    <div class="border3-2">
        <div class="info-title">
            <a href="<?=$h($site_home_url_raw)?>"><?=SITE_NAME?></a> &gt; <a href="<?=$h($sort_url_raw)?>"><?=$h($sort_name)?></a> &gt; <a href="<?=$h($info_url_raw)?>"><?=$h($article_title)?></a> &gt; 章节目录
        </div>
        <div class="info-main">
            <img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$h(isset($img_url) ? $img_url : '')?>" alt="<?=$h($article_title)?>" width="120" height="150" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;">
            <div class="w100">
                <h1><?=$h($article_title)?></h1>
                <div class="w100 dispc">
                    <span><a href="<?=$h(isset($author_url) ? $author_url : '')?>">作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$h($author_name)?></a></span>
                    动&nbsp;&nbsp;&nbsp;&nbsp;做：<a href="<?=$h(isset($first_url) ? $first_url : '')?>">开始阅读</a>，<?=$h(isset($isfull) ? $isfull : '')?>，<a href="javascript:gofooter();">直达底部</a>
                </div>
                <div class="dispc"><span>最后更新：<?=$h(isset($lastupdate) ? $lastupdate : '')?></span><a href="<?=$h(isset($last_url) ? $last_url : '')?>">最新章节：<?=$h(isset($lastchapter) ? $lastchapter : '')?></a></div>
                <div class="info-main-intro"><?=!empty($intro_p) ? $intro_p : ''?></div>
            </div>
        </div>
        <?php if (isset($is_langtail) && (int)$is_langtail === 1 && !empty($langtail_rows)) : ?>
        <div class="info-commend">
            <p>相关推荐：
                <?php foreach ($langtail_rows as $v) : ?>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['langname']) ? $v['langname'] : '')?></a>&nbsp;
                <?php endforeach ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
    <div class="diswap info-main-wap border3-1">
        <a href="<?=$h(isset($author_url) ? $author_url : '')?>"><p>作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$h($author_name)?></p></a>
        <p>最后更新：<?=$h(isset($lastupdate) ? $lastupdate : '')?>&nbsp;&nbsp;<a href="javascript:gofooter();">直达底部</a></p>
        <a href="<?=$h(isset($last_url) ? $last_url : '')?>"><p>最新章节：<?=$h(isset($lastchapter) ? $lastchapter : '')?></p></a>
    </div>
</div>

<div class="chapter-range-info">
    <?php if ($chapters_safe > 0): ?>
        <strong>共 <?=$chapters_safe?> 章</strong>
        <span>当前显示：第 <?=$startChapter?> - <?=$endChapter?> 章（第 <?=$currentPage?> 页 / 共 <?=$totalPages?> 页）</span>
    <?php else: ?>
        <strong>暂无目录</strong>
    <?php endif; ?>
</div>

<div class="container border3-2 mt8">
    <div class="info-chapters-title"><strong>《<?=$h($article_title)?>》章节目录</strong></div>
    <div class="info-chapters flex flex-wrap">
        <?php if (!empty($list_rows)): ?>
            <?php $chapterCursor = $startChapter; ?>
            <?php foreach($list_rows as $v): ?>
                <?php if (isset($v['chaptertype']) && (int)$v['chaptertype'] === 1): ?>
                    <div class="chapter-empty chapter-group-title"><?=$h(isset($v['cname']) ? $v['cname'] : '')?></div>
                <?php else: ?>
                    <?php $chapterName = isset($v['cname']) ? (string)$v['cname'] : ''; ?>
                    <a href="<?=$h(isset($v['cid_url']) ? $v['cid_url'] : '')?>" title="<?=$h($article_title . ' ' . $chapterName)?>">第<?=$chapterCursor?>章 <?=$h($chapterName)?></a>
                    <?php $chapterCursor++; ?>
                <?php endif; ?>
            <?php endforeach ?>
        <?php else: ?>
            <div class="chapter-empty">暂无目录</div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($htmltitle)): ?>
<div class="chapter-pagination">
    <?=$htmltitle?>
</div>
<?php elseif ($totalPages > 1): ?>
<div class="chapter-pagination">
    <div class="chapter-page-info">第 <?=$currentPage?> 页 / 共 <?=$totalPages?> 页</div>
</div>
<?php endif; ?>

<button class="gotop" onclick="javascript:gotop();">顶部</button>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
