<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php $year_safe = isset($year) ? $year : date('Y'); ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
	<div class="content">
		<div class="search">
			<form name="articlesearch" method="post"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
				<input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" placeholder="<?=$search_placeholder_attr?>" />
				<input type="hidden" name="searchtype" value="all" />
				<button type="submit" name="submit"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜  索</button>
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
