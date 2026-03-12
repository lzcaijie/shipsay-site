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
$full_allbooks_url_safe = !empty($full_allbooks_url)
    ? $full_allbooks_url
    : ('/quanben' . (isset($allbooks_url) ? $allbooks_url : '/sort/'));
$recentread_url_reader = !empty($recentread_url_attr) ? $recentread_url_attr : (!empty($fake_recentread) ? $fake_recentread : 'javascript:history.go(-1)');

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
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">

<meta property="og:type" content="novel">
<meta property="og:title" content="<?=$pageTitle?>">
<meta property="og:description" content="<?=$chaptername?>是<?=$author?>所著<?=$sortname?>小说《<?=$articlename?>》的最新章节">
<meta property="og:novel:category" content="<?=$sortname?>小说">
<meta property="og:novel:author" content="<?=$author?>">
<meta property="og:novel:book_name" content="<?=$articlename?>">
<meta property="og:novel:index_url" content="<?=$info_url?>">
<meta property="og:novel:info_url" content="<?=$info_url?>">
<meta property="og:novel:status" content="<?=$isfull?>">
<meta property="og:novel:chapter_name" content="<?=$chaptername?>">
<meta property="og:novel:chapter_url" content="<?=$uri?>">

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
<body id="wrapper">
	<header class="header">
		<div class="left"><a href="<?=$info_url?>"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center"><?=$articlename?></div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	
	
