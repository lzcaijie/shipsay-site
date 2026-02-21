<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$rank_base = '/' . ((isset($fake_rankstr) && $fake_rankstr) ? trim($fake_rankstr, '/') : 'rank') . '/';
$full_allbooks_url_safe = (isset($full_allbooks_url) && $full_allbooks_url) ? $full_allbooks_url : ('/' . ((isset($fake_fullstr) && $fake_fullstr) ? trim($fake_fullstr,'/') : 'quanben') . $allbooks_url);
?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title>小说排行榜-<?=SITE_NAME?></title>
<meta name="keywords" content="小说排行榜" />
<meta name="description" content="小说排行榜" />
<?php require_once __THEME_DIR__ . '/tpl_header.php';?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="javascript:history.go(-1)"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center">小说排行榜</div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed">	<div class="rank mt0">
		<h4>小说周点击榜<a class="pull-right" href="<?=$rank_base?>weekvisit/">More+</a></h4>
		<div class="content">
		     <?php
                         $sql =  $rico_sql;
                            $sql .= ' ORDER BY weekvisit DESC LIMIT 5';
                            if(isset($redis)) {
                            $weekvisit5 = $redis->ss_redis_getrows($sql, $home_cache_time);
                            } else {
                            $weekvisit5 = $db->ss_getrows($sql);
                            }
                            foreach($weekvisit5 as $k => $v): ?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
		<?php endforeach?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="rank">
		<h4>小说月点击榜<a class="pull-right" href="<?=$rank_base?>monthvisit/">More+</a></h4>
		<div class="content">
		    <?php
                         $sql =  $rico_sql;
                            $sql .= ' ORDER BY monthvisit DESC LIMIT 5';
                            if(isset($redis)) {
                            $monthvisit5 = $redis->ss_redis_getrows($sql, $home_cache_time);
                            } else {
                            $monthvisit5 = $db->ss_getrows($sql);
                            }
                            foreach($monthvisit5 as $k => $v): ?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
			<?php endforeach?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="rank">
		<h4>小说总点击榜<a class="pull-right" href="<?=$rank_base?>allvisit/">More+</a></h4>
		<div class="content">
			<?php
                         $sql =  $rico_sql;
                            $sql .= ' ORDER BY allvisit DESC LIMIT 5';
                            if(isset($redis)) {
                            $monthvisit10 = $redis->ss_redis_getrows($sql, $home_cache_time);
                            } else {
                            $monthvisit10 = $db->ss_getrows($sql);
                            }
                            foreach($monthvisit10 as $k => $v): ?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
			<?php endforeach?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="rank">
		<h4>小说收藏榜<a class="pull-right" href="<?=$rank_base?>goodnum/">More+</a></h4>
		<div class="content">
			<?php
                         $sql =  $rico_sql;
                            $sql .= ' ORDER BY goodnum DESC LIMIT 5';
                            if(isset($redis)) {
                            $monthvisit10 = $redis->ss_redis_getrows($sql, $home_cache_time);
                            } else {
                            $monthvisit10 = $db->ss_getrows($sql);
                            }
                            foreach($monthvisit10 as $k => $v): ?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
				<dd><?=$v['intro_des']?></dd>
				<dd><a href="<?=$v['author_url']?>"><?=$v['author']?></a><span><?=$v['isfull']?></span><span><?=$v['words_w']?>万字</span></dd>
			</dl>
			<?php endforeach?>
		</div>
		<div class="clear"></div>
	</div>
	<?php for($i=1;$i<=8;$i++):?>
	<div class="rank">
		<h4><?=Sort::ss_sortname($i,1)?>小说榜<a class="pull-right" href="<?=Sort::ss_sorturl($i)?>">More+</a></h4>
		<div class="content">
		    <?php $tmp='allvisit'.$i;foreach($$tmp as $k => $v): ?><?php if($k == 0):?>
			<dl>
				<a href="<?=$v['info_url']?>" class="cover" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=$v['articlename']?>"></a>
				<dt><span><?=$k+1?></span></span><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
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
<?php endfor?>
	<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
    <div id="guide" class="guide">
        <div class="guide-content">
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
        <a href="<?=$full_allbooks_url_safe?>" class="guide-nav-a">
            <i class="icon icon-end"></i>
            <span class="guide-nav-h">全本</span>
        </a>
        <a href="<?=$fake_recentread?>" class="guide-nav-a">
            <i class="icon icon-free"></i>
            <span class="guide-nav-h">记录</span>
        </a>
    </nav>
            <div class="guide-footer">
                <a href="/bookcase/"><svg id="icon-person" viewBox="0 0 16 16"><g><path d="M12 5a4 4 0 1 0-8 0 4 4 0 0 0 8 0zM3 5a5 5 0 1 1 10 0A5 5 0 0 1 3 5z"></path><path d="M8 9c-4.397 0-8 2.883-8 6.5a.5.5 0 1 0 1 0C1 12.49 4.113 10 8 10s7 2.49 7 5.5a.5.5 0 1 0 1 0C16 11.883 12.397 9 8 9z"></path></g></svg>会员书架</a>
            </div>
        </div>
    </div>

</body>
</html>