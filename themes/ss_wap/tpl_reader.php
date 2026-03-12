<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php';?>
<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$isSearchEngine = false;
$searchEngines = ['Baiduspider','bingbot','360Spider','Sogou web spider','YisouSpider'];
foreach ($searchEngines as $bot) {
    if (stripos($userAgent, $bot) !== false) {
        $isSearchEngine = true;
        break;
    }
}
$recentread_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$info_url_attr = htmlspecialchars((string)$info_url, ENT_QUOTES, 'UTF-8');
$index_url_raw = isset($index_url) ? (string)$index_url : '';
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('reader');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta property="og:type" content="novel">
<meta property="og:title" content="<?=htmlspecialchars((string)$seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars((string)$chaptername . '是' . (string)$author . '所著' . (string)$sortname . '小说《' . (string)$articlename . '》的最新章节', ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:category" content="<?=htmlspecialchars((string)$sortname . '小说', ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:author" content="<?=htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:book_name" content="<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:index_url" content="<?=$info_url_attr?>">
<meta property="og:novel:info_url" content="<?=$info_url_attr?>">
<meta property="og:novel:status" content="<?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:chapter_name" content="<?=htmlspecialchars((string)$chaptername, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:chapter_url" content="<?=htmlspecialchars((string)$uri, ENT_QUOTES, 'UTF-8')?>">
<style>
.loading-text{text-align:center;padding:40px 20px;color:#666;font-size:16px;}
.error-text{text-align:center;padding:40px 20px;color:#f00;font-size:16px;}
.spider-pagination{position:absolute;left:-9999px;top:-9999px;height:0;overflow:hidden;}
.spider-pagination a{display:inline-block;margin:0 5px;color:#333;text-decoration:none;}
#nr_body .s_m,#nr_body .s_m p{color:#666 !important;}#nr_body .s_m a{color:#1a73e8 !important;text-decoration:none;}
</style>
<?php require_once 'tpl_header.php'; ?>
</head>
<body id="nr_body" class="nr_all c_nr">
<div class="spider-pagination" aria-label="章节分页导航">
<?php if ($max_pid > 1): ?>
    <?php if ($now_pid > 1): ?><a href="<?=htmlspecialchars((string)$prevpage_url, ENT_QUOTES, 'UTF-8')?>" rel="prev">上一页</a><?php endif; ?>
    <span>第<?=$now_pid?>页/共<?=$max_pid?>页</span>
    <?php for ($i = 1; $i <= min($max_pid, 10); $i++): ?>
        <?php if ($i == $now_pid): ?><strong><?=$i?></strong><?php else: ?><a href="/read/<?=urlencode((string)$articleid)?>/<?=urlencode((string)$chapterid)?>/<?=$i?>.html"><?=$i?></a><?php endif; ?>
    <?php endfor; ?>
    <?php if ($now_pid < $max_pid): ?><a href="<?=htmlspecialchars((string)$nextpage_url, ENT_QUOTES, 'UTF-8')?>" rel="next">下一页</a><?php endif; ?>
<?php endif; ?>
</div>
<div>
    <div class="nr_set">
        <div id="lightdiv" class="set1" onclick="nr_setbg('light')">关灯</div>
        <div id="huyandiv" class="set1" onclick="nr_setbg('huyan')">护眼</div>
        <div class="set2"><div>字体：</div><div id="fontbig" onclick="nr_setbg('big')">大</div><div id="fontmiddle" onclick="nr_setbg('middle')">中</div><div id="fontsmall" onclick="nr_setbg('small')">小</div></div>
        <div class="cc"></div>
    </div>
    <h1 class="nr_title" id="nr_title"><?=htmlspecialchars((string)$chaptername, ENT_QUOTES, 'UTF-8')?><?php if ($max_pid > 1): ?><span style="font-size:14px;color:#666;margin-left:10px;">（第<?=$now_pid?>页/共<?=$max_pid?>页）</span><?php endif; ?></h1>
    <div class="nr_page">
        <table cellpadding="0" cellspacing="0"><tr>
            <td class="prev"><a id="pt_index" href="/">首页</a></td>
            <td class="mulu"><?php if ($recentread_url_raw !== ''): ?><a id="pt_bookcase" href="<?=$recentread_url_attr?>">阅读记录</a><?php else: ?><a id="pt_bookcase" href="javascript:void(0);" class="w_gray">阅读记录</a><?php endif; ?></td>
            <td class="mulu"><a id="shuqian" href="<?=$info_url_attr?>">书籍详情</a></td>
            <td class="next"><?php if ($index_url_raw !== ''): ?><a id="pt_mulu" href="<?=$index_url_attr?>">返回目录</a><?php else: ?><a id="pt_mulu" href="javascript:void(0);" class="w_gray">返回目录</a><?php endif; ?></td>
        </tr></table>
    </div>
    <div id="nr" class="nr_nr"><div id="nr1"><?php if ($isSearchEngine || !Ss::use_js()): ?><?php echo $rico_content; ?><?php else: ?><div class="loading-text">正在加载章节内容...</div><?php endif; ?></div></div>
    <div class="nr_page"><table cellpadding="0" cellspacing="0" style="margin:5px 0;"><tr>
        <td class="prev"><?php if($prevpage_url != ''): ?><a id="pb_prev" href="<?=htmlspecialchars((string)$prevpage_url, ENT_QUOTES, 'UTF-8')?>">上一页</a><?php else: ?><?php if($pre_cid == 0): ?><a id="pb_prev" href="javascript:void(0);" class="w_gray">书首页</a><?php else: ?><a id="pb_prev" href="<?=htmlspecialchars((string)$pre_url, ENT_QUOTES, 'UTF-8')?>">上一章</a><?php endif ?><?php endif ?></td>
        <td class="mulu"><?php if ($index_url_raw !== ''): ?><a id="pb_mulu" href="<?=$index_url_attr?>">目录</a><?php else: ?><a id="pb_mulu" href="javascript:void(0);" class="w_gray">目录</a><?php endif; ?></td>
        <td class="next"><?php if($nextpage_url != ''): ?><a id="pb_next" href="<?=htmlspecialchars((string)$nextpage_url, ENT_QUOTES, 'UTF-8')?>">下一页</a><?php else: ?><?php if($next_cid == 0): ?><a id="pb_next" href="javascript:void(0);" class="w_gray">书末页</a><?php else: ?><a id="pb_next" href="<?=htmlspecialchars((string)$next_url, ENT_QUOTES, 'UTF-8')?>">下一章</a><?php endif ?><?php endif ?></td>
    </tr></table></div>
</div>
<script>
<?php if (Ss::use_js() && !$isSearchEngine) : ?>
setTimeout(function() {
    $.ajax({type:'post',url:'/api/reader_js.php',data:{articleid:'<?=addslashes((string)$articleid)?>',chapterid:'<?=addslashes((string)$chapterid)?>',pid:'<?=addslashes((string)$now_pid)?>'},success:function(data){$('#nr1').html(data);},error:function(){$('#nr1').html('<div class="error-text">加载失败，请刷新重试</div>');}});
}, 200);
<?php endif ?>
</script>
<script src="/static/<?=$theme_dir_attr?>/tempbookcase.js"></script>
<script>
getset();
if (window.lastread && typeof window.lastread.set === 'function') {
    window.lastread.set(
        <?=json_encode((string)$info_url, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
        <?=json_encode((string)$uri, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
        <?=json_encode((string)$articlename, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
        <?=json_encode((string)$chaptername, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
        <?=json_encode((string)$author, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
        <?=json_encode(date('m-d'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
        <?=json_encode((string)$img_url, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>
    );
}
</script>
<?php require_once 'tpl_footer.php'; ?>
