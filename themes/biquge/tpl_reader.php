<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$isSearchEngine = false;
$searchEngines = [
    'Baiduspider',
    'bingbot',
    '360Spider',
    'Sogou web spider',
    'YisouSpider'
];

foreach ($searchEngines as $bot) {
    if (stripos($userAgent, $bot) !== false) {
        $isSearchEngine = true;
        break;
    }
}

require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('reader');
$pageTitle = trim((string)$seo_title) !== '' ? (string)$seo_title : ((string)$articlename . ' - ' . (string)$chaptername . ' - ' . SITE_NAME);
$pageDescription = trim((string)$seo_description) !== '' ? (string)$seo_description : ('《' . (string)$articlename . '》最新章节：' . (string)$chaptername . '，作者：' . (string)$author . '。');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$current_uri_raw = isset($uri) ? (string)$uri : '';
$canonical_url_raw = ($site_home_url_raw !== '/' && $current_uri_raw !== '' && strpos($current_uri_raw, 'http') !== 0)
    ? rtrim($site_home_url_raw, '/') . '/' . ltrim($current_uri_raw, '/')
    : $current_uri_raw;
$sort_url_raw = isset($sortid) ? (string)Sort::ss_sorturl($sortid) : '';
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$index_url_raw = !empty($index_url) ? (string)$index_url : '';
$prevpage_url_raw = isset($prevpage_url) ? (string)$prevpage_url : '';
$nextpage_url_raw = isset($nextpage_url) ? (string)$nextpage_url : '';
$pre_url_raw = isset($pre_url) ? (string)$pre_url : '';
$next_url_raw = isset($next_url) ? (string)$next_url : '';
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title><?=$h($pageTitle)?></title>
<meta name="keywords" content="<?=$h($seo_keywords)?>">
<meta name="description" content="<?=$h($pageDescription)?>">
<?php if ($canonical_url_raw !== ''): ?><link rel="canonical" href="<?=$h($canonical_url_raw)?>"><?php endif; ?>
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">

<meta property="og:type" content="novel">
<meta property="og:title" content="<?=$h($pageTitle)?>">
<meta property="og:description" content="<?=$h('《' . (string)$articlename . '》最新章节：' . (string)$chaptername)?>">
<meta property="og:novel:category" content="<?=$h((string)$sortname . '小说')?>">
<meta property="og:novel:author" content="<?=$h($author)?>">
<meta property="og:novel:book_name" content="<?=$h($articlename)?>">
<?php if($index_url_raw !== ''): ?><meta property="og:novel:index_url" content="<?=$h($index_url_raw)?>"><?php endif; ?>
<?php if($info_url_raw !== ''): ?><meta property="og:novel:info_url" content="<?=$h($info_url_raw)?>"><?php endif; ?>
<meta property="og:novel:status" content="<?=$h($isfull)?>">
<meta property="og:novel:chapter_name" content="<?=$h($chaptername)?>">
<?php if($canonical_url_raw !== ''): ?><meta property="og:novel:chapter_url" content="<?=$h($canonical_url_raw)?>"><?php endif; ?>

<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">

