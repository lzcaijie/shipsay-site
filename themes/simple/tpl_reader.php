<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php';?>
<?php
$userAgent   = $_SERVER['HTTP_USER_AGENT'] ?? '';
$articlename = isset($articlename) ? (string)$articlename : '';
$chaptername = isset($chaptername) ? (string)$chaptername : '';
$author      = isset($author) ? (string)$author : '';
$sortname    = isset($sortname) ? (string)$sortname : '';
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$reader_url_raw = isset($uri) ? (string)$uri : '';
$reader_url_attr = htmlspecialchars($reader_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$sort_url_raw = isset($sortid) ? (string)Sort::ss_sorturl($sortid) : '';
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$index_url_raw = isset($index_url) && $index_url ? (string)$index_url : '';
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)($author_url ?? ''), ENT_QUOTES, 'UTF-8');
$article_title_html = htmlspecialchars($articlename, ENT_QUOTES, 'UTF-8');
$chaptername_html = htmlspecialchars($chaptername, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars($author, ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars($sortname, ENT_QUOTES, 'UTF-8');
$status_html = htmlspecialchars((string)($isfull ?? ''), ENT_QUOTES, 'UTF-8');
$chapterwords_safe = isset($chapterwords) ? (int)$chapterwords : 0;
$lastupdate_text_html = htmlspecialchars((string)Text::ss_lastupdate($lastupdate), ENT_QUOTES, 'UTF-8');
$now_pid_safe = isset($now_pid) ? (int)$now_pid : 1;
$max_pid_safe = isset($max_pid) ? (int)$max_pid : 1;
$prevpage_url_attr = htmlspecialchars((string)($prevpage_url ?? ''), ENT_QUOTES, 'UTF-8');
$nextpage_url_attr = htmlspecialchars((string)($nextpage_url ?? ''), ENT_QUOTES, 'UTF-8');
$pre_url_attr = htmlspecialchars((string)($pre_url ?? ''), ENT_QUOTES, 'UTF-8');
$next_url_attr = htmlspecialchars((string)($next_url ?? ''), ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
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
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = $chaptername . '_' . $articlename . '_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = $articlename . ',' . $chaptername . ',' . SITE_NAME . ',在线阅读';
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = '《' . $articlename . '》最新章节：' . $chaptername . '，作者：' . $author . '。';
}
$reader_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => $sort_url_raw !== '' ? $sort_url_raw : $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url_raw !== '' ? $info_url_raw : $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 4, 'name' => $chaptername, 'item' => $reader_url_raw !== '' ? $reader_url_raw : $site_home_url_raw],
    ],
];
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="applicable-device" content="pc,mobile">
    <?php if ($reader_url_raw !== ''): ?>
    <meta name="mobile-agent" content="format=html5;url=<?=$reader_url_attr?>">
    <link rel="canonical" href="<?=$reader_url_attr?>">
    <meta property="og:url" content="<?=$reader_url_attr?>">
    <?php endif; ?>
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:novel:category" content="<?=$sortname_html?>小说">
    <meta property="og:novel:author" content="<?=$author_html?>">
    <meta property="og:novel:book_name" content="<?=$article_title_html?>">
    <?php if ($index_url_raw !== ''): ?><meta property="og:novel:index_url" content="<?=$index_url_attr?>"><?php endif; ?>
    <?php if ($info_url_raw !== ''): ?><meta property="og:novel:info_url" content="<?=$info_url_attr?>"><?php endif; ?>
    <meta property="og:novel:status" content="<?=$status_html?>">
    <meta property="og:novel:chapter_name" content="<?=$chaptername_html?>">
    <?php if ($reader_url_raw !== ''): ?><meta property="og:novel:chapter_url" content="<?=$reader_url_attr?>"><?php endif; ?>
    <script type="application/ld+json"><?=json_encode($reader_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>

    <style>
        #rtext p { text-indent: 2rem; margin: 2rem 0; }
        .loading-text { text-align: center; padding: 40px 20px; color: #666; font-size: 16px; }
        .error-text { text-align: center; padding: 40px 20px; color: #f00; font-size: 16px; }
        .spider-pagination { position: absolute; left: -9999px; top: -9999px; height: 0; overflow: hidden; }
        .spider-pagination a { display: inline-block; margin: 0 5px; color: #333; text-decoration: none; }
        .reader-meta { margin-bottom: 10px; color: #666; line-height: 1.8; }
        .reader-meta span { display: inline-block; margin-right: 12px; }
    </style>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="spider-pagination" aria-label="章节分页导航">
    <?php if ($max_pid_safe > 1): ?>
        <?php if ($now_pid_safe > 1): ?>
            <a href="<?=$prevpage_url_attr?>" rel="prev">上一页</a>
        <?php endif; ?>
        <span>第<?=$now_pid_safe?>页/共<?=$max_pid_safe?>页</span>
        <?php for ($i = 1; $i <= min($max_pid_safe, 10); $i++): ?>
            <?php if ($i == $now_pid_safe): ?>
                <strong><?=$i?></strong>
            <?php else: ?>
                <?php $spider_page_url = class_exists('Url') ? Url::chapter_url($articleid, $chapterid, $i) : ''; ?>
                <?php if ($spider_page_url !== ''): ?><a href="<?=htmlspecialchars((string)$spider_page_url, ENT_QUOTES, 'UTF-8')?>"><?=$i?></a><?php endif; ?>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($now_pid_safe < $max_pid_safe): ?>
            <a href="<?=$nextpage_url_attr?>" rel="next">下一页</a>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="container">
    <div class="content">
        <ol class="breadcrumb">
            <li><a href="<?=$site_home_url_attr?>" title="<?=SITE_NAME ?>">首页</a></li>
            <li><?php if ($sort_url_raw !== ''): ?><a href="<?=$sort_url_attr?>"><?=$sortname_html?></a><?php else: ?><?=$sortname_html?><?php endif; ?></li>
            <li><?php if ($info_url_raw !== ''): ?><a href="<?=$info_url_attr?>"><?=$article_title_html?></a><?php else: ?><?=$article_title_html?><?php endif; ?></li>
            <li class="active">
                <?=$chaptername_html?>
                <?php if ($max_pid_safe > 1): ?>
                <span style="font-size: 14px; color: #666; margin-left: 10px;">（第<?=$now_pid_safe?>页/共<?=$max_pid_safe?>页）</span>
                <?php endif; ?>
            </li>
        </ol>

        <div class="book read" id="acontent">
            <div class="fullbar"><script src="/static/<?=$theme_dir_attr?>/pagetop.js"></script></div>
            <h1 class="pt10">
                <?=$chaptername_html?>
                <?php if ($max_pid_safe > 1): ?>
                <span style="font-size: 14px; color: #666; margin-left: 10px;">（第<?=$now_pid_safe?>页/共<?=$max_pid_safe?>页）</span>
                <?php endif; ?>
            </h1>
            <div class="reader-meta">
                <span><?php if ($info_url_raw !== ''): ?><a href="<?=$info_url_attr?>"><?=$article_title_html?></a><?php else: ?><?=$article_title_html?><?php endif; ?></span>
                <span><?php if ($author_url_attr !== ''): ?><a href="<?=$author_url_attr?>">作者：<?=$author_html?></a><?php else: ?>作者：<?=$author_html?><?php endif; ?></span>
                <span>字数：<?=$chapterwords_safe?></span>
                <span>时间：<?=$lastupdate_text_html?></span>
            </div>

            <div class="readcontent" id="rtext">
                <p>天才一秒记住【<?=SITE_NAME?>】地址：<?=htmlspecialchars((string)$site_url, ENT_QUOTES, 'UTF-8')?></p>
                <?php if ($isSearchEngine || !Ss::use_js()): ?>
                    <?php echo $rico_content; ?>
                <?php else: ?>
                    <div class="loading-text">正在加载章节内容...</div>
                <?php endif; ?>
            </div>

            <p class="text-center">
                <?php if((string)($prevpage_url ?? '') !== ''): ?>
                    <a id="linkPrev" class="btn btn-default" href="<?=$prevpage_url_attr?>">上一页</a>
                <?php else: ?>
                    <?php if((int)($pre_cid ?? 0) === 0): ?><a id="linkPrev" class="btn btn-default" href="javascript:void(0);">书首页</a><?php else: ?><a id="linkPrev" class="btn btn-default" href="<?=$pre_url_attr?>">上一章</a><?php endif ?>
                <?php endif ?>
                <?php if ($index_url_raw !== ''): ?><a id="linkIndex" class="btn btn-default" href="<?=$index_url_attr?>">目录</a><?php else: ?><a id="linkIndex" class="btn btn-default" href="javascript:void(0);" aria-disabled="true">目录</a><?php endif; ?>
                <?php if((string)($nextpage_url ?? '') !== ''): ?>
                    <a id="linkNext" class="btn btn-default" href="<?=$nextpage_url_attr?>">下一页</a>
                <?php else: ?>
                    <?php if((int)($next_cid ?? 0) === 0): ?><a id="linkNext" class="btn btn-default" href="javascript:void(0);">书末页</a><?php else: ?><a id="linkNext" class="btn btn-default" href="<?=$next_url_attr?>">下一章</a><?php endif ?>
                <?php endif ?>
            </p>

            <div class="clear"></div>
        </div>

        <div class="book mt10 pt10 tuijian">
            <?=$sortname_html?>相关阅读：
            <?php include __ROOT_DIR__ . '/shipsay/include/neighbor.php'; foreach($neighbor as $v):?>
                <a href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>" title="<?=$article_title_html?>"><?=htmlspecialchars((string)($v['articlename'] ?? ''), ENT_QUOTES, 'UTF-8')?></a>
            <?php endforeach ?>
            <div class="clear"></div>
        </div>

        <p class="pt10 hidden-xs">《<?=$article_title_html?>》情节跌宕起伏、扣人心弦，是一本情节与文笔俱佳的<?=$sortname_html?>小说，<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>转载收集《<?=$article_title_html?>》最新章节。</p>
    </div>
    <div class="clear"></div>
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
            $('#rtext').html(data);
        },
        error: function() {
            $('#rtext').html('<div class="error-text">加载失败，请刷新重试</div>');
        }
    });
}, 200);
<?php endif ?>
var lastread = new LastRead();
lastread.set(<?=json_encode($info_url_raw, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>, window.location.href, <?=json_encode($articlename, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>, <?=json_encode($chaptername, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>, <?=json_encode($author, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>, <?=json_encode($sortname, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>);
</script>

<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>
