<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__ . '/shipsay/include/neighbor.php';
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$info_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($info_url) && $info_url) ? (string)$info_url : '');
$sort_url_raw = isset($sortid) ? (string)Sort::ss_sorturl($sortid) : '';
$index_url_raw = isset($index_url) && $index_url ? (string)$index_url : '';
$theme_dir_attr = $h(isset($theme_dir) ? $theme_dir : 'biquge');
$article_title = isset($articlename) ? (string)$articlename : '';
$author_name = isset($author) ? (string)$author : '';
$sort_name = isset($sortname) ? (string)$sortname : '';
$intro_html = !empty($intro_p) ? (string)$intro_p : (!empty($intro) ? (string)$intro : (!empty($intro_des) ? nl2br($h($intro_des)) : ''));
$intro_plain = trim(strip_tags($intro_html));
$latest_rows = !empty($lastarr) && is_array($lastarr) ? $lastarr : [];
$preview_rows = !empty($chapterrows) && is_array($chapterrows) ? array_slice($chapterrows, 0, 50) : [];
$langtail_rows = !empty($langtailrows) && is_array($langtailrows) ? $langtailrows : [];
$neighbor_rows = !empty($neighbor) && is_array($neighbor) ? $neighbor : [];
$postdate_rows = !empty($postdate) && is_array($postdate) ? $postdate : [];
$chapters_safe = isset($chapters) ? max(0, (int)$chapters) : 0;
$year = isset($year) && $year ? $year : date('Y');

require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('info');
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) $seo_title = $article_title . '最新章节目录_' . $author_name . '_' . SITE_NAME;
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) $seo_keywords = $article_title . ',' . $author_name . ',' . SITE_NAME . ',最新章节,全文阅读';
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) $seo_description = '《' . $article_title . '》作者：' . $author_name . '，简介：' . $intro_plain;
$info_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sort_name, 'item' => $sort_url_raw],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $article_title, 'item' => $info_url_raw !== '' ? $info_url_raw : $site_home_url_raw],
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
    <?php if ($info_url_raw !== ''): ?>
    <link rel="canonical" href="<?=$h($info_url_raw)?>">
    <meta name="mobile-agent" content="format=html5;url=<?=$h($info_url_raw)?>">
    <meta property="og:url" content="<?=$h($info_url_raw)?>">
    <?php endif; ?>
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$h($seo_title)?>">
    <meta property="og:image" content="<?=$h(isset($img_url) ? $img_url : '')?>">
    <meta property="og:description" content="<?=$h($seo_description)?>">
    <meta property="og:novel:category" content="<?=$h($sort_name)?>">
    <meta property="og:novel:author" content="<?=$h($author_name)?>">
    <meta property="og:novel:author_link" content="<?=$h((!empty($site_url) ? rtrim((string)$site_url, '/') : '') . (isset($author_url) ? (string)$author_url : ''))?>">
    <meta property="og:novel:book_name" content="<?=$h($article_title)?>">
    <meta property="og:novel:read_url" content="<?=$h((!empty($site_url) ? rtrim((string)$site_url, '/') : '') . (isset($uri) ? (string)$uri : ''))?>">
    <meta property="og:novel:url" content="<?=$h((!empty($site_url) ? rtrim((string)$site_url, '/') : '') . (isset($uri) ? (string)$uri : ''))?>">
    <meta property="og:novel:status" content="<?=$h(isset($isfull) ? $isfull : '')?>">
    <meta property="og:novel:update_time" content="<?=$h(isset($lastupdate) ? $lastupdate : '')?>">
    <meta property="og:novel:lastest_chapter_name" content="<?=$h(isset($lastchapter) ? $lastchapter : '')?>">
    <meta property="og:novel:lastest_chapter_url" content="<?=$h((!empty($site_url) ? rtrim((string)$site_url, '/') : '') . (isset($last_url) ? (string)$last_url : ''))?>">
    <script type="application/ld+json"><?=json_encode($info_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
    <div class="border3-2">
        <div class="info-title">
            <a href="<?=$h($site_home_url_raw)?>"><?=SITE_NAME?></a> &gt; <a href="<?=$h($sort_url_raw)?>"><?=$h($sort_name)?></a> &gt; <?=$h($article_title)?>最新章节列表
        </div>
        <div class="info-main">
            <img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$h(isset($img_url) ? $img_url : '')?>" alt="<?=$h($article_title)?>" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;">
            <div class="w100">
                <h1><?=$h($article_title)?></h1>
                <div class="w100 dispc">
                    <span><a href="<?=$h(isset($author_url) ? $author_url : '')?>">作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$h($author_name)?></a></span>
                    动&nbsp;&nbsp;&nbsp;&nbsp;做：<a href="<?=$h(isset($first_url) ? $first_url : '')?>">开始阅读</a>，<?=$h(isset($isfull) ? $isfull : '')?>，<a href="javascript:gofooter();">直达底部</a>
                </div>
                <div class="dispc"><span>最后更新：<?=$h(isset($lastupdate) ? $lastupdate : '')?></span><a href="<?=$h(isset($last_url) ? $last_url : '')?>">最新章节：<?=$h(isset($lastchapter) ? $lastchapter : '')?></a></div>
                <div class="info-main-intro"><?=$intro_html?></div>
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

        <?php if (!empty($neighbor_rows)) : ?>
        <div class="info-commend">推荐阅读:
            <?php foreach($neighbor_rows as $v): ?>
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>" title="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a>
            <?php endforeach ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="diswap info-main-wap border3-1">
        <a href="<?=$h(isset($author_url) ? $author_url : '')?>"><p>作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$h($author_name)?></p></a>
        <p>最后更新：<?=$h(isset($lastupdate) ? $lastupdate : '')?>&nbsp;&nbsp;<a href="javascript:gofooter();">直达底部</a></p>
        <a href="<?=$h(isset($last_url) ? $last_url : '')?>"><p>最新章节：<?=$h(isset($lastchapter) ? $lastchapter : '')?></p></a>
    </div>
</div>

<div class="container border3-2 mt8">
    <div class="info-chapters-title"><strong>《<?=$h($article_title)?>》最新章节</strong><span class="dispc">（提示：已启用缓存技术，最新章节可能会延时显示。）</span></div>
    <div class="info-chapters flex flex-wrap">
        <?php if (!empty($latest_rows)): ?>
            <?php foreach($latest_rows as $v): ?>
                <a href="<?=$h(isset($v['cid_url']) ? $v['cid_url'] : '')?>" title="<?=$h($article_title . ' ' . (isset($v['cname']) ? $v['cname'] : ''))?>"><?=$h(isset($v['cname']) ? $v['cname'] : '')?></a>
            <?php endforeach ?>
        <?php else: ?>
            <div class="chapter-empty">暂无最新章节</div>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($is_langtail) && (int)$is_langtail === 1 && !empty($langtail_rows)) : ?>
