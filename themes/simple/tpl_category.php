<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$sortname_safe = isset($sortname) ? $sortname : '';
$fullflag_safe = !empty($fullflag);
$year_safe = isset($year) ? $year : date('Y');
$sorttitle_safe = ($sortname_safe !== '') ? $sortname_safe : '全部';
?>
    <title><?php if($sortname_safe != ''):?><?=$sortname_safe?>_<?=$sortname_safe?>小说_<?php endif ?><?php if($fullflag_safe):?>已完本_<?php endif ?>小说书库_<?=SITE_NAME?></title>
    <meta name="keywords" content="<?php if($sortname_safe == ''):?>分类列表,小说全部分类列表,小说书库<?php else:?><?=$sortname_safe?>,<?=$sortname_safe?>类型推荐,<?=$year_safe?>热门的<?=$sortname_safe?>小说,<?=$sortname_safe?>的分类列表,<?=$sortname_safe?>的小说书库<?php endif ?>">
    <meta name="description" content="<?php if($sortname_safe == ''):?>分类列表,小说全部分类列表,小说书库<?php else:?><?=$sortname_safe?>,<?=$sortname_safe?>类型推荐,<?=$year_safe?>热门的<?=$sortname_safe?>小说,<?=$sortname_safe?>的分类列表,<?=$sortname_safe?>的小说书库,<?=SITE_NAME?>为你提供免费无弹窗的阅读体验<?php endif ?>">
<?php require_once 'tpl_header.php'; ?>

<div class="container">
	<div class="class">
		<ul>
            <?php if(is_array($sortcategory)): ?>
            <?php foreach($sortcategory as $k => $v): ?>
				<li><a href="<?=$v['sorturl']?>"<?php if($sortid == $k): ?> class="onselect"<?php endif?>><?=$v['sortname']?></a></li>
			<?php endforeach ?>
            <?php endif ?>
		</ul>
	</div>
	<div class="content book" id="fengtui">
        <h2 class="text-center"><?php if($fullflag_safe):?>已完本<?php endif ?><?=$sorttitle_safe?>小说列表</h2>
        <?php if(is_array($retarr)):?>
		<?php foreach($retarr as $k => $v): ?>
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
<?php require_once 'tpl_footer.php'; ?>
