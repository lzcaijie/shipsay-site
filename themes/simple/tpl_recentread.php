<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>最近阅读_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=SITE_NAME?>,免费小说网,手机小说,最新小说推荐,小说阅读网,免费小说阅读网,小说阅读器全本免费小说,小说网站排名,小说在线阅读" />
<meta name="description" content="<?=SITE_NAME?>收集了<?=$year?>网络热门小说的最新章节免费阅读,提供玄幻、武侠、原创、网游、都市、言情、历史、军事、科幻、恐怖、官场、穿越、重生等小说,<?=$year?>最新全本免费手机小说阅读推荐,一切精彩尽在<?=SITE_NAME?>" />

<?php require_once 'tpl_header.php'; ?>

<div class="container">
    <div class="content book">
	<h2 class="text-center">阅读记录</h2>
	<div id="showbook">
		<script>showbook();</script>
	</div>
    </div>
</div>

<?php require_once 'tpl_footer.php'; ?>
