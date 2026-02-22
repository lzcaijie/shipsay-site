<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php $year_safe = isset($year) ? $year : date('Y'); ?>
<title>搜索_<?=SITE_NAME?>_顶尖口碑的免费小说阅读网</title>
<meta name="keywords" content="<?=SITE_NAME?>,免费小说网,手机小说,最新小说推荐,小说阅读网,免费小说阅读网,小说阅读器全本免费小说,小说网站排名,小说在线阅读" />
<meta name="description" content="<?=SITE_NAME?>收集了<?=$year_safe?>网络热门小说的最新章节免费阅读,提供玄幻、武侠、原创、网游、都市、言情、历史、军事、科幻、恐怖、官场、穿越、重生等小说,<?=$year_safe?>最新全本免费手机小说阅读推荐,一切精彩尽在<?=SITE_NAME?>" />
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
	<div class="content">
		<div class="search">
			<form name="articlesearch" method="post" action="<?=$search_url_safe?>">
				<input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" placeholder="搜索从这里开始..." />
				<input type="hidden" name="action" value="login" />
				<button type="submit" name="submit">搜  索</button>
			</form>
		</div>
		<div class="clear"></div>
	</div>

	<div class="content book" id="fengtui">
		<?php if (!empty($searchkey)): ?>
			<h2>与“<?=$searchkey?>”有关的小说</h2>
		<?php else: ?>
			<h2>热门小说推荐</h2>
		<?php endif; ?>

		<?php if (!empty($search_res) && is_array($search_res)): ?>
			<?php foreach($search_res as $k => $v): ?>
			<div class="bookbox">
				<div class="p10">
					<span class="num"><?=$k+1?></span>
					<div class="bookinfo">
						<h4 class="bookname"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h4>
						<div class="author">作者：<?=$v['author']?></div>
						<div class="author">阅读量：<?=$v['allvisit']?></div>
						<div class="cat"><span>更新到：</span><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></div>
						<div class="update"><span>简介：</span><?=$v['intro_des']?></div>
					</div>
					<div class="delbutton"><a class="del_but" href="<?=$v['info_url']?>">阅读</a></div>
				</div>
			</div>
			<?php endforeach ?>

		<?php else: ?>

			<?php if (!empty($searchkey)): ?>
				<div class="bookbox">
					<div class="p10" style="text-align:center;color:#999;">
						未找到相关结果，给你推荐一些热门小说：
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($articlerows) && is_array($articlerows)): ?>
				<?php foreach($articlerows as $k => $v): ?>
				<div class="bookbox">
					<div class="p10">
						<span class="num"><?=$k+1?></span>
						<div class="bookinfo">
							<h4 class="bookname"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h4>
							<div class="author">作者：<?=$v['author']?></div>
							<div class="author">阅读量：<?=$v['allvisit']?></div>
							<div class="cat"><span>更新到：</span><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></div>
							<div class="update"><span>简介：</span><?=$v['intro_des']?></div>
						</div>
						<div class="delbutton"><a class="del_but" href="<?=$v['info_url']?>">阅读</a></div>
					</div>
				</div>
				<?php endforeach ?>
			<?php endif; ?>

		<?php endif; ?>

		<div class="clear"></div>
	</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
