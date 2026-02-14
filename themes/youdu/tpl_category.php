<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-Hans">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($sortname)):?><?=$sortname?><?php else:?>小说书库<?php endif ?>_书友最值得收藏的网络小说阅读网</title>
<meta name="keywords" content="小说,小说网,最新章节免费阅读小说网,<?=SITE_NAME?>阅读网">
<meta name="description" content="小说,小说网,最新章节免费阅读小说网,<?=SITE_NAME?>阅读网">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="applicable-device" content="pc,mobile" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="renderer" content="webkit">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
</head>
<body style="zoom: 1;">
<?php
$sortcategory_safe = (!empty($sortcategory) && is_array($sortcategory)) ? $sortcategory : [];
$retarr_safe       = (!empty($retarr) && is_array($retarr)) ? $retarr : [];
$sortid_safe       = isset($sortid) ? (int)$sortid : -1;
$sortname_safe     = isset($sortname) ? $sortname : '';
?>
<div class="page">
<!-- start header -->
<?php require_once 'tpl_header.php'; ?>
<!-- end header -->

<div class="lst-hd g_sub_hd pop-lst-hd">
	<div class="g_wrap pr" style="text-transform:capitalize">
		<h1><?php if($sortname_safe != ''):?><?=$sortname_safe?><?php endif ?></h1>
		<span class="_shadow"><?php if($sortname_safe != ''):?><?=$sortname_safe?><?php endif ?></span>

		<p class="lst-nav _tab _slide">
			<a href="/home/" title="全部小说">全部小说</a>
			<?php foreach($sortcategory_safe as $k => $v): ?>
				<a href="<?=$v['sorturl']?>" title="<?=$v['sortname']?>" <?php if($sortid_safe == $k): ?>style="font-weight: 700; color: rgb(0, 0, 0); border-bottom: 1px solid;"<?php endif?>>
					<?=$v['sortname']?>
				</a>
			<?php endforeach ?>
		</p>
	</div>
</div>

<div class="pop-list" id="imgload">
	<ul class="g_row lis-mn j_bookList">
		<?php foreach($retarr_safe as $k => $v): ?>
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
							<svg class="mr5 c_strong"><use xlink:href="#i-author"></use></svg><span><?=$v['author']?></span>
						</strong>
						<strong class="c_small mb5 mr15 ell ttc fs16">
							<svg class="mr5 c_strong"><use xlink:href="#i-others"></use></svg><span><?=$v['sortname_2']?></span>
						</strong>
						<strong class="c_small mb5 mr15 ell ttc fs16">
							<svg class="mr5 c_strong"><use xlink:href="#i-chapter"></use></svg><span><?=$v['isfull']?></span>
						</strong>
					</p>
					<a href="<?=$v['info_url']?>" class="fs16 lh1d5 c_strong oh _p is-truncated"><?=$v['intro_des']?></a>
				</div>
			</li>
		<?php endforeach ?>
	</ul>
</div>
<!-- end list -->
</div>

<script>tj();</script>

<div class="g_footer">
	<div class="g_row">
		<div class="g_col_9">
			<?php require_once 'tpl_footer.php'; ?>
		</div>
	</div>
</div>

<div class="g_goTop _on" style="display: none;">
	<a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a>
</div>

<script type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
</body>
</html>
