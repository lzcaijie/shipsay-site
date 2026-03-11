<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
	<div class="content">
		<div class="content-left" id="fengtui">
			<h2>热门小说推荐</h2>
			<?php if(is_array($commend)): ?><?php foreach($commend as $k => $v): ?><?php if($k < 4):?>
			<div class="item">
				<div class="image"><a href="<?=$v['info_url']?>"><img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"  width="120" height="150" /></a></div>
				<dl>
				<dt><span><?=$v['author']?></span><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				</dl>
				<div class="clear"></div>
			</div>
			<?php endif ?><?php endforeach?><?php endif ?>

		</div>


		<div class="content-right" id="fengyou">
			<div class="search hidden-xs">
				<form name="articlesearch" method="post"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
					<input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" placeholder="<?=$search_placeholder_attr?>">
					<input type="hidden" name="searchtype" value="all">
					<button type="submit" name="submit"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜  索</button>
				</form>
			</div>
			<h2 class="visible-xs">阅读排行榜</h2>
			<ul>
                <?php if(is_array($popular)): ?><?php foreach($popular as $k => $v): ?><?php if($k < 9):?>
                    <li>[<?=$v['sortname_2']?>] <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><span><?=$v['author']?></span></li>
                <?php endif ?><?php endforeach ?><?php endif ?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div class="content">
		<div class="content-right" id="zuixin">
			<h2>最新小说</h2>
			<ul>
			<?php if(is_array($postdate)): ?><?php foreach($postdate as $v): ?>	
				<li>[<?=$v['sortname_2']?>] <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><span><?=$v['author']?></span></li>
			<?php endforeach ?><?php endif ?>
			</ul>
		</div>
		<div class="content-left" id="gengxin">
			<h2>最近更新</h2>
			<ul>
			<?php if(is_array($lastupdate)): ?><?php foreach($lastupdate as $v): ?>	
                <li><span class="s1">[<?=$v['sortname']?>]</span><span class="s2"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></span><span class="s3"><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></span><span class="s5"><?=date('m-d H:i',$v['lastupdate'])?></span><span class="s4"><?=$v['author']?></span></li>
            <?php endforeach ?><?php endif ?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div class="content tuijian hidden-xs">
		<div class="clear"></div>
	</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
