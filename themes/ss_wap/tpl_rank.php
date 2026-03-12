<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
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
$current_query = isset($query) && $query ? (string)$query : 'allvisit';
$current_title = isset($title_arr[$current_query]) ? $title_arr[$current_query] : '排行榜';
$recentread_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$rank_detail_base_raw = !empty($rank_detail_base) ? rtrim((string)$rank_detail_base, '/') . '/' : '';
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) $seo_title = $current_title . '_' . SITE_NAME;
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) $seo_keywords = $current_title . ',排行榜,' . SITE_NAME;
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) $seo_description = SITE_NAME . $current_title . '页面。';
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<style>
.rank-tabs{display:flex;gap:8px;overflow-x:auto;padding:8px 8px 0;background:#fff;white-space:nowrap;-webkit-overflow-scrolling:touch;}
.rank-tabs a{display:inline-block;padding:6px 10px;border:1px solid #65bbec;border-radius:14px;color:#007BB1;background:#fff;}
.rank-tabs a.active{background:#65bbec;color:#fff;}
.list-item{border-bottom:1px dashed #D4D4D4;padding:5px;width:100%;}.list-item .article{height:100px;overflow:hidden;line-height:20px;}.list-item .fs12{font-size:12px;}.list-item .gray{color:#7d7d7d;}.list-item .mr15{margin-right:15px;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php';?>
</head>
<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow" class="bookcase">阅读记录</a><?php endif; ?>
    <h1><?=htmlspecialchars($current_title, ENT_QUOTES, 'UTF-8')?></h1>
</div>
<div class="rank-tabs">
<?php foreach ($title_arr as $key => $label): ?>
    <?php if ($rank_detail_base_raw !== ''): ?><a href="<?=htmlspecialchars($rank_detail_base_raw . $key . '/', ENT_QUOTES, 'UTF-8')?>" class="<?=$current_query === $key ? 'active' : ''?>"><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?></a><?php endif; ?>
<?php endforeach; ?>
</div>
<?php if (!empty($articlerows) && is_array($articlerows)): foreach ($articlerows as $k => $v): if ($k >= 30) break; ?>
<table class="list-item"><tr>
    <td width="80"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><img src="<?=htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8')?>" width="80" height="100" alt="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>"/></a></td>
    <td><div class="article">
        <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><strong><?=($k+1)?>.</strong> <?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a>
        <br/><p class="fs12 gray"><span class="mr15">作者:<?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></span><?php if (!empty($v['sortname_2'])): ?>分类:<?=htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8')?><?php endif; ?></p>
        <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><span class="fs12 gray"><?=htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8')?></span></a>
    </div></td>
</tr></table>
<?php endforeach; else: ?>
<div style="padding:12px;color:#999;">暂无榜单数据</div>
<?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
