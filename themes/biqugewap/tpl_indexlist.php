<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$per_indexlist_safe = 50;
if (isset($per_indexlist) && (int)$per_indexlist > 0) {
    $per_indexlist_safe = (int)$per_indexlist;
} elseif (isset($per_page) && (int)$per_page > 0) {
    $per_indexlist_safe = (int)$per_page;
}
$current_page = isset($pid) ? max(1, (int)$pid) : 1;
$total_pages = 1;
if (isset($chapters) && $per_indexlist_safe > 0) {
    $total_pages = max(1, (int)ceil((int)$chapters / $per_indexlist_safe));
} elseif ($current_page > 1) {
    $total_pages = $current_page;
}
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$allbooks_url_attr = !empty($allbooks_url) ? htmlspecialchars((string)$allbooks_url, ENT_QUOTES, 'UTF-8') : $site_home_url_attr;
$full_allbooks_url_attr = !empty($full_allbooks_url) ? htmlspecialchars((string)$full_allbooks_url, ENT_QUOTES, 'UTF-8') : $allbooks_url_attr;
$recentread_url_attr = !empty($fake_recentread) ? htmlspecialchars((string)$fake_recentread, ENT_QUOTES, 'UTF-8') : 'javascript:history.go(-1)';
$rank_entry_url_attr = !empty($rank_entry_url) ? htmlspecialchars((string)$rank_entry_url, ENT_QUOTES, 'UTF-8') : (!empty($fake_top) ? htmlspecialchars((string)$fake_top, ENT_QUOTES, 'UTF-8') : 'javascript:history.go(-1)');
$indexlist_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($index_url) && $index_url) ? (string)$index_url : '');
$indexlist_url_attr = htmlspecialchars($indexlist_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$chapters_html = htmlspecialchars((string)(int)$chapters, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$sort_url_attr = htmlspecialchars((string)Sort::ss_sorturl($sortid), ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$last_url_attr = htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8');
$lastchapter_html = htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8');
$lastupdate_cn_html = htmlspecialchars((string)$lastupdate_cn, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8');
$info_url_attr = htmlspecialchars((string)$info_url, ENT_QUOTES, 'UTF-8');
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = $articlename . '章节目录' . ($current_page > 1 ? '第' . $current_page . '页' : '') . '_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = $articlename . ',章节目录,' . $author . ',' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = '《' . $articlename . '》章节目录，共' . (int)$chapters . '章。';
}
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="<?=$info_url_attr?>"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center"><?=$article_title_html?></div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed"><div class="book">
	    <img src="<?=$img_url_attr?>" onerror="src='/static/<?=$theme_dir?>/nocover.jpg'" class="book-cover-blur" alt="<?=$article_title_html?>" aria-hidden="true">
	    <div class="book-info">
	        <div class="book-layout">
	            <img src="<?=$img_url_attr?>" onerror="src='/static/<?=$theme_dir?>/nocover.jpg'" class="book-cover" alt="<?=$article_title_html?>">
	            <div class="book-cell">
                    <h1 class="book-title"><?=$article_title_html?></h1>
                    <p class="book-meta">作者：<a href="<?=$author_url_attr?>" title="<?=$author_html?>"><?=$author_html?></a></p>
                    <p class="book-meta">分类：<a href="<?=$sort_url_attr?>" title="<?=$sortname_html?>"><?=$sortname_html?></a></p>
                    <p class="book-meta">人气：<?=htmlspecialchars((string)$allvisit, ENT_QUOTES, 'UTF-8')?></p>
                    <p class="book-meta"><?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?> | <?=htmlspecialchars((string)$words_w, ENT_QUOTES, 'UTF-8')?>万字</p>
                </div>
	        </div>
	        <div class="last"><?=$lastupdate_cn_html?>更新到：<a href="<?=$last_url_attr?>" title="<?=$lastchapter_html?>" rel="chapter"><?=$lastchapter_html?></a></div>
    	    <ul class="book-info-btn">
    	        <li><a href="<?=$first_url_attr?>">立即阅读</a></li>
    	        <li><a href="<?=$info_url_attr?>">返回详情</a></li>
    	        <li><a href="<?=$recentread_url_attr?>">阅读记录</a></li>
    	    </ul>
	    </div>
		<div class="clear"></div>
	</div>
	<div class="bookintro"><?=!empty($intro) ? $intro : $intro_des?></div>
	<div class="bookchapter">
    	    <h2>章节目录<span class="pull-right">共<?=$chapters_html?>章</span></h2>
            <?php if (!empty($htmltitle)): ?><div class="listpage"><?=$htmltitle?></div><?php endif; ?>
    	    <ul class="mt0">
    	        <?php if (!empty($list_arr) && is_array($list_arr)): ?>
                    <?php foreach($list_arr as $v): ?>
                    <?php if (isset($v['chaptertype']) && (int)$v['chaptertype'] === 1): ?>
                    <li><?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?></li>
                    <?php else: ?>
                    <li><a href="<?=htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8')?>" title="<?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?>" rel="chapter"><?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?></a></li>
                    <?php endif; ?>
                    <?php endforeach ?>
                <?php else: ?>
                    <li>暂无章节数据</li>
                <?php endif; ?>
        	</ul>
            <?php if (!empty($htmltitle)): ?><div class="listpage"><?=$htmltitle?></div><?php endif; ?>
            <div class="pages">当前第 <?=$current_page?> 页 / 共 <?=$total_pages?> 页，每页 <?=$per_indexlist_safe?> 章</div>
    		<div class="clear"></div>
    	</div>
	<div class="rank mt0 mb0">
		<h4>人气小说推荐<a class="pull-right" href="<?=$rank_entry_url_attr?>">More+</a></h4>
		<div class="content">
		    <?php if (!empty($postdate) && is_array($postdate)): foreach($postdate as $k => $v): ?><?php if($k < 5):?>
            <?php $book_info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $book_title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $book_intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8'); $book_author_url_attr = htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8'); $book_author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); $book_img_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8'); ?>
			<dl>
				<a href="<?=$book_info_url_attr?>" class="cover" title="<?=$book_title_html?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$book_img_attr?>" alt="<?=$book_title_html?>"></a>
				<dt><a href="<?=$book_info_url_attr?>" title="<?=$book_title_html?>"><?=$book_title_html?></a></dt>
				<dd><?=$book_intro_html?></dd>
				<dd><a href="<?=$book_author_url_attr?>"><?=$book_author_html?></a></dd>
			</dl>
			 <?php endif; endforeach; else: ?>
            <dl><dd>暂无推荐内容</dd></dl>
            <?php endif; ?>
		</div>
		<div class="clear"></div>
	</div>
	<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
    <div id="guide" class="guide">
        <div class="guide-content">
        <nav class="guide-nav">
        <a href="<?=$site_home_url_attr?>" class="guide-nav-a">
            <i class="icon icon-home"></i>
            <span class="guide-nav-h">首页</span>
        </a>
        <a href="<?=$allbooks_url_attr?>" class="guide-nav-a">
            <i class="icon icon-sort"></i>
            <span class="guide-nav-h">分类</span>
        </a>
        <a href="<?=$rank_entry_url_attr?>" class="guide-nav-a">
            <i class="icon icon-rank"></i>
            <span class="guide-nav-h">排行榜</span>
        </a>
        <a href="<?=$full_allbooks_url_attr?>" class="guide-nav-a">
            <i class="icon icon-end"></i>
            <span class="guide-nav-h">全本</span>
        </a>
        <a href="<?=$recentread_url_attr?>" class="guide-nav-a">
            <i class="icon icon-free"></i>
            <span class="guide-nav-h">记录</span>
        </a>
    </nav>
        </div>
    </div>

</body>
</html>
