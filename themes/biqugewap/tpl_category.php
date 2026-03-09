<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
$site_home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$allbooks_url_raw = isset($allbooks_url) ? (string)$allbooks_url : '';
$allbooks_url_attr = htmlspecialchars($allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_raw = isset($full_allbooks_url) ? (string)$full_allbooks_url : '';
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_raw = isset($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$rank_entry_url_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$rank_entry_url_attr = htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$category_title_html = $sortname_html !== '' ? $sortname_html : '小说书库';
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="javascript:history.go(-1)"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center"><?=$category_title_html?></div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed">
	    <div class="sort mt0">
            <h4>小说分类</h4>
            <ul>
            <li><a href="<?=$allbooks_url_attr?>"<?php if ((int)$sortid < 1): ?> class="active"<?php endif; ?>>全部小说</a></li>
            <?php if (!empty($sortcategory) && is_array($sortcategory)): ?>
            <?php foreach($sortcategory as $k => $v): ?>
                <?php $sorturl_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8'); $sortname_item_html = htmlspecialchars((string)$v['sortname'], ENT_QUOTES, 'UTF-8'); ?>
			<li><a href="<?=$sorturl_attr?>"<?php if ((string)$sortid === (string)$k): ?> class="active"<?php endif; ?>><?=$sortname_item_html?></a></li>
            <?php endforeach ?>
            <?php endif; ?>
            </ul>
            <div class="clear"></div>
        </div>
	<div class="rank">
		<h4><?=$category_title_html?></h4>
		<div class="content">
		    <?php if(!empty($retarr) && is_array($retarr)) { foreach($retarr as $k => $v){ ?>
                <?php
                $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
                $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8');
                $book_title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
                $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8');
                $isfull_html = htmlspecialchars((string)$v['isfull'], ENT_QUOTES, 'UTF-8');
                $words_html = htmlspecialchars((string)$v['words_w'], ENT_QUOTES, 'UTF-8');
                ?>
			<dl>
                <a href="<?=$info_url_attr?>" class="cover" title="<?=$book_title_html?>"><img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$img_url_attr?>" alt="<?=$book_title_html?>"></a>
				<dt><a href="<?=$info_url_attr?>" title="<?=$book_title_html?>"><?=$book_title_html?></a></dt>
				<dd><?=$intro_html?></dd>
				<dd><a href="<?=$author_url_attr?>"><?=$author_html?></a><span><?=$isfull_html?></span><span><?=$words_html?>万字</span></dd>
			</dl>
			<?php }} else { ?>
            <dl><dd>暂无相关内容</dd></dl>
            <?php } ?>
		</div>
		<div class="clear"></div>
		<div class="pages"><ul class="pagination" id="pagelink"><?php if (!empty($jump_html_wap)) { $jump_html_wap=str_replace('<a','<li><a',$jump_html_wap);$jump_html_wap=str_replace('</a>','</a></li>',$jump_html_wap);$jump_html_wap=str_replace('<strong>','<li class="active"><span>',$jump_html_wap);$jump_html_wap=str_replace('</strong>','</span></li>',$jump_html_wap);echo $jump_html_wap; } ?></ul></div>
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
