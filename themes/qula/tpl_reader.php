<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php';?>
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
<head>
    <meta charset="UTF-8">
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('reader');
    $pageTitle = $seo_title;
    $pageDescription = $seo_description;
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="applicable-device" content="pc,mobile">
    
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$pageTitle?>">
    <meta property="og:description" content="<?=$pageDescription?>">
    <meta property="og:novel:category" content="<?=$sortname?>小说">
    <meta property="og:novel:author" content="<?=$author?>">
    <meta property="og:novel:book_name" content="<?=$articlename?>">
    <meta property="og:novel:index_url" content="<?=$index_url?>">
    <meta property="og:novel:info_url" content="<?=$info_url?>">
    <meta property="og:novel:status" content="<?=$isfull?>">
    <meta property="og:novel:chapter_name" content="<?=$chaptername?>">
    <meta property="og:novel:chapter_url" content="<?=$uri?>">
    
    <link rel="canonical" href="<?=$site_url?><?=$uri?>"/>
    <script src="/static/<?=$theme_dir?>/base.js" type="text/javascript"></script>
    <script src="/static/<?=$theme_dir?>/tran.js" type="text/javascript"></script>
    <script src="/static/<?=$theme_dir?>/tempbookcase.js"></script>
<?php require_once 'tpl_header.php';?>
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
<div class="m-setting">
    <div class="font-box">
        <span><a href="javascript:zh_tran('t');" title="点击[繁/简]切换">繁体版</a></span>
        <span style=" margin-right: 10px;"><a href="javascript:zh_tran('s');" title="点击[繁/简]切换">简体版</a></span>
        
        <select style=" float: right;border: 1px solid #0065B5;border-radius: 5px; color: #0065B5;" class="select select-size">
            <option value="24px">默认</option>
            <option value="16px">16px</option>
            <option value="18px">18px</option>
            <option value="20px">20px</option>
            <option value="22px">22px</option>
            <option value="24px">24px</option>
            <option value="26px">26px</option>
            <option value="28px">28px</option>
            <option value="30px">30px</option>
            <option value="32px">32px</option>
        </select> 
        <select style=" border: 1px solid #0065B5;border-radius: 5px; color: #0065B5;" class="select select-bg">
            <option value="#E9FAFF">默认</option>
            <option value="#FFFFFF">白雪</option>
            <option value="#111111">漆黑</option>
            <option value="#FFFFED">明黄</option>
            <option value="#EEFAEE">淡绿</option>
            <option value="#CCE8CF">草绿</option>
            <option value="#FCEFFF">红粉</option>
            <option value="#EFEFEF">深灰</option>
            <option value="#F5F5DC">米色</option>
            <option value="#D2B48C">茶色</option>
            <option value="#C0C0C0">银色</option>
        </select> 
        <select style=" border: 1px solid #0065B5;border-radius: 5px; color: #0065B5;" class="select select-font">
            <option value="方正启体简体,Apple LiGothic Medium">默认</option>
            <option value="黑体,STHeiti">黑体</option>
            <option value="楷体_GB2312,STKaiti">楷体</option>
            <option value="微软雅黑,STXihei">雅黑</option>
            <option value="方正启体简体,Apple LiGothic Medium">启体</option>
            <option value="宋体,STSong">宋体</option>
        </select>
    </div>
</div>


