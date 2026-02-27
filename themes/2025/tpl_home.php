<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<link rel="canonical" href="<?=SITE_URL?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="MobileOptimized" content="320">
<meta name="mobile-web-app-capable" content="yes">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20221207" />
</head>
<body>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
<div class="list-index-1">
<div class="title"><h2>精品荟萃</h2><span>最火热门小说推荐</span></div>
<?php if(is_array($commend)): ?><?php foreach($commend as $k => $v): ?><?php if($k < 4):?>
<div class="item">
<div class="cover">
<a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" width="120" height="150" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;" /></a>
<span><?=$v['sortname_2']?> /  <?=$v['isfull']?></span>
</div>
<dl>
<dt><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
<dd class="author"><?=$v['author']?></dd>
<dd class="intro"><?=$v['intro_des']?></dd>
<dd class="more"><span><?=$v['words_w']?>万字</span><span><?=Text::ss_lastupdate($v['lastupdate'])?></span></dd>
</dl>
<div class="cf"></div>
</div>
<?php endif ?><?php endforeach ?><?php endif ?>
<div class="cf"></div>
</div>
<div class="list-index-tag">
<div class="title"><h2>热门作者</h2><span>更多大神小说</span></div>
<ul>
<li><a href="/author/唐家三少/" title="唐家三少">唐家三少</a></li>
<li><a href="/author/天蚕土豆/" title="天蚕土豆">天蚕土豆</a></li>
<li><a href="/author/辰东/" title="辰东">辰东</a></li>
<li><a href="/author/爱潜水的乌贼/" title="爱潜水的乌贼">爱潜水的乌贼</a></li>
<li><a href="/author/猫腻/" title="猫腻">猫腻</a></li>
<li><a href="/author/血红/" title="血红">血红</a></li>
<li><a href="/author/我吃西红柿/" title="我吃西红柿">我吃西红柿</a></li>
<li><a href="/author/月关/" title="月关">月关</a></li>
<li><a href="/author/小刀锋利/" title="小刀锋利">小刀锋利</a></li>
<li><a href="/author/流浪的蛤蟆/" title="流浪的蛤蟆">流浪的蛤蟆</a></li>
<li><a href="/author/乘风御剑/" title="乘风御剑">乘风御剑</a></li>
<li><a href="/author/骷髅精灵/" title="骷髅精灵">骷髅精灵</a></li>
<li><a href="/author/傲无常/" title="傲无常">傲无常</a></li>
<li><a href="/author/无罪/" title="无罪">无罪</a></li>
<li><a href="/author/石三/" title="石三">石三</a></li>
<li><a href="/author/虾写/" title="虾写">虾写</a></li>
<li><a href="/author/卖报小郎君/" title="卖报小郎君">卖报小郎君</a></li>
<li><a href="/author/烽火戏诸侯" title="烽火戏诸侯">烽火戏诸侯</a></li>
<li><a href="/author/会说话的肘子/" title="会说话的肘子">会说话的肘子</a></li>
<li><a href="/author/季越人/" title="季越人">季越人</a></li>
<li><a href="/author/狐尾的笔/" title="狐尾的笔">狐尾的笔</a></li>
</ul>
<div class="cf"></div>
</div>
<div class="cf"></div>
</div>
<div class="container">
<div class="list-index-2">
<div class="title"><h2>人气精品</h2><span>跟上书友的步伐</span></div>
<?php if(is_array($popular)): ?><?php foreach($popular as $k => $v): ?><?php if($k < 6):?>	
<div class="item">
<div class="cover">
<a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" width="120" height="150" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;" /></a>
<span><?=$v['sortname_2']?> /  <?=$v['isfull']?></span>
</div>
<dl>
<dt><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
<dd class="author"><?=$v['author']?></dd>
<dd class="intro"><?=$v['intro_des']?></dd>
<dd class="more"><span><?=$v['words_w']?>万字</span><span><?=Text::ss_lastupdate($v['lastupdate'])?></span></dd>
</dl>
<div class="cf"></div>
</div>
<?php endif ?><?php endforeach ?><?php endif ?>
<div class="cf"></div>
</div>
</div>
<div class="container">
<div class="list-index-4">
<div class="title"><h2>最新小说</h2><span>每天新书上不停</span></div>
<ul>
<?php if(is_array($postdate)) { foreach($postdate as $k => $v) { ?>
<li><span class="s1">[<?=$v['sortname_2']?>]</span><a class="s2" href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a><span class="s3"><?=$v['author']?></span></li>
<?php }} ?>
</ul>
<div class="cf"></div>
</div>
<div class="list-index-3">
<div class="title"><h2>最近更新</h2><span>24小时精彩不间断</span></div>
<?php if(is_array($lastupdate)){ foreach($lastupdate as $k => $v) { ?>
<div class="item">
<div class="cover">
<a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" width="120" height="150" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;" /></a>
<span><?=$v['sortname_2']?> /  <?=$v['isfull']?></span>
</div>
<dl>
<dt><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></dt>
<dd class="author"><?=$v['author']?></dd>
<dd class="intro"><?=$v['intro_des']?></dd>
<dd class="more"><span><?=$v['words_w']?>万字</span><span><?=Text::ss_lastupdate($v['lastupdate'])?></span></dd>
</dl>
<div class="cf"></div>
</div>
<?php }} ?>
<div class="cf"></div>
</div>
<div class="cf"></div>
<div class="list-index-link hidden-xs">
<div class="title"><h2>友情链接</h2></div>
<p> <?=$link_html?></p>
</div>
<div class="cf"></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
