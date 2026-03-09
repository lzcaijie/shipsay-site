<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$allbooks_url_raw = isset($allbooks_url) ? (string)$allbooks_url : '';
$allbooks_url_attr = htmlspecialchars($allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_raw = isset($full_allbooks_url) ? (string)$full_allbooks_url : '';
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_raw = isset($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$rank_entry_url_raw = !empty($rank_entry_url) ? rtrim((string)$rank_entry_url, '/') . '/' : (!empty($fake_top) ? rtrim((string)$fake_top, '/') . '/' : '');
$rank_entry_url_attr = htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8');
$rank_detail_base_raw = !empty($rank_detail_base) ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
$rank_detail_base_attr = htmlspecialchars($rank_detail_base_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = '小说排行榜_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = '小说排行榜,热门榜单,' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = SITE_NAME . '小说排行榜聚合页';
}
$top_sections_list = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$top_rank_lists_map = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$top_rank_limit_safe = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 5;
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>" />
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>" />
<?php require_once __THEME_DIR__ . '/tpl_header.php';?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="javascript:history.go(-1)"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center">小说排行榜</div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed">
    <?php if (!empty($top_sections_list)): ?>
        <?php foreach ($top_sections_list as $top_key => $conf): ?>
            <?php
            $section_title_html = htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8');
            $section_more_attr = htmlspecialchars((string)$conf['more'], ENT_QUOTES, 'UTF-8');
            $section_list = isset($top_rank_lists_map[$top_key]) && is_array($top_rank_lists_map[$top_key]) ? $top_rank_lists_map[$top_key] : [];
            $section_first = !empty($section_list) ? $section_list[0] : null;
            $section_rest = count($section_list) > 1 ? array_slice($section_list, 1, max(0, $top_rank_limit_safe - 1)) : [];
            ?>
        <div class="rank mt0">
            <h4><?=$section_title_html?><a class="pull-right" href="<?=$section_more_attr?>">More+</a></h4>
            <div class="content">
                <?php if (!empty($section_first)): ?>
                    <?php
                    $info_url_attr = htmlspecialchars((string)$section_first['info_url'], ENT_QUOTES, 'UTF-8');
                    $img_url_attr = htmlspecialchars((string)$section_first['img_url'], ENT_QUOTES, 'UTF-8');
                    $book_title_html = htmlspecialchars((string)$section_first['articlename'], ENT_QUOTES, 'UTF-8');
                    $intro_html = htmlspecialchars((string)$section_first['intro_des'], ENT_QUOTES, 'UTF-8');
                    $author_url_attr = htmlspecialchars((string)$section_first['author_url'], ENT_QUOTES, 'UTF-8');
                    $author_html = htmlspecialchars((string)$section_first['author'], ENT_QUOTES, 'UTF-8');
                    $isfull_html = htmlspecialchars((string)$section_first['isfull'], ENT_QUOTES, 'UTF-8');
                    $words_html = htmlspecialchars((string)$section_first['words_w'], ENT_QUOTES, 'UTF-8');
                    ?>
                    <dl>
                        <a href="<?=$info_url_attr?>" class="cover" title="<?=$book_title_html?>"><img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$img_url_attr?>" alt="<?=$book_title_html?>"></a>
                        <dt><span>1</span><a href="<?=$info_url_attr?>" title="<?=$book_title_html?>"><?=$book_title_html?></a></dt>
                        <dd><?=$intro_html?></dd>
                        <dd><a href="<?=$author_url_attr?>"><?=$author_html?></a><span><?=$isfull_html?></span><span><?=$words_html?>万字</span></dd>
                    </dl>
                <?php else: ?>
                    <dl><dd>暂无榜单数据</dd></dl>
                <?php endif; ?>
            </div>
            <?php if (!empty($section_rest)): ?>
            <ul class="list">
                <?php foreach ($section_rest as $i => $v): ?>
                    <?php
                    $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
                    $book_title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
                    $author_url_attr = htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8');
                    $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8');
                    ?>
                    <li><span><?=$i + 2?></span><a href="<?=$info_url_attr?>" title="<?=$book_title_html?>"><?=$book_title_html?></a><a href="<?=$author_url_attr?>"><?=$author_html?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <div class="clear"></div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="rank mt0"><h4>小说排行榜</h4><div class="content"><dl><dd>暂无榜单数据</dd></dl></div><div class="clear"></div></div>
    <?php endif; ?>
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
