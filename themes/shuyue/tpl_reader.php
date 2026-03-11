<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php'; ?>
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
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$site_url_text_html = htmlspecialchars((string)$site_url, ENT_QUOTES, 'UTF-8');
$sort_url_raw = Sort::ss_sorturl($sortid);
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$reader_url_raw = (!empty($site_url) && !empty($uri)) ? rtrim((string)$site_url, '/') . (string)$uri : '';
$reader_url_attr = htmlspecialchars($reader_url_raw, ENT_QUOTES, 'UTF-8');
$index_url_raw = !empty($index_url) ? (string)$index_url : '';
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
$info_url_raw = !empty($info_url) ? (string)$info_url : '';
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$author_url_raw = !empty($author_url) ? (string)$author_url : '';
$author_url_attr = htmlspecialchars($author_url_raw, ENT_QUOTES, 'UTF-8');
?>
<?php require_once __ROOT_DIR__ . '/shipsay/include/neighbor.php'; ?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php
    require_once __ROOT_DIR__ . '/shipsay/seo.php';
    list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('reader');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:novel:category" content="<?=htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8')?>小说">
    <meta property="og:novel:author" content="<?=htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:novel:book_name" content="<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>">
    <?php if ($info_url_raw !== ""): ?><meta property="og:novel:index_url" content="<?=$info_url_attr?>">
    <meta property="og:novel:info_url" content="<?=$info_url_attr?>"><?php endif; ?>
    <meta property="og:novel:status" content="<?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:novel:chapter_name" content="<?=htmlspecialchars((string)$chaptername, ENT_QUOTES, 'UTF-8')?>">
    <?php if ($reader_url_raw !== ""): ?><meta property="og:novel:chapter_url" content="<?=$reader_url_attr?>">
    <link rel="canonical" href="<?=$reader_url_attr?>"><?php endif; ?>
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="MobileOptimized" content="320">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <style>
    .loading-text { text-align:center; padding:40px 20px; color:#666; font-size:16px; }
    .error-text { text-align:center; padding:40px 20px; color:#f00; font-size:16px; }
    .spider-pagination { position:absolute; left:-9999px; top:-9999px; height:0; overflow:hidden; }
    .spider-pagination a { display:inline-block; margin:0 5px; color:#333; text-decoration:none; }
    #rtext #booktxt p { margin:0 0 16px; }
    #rtext #booktxt p:empty { display:none; margin:0; padding:0; }
    </style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="spider-pagination" aria-label="章节分页导航">
    <?php if ($max_pid > 1): ?>
        <?php if ($now_pid > 1): ?><a href="<?=$prevpage_url?>" rel="prev">上一页</a><?php endif; ?>
        <span>第<?=$now_pid?>页/共<?=$max_pid?>页</span>
        <?php for ($i = 1; $i <= min($max_pid, 10); $i++): ?>
            <?php $page_url = ($i === 1) ? Url::chapter_url($articleid, $chapterid) : Url::chapter_url($articleid, $chapterid, $i); ?>
            <?php if ($i == $now_pid): ?><strong><?=$i?></strong><?php else: ?><a href="<?=$page_url?>"><?=$i?></a><?php endif; ?>
        <?php endfor; ?>
        <?php if ($now_pid < $max_pid): ?><a href="<?=$nextpage_url?>" rel="next">下一页</a><?php endif; ?>
    <?php endif; ?>
</div>

<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li><a href="<?=$sort_url_attr?>"><?=$sortname?></a></li>
        <li><?php if ($info_url_raw !== ""): ?><a href="<?=$info_url_attr?>"><?=$articlename?></a><?php else: ?><?=$articlename?><?php endif; ?></li>
        <li class="active"><?=$chaptername?><?php if ($max_pid > 1): ?><span style="font-size:14px;color:#666;margin-left:10px;">（第<?=$now_pid?>页/共<?=$max_pid?>页）</span><?php endif; ?></li>
        <span class="pull-right" id="ReadSet"></span>
    </ol>

    <div class="panel panel-default" id="content">
        <div class="text-center visible-xs" id="mReadSet"></div>
        <div class="page-header text-center">
            <h1 class="readTitle"><?=$chaptername?><?php if ($max_pid > 1): ?><span style="font-size:14px;color:#666;margin-left:10px;">（第<?=$now_pid?>页/共<?=$max_pid?>页）</span><?php endif; ?></h1>
            <p class="text-center booktag">
                <?php if ($info_url_raw !== ""): ?><a class="blue" href="<?=$info_url_attr?>"><i class="glyphicon glyphicon-book fs-12" aria-hidden="true"></i> <?=$articlename?></a><?php else: ?><span class="blue"><i class="glyphicon glyphicon-book fs-12" aria-hidden="true"></i> <?=$articlename?></span><?php endif; ?>
                <?php if ($author_url_raw !== ""): ?><a class="blue" href="<?=$author_url_attr?>" title="<?=$author?>"><i class="glyphicon glyphicon-user fs-12" aria-hidden="true"></i> <?=$author?></a><?php else: ?><span class="blue"><i class="glyphicon glyphicon-user fs-12" aria-hidden="true"></i> <?=$author?></span><?php endif; ?>
            </p>
        </div>

        <div class="panel-body" id="rtext">
            <div id="booktxt">
                <article id="article" class="content">
                    <p>天才一秒记住【<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>】地址：<?=$site_url_text_html?></p>
                    <div id="BookText">
                        <?php if ($isSearchEngine || !Ss::use_js()): ?>
                            <?=$rico_content?>
                        <?php else: ?>
                            <div class="loading-text">正在加载章节内容...</div>
                        <?php endif; ?>
                    </div>
                    <p><?=$author?>提示您：看后继续阅读更方便（<?=$chaptername?>，<?=$articlename?>，<?=$author?>，<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>）。</p>
                </article>
            </div>
        </div>

        <div class="readPager">
            <?php if ($prevpage_url != ''): ?>
                <a id="linkPrev" href="<?=$prevpage_url?>"><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 上一页</a>
            <?php else: ?>
                <?php if ($pre_cid == 0): ?><a id="linkPrev" href="#"><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 无上章</a><?php else: ?><a id="linkPrev" href="<?=$pre_url?>"><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 上一章</a><?php endif; ?>
            <?php endif; ?>

            <?php if ($index_url_raw !== ''): ?><a id="linkIndex" href="<?=$index_url_attr?>"><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> 目 录</a><?php else: ?><a id="linkIndex" href="#"><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> 目 录</a><?php endif; ?>

            <?php if ($nextpage_url != ''): ?>
                <a id="linkNext" href="<?=$nextpage_url?>">下一页 <i class="glyphicon glyphicon-forward" aria-hidden="true"></i></a>
            <?php else: ?>
                <?php if ($next_cid == 0): ?><a rel="next" href="#">无下章</a><?php else: ?><a id="linkNext" href="<?=$next_url?>">下一章 <i class="glyphicon glyphicon-forward" aria-hidden="true"></i></a><?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="panel panel-default" id="content2">
        <div class="panel-heading"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=$sortname?>小说相关阅读<a class="pull-right" href="<?=$sort_url_attr?>">More+</a></div>
        <div class="panel-body">
            <div class="row">
                <?php if (!empty($neighbor) && is_array($neighbor)): ?><?php foreach ($neighbor as $k => $v): ?><?php if ($k < 3): ?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5"><a href="<?=$v['info_url']?>" class="thumbnail" style="background-image:url(<?=$v['img_url']?>)"></a></div>
                        <div class="col-sm-7 pl0">
                            <div class="caption">
                                <h4 class="fs-16 text-muted"><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></h4>
                                <small class="fs-14 text-muted"><?=$v['author']?></small>
                                <p class="fs-12 text-justify hidden-xs"><?=$v['intro_des']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?><?php endforeach; ?><?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <p>《<?=$articlename?>》所有内容均来自互联网或网友上传，<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>只为原作者<?=$author?>的小说进行宣传。欢迎各位书友支持<?=$author?>并收藏《<?=$articlename?>》最新章节。</p>
    <div class="clear"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    try { document.body.id = 'apage'; } catch (e) {}
    function loadScript(src) {
        return new Promise(function (resolve, reject) {
            var s = document.createElement('script');
            s.src = src;
            s.async = true;
            s.onload = resolve;
            s.onerror = reject;
            document.head.appendChild(s);
        });
    }
    var themeDir = <?=json_encode((string)$theme_dir, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
    var v = <?=json_encode(date('Ymd', time()), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
    var queue = [
        '/static/' + themeDir + '/js/layer.js',
        '/static/' + themeDir + '/js/tempbookcase.js?v=' + v,
        '/static/' + themeDir + '/js/pagetop.js?v=' + v
    ];
    (function next(i) {
        if (i >= queue.length) {
            afterAll();
            return;
        }
        loadScript(queue[i]).then(function () { next(i + 1); }).catch(function () { next(i + 1); });
    })(0);
    function afterAll() {
        <?php if (Ss::use_js() && !$isSearchEngine) : ?>
        setTimeout(function () {
            $.ajax({
                type: 'post',
                url: '/api/reader_js.php',
                data: {
                    articleid: '<?=$articleid?>',
                    chapterid: '<?=$chapterid?>',
                    pid: '<?=$now_pid?>'
                },
                success: function (data) {
                    $('#article').html(data);
                },
                error: function () {
                    $('#article').html('<div class="error-text">加载失败，请刷新重试</div>');
                }
            });
        }, 200);
        <?php endif; ?>
        try {
            if (window.lastread && typeof lastread.set === 'function') {
                lastread.set(
                    <?=json_encode((string)$info_url_raw, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
                    <?=json_encode((string)$uri, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
                    <?=json_encode((string)$articlename, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
                    <?=json_encode((string)$chaptername, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
                    <?=json_encode((string)$author, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
                    <?=json_encode(date('m-d'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
                    <?=json_encode((string)$img_url, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>
                );
            }
        } catch (e) {}
    }
});
</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
