<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php';?>
<?php
// 变量安全兜底（避免 notice）
$userAgent   = $_SERVER['HTTP_USER_AGENT'] ?? '';
$articlename = isset($articlename) ? $articlename : '';
$chaptername = isset($chaptername) ? $chaptername : '';
$author      = isset($author) ? $author : '';
$sortname    = isset($sortname) ? $sortname : '';
$info_url    = isset($info_url) ? $info_url : '';
$uri         = isset($uri) ? $uri : '';
$isfull      = isset($isfull) ? $isfull : '';
$site_url    = isset($site_url) ? $site_url : '';

$articleid   = isset($articleid) ? $articleid : 0;
$chapterid   = isset($chapterid) ? $chapterid : 0;

$max_pid     = isset($max_pid) ? (int)$max_pid : 1;
$now_pid     = isset($now_pid) ? (int)$now_pid : 1;

$prevpage_url = isset($prevpage_url) ? $prevpage_url : '';
$nextpage_url = isset($nextpage_url) ? $nextpage_url : '';

$pre_cid     = isset($pre_cid) ? (int)$pre_cid : 0;
$next_cid    = isset($next_cid) ? (int)$next_cid : 0;

$pre_url     = isset($pre_url) ? $pre_url : '';
$next_url    = isset($next_url) ? $next_url : '';

$rico_content = isset($rico_content) ? $rico_content : '';

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

$pageTitle = $articlename . ' - ' . $chaptername;
if ($max_pid > 1) {
    $pageTitle .= '（' . $now_pid . '/' . $max_pid . '）';
}
$pageTitle .= ' - ' . SITE_NAME;

$pageDescription = '《' . $articlename . '》最新章节：' . $chaptername;
if ($max_pid > 1) {
    $pageDescription .= ' 第' . $now_pid . '页/共' . $max_pid . '页';
}
$pageDescription .= '，作者：' . $author . '。';
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">

    <title><?=$pageTitle?></title>
    <meta name="keywords" content="<?=$articlename?>,<?=$chaptername?>,<?=$articlename?>最新章节,<?=$author?>" />
    <meta name="description" content="<?=$pageDescription?>" />

    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="applicable-device" content="pc,mobile">

    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$pageTitle?>">
    <meta property="og:description" content="<?=$pageDescription?>">
    <meta property="og:novel:category" content="<?=$sortname?>小说">
    <meta property="og:novel:author" content="<?=$author?>">
    <meta property="og:novel:book_name" content="<?=$articlename?>">
    <meta property="og:novel:index_url" content="<?=$info_url?>">
    <meta property="og:novel:info_url" content="<?=$info_url?>">
    <meta property="og:novel:status" content="<?=$isfull?>">
    <meta property="og:novel:chapter_name" content="<?=$chaptername?>">
    <meta property="og:novel:chapter_url" content="<?=$uri?>">

    <style>
        #rtext p {
            text-indent: 2rem;
            margin: 2rem 0;
        }
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

<?php require_once 'tpl_header.php'; ?>
<script src="/static/<?=$theme_dir?>/user.js"></script>

<div class="spider-pagination" aria-label="章节分页导航">
    <?php if ($max_pid > 1): ?>
        <?php if ($now_pid > 1): ?>
            <a href="<?=$prevpage_url?>" rel="prev">上一页</a>
        <?php endif; ?>

        <span>第<?=$now_pid?>页/共<?=$max_pid?>页</span>

        <?php for ($i = 1; $i <= min($max_pid, 10); $i++): ?>
            <?php if ($i == $now_pid): ?>
                <strong><?=$i?></strong>
            <?php else: ?>
                <a href="/read/<?=$articleid?>/<?=$chapterid?>/<?=$i?>.html"><?=$i?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($now_pid < $max_pid): ?>
            <a href="<?=$nextpage_url?>" rel="next">下一页</a>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="container">
    <div class="content">
        <ol class="breadcrumb">
            <li><a href="/" title="<?=SITE_NAME ?>">首页</a></li>
            <li><a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></li>
            <li><a href="<?=$info_url?>"><?=$articlename?></a></li>
            <li class="active">
                <?=$chaptername?>
                <?php if ($max_pid > 1): ?>
                <span style="font-size: 14px; color: #666; margin-left: 10px;">
                    （第<?=$now_pid?>页/共<?=$max_pid?>页）
                </span>
                <?php endif; ?>
            </li>
        </ol>

        <div class="book read" id="acontent">
            <div class="fullbar"><script src="/static/<?=$theme_dir?>/pagetop.js"></script></div>

            <h1 class="pt10">
                <?=$chaptername?>
                <?php if ($max_pid > 1): ?>
                <span style="font-size: 14px; color: #666; margin-left: 10px;">
                    （第<?=$now_pid?>页/共<?=$max_pid?>页）
                </span>
                <?php endif; ?>
            </h1>

            <p class="booktag">
                <a class="red" id="a_addbookcase" href="javascript:addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')">加入书签</a>
            </p>

            <div class="readcontent" id="rtext">
                <p>天才一秒记住【<?=SITE_NAME?>】地址：<?=$site_url?></p>

                <?php if ($isSearchEngine || !Ss::use_js()): ?>
                    <?php echo $rico_content; ?>
                <?php else: ?>
                    <div class="loading-text">正在加载章节内容...</div>
                <?php endif; ?>
            </div>

            <p class="text-center">
                <?php if($prevpage_url != ''): ?>
                    <a id="linkPrev" class="btn btn-default" href="<?=$prevpage_url?>">上一页</a>
                <?php else: ?>
                    <?php if($pre_cid == 0): ?><a id="linkPrev" class="btn btn-default" href="javascript:void(0);">书首页</a><?php else: ?><a id="linkPrev" class="btn btn-default" href="<?=$pre_url?>">上一章</a><?php endif ?>
                <?php endif ?>
                <a id="linkIndex" class="btn btn-default" href="<?=$info_url?>" disable="disabled">书页/目录</a>
                <?php if($nextpage_url != ''): ?>
                    <a id="linkNext" class="btn btn-default" href="<?=$nextpage_url?>">下一页</a>
                <?php else: ?>
                    <?php if($next_cid == 0): ?><a id="linkNext" class="btn btn-default" href="javascript:void(0);">书末页</a><?php else: ?><a id="linkNext" class="btn btn-default" href="<?=$next_url ?>">下一章 </a><?php endif ?>
                <?php endif ?>
            </p>

            <div class="clear"></div>
        </div>

        <div class="book mt10 pt10 tuijian">
            <?=$sortname?>相关阅读：
            <?php include __ROOT_DIR__ . '/shipsay/include/neighbor.php'; foreach($neighbor as $v):?>
                <a href="<?=$site_url?><?=$v['info_url'] ?>" title="<?=$articlename?>"><?=$v['articlename'] ?></a>
            <?php endforeach ?>
            <div class="clear"></div>
        </div>

        <p class="pt10 hidden-xs">
            <a href="<?=$info_url?>" title="<?=$articlename?>"><?=$articlename?></a>所有内容均来自互联网，<?=SITE_NAME ?>只为原作者<?=$author?>的小说进行宣传。欢迎各位书友支持<?=$author?>并收藏
            <a href="<?=$info_url?>" title="<?=$articlename?>"><?=$articlename?>最新章节</a>。
        </p>
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
lastread.set('<?=$info_url?>', window.location.href, '<?=$articlename?>', '<?=$chaptername?>', '<?=$author?>', '<?=$sortname?>');
</script>

<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>
