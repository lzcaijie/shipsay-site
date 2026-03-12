<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$searchkey_safe = isset($searchkey) ? trim((string)$searchkey) : '';
$recentread_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
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
<div class="page-head">
    <a href="/" class="home">首页</a>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow" class="bookcase">阅读记录</a><?php endif; ?>
    <h1>搜索小说</h1>
</div>
<?php
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : '';
$search_url_attr = ss_h($search_url_raw);
?>
<div class="waps_r"><div class="search">
<form id="post" name="t_frmsearch" method="post" action="<?=$search_url_attr?>"<?php if ($search_url_raw === ''): ?> onsubmit="return false;"<?php endif; ?>>
    <table cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
            <td style="width:50px;">
                <div id="type" class="type">综合</div>
            </td>
            <td style="background-color:#fff; border:1px solid #CCC;">
                <input id="s_key" name="searchkey" type="text" class="key" value="<?=htmlspecialchars($searchkey_safe, ENT_QUOTES, 'UTF-8')?>" placeholder="输入书名/作者" maxlength="50">
                <input type="hidden" name="searchtype" value="all">
            </td>
            <td style="width:35px; background-color:#0080C0; background-image:url('/static/<?=$theme_dir_attr?>/search.png'); background-repeat:no-repeat; background-position:center">
                <input name="t_btnsearch" type="submit" value="" class="go"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>
            </td>
        </tr>
    </table><span id="s_tips"></span>
</form>
</div></div>
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
