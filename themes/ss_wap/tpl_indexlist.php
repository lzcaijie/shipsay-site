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
$recentread_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<style>
.index-container{display:flex;justify-content:space-between;padding:10px;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow" class="bookcase">阅读记录</a><?php endif; ?>
    <h1>章节目录</h1>
</div>
<div class="lb_mulu" id="alllist">
    <div class="lb_mulu">
        <ul class="last9">
            <li class="title"><a href="<?=htmlspecialchars((string)$info_url, ENT_QUOTES, 'UTF-8')?>" class="back">返回《<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>》简介</a></li>
            <?php foreach($list_arr_safe as $k => $v): ?>
                <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="index-container"><?=$htmltitle_safe?></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