<?php require_once __THEME_DIR__ . '/tpl_header.php'; require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>
<style>
.loading-text {
    text-align: center;
    padding: 40px 20px;
    color: #666;
    font-size: 16px;
}
.error-text {
    text-align: center;
    padding: 40px 20px;
    color: #f00;
    font-size: 16px;
}
.spider-pagination {
    position: absolute;
    left: -9999px;
    top: -9999px;
    height: 0;
    overflow: hidden;
}
.spider-pagination a {
    display: inline-block;
    margin: 0 5px;
    color: #333;
    text-decoration: none;
}
</style>
</head>
<body>
<div class="container">
    <div class="border3-2" id="ss-reader-main">
        <div class="info-title">
            <a href="<?=$h($site_home_url_raw)?>"><?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></a> &gt; <a href="<?=$h($sort_url_raw)?>"><?=$h($sortname)?></a> &gt; <a href="<?=$h($info_url_raw)?>"><?=$h($articlename)?></a> &gt; <?=$h($chaptername)?>
        </div>

        <div class="spider-pagination" aria-label="章节分页导航">
            <?php if ($max_pid > 1): ?>
                <?php if ($now_pid > 1 && $prevpage_url_raw !== ''): ?>
                    <a href="<?=$h($prevpage_url_raw)?>" rel="prev">上一页</a>
                <?php endif; ?>

                <span>第<?=$h($now_pid)?>页/共<?=$h($max_pid)?>页</span>

                <?php if ($now_pid > 1 && $prevpage_url_raw !== ''): ?>
                    <a href="<?=$h($prevpage_url_raw)?>" rel="prev">上一分页</a>
                <?php endif; ?>
                <strong><?=$h($now_pid)?></strong>
                <?php if ($now_pid < $max_pid && $nextpage_url_raw !== ''): ?>
                    <a href="<?=$h($nextpage_url_raw)?>" rel="next">下一分页</a>
                <?php endif; ?>

                <?php if ($now_pid < $max_pid && $nextpage_url_raw !== ''): ?>
                    <a href="<?=$h($nextpage_url_raw)?>" rel="next">下一页</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="reader-main">
            <div id="readSetMount"></div>
            <script src="/static/<?=$theme_dir_attr?>/readpage.js"></script>
            <h1>
                <?=$h($chaptername)?>
                <?php if ($max_pid > 1): ?>
                <span class="reader-pagecount">
                    （第<?=$h($now_pid)?>页/共<?=$h($max_pid)?>页）
                </span>
                <?php endif; ?>
            </h1>

            <div class="read_nav">
                <?php if($prevpage_url_raw !== ''): ?>
                    <a class="read_nav_link" href="<?=$h($prevpage_url_raw)?>"><i class="fa fa-backward"></i> 上一页</a>
                <?php else: ?>
                    <?php if($pre_cid == 0): ?><span class="w_gray"><i class="fa fa-stop"></i> 书首页</span><?php else: ?><a class="read_nav_link" href="<?=$h($pre_url_raw)?>"><i class="fa fa-backward"></i> 上一章</a><?php endif ?>
                <?php endif ?>
                <span class="read_nav_sep">←</span><?php if($index_url_raw !== ''): ?><a class="read_nav_link" href="<?=$h($index_url_raw)?>">章节目录</a><?php else: ?><span class="w_gray">章节目录</span><?php endif; ?><span class="read_nav_sep">→</span>
                <?php if($nextpage_url_raw != ''): ?>
                    <a class="read_nav_link" href="<?=$h($nextpage_url_raw)?>"><i class="fa fa-forward"></i> 下一页</a>
                <?php else: ?>
                    <?php if($next_cid == 0): ?><span class="w_gray">书末页 <i class="fa fa-stop"></i></span><?php else: ?><a class="read_nav_link" href="<?=$h($next_url_raw)?>">下一章 <i class="fa fa-forward"></i></a><?php endif ?>
                <?php endif ?>
            </div>
        </div>

        <div class="info-commend mt8">推荐阅读:
            <?php if (!empty($neighbor) && is_array($neighbor)): ?>
                <?php foreach($neighbor as $k => $v): ?>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>" title="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a>
                <?php endforeach ?>
            <?php endif; ?>
        </div>

        <div class="reader-hr" ></div>

        <article id="article" class="content">
            <?php if ($isSearchEngine || !Ss::use_js()): ?>
                <?php echo $rico_content; ?>
            <?php else: ?>
                <div class="loading-text">正在加载章节内容...</div>
            <?php endif; ?>
        </article>

        <div class="read_nav reader-bottom">
            <?php if($prevpage_url_raw != ''): ?>
                <a class="read_nav_link" href="<?=$h($prevpage_url_raw)?>"><i class="fa fa-backward"></i> 上一页</a>
            <?php else: ?>
                <?php if($pre_cid == 0): ?><span class="w_gray"><i class="fa fa-stop"></i> 书首页</span><?php else: ?><a class="read_nav_link" href="<?=$h($pre_url_raw)?>"><i class="fa fa-backward"></i> 上一章</a><?php endif ?>
            <?php endif ?>
            <span class="read_nav_sep">←</span><?php if($index_url_raw !== ''): ?><a class="read_nav_link" href="<?=$h($index_url_raw)?>">章节目录</a><?php else: ?><span class="w_gray">章节目录</span><?php endif; ?><span class="read_nav_sep">→</span>
            <?php if($nextpage_url_raw != ''): ?>
                <a class="read_nav_link" href="<?=$h($nextpage_url_raw)?>"><i class="fa fa-forward"></i> 下一页</a>
            <?php else: ?>
                <?php if($next_cid == 0): ?><span class="w_gray">书末页 <i class="fa fa-stop"></i></span><?php else: ?><a class="read_nav_link" href="<?=$h($next_url_raw)?>">下一章 <i class="fa fa-forward"></i></a><?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="info-commend mt8">最新小说:
        <?php if (!empty($postdate) && is_array($postdate)): ?>
            <?php foreach($postdate as $k => $v): ?>
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>" title="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>

<script src="/static/<?=$theme_dir_attr?>/tempbookcase.js"></script>

<script>
<?php if (Ss::use_js() && !$isSearchEngine) : ?>
setTimeout(function() {
    $.ajax({
        type: "post",
        url: "/api/reader_js.php",
        data: {
            articleid: <?=json_encode((string)$articleid, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
            chapterid: <?=json_encode((string)$chapterid, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
            pid: <?=json_encode((string)$now_pid, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>
        },
        success: function(data) {
            $('#article').html(data);
        },
        error: function() {
            $('#article').html('<div class="error-text">加载失败，请刷新重试</div>');
        }
    });
}, 200);
<?php endif ?>
const articleid = <?=json_encode((string)$articleid, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
const chapterid = <?=json_encode((string)$chapterid, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
const uri = <?=json_encode((string)$current_uri_raw, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
const articlename = <?=json_encode((string)$articlename, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
const chaptername = <?=json_encode((string)$chaptername, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
const author = <?=json_encode((string)$author, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
const lastvisit = <?=json_encode((string)$lastupdate, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
const imgurl = <?=json_encode((string)$img_url, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
if (typeof lastread !== 'undefined' && lastread && typeof lastread.set === 'function') {
    lastread.set(articleid, uri, articlename, chaptername, author, lastvisit, imgurl);
}
</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
