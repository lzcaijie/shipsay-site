<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$pageTitle = "《{$articlename}》最新章节免费阅读_<?=$articlename?>全文免费阅读_{$author}作品_{$sortname}最新章节列表_<?=$articlename?>小说目录_<?=SITE_NAME?>";
$description = "《{$articlename}》是{$author}创作的{$sortname}小说，总章节{$chapters}章，最新章节：{$lastchapter}，{$intro_des}。<?=SITE_NAME?>提供<?=$articlename?>最新章节全文免费阅读，<?=$articlename?>完整版全文免费在线阅读";
$keywords = "{$articlename},{$articlename}最新章节,{$articlename}免费阅读,{$articlename}全文阅读,{$author}小说,{$sortname}小说";
?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
$pageTitle = $seo_title;
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

<link href="<?=$site_url?><?=$uri?>" rel="canonical">
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

<?php require_once __THEME_DIR__ . '/tpl_header.php'; require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="javascript:history.go(-1)"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center"><?=$articlename?></div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed"><div class="book">
	    <img src="<?=$img_url?>" onerror="src='/static/<?=$theme_dir?>/nocover.jpg'" class="book-cover-blur" alt="<?=$articlename?>" aria-hidden="true">
	    <div class="book-info">
	        <div class="book-layout">
	            <img src="<?=$img_url?>" onerror="src='/static/<?=$theme_dir?>/nocover.jpg'" class="book-cover" alt="<?=$articlename?>">
	            <div class="book-cell">
                    <h1 class="book-title"><?=$articlename?></h1>
                    <p class="book-meta">作者：<a href="<?=$author_url?>" title="<?=$author?>"><?=$author?></a></p>
                    <p class="book-meta">分类：<a href="<?=Sort::ss_sorturl($sortid)?>" title="<?=$sortname?>"><?=$sortname?></a></p>
                    <p class="book-meta">人气：<?=$allvisit?></p>
                    <p class="book-meta"><?=$isfull?> | <?=$words_w?>万字</p>
                </div>
	        </div>
<?php $recentread_url_info = !empty($recentread_url_attr) ? $recentread_url_attr : (!empty($fake_recentread) ? $fake_recentread : 'javascript:history.go(-1)'); ?>
	        <div class="last"><?=$lastupdate_cn?>更新到：<a href="<?=$last_url?>" title="<?=$lastchapter?>" rel="chapter"><?=$lastchapter?></a></div>
    	    <ul class="book-info-btn">
    	        <li><a href="<?=$first_url?>">立即阅读</a></li>
    	        <li><a href="<?=$index_url?>">章节目录</a></li>
    	        <li><a href="<?=$recentread_url_info?>">阅读记录</a></li>
    	    </ul>
	    </div>
		<div class="clear"></div>
	</div>
	<div class="bookintro"><?=$intro_des?></div>
	<div class="bookchapter">
	    <h2>最新章节<span class="pull-right">共<?=$chapters?>章</span></h2>
	    <ul>
	        <?php if($lastarr != ''){ ?><?php foreach($lastarr as $k => $v){ ?>
            <li><a href="<?=$v['cid_url'] ?>" title="<?=$v['cname'] ?>" rel="chapter"><?=$v['cname'] ?></a></li>
             <?php }} ?>
	    </ul>
	    <a href="<?=$index_url?>" class="bookchaptermore">全部章节目录</a>
		<div class="clear"></div>
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
			 <?php endif;endforeach ?>
		</div>
		<div class="clear"></div>
	</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>

</body>
</html>