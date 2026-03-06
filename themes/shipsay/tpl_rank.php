<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_base = (isset($rank_entry_url) && $rank_entry_url)
    ? rtrim($rank_entry_url, '/') . '/'
    : ((isset($fake_top) && $fake_top)
        ? rtrim($fake_top, '/') . '/'
        : ('/' . ((isset($fake_rankstr) && $fake_rankstr) ? trim($fake_rankstr, '/') : 'rank') . '/'));
$title_arr = [
    'allvisit' => '总点击榜',
    'monthvisit' => '月点击榜',
    'weekvisit' => '周点击榜',
    'dayvisit' => '日点击榜',
    'allvote' => '总推荐榜',
    'monthvote' => '月推荐榜',
    'weekvote' => '周推荐榜',
    'dayvote' => '日推荐榜',
    'goodnum' => '收藏榜',
];
$current_query = isset($query) && $query ? $query : 'allvisit';
$current_title = isset($title_arr[$current_query]) ? $title_arr[$current_query] : '排行榜';
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $current_title . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $current_title . ',' . SITE_NAME . ',排行榜,热门小说';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = $current_title . '榜单，尽在' . SITE_NAME . '。';
}
$rank_url_safe = (isset($uri) && $uri) ? $uri : $rank_base . $current_query . '/';
$current_title_html = htmlspecialchars($current_title, ENT_QUOTES, 'UTF-8');
$rank_url_attr = htmlspecialchars($rank_url_safe, ENT_QUOTES, 'UTF-8');
$rank_base_attr = htmlspecialchars($rank_base, ENT_QUOTES, 'UTF-8');
$rank_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => !empty($site_url) ? $site_url : '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '排行榜', 'item' => $rank_base],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $current_title, 'item' => $rank_url_safe],
    ],
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$rank_url_attr?>">
<link rel="canonical" href="<?=$rank_url_attr?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$rank_url_attr?>">
<script type="application/ld+json"><?=json_encode($rank_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="/">首页</a> &gt; <span><?=$current_title_html?></span>
        </div>
        <div class="rank-page-head">
            <h1><?=$current_title_html?></h1>
        </div>
        <div class="rank-tabs">
            <?php foreach ($title_arr as $key => $label): ?>
                <?php $rank_tab_url = htmlspecialchars($rank_base . $key . '/', ENT_QUOTES, 'UTF-8'); $label_html = htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                <a href="<?=$rank_tab_url?>" class="<?=$current_query === $key ? 'active' : ''?>"><?=$label_html?></a>
            <?php endforeach; ?>
        </div>
        <ol class="rank-page-list">
            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
                <?php foreach ($articlerows as $k => $v): ?>
                    <li>
                        <span class="rank-num"><?=($k + 1)?></span>
                        <div class="rank-main">
                            <?php $info_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8'); $bookname_html = htmlspecialchars($v['articlename'], ENT_QUOTES, 'UTF-8'); ?>
                            <a href="<?=$info_url_attr?>" class="rank-bookname"><?=$bookname_html?></a>
                            <div class="rank-meta">
                                <?php $author_url_attr = htmlspecialchars($v['author_url'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars($v['author'], ENT_QUOTES, 'UTF-8'); ?>
                                <a href="<?=$author_url_attr?>"><?=$author_html?></a>
                                <?php if (!empty($v['sortname_2'])): ?><em><?=htmlspecialchars($v['sortname_2'], ENT_QUOTES, 'UTF-8')?></em><?php endif; ?>
                                <em><?=$v['words_w']?>万字</em>
                                <em><?=Text::ss_lastupdate($v['lastupdate'])?></em>
                            </div>
                            <p><?=htmlspecialchars($v['intro_des'], ENT_QUOTES, 'UTF-8')?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="rank-empty">暂无排行榜数据</li>
            <?php endif; ?>
        </ol>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
