<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php'; ?>
<?php
$pageTitle = $articlename . ' - ' . $chaptername;
if ($max_pid > 1) {
    $pageTitle .= '（' . $now_pid . '/' . $max_pid . '）';
}
$pageTitle .= ' - ' . SITE_NAME;
$index_url_safe = isset($index_url) && $index_url ? $index_url : $info_url;
$reader_url_safe = isset($uri) && $uri ? $uri : '';
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
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => !empty($site_url) ? $site_url : '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => Sort::ss_sorturl($sortid)],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url],
        ['@type' => 'ListItem', 'position' => 4, 'name' => $chaptername, 'item' => $reader_url_safe !== '' ? $reader_url_safe : $info_url],
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
<meta name="mobile-agent" content="format=html5;url=<?=$reader_url_safe?>">
<meta property="og:type" content="novel">
<link rel="canonical" href="<?=$reader_url_safe?>">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:category" content="<?=$sortname?>小说">
<meta property="og:novel:author" content="<?=$author?>">
<meta property="og:novel:book_name" content="<?=$articlename?>">
<meta property="og:novel:index_url" content="<?=$info_url?>">
<meta property="og:novel:info_url" content="<?=$info_url?>">
<meta property="og:novel:status" content="<?=$isfull?>">
<meta property="og:novel:chapter_name" content="<?=$chaptername?>">
<meta property="og:novel:chapter_url" content="<?=$reader_url_safe?>">
<script type="application/ld+json"><?=json_encode($reader_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="read_bg">
    <main class="container">
        <section class="section_style">
            <div class="bread_crumbs read-breadcrumbs">
                <a href="/">首页</a> &gt; <a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a> &gt; <a href="<?=$info_url?>"><?=$articlename?></a> &gt; <span><?=$chaptername?></span>
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
                    <h1 class="style_h1"><?=$chaptername?></h1>
                    <div class="text_info">
                        <span><a href="<?=$info_url?>"><i class="fa fa-book"> <?=$articlename?></i></a></span>
                        <span><a href="<?=$author_url?>"><i class="fa fa-user-circle-o"> <?=$author?></i></a></span>
                        <span><i class="fa fa-list-ol"> <?=$chapterwords?> 字</i></span>
                        <span><i class="fa fa-clock-o"> <?=Text::ss_lastupdate($lastupdate)?></i></span>
                    </div>
                    <?php if ($max_pid > 1): ?>
                    <div class="page-info reader-page-inline">当前第 <?=$now_pid?> 页 / 共 <?=$max_pid?> 页</div>
                    <?php endif; ?>
                </div>
            </div>
            <article id="article" class="content"><?=$rico_content?></article>
            <div class="s_gray tc"><script>tips('<?=$articlename?>');</script></div>
        </section>
        <div class="read_nav">
            <?php if ($prevpage_url != ''): ?>
                <a id="prev_url" href="<?=$prevpage_url?>"><i class="fa fa-backward"></i> 上一页</a>
            <?php else: ?>
                <?php if ($pre_cid == 0): ?><a id="prev_url" href="<?=$info_url?>" class="w_gray"><i class="fa fa-stop"></i> 没有了</a><?php else: ?><a id="prev_url" href="<?=$pre_url?>"><i class="fa fa-backward"></i> 上一章</a><?php endif; ?>
            <?php endif; ?>
            <a id="info_url" href="<?=$index_url_safe?>">目录</a>
            <?php if ($nextpage_url != ''): ?>
                <a id="next_url" href="<?=$nextpage_url?>">下一页 <i class="fa fa-forward"></i></a>
            <?php else: ?>
                <?php if ($next_cid == 0): ?><a id="next_url" href="<?=$info_url?>" class="w_gray">没有了 <i class="fa fa-stop"></i></a><?php else: ?><a id="next_url" href="<?=$next_url?>">下一章 <i class="fa fa-forward"></i></a><?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
<script src="/static/<?=$theme_dir?>/style.js"></script>
<script>
if (window.lastread && typeof window.lastread.set === 'function') {
    lastread.set(<?=json_encode($info_url, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($uri, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($articlename, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($chaptername, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($author, JSON_UNESCAPED_UNICODE)?>, <?=json_encode($img_url, JSON_UNESCAPED_UNICODE)?>);
}
</script>
