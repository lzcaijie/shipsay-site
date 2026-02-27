<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<!-- header -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="applicable-device" content="pc,mobile">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="mobile-web-app-capable" content="yes">
<link rel="apple-touch-icon" href="/static/<?=$theme_dir?>/images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
<script>
	var userlogin = 0;
</script>
</head>

<body style="zoom: 1;">
<div class="page">
    <!-- start header -->
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
    <!-- end header -->

<?php
$rank_base = '/' . ((isset($fake_rankstr) && $fake_rankstr) ? trim($fake_rankstr, '/') : 'rank') . '/';
$rank_allvote_url = $rank_base . 'allvote/';
?>

	<div class="hom-bd pr" id="imgload">
		<!-- start continue reading -->
		<div class="j_reading_wrap"></div>

		<div class="cf g_wrap">
    		<h2 class="hom-h1 fl">新书推荐</h2>
			<a href="<?=$rank_allvote_url?>" class="fl ml20 mt20 fs16 ttl">more<i class="i-more"></i></a>
    	</div>

	    <ul class="g_row hom-books hom-gutter hom-arr">
	        <?php if(!empty($postdate) && is_array($postdate)): ?>
                <?php foreach($postdate as $k => $v): ?>
                    <li class="g_col_2">
                        <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
                            <i class="g_thumb hom-thumb">
                                <img _src="<?=$v['img_url']?>" width="140" height="186" src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" style="display: block;">
                            </i>
                            <h3 class="hom-h2" style="word-wrap: break-word;"><?=$v['articlename']?></h3>
                        </a>
                        <span class="_type"><?=$v['sortname']?></span>
                    </li>
                <?php endforeach ?>
            <?php endif; ?>
		</ul>

		<h2 class="g_wrap hom-h1">编辑力荐</h2>
		<ul class="g_row hom-rec hom-books hom-gutter pt5">
            <li class="g_col_4 hom-rec-1st">
            	<div class="p20">
            	    <?php if(!empty($commend) && is_array($commend)): ?>
            	    <?php foreach($commend as $k => $v) { if($k  < 1 ) { ?>
            		<a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
            			<span class="g_thumb hom-thumb">
            				<img _src="<?=$v['img_url']?>" width="180" height="240" src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" style="display: block;">
            				<i></i>
            				<span></span>
            			</span>
            			<h3 class="hom-h3 ell" style="word-wrap: break-word; white-space: normal;"><?=$v['articlename']?></h3>
            		</a>
            		<span class="db mb15 ttc c_small"><?=$v['sortname']?></span>
            		<strong class="g_score mb5 g_score_4 g_score_half"><i></i><small>4.6</small></strong> 
            		<p class="fs16 lh1d5 c_strong g_ells" style="word-wrap: break-word;" title="<?=$v['intro_des']?>"><?=$v['intro_des']?></p>
                    <?php }} ?>
                    <?php endif; ?>
            	</div>
            </li>

            <?php if(!empty($commend) && is_array($commend)): ?>
            <?php foreach($commend as $k => $v) { if($k > 0 && $k <= 10) { ?>
            <li class="g_col_2 mb20">
            	<a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
            		<i class="g_thumb hom-thumb">
                        <img _src="<?=$v['img_url']?>" width="140" height="186" alt="<?=$v['articlename']?>" style="display: block;" src="<?=$v['img_url']?>">
                    </i>
            		<h3 class="hom-h2" style="word-wrap: break-word;"><?=$v['articlename']?></h3>
            	</a>
            	<span class="_type"><?=$v['sortname']?></span>
            </li>
            <?php }} ?>
            <?php endif; ?>
		</ul>

		<div class="cf g_wrap">
			<h2 class="hom-h1 fl">最受欢迎</h2>
		</div>
		<div class="g_thumb_list">
        	<ul class="g_row hom-books hom-gutter hom-pop">
                <?php if(!empty($popular) && is_array($popular)): ?>
                <?php foreach($popular as $k => $v){ if($k < 6) { ?>
                <li class="g_col_2">
                	<a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
                		<i class="g_thumb hom-thumb">
                            <img _src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" src="<?=$v['img_url']?>" style="display: block;">
                            <span class="fwb pa t0 l0 _num _num1"><?=($k+1)?></span>
                        </i>
                		<h3 class="hom-h2" style="word-wrap: break-word;"><?=$v['articlename']?></h3>
                	</a>
                	<span class="_type mb5 ttc"><?=$v['sortname']?></span>
                </li>
                <?php }} ?>
                <?php endif; ?>
            </ul>
		</div>
	</div>
</div>

<h2 class="g_wrap hom-h1">最近更新</h2>
<div class="g_wrap hom-gutter">
	<table class="w100p m-update">
		<thead>
			<tr class="c_small">
				<th class="_f">分类</th>
				<th>小说</th>
				<th class="_re">最新</th>
				<th class="_au">作者</th>
				<th class="_l">时间</th>
			</tr>
		</thead>
		<tbody>
            <?php if(!empty($lastupdate) && is_array($lastupdate)): ?>
		    <?php foreach($lastupdate as $k => $v): ?>
		    <tr>
            	<td class="_f"><span class="_gen c_small"><?=$v['sortname']?></span></td>
            	<td><a href="<?=$v['info_url']?>" class="_tit f_serif c_strong fs16" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></td>
            	<td class="_re"><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></td>
            	<td class="_au"><a class="note" href="<?=$v['author_url']?>"><span class="_aut c_small" title="<?=$v['author']?>"><?=$v['author']?></span></a></td>
            	<td class="_l"><span class="_tim"><?=date('m-d',$v['lastupdate'])?></span></td>
            </tr>
		    <?php endforeach ?>
            <?php endif; ?>
		</tbody>
	</table>
</div>

<div class="g_footer">
	<div class="g_row">
		<div class="g_col_9">
            <?php if(isset($ShipSayLink['is_link']) && $ShipSayLink['is_link']==1 && !empty($link_html)): ?>
                <h4>友情链接:</h4> <?=$link_html?>
            <?php endif; ?>
            <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
		</div>
	</div>
</div>
<!-- end footer -->

<div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>

<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>tongji();</script>
</body>
</html>