<?php
$reader_recentread_url = '';
if (function_exists('ss_recentread_url')) {
    $reader_recentread_url = trim((string)ss_recentread_url());
}
if ($reader_recentread_url === '' && !empty($fake_recentread)) {
    $reader_recentread_url = trim((string)$fake_recentread);
}
$reader_rank_url = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
if (!function_exists('ss_reader_page_url')) {
    function ss_reader_page_url($articleid, $chapterid, $page){
        if (class_exists('Url') && method_exists('Url', 'chapter_url')) {
            return (string)Url::chapter_url($articleid, $chapterid, $page);
        }
        return '';
    }
}
?>

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
                <?php $reader_page_url = ss_reader_page_url($articleid, $chapterid, $i); ?><?php if($reader_page_url !== ""): ?><a href="<?=$reader_page_url?>"><?=$i?></a><?php else: ?><span><?=$i?></span><?php endif; ?>
            <?php endif; ?>
        <?php endfor; ?>
        
        <?php if ($now_pid < $max_pid): ?>
            <a href="<?=$nextpage_url?>" rel="next">下一页</a>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="container" id="container">
    <div class="row row-detail row-reader">
        <div class="layout layout-col1">
            <div class="layout-tit xs-hidden">
                <a href="/"><?=SITE_NAME?></a> > <a href="<?=$info_url?>" title="<?=$articlename?>"><?=$articlename?></a> &gt; <?=$chaptername?>
                <?php if ($max_pid > 1): ?>
                <span style="font-size: 14px; color: #666; margin-left: 10px;">
                    （第<?=$now_pid?>页/共<?=$max_pid?>页）
                </span>
                <?php endif; ?>
                <div class="reader-fun">
                    <select class="select select-font">
                        <option value="宋体,STSong">字体</option>
                        <option value="方正启体简体,Apple LiGothic Medium">默认</option>
                        <option value="黑体,STHeiti">黑体</option>
                        <option value="楷体_GB2312,STKaiti">楷体</option>
                        <option value="微软雅黑,STXihei">雅黑</option>
                        <option value="方正启体简体,Apple LiGothic Medium">启体</option>
                        <option value="宋体,STSong">宋体</option>
                    </select>
                    <select class="select select-color">
                        <option value="#555555">颜色</option>
                        <option value="#555555">默认</option>
                        <option value="#9370DB">暗紫</option>
                        <option value="#2E8B57">藻绿</option>
                        <option value="#2F4F4F">深灰</option>
                        <option value="#778899">青灰</option>
                        <option value="#800000">栗色</option>
                        <option value="#6A5ACD">青蓝</option>
                        <option value="#BC8F8F">玫褐</option>
                        <option value="#F4A460">黄褐</option>
                        <option value="#F5F5DC">米色</option>
                        <option value="#F5F5F5">雾白</option>
                    </select>
                    <select class="select select-size">
                        <option value="#E9FAFF">大小</option>
                        <option value="24px">默认</option>
                        <option value="16px">16px</option>
                        <option value="18px">18px</option>
                        <option value="20px">20px</option>
                        <option value="22px">22px</option>
                        <option value="24px">24px</option>
                        <option value="26px">26px</option>
                        <option value="28px">28px</option>
                        <option value="30px">30px</option>
                        <option value="32px">32px</option>
                    </select>
                    <select class="select select-bg">
                        <option value="#E9FAFF">背景</option>
                        <option value="#E9FAFF">默认</option>
                        <option value="#FFFFFF">白雪</option>
                        <option value="#111111">漆黑</option>
                        <option value="#FFFFED">明黄</option>
                        <option value="#EEFAEE">淡绿</option>
                        <option value="#CCE8CF">草绿</option>
                        <option value="#FCEFFF">红粉</option>
                        <option value="#EFEFEF">深灰</option>
                        <option value="#F5F5DC">米色</option>
                        <option value="#D2B48C">茶色</option>
                        <option value="#C0C0C0">银色</option>
                    </select>
                </div>
            </div>
            <div class="reader-main">
                <h1 class="title">
                    <?=$chaptername?>
                    <?php if ($max_pid > 1): ?>
                    <span style="font-size: 14px; color: #666; margin-left: 10px;">
                        （第<?=$now_pid?>页/共<?=$max_pid?>页）
                    </span>
                    <?php endif; ?>
                </h1>
                <div class="section-opt">
                    <?php if($prevpage_url != ''): ?>
                        <a id="prev_url" href="<?=$prevpage_url?>"> 上一页</a>
                    <?php else: ?>
                        <?php if($pre_cid == 0): ?> <a id="prev_url" href="<?=$info_url?>" style="outline: none; text-decoration: none"> 没有了</a><?php else: ?><a id="prev_url" href="<?=$pre_url?>"> 上一章</a>  <span class="xs-hidden">← </span><?php endif ?>
                    <?php endif ?>

                    <a id="info_url" href="<?=$index_url?>">目录</a>  <span class="xs-hidden">→</span>

                    <?php if($nextpage_url != ''): ?>
                        <a id="next_url" href="<?=$nextpage_url?>"> 下一页</a> 
                    <?php else: ?>
                        <?php if($next_cid == 0): ?><a id="next_url" href="<?=$info_url?>" class="w_gray">没有了 </a><?php else: ?><a id="next_url" href="<?=$next_url ?>">下一章 </a><?php endif ?>
                    <?php endif ?>
                    <?php if($enable_down) { ?> 
                        <?php if($reader_recentread_url !== ""): ?><a href="<?=$reader_recentread_url?>" rel="nofollow">最近阅读</a><?php endif; ?>
                    <?php }?>
                    <a href="javascript:vote('<?=$articleid?>','<?=$vote_perday?>')" class="xs-hidden" rel="nofollow">推荐本书</a>
                </div>
                <div class="content" id="content">
                    <?php if(!empty($ShipSayReport['on'])) : ?>
                        <div class="posterror"><a href="javascript:report();" class="red">章节错误,点此举报(免注册)</a>,举报后维护人员会在两分钟内校正章节内容,请耐心等待,并刷新页面。</div>
                    <?php endif ?>
                    
                    <?php if ($isSearchEngine || !Ss::use_js()): ?>
                        <?php echo $rico_content; ?>
                    <?php else: ?>
                        <div class="loading-text">正在加载章节内容...</div>
                    <?php endif; ?>
                </div>
                
                <div class="section-opt m-bottom-opt" style="margin: 0px; top: 0">
                    <?php if($prevpage_url != ''): ?>
                        <a id="prev_url" href="<?=$prevpage_url?>"> 上一页</a>
                    <?php else: ?>
                        <?php if($pre_cid == 0): ?> <a id="prev_url" href="<?=$info_url?>" style="outline: none; text-decoration: none"> 没有了</a><?php else: ?><a id="prev_url" href="<?=$pre_url?>"> 上一章</a>  <span class="xs-hidden">← </span><?php endif ?>
                    <?php endif ?>

                    <a id="info_url" href="<?=$index_url?>">目录</a>  <span class="xs-hidden">→</span>

                    <?php if($nextpage_url != ''): ?>
                        <a id="next_url" href="<?=$nextpage_url?>"> 下一页</a> 
                    <?php else: ?>
                        <?php if($next_cid == 0): ?><a id="next_url" href="<?=$info_url?>" class="w_gray">没有了 </a><?php else: ?><a id="next_url" href="<?=$next_url ?>">下一章 </a><?php endif ?>
                    <?php endif ?>
                    <?php if($enable_down) { ?> 
                        <?php if($reader_recentread_url !== ""): ?><a href="<?=$reader_recentread_url?>" rel="nofollow">最近阅读</a><?php endif; ?>
                    <?php }?>
                </div>
            </div>
        </div>
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
                  $('#content').html(data);
              },
              error: function() {
                  $('#content').html('<div class="error-text">加载失败，请刷新重试</div>');
              }
          });
      }, 200);
  <?php endif ?>

    lastread.set('<?=$info_url?>','<?=$uri?>','<?=$articlename?>','<?=$chaptername?>','<?=$author?>','<?=date("m-d")?>','<?=$img_url?>');
</script>
<?php require_once 'tpl_footer.php'; ?>
