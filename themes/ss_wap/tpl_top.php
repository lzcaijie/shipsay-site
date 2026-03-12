<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$recentread_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) $seo_title = '排行榜_' . SITE_NAME;
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) $seo_keywords = '排行榜,日榜,周榜,月榜,总榜,推荐榜,收藏榜,' . SITE_NAME;
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) $seo_description = SITE_NAME . '小说排行榜聚合页。';
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<style>
.rank-tabs{display:flex;gap:8px;overflow-x:auto;padding:10px;background:#fff;white-space:nowrap;-webkit-overflow-scrolling:touch;}
.rank-tabs a{display:inline-block;padding:6px 10px;border:1px solid #65bbec;border-radius:14px;color:#007BB1;background:#fff;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow" class="bookcase">阅读记录</a><?php endif; ?>
    <h1>排行榜</h1>
</div>
<?php if (!empty($rank_sections)): ?>
<div class="rank-tabs">
    <?php foreach ($rank_sections as $conf): ?>
        <a href="<?=htmlspecialchars((string)$conf['more'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8')?></a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php foreach ($rank_sections as $key => $conf): ?>
<?php $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : []; ?>
<div class="s_m">
    <div class="q_top c_big"><p class="c_big_border"><?=htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8')?></p><div class="more"><a href="<?=htmlspecialchars((string)$conf['more'], ENT_QUOTES, 'UTF-8')?>">更多</a></div></div>
    <div class="cc"></div>
    <?php if (!empty($list)): ?>
        <?php foreach (array_slice($list, 0, $rank_limit) as $i => $v): ?>
            <div class="s_list"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=($i+1)?>. <?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?> - <?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></a></div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="padding:10px;color:#999;">暂无数据</p>
    <?php endif; ?>
</div>
<?php endforeach; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
