<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
$list_arr_safe = (!empty($list_arr) && is_array($list_arr)) ? $list_arr : [];
$htmltitle_safe = isset($htmltitle) ? (string)$htmltitle : '';
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$sort_url_raw = isset($sortid) ? (string)Sort::ss_sorturl($sortid) : '';
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$canonical_raw = function_exists('ss_abs_url') ? ss_abs_url(isset($uri) ? (string)$uri : ((isset($index_url) && $index_url) ? (string)$index_url : '')) : '';
$canonical_attr = htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8');
$sort_abs_url_raw = function_exists('ss_abs_url') ? ss_abs_url($sort_url_raw) : $sort_url_raw;
$sort_abs_url_attr = htmlspecialchars($sort_abs_url_raw, ENT_QUOTES, 'UTF-8');
$info_abs_url_raw = function_exists('ss_abs_url') ? ss_abs_url($info_url_raw) : $info_url_raw;
$info_abs_url_attr = htmlspecialchars($info_abs_url_raw, ENT_QUOTES, 'UTF-8');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($canonical_raw !== ''): ?><link rel="canonical" href="<?=$canonical_attr?>"><?php endif; ?>
<meta property="og:type" content="novel">
<meta property="og:title" content="<?=htmlspecialchars((string)$seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars((string)$seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($canonical_raw !== ''): ?><meta property="og:url" content="<?=$canonical_attr?>"><?php endif; ?>
<?php if ($info_abs_url_raw !== ''): ?><meta property="og:novel:url" content="<?=$info_abs_url_attr?>"><?php endif; ?>
<?php if ($sort_abs_url_raw !== ''): ?><meta property="og:novel:category_url" content="<?=$sort_abs_url_attr?>"><?php endif; ?>
<style>
.index-container{display:flex;justify-content:space-between;padding:10px;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<?php ss_render_page_top(['page_title' => '章节目录', 'page_back_url' => $info_url_raw, 'show_back' => true]); ?>
<div class="lb_mulu" id="alllist">
    <div class="lb_mulu">
        <ul class="last9">
            <li class="title"><a href="<?=$info_url_attr?>" class="back">返回《<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>》简介</a></li>
            <?php foreach($list_arr_safe as $k => $v): ?>
                <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="index-container"><?=$htmltitle_safe?></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
