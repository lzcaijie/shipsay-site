<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
if (!function_exists('ss_e')) {
	function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
$__author = isset($author) ? $author : '';
?>

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
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
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20251207" />
</head>
<body>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container visible-xs">
<div class="header-m">
<a class="header-m-left" href="javascript:window.history.go(-1);"><svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2585"><path d="M358.997 512l311.168-311.168a42.667 42.667 0 1 0-60.33-60.33L268.5 481.834a42.667 42.667 0 0 0 0 60.33L609.835 883.5a42.667 42.667 0 0 0 60.33-60.331L358.997 512z" p-id="2586"></path></svg></a>
<div class="header-m-center"><?=ss_e($__author)?></div>
<a class="header-m-right" href="/"><svg class="icon" viewBox="0 0 1025 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2094"><path d="M938.977859 1024c-100.292785 0-198.718416 0-298.210992 0 0-113.362855 0-226.458974 0-340.355301-85.889034 0-170.17765 0-255.799948 0 0 112.829383 0 225.658765 0 339.821829-100.292785 0-199.251889 0-299.277937 0 0-4.534514 0-8.802292 0-13.07007 0-176.579318 0-352.891899 0.266736-529.471216 0-5.868195 3.46757-13.870279 8.002084-17.604585 138.436051-111.228966 277.138838-222.191196 416.108362-333.153425 0.533472-0.533472 1.600417-0.800208 3.200834-1.333681 45.345142 36.276114 91.223756 72.818963 136.835634 109.361813 91.490492 73.352436 182.980985 146.704871 275.004949 219.523834 10.402709 8.26882 14.403751 16.53764 14.403751 29.874446-0.533472 173.911956-0.266736 347.557176-0.266736 521.469133C938.977859 1013.864027 938.977859 1018.932014 938.977859 1024zM85.422245 85.889034c57.348268 0 113.096119 0 169.910914 0 0 38.410003 0 76.820005 0 119.497786 87.222714-69.61813 171.511331-137.10237 256.866892-205.386819 22.939307 18.404793 46.14535 36.809586 69.351394 55.214379 144.570982 115.76348 289.141964 231.52696 433.979682 347.023704 6.668403 5.334723 9.602501 10.135973 9.335765 18.671529-0.800208 13.603543-0.266736 27.207085-0.266736 44.011461C852.288617 327.285231 682.644439 191.516541 512.200052 55.214379 342.022402 191.516541 172.111487 327.285231 0.066684 464.921073c0-19.205001-0.266736-35.475905 0.266736-51.480073 0-3.200834 3.734306-6.668403 6.401667-9.069028 22.672571-18.404793 45.611878-36.809586 68.817921-54.680906 7.468612-5.868195 10.135973-12.003126 9.869237-21.33889C85.422245 252.599114 85.422245 177.11279 85.422245 101.626465 85.422245 96.825215 85.422245 92.023965 85.422245 85.889034z" p-id="2095"></path></svg></a>
</div>
</div>

<div class="container autoheight">
<ol class="navigator">
<li><a href="/"><?=SITE_NAME?></a></li>
<li>作者大全</li>
<li class="active"><?=ss_e($__author)?></li>
</ol>

<div class="list-author">
<div class="title"><h2><?=ss_e($__author)?> 作品简介</h2></div>
<div class="list-author-info">
<a href="<?=$uri?>"><?=ss_e($__author)?></a>是一名非常出色的小说作者，TA的作品包括：
<?php if(is_array($res)): ?><?php $__w=0; ?><?php foreach($res as $k => $v){ $__w++; if($__w>20) break; ?>《<a href="<?=$v['info_url']?>"><?=ss_e($v['articlename'])?></a>》<?php } ?><?php endif?>
等等，小说可谓是本本精品，字字珠玑。
<a href="<?=$uri?>"><?=ss_e($__author)?></a>所写的小说情节跌宕起伏、扣人心弦，情节与文笔俱佳。
<?=SITE_NAME?>强烈建议您到正版网站阅读<a href="<?=$uri?>"><?=ss_e($__author)?></a>的小说作品，您的每一次阅读都是对作者<a href="<?=$uri?>"><?=ss_e($__author)?></a>的认可！
如果您在<?=SITE_NAME?>阅读<a href="<?=$uri?>"><?=ss_e($__author)?></a>作品时，遇到问题，请及时反馈，我们将第一时间解决，争取为您奉上一场阅读盛宴！
</div>
<div class="cf"></div>
</div>

<div class="list-index-2">
<div class="title"><h2><?=ss_e($__author)?></h2><span>共有<?=$author_count?>部小说</span></div>
<?php if(is_array($res) && !empty($res)): ?><?php $__i=0; ?><?php foreach($res as $k => $v): $__i++; if($__i>50) break; ?>
<div class="item">
<div class="cover">
<a href="<?=$v['info_url']?>" title="<?=ss_e($v['articlename'])?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-src="<?=$v['img_url']?>" alt="<?=ss_e($v['articlename'])?>" width="120" height="150" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;" /></a>
<span><?=ss_e($v['sortname_2'])?> /  <?=ss_e($v['isfull'])?></span>
</div>
<dl>
<dt><a href="<?=$v['info_url']?>" title="<?=ss_e($v['articlename'])?>"><?=ss_e($v['articlename'])?></a></dt>
<dd class="author"><?=ss_e($v['author'])?></dd>
<dd class="intro"><?=ss_e($v['intro_des'])?></dd>
<dd class="more"><span><?=ss_e($v['words_w'])?>万字</span><span><?=Text::ss_lastupdate($v['lastupdate'])?></span></dd>
</dl>
<div class="cf"></div>
</div>
<?php endforeach ?><?php else: ?>
<div style="padding:20px;color:#888;">暂无该作者作品</div>
<?php endif?>
<div class="cf"></div>
</div>

<?php
$rand_authors = [];
if (isset($dbarr) && isset($db)) {
	$sql_rand = 'SELECT author, COUNT(*) AS bookcount FROM '.$dbarr['pre'].'article_article WHERE display <> 1 AND '.$dbarr['words'].' >= 0 AND author <> "" GROUP BY author ORDER BY RAND() LIMIT 15';
	if (isset($redis)) {
		$rand_authors = $redis->ss_redis_getrows($sql_rand,86400);
	} else {
		$rand_authors = $db->ss_getrows($sql_rand);
	}
}
?>
<?php if(is_array($rand_authors) && !empty($rand_authors)): ?>
<div class="list-author">
<div class="title"><h2><?=SITE_NAME?>推荐作者</h2></div>
<ul>
<?php foreach($rand_authors as $ra): ?>
	<?php $ra_name = isset($ra['author']) ? $ra['author'] : ''; ?>
	<?php if($ra_name=='') continue; ?>
	<li><a href="<?=Url::author_url($ra_name)?>" title="作者<?=ss_e($ra_name)?>（共<?=intval($ra['bookcount'])?>本）"><?=ss_e($ra_name)?></a></li>
<?php endforeach; ?>
</ul>
<div class="cf"></div>
</div>
<?php endif; ?>

</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
