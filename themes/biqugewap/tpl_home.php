<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title><?=SITE_NAME?>_<?=SITE_NAME?>网_书友最值得收藏的网络小说阅读网</title>
<meta name="keywords" content="<?=SITE_NAME?>,<?=SITE_NAME?>网,最新<?=SITE_NAME?>,<?=SITE_NAME?>阅读网">
<meta name="description" content="<?=SITE_NAME?>,<?=SITE_NAME?>网,最新<?=SITE_NAME?>,<?=SITE_NAME?>阅读网，是广大书友最值得收藏的网络小说阅读网，网站收录了当前最火热的网络小说，免费提供高质量的小说最新章节，是广大网络小说爱好者必备的小说阅读网。">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="/bookcase/"><svg id="icon-person" viewBox="0 0 16 16"><g><path d="M12 5a4 4 0 1 0-8 0 4 4 0 0 0 8 0zM3 5a5 5 0 1 1 10 0A5 5 0 0 1 3 5z"></path><path d="M8 9c-4.397 0-8 2.883-8 6.5a.5.5 0 1 0 1 0C1 12.49 4.113 10 8 10s7 2.49 7 5.5a.5.5 0 1 0 1 0C16 11.883 12.397 9 8 9z"></path></g></svg></a></div>
		<div class="center"><?=SITE_NAME?></div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed">
	    <nav class="guide-nav">
        <a href="<?=$site_url?>" class="guide-nav-a">
            <i class="icon icon-home"></i>
            <span class="guide-nav-h">首页</span>
        </a>
        <a href="<?=$allbooks_url?>" class="guide-nav-a">
            <i class="icon icon-sort"></i>
            <span class="guide-nav-h">分类</span>
        </a>
        <a href="<?=$fake_top?>" class="guide-nav-a">
            <i class="icon icon-rank"></i>
            <span class="guide-nav-h">排行榜</span>
        </a>
        <a href="<?=$full_allbooks_url?>" class="guide-nav-a">
            <i class="icon icon-end"></i>
            <span class="guide-nav-h">全本</span>
        </a>
        <a href="<?=$fake_recentread?>" class="guide-nav-a">
            <i class="icon icon-free"></i>
            <span class="guide-nav-h">记录</span>
        </a>
    </nav>
	<div class="rank">
		<h4>热门小说推荐<a class="pull-right" href="<?=$fake_top?>">More+</a></h4>
		<div class="content">
		    <?php foreach($commend as $k => $v): ?><?php if($k < 5):?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
			<?php endif ?><?php endforeach ?>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="rank">
		<h4>本周人气榜<a class="pull-right" href="/rank/weekvisit/">More+</a></h4>
		<div class="content">
		    <?php
                         $sql =  $rico_sql;
                            $sql .= ' ORDER BY weekvisit DESC LIMIT 5';
                            if(isset($redis)) {
                            $weekvisit5 = $redis->ss_redis_getrows($sql, $home_cache_time);
                            } else {
                            $weekvisit5 = $db->ss_getrows($sql);
                            }
                            foreach($weekvisit5 as $k => $v): ?><?php if($k == 0):?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
		</div>
		<ul class="list">
		    <?php elseif( $k < 5 ) : ?>
            <li><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a><a href="<?=$v['author_url']?>"><?=$v['author']?></a></li>
            <?php endif?><?php endforeach?>
		</ul>
		<div class="clear"></div>
	</div>
	<div class="rank">
		<h4>书友收藏榜<a class="pull-right" href="/rank/goodnum/">More+</a></h4>
		<div class="content">
			<?php
                         $sql =  $rico_sql;
                            $sql .= ' ORDER BY goodnum DESC LIMIT 5';
                            if(isset($redis)) {
                            $weekvisit5 = $redis->ss_redis_getrows($sql, $home_cache_time);
                            } else {
                            $weekvisit5 = $db->ss_getrows($sql);
                            }
                            foreach($weekvisit5 as $k => $v): ?><?php if($k == 0):?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
		</div>
		<ul class="list">
		    <?php elseif( $k < 5 ) : ?>
            <li><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?><?=$v['articlename']?></a><a href="<?=$v['author_url']?><?=$v['author']?></a></li>
            <?php endif?><?php endforeach?>
		</ul>
		<div class="clear"></div>
	</div>
	<div class="rank">
		<h4>最新小说<a class="pull-right" href="<?=$allbooks_url?>">More+</a></h4>
		<?php if(is_array($postdate)) { foreach($postdate as $k => $v) { if( $k == 0 ){ ?>	
		<div class="content">
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
		</div>
		<ul class="list">
		     <?php } else { ?>
            <li><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a><a href="<?=$v['author_url']?>"><?=$v['author']?></a></li>
		<?php }}} ?>
		</ul>
		<div class="clear"></div>
	</div>
	<div class="rank">
		<h4>最近更新<a class="pull-right" href="<?=$allbooks_url?>">More+</a></h4>
		<div class="content">
		    <?php foreach($lastupdate as $k => $v){ ?>
			<dl>
            <a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
		<?php } ?>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="rank"><h4>友情链接:</h4> <?=$link_html?></div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>