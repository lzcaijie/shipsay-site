<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>阅读记录 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php';?>
<?php
$full_allbooks_url_safe = !empty($full_allbooks_url)
    ? $full_allbooks_url
    : ('/quanben' . (isset($allbooks_url) ? $allbooks_url : '/sort/'));
?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="javascript:history.go(-1)"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center">阅读记录</div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed">	<div class="rank mt0 mb0 min-height">
		<h4>阅读记录<a href="javascript:removeall();" onclick="return confirm('确定要移除全部记录吗？')" class="pull-right">清空记录</a></h4>
		<div class="content" id="tempBookcase"></div>
		<div class="clear"></div>
	</div>
	<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>	
<script src="/static/<?=$theme_dir?>/tempbookcase.js"></script>
    <script>
        showtempbooks();
        $("#del_temp").on('click',function(){return false;});
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
        <a href="<?=!empty($rank_entry_url) ? $rank_entry_url : $fake_top?>" class="guide-nav-a">
            <i class="icon icon-rank"></i>
            <span class="guide-nav-h">排行榜</span>
        </a>
        <a href="<?=$full_allbooks_url_safe?>" class="guide-nav-a">
            <i class="icon icon-end"></i>
            <span class="guide-nav-h">全本</span>
        </a>
        <a href="<?=!empty($recentread_url_attr) ? $recentread_url_attr : $fake_recentread?>" class="guide-nav-a">
            <i class="icon icon-free"></i>
            <span class="guide-nav-h">记录</span>
        </a>
    </nav>
        </div>
    </div>

	</body>
</html>