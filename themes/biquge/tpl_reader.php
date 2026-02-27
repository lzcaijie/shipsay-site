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
<html lang='zh'>
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
    <link rel="canonical" href="<?=$site_url?><?=$uri?>">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="applicable-device" content="pc,mobile">
    
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$pageTitle?>">
    <meta property="og:description" content="《<?=$articlename?>》最新章节：<?=$chaptername?>">
    <meta property="og:novel:category" content="<?=$sortname?>小说">
    <meta property="og:novel:author" content="<?=$author?>">
    <meta property="og:novel:book_name" content="<?=$articlename?>">
    <meta property="og:novel:index_url" content="<?=$info_url?>">
    <meta property="og:novel:info_url" content="<?=$info_url?>">
    <meta property="og:novel:status" content="<?=$isfull?>">
    <meta property="og:novel:chapter_name" content="<?=$chaptername?>">
    <meta property="og:novel:chapter_url" content="<?=$uri?>">
    
    <link rel="shortcut icon" type="image/x-icon" href="<?=$site_url?>/static/<?=$theme_dir?>/favicon.ico" media="screen">

<?php require_once 'tpl_header.php'; require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>
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
            <a href="/"><?=SITE_NAME?></a> &gt; <a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a> &gt; <a href="<?=$info_url?>"><?=$articlename?></a> &gt; <?=$chaptername?>
        </div>
        
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
        
        <div class="reader-main">
            <script src="/static/<?=$theme_dir?>/readpage.js"></script>
            <h1>
                <?=$chaptername?>
                <?php if ($max_pid > 1): ?>
                <span style="font-size: 14px; color: #666; margin-left: 10px;">
                    （第<?=$now_pid?>页/共<?=$max_pid?>页）
                </span>
                <?php endif; ?>
            </h1>

            <div class="read_nav">
                <?php if($prevpage_url != ''): ?>
                    <a id="prev_url" href="<?=$prevpage_url?>"><i class="fa fa-backward"></i> 上一页</a>
                <?php else: ?>
                    <?php if($pre_cid == 0): ?><a id="pre_url" href="javascript:void(0);" class="w_gray"><i class="fa fa-stop"></i> 书首页</a><?php else: ?><a id="prev_url" href="<?=$pre_url?>"><i class="fa fa-backward"></i> 上一章</a><?php endif ?>
                <?php endif ?>
                &nbsp; ← &nbsp;<a id="info_url" href="<?=$info_url?>"  disable="disabled">章节目录</a>&nbsp; → &nbsp;
                <?php if($nextpage_url != ''): ?>
                    <a id="next_url" href="<?=$nextpage_url?>"><i class="fa fa-forward"></i> 下一页</a>
                <?php else: ?>
                    <?php if($next_cid == 0): ?><a id="next_url" href="javascript:void(0);" class="w_gray">书末页 <i class="fa fa-stop"></i></a><?php else: ?><a id="next_url" href="<?=$next_url ?>">下一章 <i class="fa fa-forward"></i></a><?php endif ?>
                <?php endif ?>
            </div>
        </div>

        <div class="info-commend mt8">推荐阅读: 
            <?php foreach($neighbor as $k => $v): ?>
                <a href="<?=$v['info_url'] ?>" title="<?=$articlename?>"><?=$v['articlename'] ?></a>
            <?php endforeach ?>
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
            <?php if($prevpage_url != ''): ?>
                <a id="prev_url" href="<?=$prevpage_url?>"><i class="fa fa-backward"></i> 上一页</a>
            <?php else: ?>
                <?php if($pre_cid == 0): ?><a id="prev_url" href="javascript:void(0);" class="w_gray"><i class="fa fa-stop"></i> 书首页</a><?php else: ?><a id="prev_url" href="<?=$pre_url?>"><i class="fa fa-backward"></i> 上一章</a><?php endif ?>
            <?php endif ?>
            &nbsp; ← &nbsp;<a id="info_url" href="<?=$info_url?>"  disable="disabled">章节目录</a>&nbsp; → &nbsp;
            <?php if($nextpage_url != ''): ?>
                <a id="next_url" href="<?=$nextpage_url?>"><i class="fa fa-forward"></i> 下一页</a>
            <?php else: ?>
                <?php if($next_cid == 0): ?><a id="next_url" href="javascript:void(0);" class="w_gray">书末页 <i class="fa fa-stop"></i></a><?php else: ?><a id="next_url" href="<?=$next_url ?>">下一章 <i class="fa fa-forward"></i></a><?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="info-commend mt8">最新小说: 
        <?php foreach($postdate as $k => $v): ?>
            <a href="<?=$v['info_url'] ?>" title="<?=$articlename?>"><?=$v['articlename'] ?></a>
        <?php endforeach ?>
    </div>
</div>

<script src="/static/<?=$theme_dir?>/tempbookcase.js"></script>

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
	const articleid = <?=$articleid?>;
	const chapterid = <?=$chapterid?>;
	const uri = "<?=$uri?>";
	const articlename = "<?=$articlename?>";
	const chaptername = "<?=$chaptername?>";
	const author = "<?= $author ?>";
	const lastvisit = "<?=$lastupdate?>";
	const imgurl = "<?=$img_url?>";
	lastread.set(articleid,uri,articlename,chaptername,author,lastvisit,imgurl);
	
</script>
<?php require_once 'tpl_footer.php'; ?>
