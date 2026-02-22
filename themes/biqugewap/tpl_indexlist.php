<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
// 分页信息计算（仅用于SEO）
$chaptersPerPage = 50;
$currentPage = isset($pid) ? $pid : 1;
$totalPages = ceil($chapters / $chaptersPerPage);

function getChapterPageUrl($articleid, $page = 1) {
    $page = (int)$page;
    if ($page < 1) $page = 1;

    // 优先走 CMS 的 Url::index_url（避免写死 /index/ 破坏后台路由/伪静态配置）
    if (class_exists('Url') && method_exists('Url', 'index_url')) {
        return Url::index_url($articleid, $page);
    }

    // 兜底（保持旧结构）
    if ($page == 1) {
        return "/index/{$articleid}/";
    }
    return "/index/{$articleid}/{$page}/";
}

$pageTitle = ($currentPage > 1) ? 
    "《{$articlename}》章节目录第{$currentPage}页_{$articlename}最新章节_{$author}作品_{$sortname}最新章节列表_{$articlename}小说目录_{$articlename}小说免费阅读_".SITE_NAME : 
    "《{$articlename}》章节目录_{$articlename}最新章节_{$author}作品_{$sortname}最新章节列表_{$articlename}小说目录_{$articlename}小说免费阅读_".SITE_NAME;

$description = "《{$articlename}》章节目录第{$currentPage}页，作者：{$author}，总章节：{$chapters}章。".SITE_NAME."提供{$articlename}最新章节,{$articlename}最新章节列表,{$articlename}小说目录免费阅读";
$keywords = "{$articlename}章节目录,{$articlename}最新章节,{$author},{$articlename}免费阅读,{$articlename}小说目录,{$articlename}最新章节列表";
?>
<title><?=$pageTitle?></title>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" />

<link href="<?=$site_url?><?=getChapterPageUrl($articleid, $currentPage)?>" rel="canonical">
<?php if ($currentPage > 1): ?>
<link rel="prev" href="<?=$site_url?><?=getChapterPageUrl($articleid, $currentPage-1)?>" />
<?php endif; ?>

<?php if ($currentPage < $totalPages): ?>
<link rel="next" href="<?=$site_url?><?=getChapterPageUrl($articleid, $currentPage+1)?>" />
<?php endif; ?>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<meta name="format-detection" content="telephone=no" /> 
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
<meta name="applicable-device" content="mobile">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/book.css">

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="<?=$info_url?>"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center"><?=$articlename?></div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed">	<div class="book">
		<div class="bookchapter">
    	    <h2>章节目录<span class="pull-right">共<?=$chapters?>章</span></h2>
    	    <div class="listpage"><?=$htmltitle?></div>
    	    <div id="content_1"></div>
    	    <ul class="mt0">
    	        <?php foreach($list_arr as $v): ?>
                    <li><a href="<?=$v['cid_url']?>" title="<?=$v['cname']?>" rel="chapter"><?=$v['cname']?></a></li>
                    <?php endforeach ?>

        	    </ul>
    	    <div id="content_2"></div>
    	    <div class="listpage"><?=$htmltitle?></div>
    	    <div id="content_3"></div>
    		<div class="clear"></div>
    	</div>
    </div>
	<div class="rank mt0 mb0">
		<h4>人气小说推荐<a class="pull-right" href="<?=$fake_top?>">More+</a></h4>
		<div class="content">
		    <?php foreach($postdate as $k => $v): ?><?php if($k < 5):?>
			<dl>
				<a href="<?=$v['info_url'] ?>" class="cover" title="<?=$v['articlename'] ?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename'] ?>"></a>
				<dt><a href="<?=$v['info_url'] ?>" title="<?=$v['articlename'] ?>"><?=$v['articlename'] ?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a></dd>
			</dl>
			 <?php endif; endforeach ?>
		</div>
		<div class="clear"></div>
	</div>
	<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
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
        <a href="<?=$fake_top?>" class="guide-nav-a">
            <i class="icon icon-rank"></i>
            <span class="guide-nav-h">排行榜</span>
        </a>
        <a href="<?=$full_allbooks_url?>" class="guide-nav-a">
            <i class="icon icon-end"></i>
            <span class="guide-nav-h">全本</span>
        </a>
        <a href="<?=$fake_recentread?>" class="guide-nav-a">
            <i class="icon icon-free"></i>
            <span class="guide-nav-h">记录</span>
        </a>
    </nav>
            <div class="guide-footer">
                <a href="/bookcase/"><svg id="icon-person" viewBox="0 0 16 16"><g><path d="M12 5a4 4 0 1 0-8 0 4 4 0 0 0 8 0zM3 5a5 5 0 1 1 10 0A5 5 0 0 1 3 5z"></path><path d="M8 9c-4.397 0-8 2.883-8 6.5a.5.5 0 1 0 1 0C1 12.49 4.113 10 8 10s7 2.49 7 5.5a.5.5 0 1 0 1 0C16 11.883 12.397 9 8 9z"></path></g></svg>会员书架</a>
            </div>
        </div>
    </div>

</body>
</html>