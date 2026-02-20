<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
// ====== 蜘蛛识别逻辑（阅读页需要：因为内容走 JS，给蜘蛛直接输出正文） ======
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

// ====== SEO 标题与描述 ======
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$pageTitle?></title>
<meta name="keywords" content="<?=$articlename?>,<?=$chaptername?>,<?=$author?>" />
<meta name="description" content="<?=$pageDescription?>" />

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
<meta property="og:url" content="<?=$uri?>" id="ogurl" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="applicable-device" content="pc,mobile" />
<meta http-equiv="mobile-agent" content="format=html5;url=<?=$uri?>" />
<meta http-equiv="mobile-agent" content="format=xhtml;url=<?=$uri?>" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="renderer" content="webkit">

<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/reader.css" />

<style>
/* ✅ 修复你截图里的 404：reader.css 里写死了 /static/ss_qb/icomoon.*，实际你du的字体在 /static/<?=$theme_dir?>/css/icomoon.ttf */
@font-face{
    font-family: 'icomoon';
    src: url('/static/<?=$theme_dir?>/css/icomoon.ttf') format('truetype');
    font-weight: 400;
    font-style: normal;
}

/* ====== 隐藏分页导航样式（阅读页给蜘蛛用） ====== */
.spider-pagination{
    position:absolute;
    left:-9999px;
    top:-9999px;
    height:0;
    overflow:hidden;
}
.spider-pagination a{
    display:inline-block;
    margin:0 5px;
    color:#333;
    text-decoration:none;
}

/* ====== 加载提示样式 ====== */
.loading-text{
    text-align:center;
    padding:40px 20px;
    color:#666;
    font-size:16px;
}
.error-text{
    text-align:center;
    padding:40px 20px;
    color:#f00;
    font-size:16px;
}
</style>

<script src="/static/<?=$theme_dir?>/js/jquery1.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/user.js"></script>
<?php
$tempvar = Ss::is_mobile() ? 'motheme' : 'pctheme';
echo '<script src="/static/' . $theme_dir . '/js/' . $tempvar . '.js"></script>';
?>
</head>

<body class="bg6" id="readbg" onselectstart="return false">

<div class="top">
    <div class="bar">
        <div class="chepnav">
            <i>当前位置:</i><a href="/"><?=SITE_NAME?></a>><a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a>><a href="<?=$info_url?>"><?=$articlename?></a>> <em><?=$chaptername?></em>
        </div>
        <ul><div class="unloginl"><script>login();</script></div></ul>
    </div>
</div>

<div class="mlfy_main">

<?php if(!Ss::is_mobile()) :?>
    <div class="container">
        <ul class="links">
            <li><a href="javascript:addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')">标记书签</a> | </li>
            <?php require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php'; if(!empty($ShipSayReport['on'])) : ?>
                <li><a href="javascript:report()" style="color:red">章节报错</a> | </li>
            <?php endif?>
            <li><a href="<?=$fake_recentread?>">阅读记录</a></li>
        </ul>
        <div class="mlfy_main_l"><i class="szk"><em class="icon-cog"></em> <z>阅读</z>设置</i><i class="hid">（推荐配合 快捷键[F11] 进入全屏沉浸式阅读）</i></div>
    </div>
    <div class="mlfy_main_sz b2">
        <p class="ml"><span class="txt">设置</span><span class="close">X</span></p>
        <ul>
            <li><span class="fl">阅读主题</span><i class="c1"></i><i class="c2"></i><i class="c3"></i><i class="c4"></i><i class="c5"></i><i class="c6 hover"></i><i class="c7"></i><i class="c8"></i></li>
            <li class="hid"><span class="fl">正文字体</span><span class="zt hover">雅黑</span><span class="zt">宋体</span><span class="zt">楷体</span><span class="zt" title="方正启体简体">启体</span><span class="zt" title="思源黑体 CN">思源</span><span class="zt" title="苹方字体">苹方</span></li>
            <li><span class="fl">字体大小</span><span class="dx dxl">A-</span><span class="dx dxc">20</span><span class="dx dxr">A+</span></li>
            <li class="hid"><span class="fl">页面宽度</span><p class="dx kdl"><span class="icon"></span><span class="fl">-</span></p><p class="dx kdc">100%</p><p class="dx kdr"><span class="icon"></span><span class="fl">+</span></p></li>
        </ul>
        <div class="btn-wrap"><a class="red-btn" href="javascript:">保存</a><a class="grey-btn" href="javascript:">取消</a></div>
    </div>
