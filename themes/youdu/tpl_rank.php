<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html>
<head>
<?php
$page_title_safe = isset($page_title) ? (string)$page_title : '排行榜';
$query_safe = isset($query) ? strtolower((string)$query) : '';
$articlerows_safe = (!empty($articlerows) && is_array($articlerows)) ? $articlerows : [];
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_detail_base_safe = isset($rank_detail_base) && $rank_detail_base ? (string)$rank_detail_base : '';
$rank_tabs = [
    'allvisit' => '总排行榜',
    'monthvisit' => '月排行榜',
    'weekvisit' => '周排行榜',
    'dayvisit' => '日排行榜',
    'allvote' => '总推荐榜',
    'monthvote' => '月推荐榜',
    'weekvote' => '周推荐榜',
    'dayvote' => '日推荐榜',
    'goodnum' => '收藏榜',
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
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
<script async type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
</head>
<body style="zoom: 1;">
<div class="page">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

    <div class="lst-hd g_sub_hd pop-lst-hd">
        <div class="g_wrap pr" style="text-transform:capitalize">
            <h1><?=$page_title_safe?></h1>
            <span class="_shadow"><?=$page_title_safe?></span>
            <p class="lst-nav _tab _slide">
                <?php foreach ($rank_tabs as $tab_key => $tab_title): ?>
                    <?php $tab_url = $rank_detail_base_safe !== '' ? $rank_detail_base_safe . $tab_key . '/' : 'javascript:;'; ?>
                    <a href="<?=$tab_url?>"<?php if ($query_safe === $tab_key): ?> style="font-weight:700;color:#000;border-bottom:1px solid;"<?php endif; ?>><?=$tab_title?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>

    <div class="pop-list" id="imgload">
        <ul class="g_row lis-mn j_bookList">
            <?php foreach ($articlerows_safe as $k => $v): ?><?php if ($k < 30): ?>
                <li class="g_col_6">
                    <div class="lst-item pr lh1d5">
                        <a class="c_strong" href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
                            <i class="g_thumb pa l0 oh">
                                <img _src="<?=$v['img_url']?>" width="140" height="186" alt="<?=$v['articlename']?>" src="<?=$v['img_url']?>" style="display:inline;">
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
            <?php endif; ?><?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="g_footer">
    <div class="g_row">
        <div class="g_col_9"><?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?></div>
    </div>
</div>
<div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
<script async type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>tongji();</script>
</body>
</html>
