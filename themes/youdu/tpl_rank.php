<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html>
<head>
<?php
$page_title_safe = isset($page_title) ? $page_title : '排行榜';
$query_safe      = isset($query) ? $query : '';
$articlerows_safe = (!empty($articlerows) && is_array($articlerows)) ? $articlerows : [];
?>
<title><?=$page_title_safe?>_全部小说书籍_热门排名榜 - <?=SITE_NAME?></title>
<meta name="keywords" content="全部小说排名,全部小说排行榜">
<meta name="description" content="全部小说排名，全部小说排行榜，全部小说榜单书籍均可免费在线阅读。">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="applicable-device" content="pc,mobile">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-title" content="<?=SITE_NAME?>">
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
    <?php require_once 'tpl_header.php'; ?>
    <!-- end header -->

    <div class="lst-hd g_sub_hd pop-lst-hd">
        <div class="g_wrap pr" style="text-transform:capitalize">
            <h1><?=$page_title_safe?></h1>
            <span class="_shadow"><?=$page_title_safe?></span>
            <p class="lst-nav _tab _slide">
                <a href="/rank/allvisit/"<?php if($query_safe == 'allvisit'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>总排行榜</a>
                <a href="/rank/monthvisit/"<?php if($query_safe =='monthvisit'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>月排行榜</a>
                <a href="/rank/weekvisit/"<?php if($query_safe =='weekvisit'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>周排行榜</a>
                <a href="/rank/dayvisit/"<?php if($query_safe =='dayvisit'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>日排行榜</a>
                <a href="/rank/allvote/"<?php if($query_safe =='allvote'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>总推荐榜</a>
                <a href="/rank/monthvote/"<?php if($query_safe =='monthvote'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>月推荐榜</a>
                <a href="/rank/weekvote/"<?php if($query_safe =='weekvote'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>周推荐榜</a>
                <a href="/rank/dayvote/"<?php if($query_safe =='dayvote'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>日推荐榜</a>
                <a href="/rank/goodnum/"<?php if($query_safe =='goodnum'):?> style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>收藏榜</a>
            </p>
        </div>
    </div>

    <div class="pop-list" id="imgload">
        <ul class="g_row lis-mn j_bookList">
            <?php foreach($articlerows_safe as $k => $v): ?><?php if($k < 30):?>
                <li class="g_col_6">
                    <div class="lst-item pr lh1d5">
                        <a class="c_strong" href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
                            <i class="g_thumb pa l0 oh">
                                <img _src="<?=$v['img_url']?>" width="140" height="186" alt="<?=$v['articlename']?>" src="<?=$v['img_url']?>" style="display: inline;">
                            </i>
                            <h2 class="mb5 fs20 f_mbo pt5 oh" style="word-wrap: break-word;"><?=$v['articlename']?></h2>
                        </a>
                        <p class="mb5 ell _tags pt2">
                            <strong class="c_small mb5 mr15 ell ttc fs16">
                                <svg class="mr5 c_strong"><use xlink:href="#i-pen"></use></svg><span><?=$v['author']?></span>
                            </strong>
                            <strong class="c_small mb5 mr15 ell ttc fs16">
                                <svg class="mr5 c_strong"><use xlink:href="#i-others"></use></svg><span><?=$v['sortname_2']?></span>
                            </strong>
                        </p>
                        <a href="<?=$v['info_url']?>" class="fs16 lh1d5 c_strong oh _p is-truncated" title="<?=$v['intro_des']?>"><?=$v['intro_des']?></a>
                    </div>
                </li>
            <?php endif ?><?php endforeach ?>
        </ul>
    </div>
    <!-- end list -->
</div>

<script>
    $("#pagelink a").attr("style","width:30px");
</script>

<!-- start footer -->
<div class="g_footer">
	<div class="g_row">
		<div class="g_col_9">
			 <?php require_once 'tpl_footer.php'; ?>
		</div>
	</div>
</div>
<!-- end footer -->
<div class="g_goTop _on" style=""><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>tongji();</script>
</body>
</html>