<div class="container border3-2 mt8 info-commend-mobile">
    <div class="info-chapters-title"><strong>相关推荐</strong></div>
    <div class="info-commend mobile-visible">
        <?php foreach ($langtail_rows as $v) : ?>
            <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>" title="<?=$h(isset($v['langname']) ? $v['langname'] : '')?>"><?=$h(isset($v['langname']) ? $v['langname'] : '')?></a>
        <?php endforeach ?>
    </div>
</div>
<?php endif; ?>

<div class="container border3-2 mt8 mb20">
    <div class="info-chapters-title">
        <strong>《<?=$h($article_title)?>》正文</strong>
        <?php if ($chapters_safe > 50 && $index_url_raw !== ''): ?>
        <a href="<?=$h($index_url_raw)?>" class="info-index-more">查看完整目录（共<?=$chapters_safe?>章）</a>
        <?php endif; ?>
    </div>
    <div class="info-chapters flex flex-wrap">
        <?php if (!empty($preview_rows)): ?>
            <?php foreach($preview_rows as $v): ?>
                <a href="<?=$h(isset($v['cid_url']) ? $v['cid_url'] : '')?>" title="<?=$h($article_title . ' ' . (isset($v['cname']) ? $v['cname'] : ''))?>"><?=$h(isset($v['cname']) ? $v['cname'] : '')?></a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="chapter-empty">暂无目录</div>
        <?php endif; ?>
    </div>

    <?php if ($chapters_safe > 50 && $index_url_raw !== ''): ?>
    <div class="info-index-more-wrap">
        <a href="<?=$h($index_url_raw)?>" class="info-index-more-btn">查看完整目录（共<?=$chapters_safe?>章）</a>
    </div>
    <?php endif; ?>
</div>

<?php if (!empty($postdate_rows)): ?>
<div class="container">
    <div class="info-commend">最新小说:
        <?php foreach($postdate_rows as $v): ?>
            <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>" title="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a>
        <?php endforeach ?>
    </div>
</div>
<?php endif; ?>

<button class="gotop" onclick="javascript:gotop();">顶部</button>

<script>
(function(){
    var bp = document.createElement('script');
    bp.src = "//zz.bdstatic.com/linksubmit/push.js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
