<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<?php $__sortname = ($sortname != '') ? $sortname : '小说'; ?>
<title><?php if($sortname !=''):?><?=$sortname?>_<?=$sortname?>大全_<?=$sortname?>排行榜<?php else:?>小说书库<?php endif ?> - <?=SITE_NAME?></title>
<meta name="keywords" content="<?=$__sortname?>,<?=$__sortname?>网,<?=$__sortname?>免费阅读,<?=SITE_NAME?>">
<meta name="description" content="<?=SITE_NAME?>为您提供好看的<?=$__sortname?>,最新热门<?=$__sortname?>排行榜。">
<link rel="canonical" href="<?=$site_url?><?=Sort::ss_sorturl($sortid)?>">
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

<div class="container visible-xs">
<div class="header-m">
<a class="header-m-left" href="javascript:window.history.go(-1);"><svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2585"><path d="M358.997 512l311.168-311.168a42.667 42.667 0 1 0-60.33-60.33L268.5 481.834a42.667 42.667 0 0 0 0 60.33L609.835 883.5a42.667 42.667 0 0 0 60.33-60.331L358.997 512z" p-id="2586"></path></svg></a>
<div class="header-m-center"><?php if($sortname!=''):?><?=$sortname?><?php else:?>全部小说<?php endif;?></div>
<a class="header-m-right" href="/"><svg class="icon" viewBox="0 0 1025 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2094"><path d="M938.977859 1024c-100.292785 0-198.718416 0-298.210992 0 0-113.362855 0-226.458974 0-340.355301-85.889034 0-170.17765 0-255.799948 0 0 112.829383 0 225.658765 0 339.821829-100.292785 0-199.251889 0-299.277937 0 0-4.534514 0-8.802292 0-13.07007 0-176.579318 0-352.891899 0.266736-529.471216 0-5.868195 3.46757-13.870279 8.002084-17.604585 138.436051-111.228966 277.138838-222.191196 416.108362-333.153425 0.533472-0.533472 1.600417-0.800208 3.200834-1.333681 45.345142 36.276114 91.223756 72.818963 136.835634 109.361813 91.490492 73.352436 182.980985 146.704871 275.004949 219.523834 10.402709 8.26882 14.403751 16.53764 14.403751 29.874446-0.533472 173.911956-0.266736 347.557176-0.266736 521.469133C938.977859 1013.864027 938.977859 1018.932014 938.977859 1024zM85.422245 85.889034c57.348268 0 113.096119 0 169.910914 0 0 38.410003 0 76.820005 0 119.497786 87.222714-69.61813 171.511331-137.10237 256.866892-205.386819 22.939307 18.404793 46.14535 36.809586 69.351394 55.214379 144.570982 115.76348 289.141964 231.52696 433.979682 347.023704 6.668403 5.334723 9.602501 10.135973 9.335765 18.671529-0.800208 13.603543-0.266736 27.207085-0.266736 44.011461C852.288617 327.285231 682.644439 191.516541 512.200052 55.214379 342.022402 191.516541 172.111487 327.285231 0.066684 464.921073c0-19.205001-0.266736-35.475905 0.266736-51.480073 0-3.200834 3.734306-6.668403 6.401667-9.069028 22.672571-18.404793 45.611878-36.809586 68.817921-54.680906 7.468612-5.868195 10.135973-12.003126 9.869237-21.33889C85.422245 252.599114 85.422245 177.11279 85.422245 101.626465 85.422245 96.825215 85.422245 92.023965 85.422245 85.889034z" p-id="2095"></path></svg></a>
</div>
</div>

<div class="container autoheight">
<ol class="navigator">
<li><a href="/"><?=SITE_NAME?></a></li>
<li class="active"><?php if($sortname!=''):?><?=$sortname?><?php else:?>小说书库<?php endif;?></li>
</ol>

<ul class="sortlist">
<li><a href="<?=$allbooks_url?>">全部小说<span class="hidden-xs"></span></a></li>

<?php if(!empty($sortcategory) && is_array($sortcategory)): ?>
<?php foreach($sortcategory as $k => $v): ?>
    <li<?php if($sortid == $k): ?> class="active"<?php endif; ?>>
        <a id="sort<?=$k?>" href="<?=$v['sorturl']?>"><?=$v['sortname']?></a>
    </li>
<?php if($sortid == $k): $curid=$k; endif; ?>
<?php endforeach; ?>
<?php endif; ?>
</ul>

<div class="list-index-2 hidden-xs">
<div class="title"><h2>热门<?=$__sortname?>小说推荐</h2></div>
<?php
    $sql = $sortid > 0 ? $rico_sql.'AND sortid = '. $sortid : $rico_sql;
    $sql .= ' ORDER BY weekvisit DESC LIMIT 6';
    if(isset($redis)) {
        $weekvisit10 = $redis->ss_redis_getrows($sql, $home_cache_time);
    } else {
        $weekvisit10 = $db->ss_getrows($sql);
    }
?>
<?php if(!empty($weekvisit10) && is_array($weekvisit10)): ?>
<?php foreach($weekvisit10 as $k => $v) { ?>
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
<?php } ?>
<?php endif; ?>
<div class="cf"></div>
</div>

<div class="list-index-2">
<div class="title"><h2>最近更新<?=$__sortname?>小说</h2></div>
<?php if(!empty($retarr) && is_array($retarr)): ?>
<?php foreach($retarr as $k => $v): ?>
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
<?php endforeach; ?>
<?php else: ?>
<div style="padding:20px;color:#888;">暂无内容</div>
<?php endif; ?>
<div class="cf"></div>
</div>

<div class="cf"></div>
</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