<?php endif ?>

<div id="mlfy_main_text">

    <h1><?=$chaptername?><?php if ($max_pid > 1): ?>（第<?=$now_pid?>页/共<?=$max_pid?>页）<?php endif; ?></h1>
    <dt class="tp"></dt>
    <dt class="kw"></dt>

<?php if(Ss::is_mobile()) :?>
    <div class="toolbar">
        <div class="theme" style="float: left;width: auto;height: auto;">
            <span>
                <a href="javascript:addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')">添加书签</a>
                <?php require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php'; if(!empty($ShipSayReport['on'])) : ?>
                    <a href="javascript:report()" style="color: red;">章节报错</a>
                <?php endif?>
                <a href="<?=$fake_recentread?>">阅读记录</a>
            </span>
        </div>
        <a href="javascript:;" class="aminus font_dec" id="font_dec"></a>
        <a href="javascript:;" class="aadd font_inc" id="font_inc"></a>
        <a href="javascript:;" class="pattern menu-moon" id="mode"></a>
        <div class="option theme">
            <div class="theme-area theme-pink" id="theme2"></div>
        </div>
        <div class="cr"></div>
    </div>
<?php endif ?>

<!-- ✅ 阅读页：蜘蛛专用分页（仅阅读页需要保留） -->
<?php if ($isSearchEngine && $max_pid > 1): ?>
<div class="spider-pagination" aria-label="章节分页导航">
    <?php if ($now_pid > 1): ?><a href="<?=$prevpage_url?>" rel="prev">上一页</a><?php endif; ?>
    <span>第<?=$now_pid?>页/共<?=$max_pid?>页</span>
    <?php for ($i = 1; $i <= min($max_pid, 10); $i++): ?>
        <?php if ($i == $now_pid): ?><strong><?=$i?></strong><?php else: ?><a href="/read/<?=$articleid?>/<?=$chapterid?>/<?=$i?>.html"><?=$i?></a><?php endif; ?>
    <?php endfor; ?>
    <?php if ($now_pid < $max_pid): ?><a href="<?=$nextpage_url?>" rel="next">下一页</a><?php endif; ?>
</div>
<?php endif; ?>

    <div id="TextContent" class="read-content">
        <article id="article" class="content">
            <?php if ($isSearchEngine || !Ss::use_js()): ?>
                <p>天才一秒记住【<?=SITE_NAME?>】地址：<?=$site_url?></p>
                <?php echo $rico_content; ?>
            <?php else: ?>
                <div class="loading-text">正在加载章节内容...</div>
            <?php endif; ?>
        </article>
    </div>
</div>
</div>

<p class="mlfy_page">
    <?php if($prevpage_url != ''): ?>
        <a id="prev_url" href="<?=$prevpage_url?>">上一页</a>
    <?php else: ?>
        <?php if($pre_cid == 0): ?><a id="prev_url" href="javascript:void(0);">没有了</a><?php else: ?><a id="prev_url" href="<?=$pre_url?>">上一章</a><?php endif ?>
    <?php endif ?>

    <a id="info_url" href="<?=$info_url?>">目录</a>
    <a href="javascript:addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')">+书签</a>

    <?php if($nextpage_url != ''): ?>
        <a id="next_url" href="<?=$nextpage_url?>">下一页</a>
    <?php else: ?>
        <?php if($next_cid == 0): ?><a id="next_url" href="javascript:void(0);">没有了</a><?php else: ?><a id="next_url" href="<?=$next_url ?>">下一章</a><?php endif ?>
    <?php endif ?>
</p>

<p class="mlfy_page"><?=SITE_NAME?> -书友最值得收藏的网络小说网站</p>

<script src="/static/<?=$theme_dir?>/js/history.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>

<script>
    var lastread = new LastRead();
lastread.set('<?=$articleid?>', '<?=$uri?>', '<?=$articlename?>', '<?=$chaptername?>', '<?=$author?>', '<?=isset($img_url)?$img_url:''?>');

</script>

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
<?php endif ?>
</script>

<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
</body>
</html>
