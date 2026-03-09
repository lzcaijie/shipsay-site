<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) $seo_title = '排行榜_' . SITE_NAME;
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) $seo_keywords = '排行榜,热门小说,' . SITE_NAME;
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) $seo_description = SITE_NAME . '小说排行榜聚合页。';
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$rank_entry_url_raw = isset($rank_entry_url) && $rank_entry_url ? rtrim((string)$rank_entry_url, '/') . '/' : ((isset($fake_top) && $fake_top) ? rtrim((string)$fake_top, '/') . '/' : '');
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$rank_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '排行榜', 'item' => $rank_entry_url_raw !== '' ? $rank_entry_url_raw : $site_home_url_raw],
    ],
];
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=$h($seo_title)?></title>
<meta name="keywords" content="<?=$h($seo_keywords)?>">
<meta name="description" content="<?=$h($seo_description)?>">
<?php if ($rank_entry_url_raw !== ''): ?>
<meta name="mobile-agent" content="format=html5;url=<?=$h($rank_entry_url_raw)?>">
<link rel="canonical" href="<?=$h($rank_entry_url_raw)?>">
<meta property="og:url" content="<?=$h($rank_entry_url_raw)?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$h($seo_title)?>">
<meta property="og:description" content="<?=$h($seo_description)?>">
<script type="application/ld+json"><?=json_encode($rank_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container top-rank-page">
    <div class="border3-2 mt8">
        <div class="info-title">
            <a href="<?=$h($site_home_url_raw)?>">首页</a> &gt; 排行榜
        </div>
        <div class="info-chapters-title"><strong>小说排行榜</strong></div>
        <?php if (!empty($rank_sections)): ?>
        <div class="info-commend top-rank-links">
            <?php foreach ($rank_sections as $conf): ?>
                <?php
                $more_raw = isset($conf['more']) ? (string)$conf['more'] : '';
                $title_html = $h(isset($conf['title']) ? $conf['title'] : '');
                ?>
                <?php if ($more_raw !== ''): ?>
                    <a href="<?=$h($more_raw)?>"><?=$title_html?></a>
                <?php else: ?>
                    <span><?=$title_html?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php if (!empty($rank_sections)): ?>
    <?php $section_keys = array_keys($rank_sections); ?>
    <?php for ($i = 0; $i < count($section_keys); $i += 2): ?>
    <div class="container flex flex-wrap section-bottom mb20 top-rank-row">
        <?php for ($j = $i; $j < min($i + 2, count($section_keys)); $j++): ?>
            <?php
            $key = $section_keys[$j];
            $conf = $rank_sections[$key];
            $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
            $more_raw = isset($conf['more']) ? (string)$conf['more'] : '';
            ?>
            <div class="border3-1 popular top-rank-card">
                <div class="popular-head">
                    <p><?=$h(isset($conf['title']) ? $conf['title'] : '')?></p>
                    <?php if ($more_raw !== ''): ?>
                        <a class="popular-more" href="<?=$h($more_raw)?>">更多</a>
                    <?php else: ?>
                        <span class="popular-more is-disabled">更多</span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($list)): ?>
                    <?php foreach (array_slice($list, 0, $rank_limit) as $idx => $v): ?>
                    <div class="list-out">
                        <span>[<?=($idx + 1)?>] <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a></span>
                        <span class="gray"><?=$h(isset($v['author']) ? $v['author'] : '')?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="biquge-page-empty top-rank-empty">暂无数据</div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
    <?php endfor; ?>
<?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
