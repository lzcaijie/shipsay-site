<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<script src="/static/<?=$theme_dir?>/user.js"></script>

<div class="container">
	<div class="content">
		<ol class="breadcrumb">
            <li><a href="<?=$site_url?>" title="<?=SITE_NAME?>">首页</a></li>
            <li><a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></li>
            <li><a href="<?=$info_url?>"><?=$articlename?></a></li>
			<li class="active">目录</li>
        </ol>

		<div class="book pt10">
			<div class="bookcover hidden-xs">
				<img class="thumbnail" alt="<?=$articlename?>" src="<?=$img_url?>" title="<?=$articlename?>" width="140" height="180" />
			</div>
			<div class="bookinfo">
				<h1 class="booktitle"><?=$articlename?></h1>
				<p class="booktag">
                    <a class="red" href="<?=$author_url?>" title="作者：<?=$author?>"><?=$author?></a>
                    <span class="blue"><?=$words_w?>万字</span>
                    <span class="blue"><?=$allvisit?>人读过</span>
                    <span class="red"><?=$isfull?></span>
                </p>
				<p>最新章节：<a class="bookchapter" href="<?=$last_url?>" title="<?=$lastchapter?>"><?=$lastchapter?></a></p>
                <p class="booktime">更新时间：<?=$lastupdate?></p>
				<div class="bookmore">
                    <a class="btn btn-info" href="<?=$first_url?>">开始阅读</a>
                    <a class="btn btn-info" href="<?=$info_url?>">返回详情</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<dl class="book chapterlist">
			<h2>《<?=$articlename?>》章节目录（第<?=$pid?>页）</h2>

            <?php if(!empty($list_arr) && is_array($list_arr)): ?>
                <?php foreach($list_arr as $k => $v): ?>
                    <dd><a href="<?=$v['cid_url']?>" title="<?=$articlename?> <?=$v['cname']?>"><?=$v['cname']?></a></dd>
                <?php endforeach; ?>
            <?php else: ?>
                <dd style="width:100%;text-align:center;color:#999;">暂无章节数据</dd>
            <?php endif; ?>

            <div class="clear"></div>

            <div class="index-container" style="margin-top:10px;">
                <?=$htmltitle?>
            </div>
		</dl>
    </div>
	<div class="clear"></div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
