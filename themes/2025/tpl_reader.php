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

$cateurl=$_SERVER['SERVER_PORT']==443?'https://':'http://';
$cateurl.=$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
?>
<?php require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<title><?=$pageTitle?></title>
<meta name="keywords" content="<?=$articlename?>,<?=$chaptername?>,<?=$articlename?>最新章节,<?=$author?>" />
<meta name="description" content="<?=$pageDescription?>" />
<link rel="canonical" href="<?=$site_url?><?=$uri?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="MobileOptimized" content="320">
<meta name="mobile-web-app-capable" content="yes">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">

<meta property="og:type" content="novel">
<meta property="og:title" content="<?=$pageTitle?>">
<meta property="og:description" content="《<?=$articlename?>》<?=$chaptername?>：<?=$reader_des?>">
<meta property="og:novel:category" content="<?=$sortname?>小说">
<meta property="og:novel:author" content="<?=$author?>">
<meta property="og:novel:book_name" content="<?=$articlename?>">
<meta property="og:novel:index_url" content="<?=$info_url?>">
<meta property="og:novel:info_url" content="<?=$info_url?>">
<meta property="og:novel:status" content="<?=$isfull?>">
<meta property="og:novel:chapter_name" content="<?=$chaptername?>">
<meta property="og:novel:chapter_url" content="<?=$uri?>">

<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20221207" />
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
<div class="header-common hidden-xs">
<div class="container">
<div class="header-common-left"><a href="/" title="<?=SITE_NAME?>" class="logo"><?=SITE_NAME?></a></div>
<div class="header-common-right">
<div class="header-common-search">
<form name="articlesearch" method="get" action="/search/">
<input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" placeholder="搜索从这里开始..." autocomplete="off" required>
<button type="submit" name="submit"><svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3340"><path d="M902.4 889.6l-156.8-156.8c156.8-147.2 166.4-393.6 22.4-553.6S371.2 12.8 211.2 160C51.2 307.2 44.8 553.6 192 713.6c131.2 140.8 342.4 166.4 502.4 60.8l160 163.2c12.8 12.8 32 12.8 44.8 0 12.8-12.8 16-35.2 3.2-48z m-755.2-448c0-182.4 147.2-329.6 329.6-329.6 182.4 0 329.6 147.2 329.6 329.6 0 182.4-147.2 329.6-329.6 329.6C294.4 774.4 147.2 624 147.2 441.6z" p-id="3341"></path></svg></button>
</form>
</div>
</div>
</div>
<div class="cf"></div>
</div>
<div class="header-common-nav hidden-xs">
<div class="container">
<a class="active" href="/" title="<?=SITE_NAME?>">首页</a>
<a href="<?=$allbooks_url?>" title="书库">书库</a>
<a href="/quanben<?=$allbooks_url?>" title="全本">全本</a>
<a href="/search/">搜索</a>
<a href="<?=$fake_recentread?>">轨迹</a>
</div>
<div class="cf"></div>
</div>
<div class="container visible-xs">
<div class="header-m">
<a class="header-m-left" href="javascript:window.history.go(-1);"><svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2585"><path d="M358.997 512l311.168-311.168a42.667 42.667 0 1 0-60.33-60.33L268.5 481.834a42.667 42.667 0 0 0 0 60.33L609.835 883.5a42.667 42.667 0 0 0 60.33-60.331L358.997 512z" p-id="2586"></path></svg></a>
<div class="header-m-center"><?=$articlename?></div>
<a class="header-m-right" href="/"><svg class="icon" viewBox="0 0 1025 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2094"><path d="M938.977859 1024c-100.292785 0-198.718416 0-298.210992 0 0-113.362855 0-226.458974 0-340.355301-85.889034 0-170.17765 0-255.799948 0 0 112.829383 0 225.658765 0 339.821829-100.292785 0-199.251889 0-299.277937 0 0-4.534514 0-8.802292 0-13.07007 0-176.579318 0-352.891899 0.266736-529.471216 0-5.868195 3.46757-13.870279 8.002084-17.604585 138.436051-111.228966 277.138838-222.191196 416.108362-333.153425 0.533472-0.533472 1.600417-0.800208 3.200834-1.333681 45.345142 36.276114 91.223756 72.818963 136.835634 109.361813 91.490492 73.352436 182.980985 146.704871 275.004949 219.523834 10.402709 8.26882 14.403751 16.53764 14.403751 29.874446-0.533472 173.911956-0.266736 347.557176-0.266736 521.469133C938.977859 1013.864027 938.977859 1018.932014 938.977859 1024zM85.422245 85.889034c57.348268 0 113.096119 0 169.910914 0 0 38.410003 0 76.820005 0 119.497786 87.222714-69.61813 171.511331-137.10237 256.866892-205.386819 22.939307 18.404793 46.14535 36.809586 69.351394 55.214379 144.570982 115.76348 289.141964 231.52696 433.979682 347.023704 6.668403 5.334723 9.602501 10.135973 9.335765 18.671529-0.800208 13.603543-0.266736 27.207085-0.266736 44.011461C852.288617 327.285231 682.644439 191.516541 512.200052 55.214379 342.022402 191.516541 172.111487 327.285231 0.066684 464.921073c0-19.205001-0.266736-35.475905 0.266736-51.480073 0-3.200834 3.734306-6.668403 6.401667-9.069028 22.672571-18.404793 45.611878-36.809586 68.817921-54.680906 7.468612-5.868195 10.135973-12.003126 9.869237-21.33889C85.422245 252.599114 85.422245 177.11279 85.422245 101.626465 85.422245 96.825215 85.422245 92.023965 85.422245 85.889034z" p-id="2095"></path></svg></a>
</div>
</div>
<div class="container autoheight">
<ol class="navigator">
<li><a href="/"><?=SITE_NAME?></a></li>
<li><a href="<?=$infoarr['0']['sort_url']?>"><?=$sortname?></a></li>
<li><a href="<?=$info_url?>"><?=$articlename?></a></li>
<li class="active"><?=$chaptername?></li>
</ol>

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

