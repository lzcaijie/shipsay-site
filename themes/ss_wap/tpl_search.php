<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$searchkey_safe = isset($searchkey) ? trim((string)$searchkey) : '';
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<style type="text/css">
.list-item{border-bottom:1px dashed #D4D4D4;padding:5px;width:100%;}
.list-item .article{height:100px; overflow:hidden; line-height:20px;}
.list-item .fs12{font-size:12px;}.list-item .gray{color:#7d7d7d;}.list-item .count{color:#333333;}.list-item .mr15{margin-right:15px;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<?php ss_render_page_top(['page_title' => '搜索小说', 'show_back' => true]); ?>
<div class="waps_r">
<?php ss_render_search_form(['searchkey' => $searchkey_safe]); ?>
</div>
<?php if($searchkey_safe !== ''): ?>
    <h1 class="search-title">搜索<span class="red"><?=htmlspecialchars($searchkey_safe, ENT_QUOTES, 'UTF-8')?></span>的结果<?php if (!empty($search_res) && is_array($search_res)): ?><small style="font-size:12px;color:#999;">（<?=count($search_res)?>条）</small><?php endif; ?></h1>
<?php endif; ?>
<?php if(!empty($search_res) && is_array($search_res)): foreach($search_res as $v): ?>
<table class="list-item"><tr>
    <td width="80"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><img src="<?=htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8')?>" width="80" height="100" alt="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>" /></a></td>
    <td><div class="article">
        <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a><br/>
        <p class="fs12 gray"><span class="mr15">作者:<?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></span>阅读:<span class="count"><?=intval($v['allvisit'])?></span></p>
        <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><span class="fs12 gray"><?=htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8')?></span></a>
    </div></td>
</tr></table>
<?php endforeach; elseif($searchkey_safe !== ''): ?>
<div style="padding:12px;color:#999;">未找到相关结果</div>
<?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
