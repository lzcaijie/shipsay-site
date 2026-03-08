<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php'; ?>
<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$isSearchEngine = false;
$searchEngines = [
    'Baiduspider',
    'bingbot',
    '360Spider',
    'Sogou web spider',
    'YisouSpider',
];
foreach ($searchEngines as $bot) {
    if (stripos($userAgent, $bot) !== false) {
        $isSearchEngine = true;
        break;
    }
}

$pageTitle = $articlename . ' - ' . $chaptername;
if ($max_pid > 1) {
    $pageTitle .= '（' . $now_pid . '/' . $max_pid . '）';
}
$pageTitle .= ' - ' . SITE_NAME;
$index_url_raw = isset($index_url) && $index_url ? (string)$index_url : '';
$reader_url_raw = isset($uri) && $uri ? (string)$uri : '';
$reader_url_attr = htmlspecialchars($reader_url_raw, ENT_QUOTES, 'UTF-8');
$home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$home_url_attr = htmlspecialchars($home_url_raw, ENT_QUOTES, 'UTF-8');
$sort_url_attr = htmlspecialchars(Sort::ss_sorturl($sortid), ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$chaptername_html = htmlspecialchars((string)$chaptername, ENT_QUOTES, 'UTF-8');
$info_url_attr = htmlspecialchars((string)$info_url, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$status_html = htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8');
$chapterwords_safe = intval($chapterwords);
$now_pid_safe = intval($now_pid);
$max_pid_safe = intval($max_pid);
$prevpage_url_attr = htmlspecialchars((string)$prevpage_url, ENT_QUOTES, 'UTF-8');
$nextpage_url_attr = htmlspecialchars((string)$nextpage_url, ENT_QUOTES, 'UTF-8');
$pre_url_attr = htmlspecialchars((string)$pre_url, ENT_QUOTES, 'UTF-8');
$next_url_attr = htmlspecialchars((string)$next_url, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('reader');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $chaptername . '_' . $articlename . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $articlename . ',' . $chaptername . ',' . SITE_NAME . ',在线阅读';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = '《' . $articlename . '》最新章节：' . $chaptername . '，作者：' . $author . '。';
}
$pageTitle = $seo_title;
$reader_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => Sort::ss_sorturl($sortid)],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url],
        ['@type' => 'ListItem', 'position' => 4, 'name' => $chaptername, 'item' => $reader_url_raw],
    ],
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta name="robots" content="all">
<meta name="bingbot" content="all">
<meta name="baiduspider" content="all">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$reader_url_attr?>">
<meta property="og:type" content="novel">
<link rel="canonical" href="<?=$reader_url_attr?>">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:category" content="<?=$sortname_html?>小说">
<meta property="og:novel:author" content="<?=$author_html?>">
<meta property="og:novel:book_name" content="<?=$article_title_html?>">
<meta property="og:novel:index_url" content="<?=$info_url_attr?>">
<meta property="og:novel:info_url" content="<?=$info_url_attr?>">
<meta property="og:novel:status" content="<?=$status_html?>">
<meta property="og:novel:chapter_name" content="<?=$chaptername_html?>">
<meta property="og:novel:chapter_url" content="<?=$reader_url_attr?>">
<script type="application/ld+json"><?=json_encode($reader_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="read_bg">
    <main class="container">
        <section class="section_style">
            <div class="bread_crumbs read-breadcrumbs">
                <a href="<?=$home_url_attr?>">首页</a> &gt; <a href="<?=$sort_url_attr?>"><?=$sortname_html?></a> &gt; <a href="<?=$info_url_attr?>"><?=$article_title_html?></a> &gt; <span><?=$chaptername_html?></span>
            </div>
            <div class="text">
                <div class="text_set">
                    <i class="fr cog fa fa-cog fa-3x" onclick="javascript:cog();"></i>
                    <div id="text_control">
                        <div class="fontsize">
                            <button onclick="javascript:changeSize('min');" title="缩小字号">A-</button>
                            <button onclick="javascript:changeSize('normal');" title="标准字号">A</button>
                            <button onclick="javascript:changeSize('plus');" title="放大字号">A+</button>
                        </div>
                        <div>
                            <a href="javascript:alert('敬请期待')" title="加入书签"><i class="fa fa-bookmark"></i></a>
                            <a href="javascript:isnight();" title="白天夜间模式"><i class="fa fa-moon-o fa-flip-horizontal"></i></a>
                            <a href="javascript:;" title="极简模式"><i id="ismini" class="fa fa-minus-square" onclick="ismini();"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reader-page-head">
                <div class="text_title">
                    <h1 class="style_h1"><?=$chaptername_html?></h1>
                    <div class="text_info">
                        <span><a href="<?=$info_url_attr?>"><i class="fa fa-book"> <?=$article_title_html?></i></a></span>
                        <span><a href="<?=$author_url_attr?>"><i class="fa fa-user-circle-o"> <?=$author_html?></i></a></span>
                        <span><i class="fa fa-list-ol"> <?=$chapterwords_safe?> 字</i></span>
                        <span><i class="fa fa-clock-o"> <?=Text::ss_lastupdate($lastupdate)?></i></span>
                    </div>
                    <?php if ($max_pid > 1): ?>
                    <div class="page-info reader-page-inline">当前第 <?=$now_pid_safe?> 页 / 共 <?=$max_pid_safe?> 页</div>
                    <?php endif; ?>
                </div>
            </div>
            <article id="article" class="content">
                <?php if ($isSearchEngine || !Ss::use_js()): ?>
                    <?=$rico_content?>
                <?php else: ?>
                    <div class="reader-loading">正在加载正文...</div>
                <?php endif; ?>
            </article>
            <div class="s_gray tc"><script>tips(<?=json_encode($articlename, JSON_UNESCAPED_UNICODE)?>);</script></div>
        </section>
        <div class="read_nav">
            <?php if ($prevpage_url != ''): ?>
                <a id="prev_url" href="<?=$prevpage_url_attr?>"><i class="fa fa-backward"></i> 上一页</a>
            <?php else: ?>
                <?php if ($pre_cid == 0): ?><a id="prev_url" href="<?=$info_url_attr?>" class="w_gray"><i class="fa fa-stop"></i> 没有了</a><?php else: ?><a id="prev_url" href="<?=$pre_url_attr?>"><i class="fa fa-backward"></i> 上一章</a><?php endif; ?>
            <?php endif; ?>
            <?php if ($index_url_raw !== ''): ?>
                <a id="info_url" href="<?=$index_url_attr?>">目录</a>
            <?php else: ?>
                <span id="info_url" class="w_gray">目录</span>
            <?php endif; ?>
            <?php if ($nextpage_url != ''): ?>
                <a id="next_url" href="<?=$nextpage_url_attr?>">下一页 <i class="fa fa-forward"></i></a>
            <?php else: ?>
                <?php if ($next_cid == 0): ?><a id="next_url" href="<?=$info_url_attr?>" class="w_gray">没有了 <i class="fa fa-stop"></i></a><?php else: ?><a id="next_url" href="<?=$next_url_attr?>">下一章 <i class="fa fa-forward"></i></a><?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>
<?php if (Ss::use_js() && !$isSearchEngine) : ?>
setTimeout(function() {
    $.ajax({
        type: "post",
        url: "/api/reader_js.php",
        data: {
            articleid: '<?= $articleid ?>',
            chapterid: '<?= $chapterid ?>',
            pid: '<?= $now_pid ?>'
        },
        success: function(data) {
            $('#article').html(data);
        },
        error: function() {
            $('#article').html('<div class="error-text">加载失败，请刷新重试</div>');
        }
    });
}, 200);
<?php endif; ?>
</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
<script src="/static/<?=$theme_dir_attr?>/style.js"></script>
<script>
if (window.lastread && typeof window.lastread.set === 'function') {
    lastread.set(<?=json_encode($info_url, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($reader_url_raw, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($articlename, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($chaptername, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($author, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($img_url, JSON_UNESCAPED_UNICODE)?>);
}
</script>