<?php
$reader_recentread_url = !empty($recentread_url_attr) ? (string)$recentread_url_attr : (!empty($fake_recentread) ? (string)$fake_recentread : '');
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
                    <a href="<?=$now_url?><?=$i?>.html"><?=$i?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($now_pid < $max_pid): ?>
                <a href="<?=$nextpage_url?>" rel="next">下一页</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

	<div class="fixed">
	    <div class="read">
	        <div id="readSet"></div>
	        <div class="clear"></div>
	        <h1>
	            <?=$chaptername?>
	            <?php if ($max_pid > 1): ?>
	            <span style="font-size: 14px; color: #666; margin-left: 10px;">
	                （第<?=$now_pid?>页/共<?=$max_pid?>页）
	            </span>
	            <?php endif; ?>
	        </h1>
		    
		    <div class="readpage">
		    	<?php if($prevpage_url != ''): ?>
                <a rel="prev" href="<?=$prevpage_url?>">上一页</a>
            <?php else: ?>
                <?php if($pre_cid == 0): ?><span class="gray" id="prev_url">没有了</span><?php else: ?><a href="<?=$pre_url?>" rel="prev" id="prev_url">上一章</a><?php endif ?>
            <?php endif ?>
	        	<a href="<?=$info_url?>" rel="index" id="info_url">目录</a>
	        	<a href="<?=$recentread_url_reader?>" class="reader-record-link">阅读记录</a>
		    	<?php if($nextpage_url != ''): ?>
                <a href="<?=$nextpage_url?>" rel="next" id="next_url">下一页</a>
            <?php else: ?>
                <?php if($next_cid == 0): ?><span rel="next" class="gray">没有了</span><?php else: ?><a href="<?=$next_url ?>" rel="next" id="next_url">下一章</a><?php endif ?>
            <?php endif ?>
		    </div>
		    
		    <div id="content_1"></div>
		    
		    <div class="readcontent">
		    	<div id="booktxt">
		        	<article id="article" class="content">   
		            	<p>喜欢【<?=SITE_NAME?>】，请收藏地址：<?=$site_url?></p>
		            	<p>
		            	    <?php if ($isSearchEngine || !Ss::use_js()): ?>
                                <?php echo $rico_content; ?>
                            <?php else: ?>
                                <div class="loading-text">正在加载章节内容...</div>
                            <?php endif; ?>
		            	</p>
		        	</article>
		    	</div>
		    	
		    	<?php if($nextpage_url != ''): ?>
                <p style="color: red;">本章未完，点击下一页继续阅读。</p>  
            <?php endif ?>
		    	
            <?php if(!empty($ShipSayReport['on'])) : ?>
                <div class="report"><a href="javascript:report()">章节报错(免登录)</a></div>
            <?php endif?>
		    </div>
		    
		    <div id="content_2"></div>
		    
		    <div class="readpage">
		    	<?php if($prevpage_url != ''): ?>
                <a rel="prev" href="<?=$prevpage_url?>">上一页</a>
            <?php else: ?>
                <?php if($pre_cid == 0): ?><span class="gray" id="prev_url">没有了</span><?php else: ?><a href="<?=$pre_url?>" rel="prev" id="prev_url">上一章</a><?php endif ?>
            <?php endif ?>
	        	<a href="<?=$info_url?>" rel="index" id="info_url">目录</a>
	        	<a href="<?=$recentread_url_reader?>" class="reader-record-link">阅读记录</a>
		    	<?php if($nextpage_url != ''): ?>
                <a href="<?=$nextpage_url?>" rel="next" id="next_url">下一页</a>
            <?php else: ?>
                <?php if($next_cid == 0): ?><span rel="next" class="gray">没有了</span><?php else: ?><a href="<?=$next_url ?>" rel="next" id="next_url">下一章</a><?php endif ?>
            <?php endif ?>
		    </div>
		    
		    <div id="content_3"></div>
		    <div class="clear"></div>
	    </div>
	</div>

    <div class="rank mt0 mb0">
        <h4>人气小说推荐<?php if($reader_rank_url !== ""): ?><a class="pull-right" href="<?=$reader_rank_url?>">More+</a><?php else: ?><span class="pull-right">More+</span><?php endif; ?></h4>
        <div class="content">
            <?php foreach($postdate as $k => $v): ?><?php if($k < 3):?>
            <dl>
                <a href="<?=$v['info_url'] ?>" class="cover" title="<?=$v['articlename'] ?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename'] ?>" loading="lazy"></a>
                <dt><a href="<?=$v['info_url'] ?>" title="<?=$v['articlename'] ?>"><?=$v['articlename'] ?></a></dt>
                <dd><?=$v['intro_des']?></dd>
                <dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a></dd>
            </dl>
            <?php endif; endforeach ?>
        </div>
        <div class="clear"></div>
    </div>

    <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>

    <script src="/static/<?=$theme_dir?>/readpage.js"></script>
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

        lastread.set('<?=$info_url?>','<?=$uri?>','<?=$articlename?>','<?=$chaptername?>','<?=$author?>','<?=date("m-d")?>','<?=$img_url?>');
    </script>

    <div id="guide" class="guide">
        <div class="guide-content">
            <nav class="guide-nav">
                <a href="<?=$site_url?>" class="guide-nav-a">
                    <i class="icon icon-home"></i>
                    <span class="guide-nav-h">首页</span>
                </a>
                <a href="<?=$allbooks_url?>" class="guide-nav-a">
                    <i class="icon icon-sort"></i>
                    <span class="guide-nav-h">分类</span>
                </a>
                <?php if($reader_rank_url !== ""): ?><a href="<?=$reader_rank_url?>" class="guide-nav-a"><?php else: ?><a href="javascript:void(0)" class="guide-nav-a" aria-disabled="true"><?php endif; ?>
                    <i class="icon icon-rank"></i>
                    <span class="guide-nav-h">排行榜</span>
                </a>
                <a href="<?=$full_allbooks_url_safe?>" class="guide-nav-a">
                    <i class="icon icon-end"></i>
                    <span class="guide-nav-h">全本</span>
                </a>
                <?php if($reader_recentread_url !== ""): ?><a href="<?=$reader_recentread_url?>" class="guide-nav-a"><?php else: ?><a href="javascript:void(0)" class="guide-nav-a" aria-disabled="true"><?php endif; ?>
                    <i class="icon icon-free"></i>
                    <span class="guide-nav-h">记录</span>
                </a>
            </nav>
        </div>
    </div>

</body>
</html>