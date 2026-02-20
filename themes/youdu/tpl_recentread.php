<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-Hans">
<head>
<title>阅读记录_<?=SITE_NAME?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="sogou_site_verification" content="wk6TjQ18le"/>
<meta name="applicable-device" content="pc,mobile">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="mobile-web-app-capable" content="yes">

<link rel="apple-touch-icon" href="/static/<?=$theme_dir?>/images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">

<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
<script>var userlogin = 0;</script>

<style>
#history img{object-fit:cover;}
.his-empty{padding:18px;color:#999;text-align:center;}
</style>
</head>

<body style="zoom: 1;">
<div class="page">

<?php require_once 'tpl_header.php'; ?>

<script>
$(function(){
	$(".user-menu3").addClass("_on");
});
</script>

<div class="g_sub_hd">
	<span class="_shadow">阅读记录</span>
	<div class="g_wrap pr">
		<h1>阅读记录</h1>
		<p class="_tab _slide">
			<a class="user-menu3 _on" href="javascript:;" title="阅读记录">阅读记录</a>
		</p>
	</div>
</div>

<div id="imgload">
	<div id="history">
		<ul class="g_row hom-books hom-gutter hon-continue"></ul>
	</div>
	<div id="hisEmpty" class="his-empty" style="display:none;">暂无阅读记录</div>
</div>

<!-- ✅ 注意：不再调用 history()，避免与 window.history 冲突 -->
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/history.js"></script>
<script type="text/javascript">
	// 渲染阅读记录（函数由 history.js 提供）
	if (typeof showbook === 'function') {
		showbook();
	} else if (typeof readHistory === 'function') {
		readHistory();
	}
	// 空态提示
	setTimeout(function(){
		var list = document.querySelector('#history ul');
		if(!list || !list.children || list.children.length === 0){
			document.getElementById('hisEmpty').style.display = 'block';
		}
	}, 80);
</script>

</div>

<div class="g_footer">
	<div class="g_row">
		<div class="g_col_9">
			<?php require_once 'tpl_footer.php'; ?>
		</div>
	</div>
</div>

<div class="g_goTop _on" style=""><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>tongji();</script>
</body>
</html>
