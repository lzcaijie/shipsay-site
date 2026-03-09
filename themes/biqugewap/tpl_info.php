<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$info_url_raw = !empty($uri) ? (string)$uri : '';
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$sort_url_attr = htmlspecialchars((string)Sort::ss_sorturl($sortid), ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$last_url_attr = htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8');
$lastchapter_html = htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8');
$lastupdate_cn_html = htmlspecialchars((string)$lastupdate_cn, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8');
$index_url_attr = htmlspecialchars((string)$index_url, ENT_QUOTES, 'UTF-8');
$recentread_url_info = !empty($recentread_url_attr) ? $recentread_url_attr : (!empty($fake_recentread) ? htmlspecialchars((string)$fake_recentread, ENT_QUOTES, 'UTF-8') : 'javascript:history.go(-1)');
$rank_entry_url_info = !empty($rank_entry_url) ? htmlspecialchars((string)$rank_entry_url, ENT_QUOTES, 'UTF-8') : (!empty($fake_top) ? htmlspecialchars((string)$fake_top, ENT_QUOTES, 'UTF-8') : 'javascript:history.go(-1)');
$allbooks_url_info = !empty($allbooks_url) ? htmlspecialchars((string)$allbooks_url, ENT_QUOTES, 'UTF-8') : $site_home_url_attr;
$full_allbooks_url_info = !empty($full_allbooks_url) ? htmlspecialchars((string)$full_allbooks_url, ENT_QUOTES, 'UTF-8') : $allbooks_url_info;
$intro_html = !empty($intro) ? (string)$intro : (!empty($intro_des) ? '<p>' . nl2br(htmlspecialchars((string)$intro_des, ENT_QUOTES, 'UTF-8')) . '</p>' : '<p>暂无简介</p>');
$langtail_rows = !empty($langtailrows) && is_array($langtailrows) ? array_slice($langtailrows, 0, 12) : [];
$postdate_rows = !empty($postdate) && is_array($postdate) ? $postdate : [];
$preview_rows = [];
if (!empty($preview_chapters) && is_array($preview_chapters)) {
    $preview_rows = array_slice($preview_chapters, 0, 50);
} elseif (!empty($chapterrows) && is_array($chapterrows)) {
    $preview_rows = array_slice($chapterrows, 0, 50);
} elseif (!empty($lastchapter_arr) && is_array($lastchapter_arr)) {
    $preview_rows = array_slice($lastchapter_arr, 0, 50);
}
$preview_end = min(max((int)$chapters, 0), 50);
$preview_title = $preview_end > 0 ? '1-' . $preview_end . '章' : '章节预览';
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
                <li><a href="<?=$index_url_attr?>">章节目录</a></li>
                <li><a href="<?=$recentread_url_info?>">阅读记录</a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
    <div class="bookintro"><div class="bookintro-content"><?=$intro_html?></div></div>
    <?php if (!empty($langtail_rows)): ?>
    <div class="booktail">
        <h2>百度长尾词推荐</h2>
        <div class="booktail-links">
            <?php foreach($langtail_rows as $v): ?>
            <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>" title="<?=htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8')?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="bookchapter">
        <h2><?=$preview_title?><span class="pull-right">共<?=htmlspecialchars((string)$chapters, ENT_QUOTES, 'UTF-8')?>章</span></h2>
        <ul>
            <?php if (!empty($preview_rows)): ?>
            <?php foreach($preview_rows as $v): ?>
            <?php $cid_url_attr = htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8'); $cname_html = htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8'); ?>
            <li><a href="<?=$cid_url_attr?>" title="<?=$cname_html?>" rel="chapter"><?=$cname_html?></a></li>
            <?php endforeach; ?>
            <?php else: ?>
            <li>暂无章节内容</li>
            <?php endif; ?>
        </ul>
        <a href="<?=$index_url_attr?>" class="bookchaptermore">全部章节目录</a>
        <div class="clear"></div>
    </div>
    <div class="rank mt0 mb0">
        <h4>人气小说推荐<a class="pull-right" href="<?=$rank_entry_url_info?>">More+</a></h4>
        <div class="content">
            <?php if (!empty($postdate_rows)): foreach($postdate_rows as $k => $v): ?><?php if($k < 5):?>
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
                <a href="<?=$allbooks_url_info?>" class="guide-nav-a">
                    <i class="icon icon-sort"></i>
                    <span class="guide-nav-h">分类</span>
                </a>
                <a href="<?=$rank_entry_url_info?>" class="guide-nav-a">
                    <i class="icon icon-rank"></i>
                    <span class="guide-nav-h">排行榜</span>
                </a>
                <a href="<?=$full_allbooks_url_info?>" class="guide-nav-a">
                    <i class="icon icon-end"></i>
                    <span class="guide-nav-h">全本</span>
                </a>
                <a href="<?=$recentread_url_info?>" class="guide-nav-a">
                    <i class="icon icon-free"></i>
                    <span class="guide-nav-h">记录</span>
                </a>
            </nav>
        </div>
    </div>
</body>
</html>