<div class="book read">
<span id="readSet"></span>
<h1>
    <?=$chaptername?>
    <?php if ($max_pid > 1): ?>
    <span style="font-size: 14px; color: #666; margin-left: 10px;">
        （第<?=$now_pid?>页/共<?=$max_pid?>页）
    </span>
    <?php endif; ?>
</h1>
<div class="read-page">
            <?php if($prevpage_url != ''): ?>
                <a id="linkPrev" href="<?=$prevpage_url?>"><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 上一页</a>
            <?php else: ?>
                <?php if($pre_cid == 0): ?><a id="linkPrev" href="#" title=""><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 无上章</a><?php else: ?><a id="linkPrev" href="<?=$pre_url?>"><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 上一章</a><?php endif ?>
            <?php endif ?>  
<a id="linkIndex" href="<?=$info_url?>" disable="disabled"><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> 目 录</a>
<a href="javascript:addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>');" class="addbookcase_r">加书签</a>
<?php if($nextpage_url != ''): ?>
                <a id="linkNext" href="<?=$nextpage_url?>">下一页 <i class="glyphicon glyphicon-forward" aria-hidden="true"></i></a>
            <?php else: ?>
                <?php if($next_cid == 0): ?><a rel="next" href="#" title="">无下章</a><?php else: ?><a id="linkNext" href="<?=$next_url?>">下一章 <i class="glyphicon glyphicon-forward" aria-hidden="true"></i></a><?php endif ?>
            <?php endif ?>
</div>


<div class="read-content" id="chaptercontent">
 <article id="article" class="content">   
<p>天才一秒记住【<?=SITE_NAME?>】地址：<?=$site_url?><p>
    <?php if ($isSearchEngine || !Ss::use_js()): ?>
        <?php echo $rico_content; ?>
    <?php else: ?>
        <div class="loading-text">正在加载章节内容...</div>
    <?php endif; ?>
</p> </div>

    <div class="read-page">
            <?php if($prevpage_url != ''): ?>
                <a id="linkPrev" href="<?=$prevpage_url?>"><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 上一页</a>
            <?php else: ?>
                <?php if($pre_cid == 0): ?><a id="linkPrev" href="#" title=""><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 无上章</a><?php else: ?><a id="linkPrev" href="<?=$pre_url?>"><i class="glyphicon glyphicon-backward" aria-hidden="true"></i> 上一章</a><?php endif ?>
            <?php endif ?>  
<a id="linkIndex" href="<?=$info_url?>" disable="disabled"><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> 目 录</a>
<a href="javascript:addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>');" class="addbookcase_r">加书签</a>
<?php if($nextpage_url != ''): ?>
                <a id="linkNext" href="<?=$nextpage_url?>">下一页 <i class="glyphicon glyphicon-forward" aria-hidden="true"></i></a>
            <?php else: ?>
                <?php if($next_cid == 0): ?><a rel="next" href="#" title="">无下章</a><?php else: ?><a id="linkNext" href="<?=$next_url?>">下一章 <i class="glyphicon glyphicon-forward" aria-hidden="true"></i></a><?php endif ?>
            <?php endif ?>
</div>

<div class="cf"></div>
</div>
<div class="list-index-2">
<div class="title"><h2>相关小说</h2></div>
<?php foreach($neighbor as $k => $v): ?><?php if($k < 3):?>
<div class="item">
<div class="cover">
<a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" width="120" height="150" /></a>
<span><?=$v['sortname_2']?> /  <?=$v['isfull']?></span>
</div>
<dl>
<dt><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
<dd class="author"><?=$v['author']?></dd>
<dd class="intro"><?=$v['intro_des']?></dd>
<dd class="more"><span><?=$v['words_w']?>万字</span><span><?=Text::ss_lastupdate($v['lastupdate'])?></span></dd>
</dl>
<div class="cf"></div>
</div>
<?php endif ?><?php endforeach ?>
</div>
<div class="cf"></div>
</div>
<div class="footer">
<div class="container">
<p class="hidden-xs">本站所有小说为转载作品，所有章节均由网友上传，转载至本站只是为了宣传本书让更多读者欣赏。</p>
<p class="visible-xs">本站小说由程序自动索引</p>
<p>Copyright &copy; 2023 <?=SITE_NAME?></p>
<p><a href="/sitemap/sm_sitemap.xml" title="神马 SiteMap" target="_blank">神马SiteMap</a> | <a href="/sitemap/sitemap.xml" title="XML SiteMap" target="_blank">SiteMap</a></p>
<div class="cf"></div>
</div>
</div>
<script src="/static/<?=$theme_dir?>/js/jquery.min.js?v=20221207"></script>
<script src="/static/<?=$theme_dir?>/js/2025.js?v=20221207"></script>
<script src="/static/<?=$theme_dir?>/js/readpage.js?v=20221207"></script>
<script src="/static/<?=$theme_dir?>/js/tempbookcase.js?v=20221207"></script>
<script src="/static/<?=$theme_dir?>/js/user.js?v=20221207" defer="defer"></script>
<script src="/static/<?=$theme_dir?>/layer/layer.js?v=20221207" defer="defer"></script>
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
	const lastvisit = "<?=date('m-d',$v['lastupdate'])?>";
	const imgurl = "<?=$img_url?>";
	lastread.set(articleid,uri,articlename,chaptername,author,lastvisit,imgurl);
	

</script>

</body>
</html>