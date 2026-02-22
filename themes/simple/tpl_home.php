<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=SITE_NAME?>_<?=SITE_NAME?>网_书友最值得收藏的网络小说阅读网</title>
<meta name="keywords" content="<?=SITE_NAME?>,<?=SITE_NAME?>网,<?=SITE_NAME?>免费阅读,<?=SITE_NAME?>阅读网">
<meta name="description" content="<?=SITE_NAME?>为您提供最新最全的小说信息,更新及时、全站免费阅读，为读者打造一个舒心的阅读环境，看小说就上<?=SITE_NAME?>阅读网">
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
				<form name="articlesearch" method="post" action="<?=$search_url_safe?>">
					<input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" placeholder="搜索从这里开始...">
					<input type="hidden" name="action" value="login"><input type="hidden" name="searchtype" value="all">
					<button type="submit" name="submit">搜  索</button>
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
