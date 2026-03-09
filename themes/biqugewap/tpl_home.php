<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang='zh'>
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
<?php
$rank_entry_url_home = !empty($rank_entry_url) ? $rank_entry_url : (!empty($fake_top) ? $fake_top : '');
$rank_week_url_home = (!empty($rank_detail_base) ? rtrim($rank_detail_base, '/') . '/weekvisit/' : $rank_entry_url_home);
$rank_goodnum_url_home = (!empty($rank_detail_base) ? rtrim($rank_detail_base, '/') . '/goodnum/' : $rank_entry_url_home);
$recentread_url_home = !empty($recentread_url_attr) ? $recentread_url_attr : (!empty($fake_recentread) ? $fake_recentread : '');
$full_allbooks_url_home = !empty($full_allbooks_url) ? $full_allbooks_url : '';
?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="<?=$recentread_url_home?>" title="阅读记录"><svg id="icon-history" viewBox="0 0 16 16"><path d="M8 1a7 7 0 1 0 6.93 8h-1.02A6 6 0 1 1 8 2c1.66 0 3.16.67 4.24 1.76L10 6h5V1l-2.05 2.05A6.97 6.97 0 0 0 8 1z"></path><path d="M7.5 4h1v4.2l3 1.8-.5.86-3.5-2.1V4z"></path></svg></a></div>
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
        <a href="<?=$rank_entry_url_home?>" class="guide-nav-a">
            <i class="icon icon-rank"></i>
            <span class="guide-nav-h">排行榜</span>
        </a>
        <a href="<?=$full_allbooks_url_home?>" class="guide-nav-a">
            <i class="icon icon-end"></i>
            <span class="guide-nav-h">全本</span>
        </a>
        <a href="<?=$recentread_url_home?>" class="guide-nav-a">
            <i class="icon icon-free"></i>
            <span class="guide-nav-h">记录</span>
        </a>
    </nav>
	<div class="rank">
		<h4>热门小说推荐<a class="pull-right" href="<?=$rank_entry_url_home?>">More+</a></h4>
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
		<h4>本周人气榜<a class="pull-right" href="<?=$rank_week_url_home?>">More+</a></h4>
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
		<h4>书友收藏榜<a class="pull-right" href="<?=$rank_goodnum_url_home?>">More+</a></h4>
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
            <li><span><?=$k+1?></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a><a href="<?=$v['author_url']?>"><?=$v['author']?></a></li>
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