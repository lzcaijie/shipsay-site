<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($top_title,$top_keywords,$top_description) = ss_seo_render('top');
if (trim($top_title) === '' || trim($top_title) === SITE_NAME) {
    $top_title = '排行榜_' . SITE_NAME;
}
if (trim($top_keywords) === '' || trim($top_keywords) === SITE_NAME) {
    $top_keywords = '排行榜,周榜,月榜,总榜,推荐榜,收藏榜,' . SITE_NAME;
}
if (trim($top_description) === '' || trim($top_description) === SITE_NAME) {
    $top_description = SITE_NAME . '小说排行榜聚合页，查看周榜、月榜、总榜、推荐榜、收藏榜。';
}
$rank_entry_url = isset($rank_entry_url) && $rank_entry_url ? $rank_entry_url : ((isset($fake_top) && $fake_top) ? $fake_top : '/rank/');
$rank_detail_base = isset($rank_detail_base) && $rank_detail_base ? $rank_detail_base : $rank_entry_url;
$top_url_safe = (isset($uri) && $uri) ? $uri : ((!empty($site_url) ? rtrim($site_url, '/') : '') . rtrim($rank_entry_url, '/') . '/');
$rank_sections = [
    'weekvisit'  => ['title' => '周榜',   'field' => 'weekvisit',  'more' => $rank_detail_base . 'weekvisit/'],
    'monthvisit' => ['title' => '月榜',   'field' => 'monthvisit', 'more' => $rank_detail_base . 'monthvisit/'],
    'allvisit'   => ['title' => '总榜',   'field' => 'allvisit',   'more' => $rank_detail_base . 'allvisit/'],
    'allvote'    => ['title' => '推荐榜', 'field' => 'allvote',    'more' => $rank_detail_base . 'allvote/'],
    'goodnum'    => ['title' => '收藏榜', 'field' => 'goodnum',    'more' => $rank_detail_base . 'goodnum/'],
];
$rank_lists = [];
$rank_limit = isset($category_per_page) && (int)$category_per_page > 0 ? (int)$category_per_page : 10;
foreach ($rank_sections as $key => $conf) {
    $rank_lists[$key] = [];
    $field = preg_replace('/[^a-z0-9_]/i', '', $conf['field']);
    if ($field === '' || !isset($rico_sql)) continue;
    $sql = $rico_sql . 'ORDER BY ' . $field . ' DESC LIMIT ' . $rank_limit;
    if (isset($redis)) {
        $rank_lists[$key] = $redis->ss_redis_getrows($sql, isset($home_cache_time) ? $home_cache_time : 300);
    } elseif (isset($db)) {
        $rank_lists[$key] = $db->ss_getrows($sql);
    }
    if (!is_array($rank_lists[$key])) $rank_lists[$key] = [];
}
$top_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => !empty($site_url) ? $site_url : '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '排行榜', 'item' => $top_url_safe],
    ],
];
?>
<title><?=htmlspecialchars($top_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($top_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($top_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$top_url_safe?>">
<link rel="canonical" href="<?=$top_url_safe?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($top_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($top_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$top_url_safe?>">
<script type="application/ld+json"><?=json_encode($top_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="/">首页</a> &gt; <span>排行榜</span>
        </div>
        <div class="rank-page-head">
            <h1>排行榜</h1>
            <p>按榜单类型查看热门作品</p>
        </div>
        <div class="rank-tabs top-rank-tabs">
            <?php foreach ($rank_sections as $key => $conf): ?>
                <a href="<?=$conf['more']?>"><?=$conf['title']?></a>
            <?php endforeach; ?>
        </div>
        <div class="top-rank-grid">
            <?php foreach ($rank_sections as $key => $conf): ?>
                <?php $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : []; ?>
                <div class="top-card">
                    <div class="top-card-head">
                        <h2><?=$conf['title']?></h2>
                        <a href="<?=$conf['more']?>">更多</a>
                    </div>
                    <ol>
                        <?php if (!empty($list)): ?>
                            <?php foreach ($list as $k => $v): if ($k >= $rank_limit) break; ?>
                                <li>
                                    <span><?=($k + 1)?></span>
                                    <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
                                    <em><?=$v['author']?></em>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="rank-empty">暂无数据</li>
                        <?php endif; ?>
                    </ol>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
