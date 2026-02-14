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
    <meta name="keywords" content="<?=$articlename?>,<?=$chaptername?>,<?=$author?>">
    <meta name="description" content="<?=$pageDescription?>">
    
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
    #nr1{
        padding: 5px 10px;
        text-align: justify;
    }
    #nr1 p{
        text-indent: 2rem;
        margin: 1rem 0;
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

    /* ✅ 阅读页底部（tpl_footer.php 的 .s_m 区块）在阅读背景下文字会被全局样式染成白色，导致看不清，这里只对阅读页做覆盖 */
    #nr_body .s_m,
    #nr_body .s_m p{
        color: #666 !important;
    }
    #nr_body .s_m a{
        color: #1a73e8 !important;
        text-decoration: none;
    }
</style>
<?php require_once 'tpl_header.php'; ?>
</head>
<body id="nr_body" class="nr_all c_nr">
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

<div>
    <div class="nr_set">
        <div id="lightdiv" class="set1" onclick="nr_setbg('light')">关灯</div>
        <div id="huyandiv" class="set1" onclick="nr_setbg('huyan')">护眼</div>
        <div class="set2">
            <div>字体：</div>
            <div id="fontbig" onclick="nr_setbg('big')">大</div>
            <div id="fontmiddle" onclick="nr_setbg('middle')">中</div>
            <div id="fontsmall" onclick="nr_setbg('small')">小</div>
        </div>
        <div class="cc"></div>
    </div>
    <h1 class="nr_title" id="nr_title">
        <?=$chaptername?>
        <?php if ($max_pid > 1): ?>
        <span style="font-size: 14px; color: #666; margin-left: 10px;">
            （第<?=$now_pid?>页/共<?=$max_pid?>页）
        </span>
        <?php endif; ?>
    </h1>
    <div class="nr_page">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="prev"><a id="pt_index" href="/">首页</a></td>
                <td class="mulu"><a id="pt_bookcase" href="/bookcase/">书架</a></td>
                <td class="mulu"><a id="shuqian" onclick="addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')">加入书签</a></td>
                <td class="next"><a id="pt_mulu" href="<?=$index_url?>">返回目录</a></td>
            </tr>
        </table>
    </div>
    <div id="nr" class="nr_nr">
        <div id="nr1">
           <?php if ($isSearchEngine || !Ss::use_js()): ?>
                <?php echo $rico_content; ?>
            <?php else: ?>
                <div class="loading-text">正在加载章节内容...</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="nr_page">
        <table cellpadding="0" cellspacing="0" style="margin: 5px 0;">
            <tr>
                <td class="prev">
                    <?php if($prevpage_url != ''): ?>
                        <a id="pb_prev" href="<?=$prevpage_url?>">上一页</a>
                    <?php else: ?>
                        <?php if($pre_cid == 0): ?>
                            <a id="pb_prev" href="javascript:void(0);" class="w_gray">书首页</a>
                        <?php else: ?>
                            <a id="pb_prev" href="<?=$pre_url?>">上一章</a>
                        <?php endif ?>
                    <?php endif ?>
                </td>
                <td class="mulu"><a id="pb_mulu" href="<?=$index_url?>">目录</a></td>
                <td class="next">
                    <?php if($nextpage_url != ''): ?>
                        <a id="pb_next" href="<?=$nextpage_url?>">下一页</a>
                    <?php else: ?>
                        <?php if($next_cid == 0): ?>
                            <a id="pb_next" href="javascript:void(0);" class="w_gray">书末页</a>
                        <?php else: ?>
                            <a id="pb_next" href="<?=$next_url ?>">下一章</a>
                        <?php endif ?>
                    <?php endif ?>
                </td>
            </tr>
        </table>
    </div>
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
                $('#nr1').html(data); 
            },
            error: function() {
                $('#nr1').html('<div class="error-text">加载失败，请刷新重试</div>');
            }
        });
    }, 200);
<?php endif ?>
</script>
<script>getset();</script>
<?php require_once 'tpl_footer.php'; ?>
