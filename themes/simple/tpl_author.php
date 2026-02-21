<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<?php
$author_safe = isset($author) ? $author : '';
$sortid_safe = isset($sortid) ? $sortid : 0;
?>
<title><?=$author_safe?>的全部小说 - <?=$author_safe?>最新作品集 - <?=$author_safe?>简介 - <?=SITE_NAME?></title>
<meta name="keywords" content="<?=$author_safe?>的全部小说,<?=$author_safe?>作品集,<?=$author_safe?>简介,<?=$author_safe?>照片,<?=SITE_NAME?>">
<meta name="description" content="<?=$author_safe?>的全部小说尽在<?=SITE_NAME?>,<?=SITE_NAME?>为您提供<?=$author_safe?>最新全部作品集，查找<?=$author_safe?>的最新作品、<?=$author_safe?>作品集就上<?=SITE_NAME?>！">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<script src="/static/<?=$theme_dir?>/user.js"></script>

<div class="container">
	<div class="class">
		<ul>
            <?php if(!empty($sortcategory) && is_array($sortcategory)): ?>
            <?php foreach($sortcategory as $k => $v): ?>
				<li><a href="<?=$v['sorturl']?>"<?php if($sortid_safe == $k): ?> class="onselect"<?php endif?>><?=$v['sortname']?></a></li>
			<?php endforeach ?>
            <?php endif ?>
		</ul>
	</div>
	<div class="content book" id="fengtui">
        <h2 class="text-center"><?=$author_safe?>小说全集列表</h2>
        <?php if(!empty($res) && is_array($res)): ?><?php foreach($res as $k => $v): ?>	
		<div class="bookbox">
			<div class="p10"><span class="num"><?=$k+1?></span>
				<div class="bookinfo">
					<h4 class="bookname"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h4>
					<div class="author">作者：<?=$v['author']?></div>
					<div class="author">字数：<?=$v['words_w']?>万字</div>
					<div class="author">阅读量：<?=$v['allvisit']?></div>
					<div class="cat"><span>更新到：</span><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></div>
					<div class="update"><span>简介：</span><?=$v['intro_des']?></div>
				</div>
				<div class="delbutton"><a class="del_but" href="<?=$v['info_url']?>">阅读</a></div>
			</div>
		</div>
        <?php endforeach ?>
        <?php endif ?>
	</div>
	<div class="clear"></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
