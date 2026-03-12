<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$author_safe = isset($author) ? trim((string)$author) : '';
$res_safe = (!empty($res) && is_array($res)) ? $res : [];
$recentread_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<style type="text/css">
.list-item{border-bottom:1px dashed #D4D4D4;padding:5px;width:100%;}
.list-item .article{height:100px; overflow:hidden; line-height:20px;}
.list-item .fs12{font-size:12px;}.list-item .red{color:red;}.list-item .gray{color:#7d7d7d;}.list-item .count{color:#333333;}.list-item .mr15{margin-right:15px;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow" class="bookcase">阅读记录</a><?php endif; ?>
    <h1><?=htmlspecialchars($author_safe !== '' ? $author_safe . '作品' : '作者作品', ENT_QUOTES, 'UTF-8')?></h1>
</div>
<?php if ($author_safe !== ''): ?><h1 class="search-title">作者：<span class="red"><?=htmlspecialchars($author_safe, ENT_QUOTES, 'UTF-8')?></span></h1><?php endif; ?>
<?php if(!empty($res_safe)): foreach($res_safe as $v): ?>
<table class="list-item"><tr>
    <td width="80"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><img src="<?=htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8')?>" width="80" height="100" alt="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>" /></a></td>
    <td><div class="article">
        <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a><?php if(isset($v['isfull']) && $v['isfull'] != '连载'):?><span class="fs12 red">(完)</span><?php endif?>
        <br/><p class="fs12 gray"><span class="mr15">作者:<?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></span>阅读:<span class="count"><?=intval($v['allvisit'])?></span></p>
        <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><span class="fs12 gray"><?=htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8')?></span></a>
    </div></td>
</tr></table>
<?php endforeach; else: ?>
<div style="padding:12px;color:#999;">暂无该作者作品</div>
<?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
