<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
// 变量安全兜底（不改变原展示）
$articlename_safe = isset($articlename) ? $articlename : '';
$intro_des_safe   = isset($intro_des) ? $intro_des : '';
$author_safe      = isset($author) ? $author : '';
$sortname_safe    = isset($sortname) ? $sortname : '';
$isfull_safe      = isset($isfull) ? $isfull : '';
$words_w_safe     = isset($words_w) ? $words_w : '';
$lastupdate_safe  = isset($lastupdate) ? (int)$lastupdate : time();
$lastchapter_safe = isset($lastchapter) ? $lastchapter : '';
$img_url_safe     = isset($img_url) ? $img_url : '';

$author_url_safe  = isset($author_url) ? $author_url : '';
$first_url_safe   = isset($first_url) ? $first_url : '';
$info_url_safe    = isset($info_url) ? $info_url : '';
$last_url_safe    = isset($last_url) ? $last_url : '';

$articleid_safe   = isset($articleid) ? (int)$articleid : 0;
$sortid_safe      = isset($sortid) ? (int)$sortid : 0;

$chapterrows_safe  = (!empty($chapterrows) && is_array($chapterrows)) ? $chapterrows : [];
$langtailrows_safe = (!empty($langtailrows) && is_array($langtailrows)) ? $langtailrows : [];

// 目录页链接兜底
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif ($articleid_safe > 0) {
    $index_url_safe = Url::index_url($articleid_safe);
}

// ✅ 详情页章节只展示前50章
$maxDisplay = 50;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta name="applicable-device" content="pc,mobile">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-title" content="<?=SITE_NAME?>">
<link rel="apple-touch-icon" href="/static/<?=$theme_dir?>/images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/user.js"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
<script>var userlogin = 0;</script>

<style>
    @media screen and (max-width: 768px){.g_header {background-color: rgba(0,0,0,.1);}.g_drop_sel .bhn:hover {background-color: rgba(0,0,0,.1);}}

    /* ✅ 相关小说样式（你之前直接加进去的那块，做轻微规范化） */
    .rel-novel{
        margin: 10px 0 0;
        font-size: 14px;
        line-height: 1.8;
        color: #333;
    }
    .rel-novel a{
        color:#1a73e8;
        text-decoration:none;
        margin-right: 8px;
        white-space: nowrap;
        display: inline-block;
    }
    .rel-novel .rel-title{
        color:#666;
        margin-right: 6px;
    }
</style>
</head>
<body style="zoom: 1;">

<div class="page">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

    <div class="det-hd pt25 mb30">
        <div class="g_wrap">
            <p class="g_bread fs16 c_strong mb30 ell">
                <a href="/" class="fs12 i c_strong"><svg><use xlink:href="#i-bread"></use></svg></a>
                <span class="vam"><a href="/" class="c_strong vam" title="<?=SITE_NAME?>" style=" text-transform: capitalize; "><?=SITE_NAME?></a>/ </span>
                <a href="<?=Sort::ss_sorturl($sortid_safe)?>" class="c_strong vam" title="<?=$sortname_safe?>" style=" text-transform: capitalize; "><?=$sortname_safe?></a>
                <span class="vam"> / <?=$articlename_safe?></span>
            </p>

            <div class="det-info g_row c_strong fs16 pr book-detail-x">
                <img src="<?=$img_url_safe?>" class="book-cover-blur hide" alt="<?=$articlename_safe?>">
                <div class="cover g_col_4">
                    <span class="g_thumb">
                        <img src="<?=$img_url_safe?>" width="300" height="400" alt="<?=$articlename_safe?>" loading="lazy">
                    </span>
                </div>

                <div class="g_col_8 pr">
                    <h1 class="mb15 lh1d2 oh"><?=$articlename_safe?></h1>
                    <p class="mb15 ell _tags pt2">
                        <strong class="mr15 ttl">
                            <svg class="fs20 mr5"><use xlink:href="#i-pen"></use></svg>
                            <span><?=$author_safe?></span>
                        </strong>
                        <strong class="mr15 ttc">
                            <svg class="fs20 mr5"><use xlink:href="#i-others"></use></svg>
                            <span><?=$sortname_safe?></span>
                        </strong>
                        <strong class="mr15 ttc hisp">
                            <svg class="fs20 mr5"><use xlink:href="#i-chapter"></use></svg>
                            <span><?=$isfull_safe?></span>
                        </strong>
                        <strong class="mr15 ttc hisp">
                            <svg class="fs20 mr5"><use xlink:href="#i-all"></use></svg>
                            <span><?=$words_w_safe?>万字</span>
                        </strong>
                    </p>

                    <div class="h112 mb15 det-abt lh1d8 c_strong fs16 hm-scroll">
                        <p><?=$intro_des_safe?><br></p>
                    </div>
                    <div class="_bts pa l0">
                        <a id="j_read" href="<?=$first_url_safe?>" title="立即阅读" class="bt">立即阅读</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="g_wrap det-con pb30 pt20" id="Contents">
        <div class="pb20">
            <div class="cf mb5">
                <h3 class="det-h2 fl">章节目录（显示前50章）</h3>
            </div>
            <p class="fs16 c_strong">
                <span class="vam">最新章节：</span>
                <a class="ell lst-chapter dib vam" href="<?=$last_url_safe?>" title="<?=$lastchapter_safe?>"><?=$lastchapter_safe?></a>
                <small class="c_small ml10 vam ml0"><?=date('Y-m-d', $lastupdate_safe)?></small>
                <label class="rank-chk">
                    <span onclick="javascript:reverse(this);"><svg><use xlink:href="#i-rank-up"></use></svg></span>
                </label>
            </p>
        </div>

        <div class="f_mr fs16 det-con-ol oh">
            <ol class="inline mb20" id="chapterList">
                <?php
                $cnt = 0;
                foreach($chapterrows_safe as $k => $v):
                    if ($cnt >= $maxDisplay) break;
                    $cnt++;
                ?>
                <li class="w33p">
                    <a href="<?=$v['cid_url']?>" title="<?=$articlename_safe?> <?=$v['cname']?>" class="c_strong vam ell db">
                        <span class="vam"><?=$v['cname']?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>

        <?php if(!empty($index_url_safe)): ?>
            <a class="lbxxyx_s fs16" href="<?=$index_url_safe?>">
                查看更多章节<?php if(isset($chapters) && (int)$chapters>0): ?>（共<?=$chapters?>章）<?php endif; ?>
            </a>
        <?php endif; ?>

        <?php if ($is_langtail == 1 && !empty($langtailrows)) : ?>
            <div class="rel-novel">
                <span class="rel-title">相关小说：</span>
                <?php foreach ($langtailrows_safe as $i => $v) : ?>
                    <a href="<?=$v['info_url']?>" title="<?=$v['langname']?>"><?=$v['langname']?></a>
                <?php endforeach ?>
            </div>
        <?php endif; ?>

        <div id="lv-container" data-id="city" data-uid="MTAyMC8zMDYwMy83MTU4" style="padding-top:30px;"></div>
    </div>

    <script type="text/javascript">
    var bookid="<?= isset($sourceid) ? $sourceid : ''?>";
    var isDesc=1;
    function reverse(obj){
        var ol=$("#chapterList");
        var list=ol.children();
        ol.empty();$(obj).text(isDesc?"↓":"↑");
        for(var i=list.length-1;i>=0;i--){
            var copy=list.eq(i).clone();
            ol.append(copy);
        }
        isDesc^=1;
    }
    </script>

    <div class="g_footer">
        <div class="g_row">
            <div class="g_col_9">
                <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
            </div>
        </div>
    </div>

    <div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
    <script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
    <script>tongji();</script>
    <script>
    (function(){
        var bp = document.createElement('script');
        bp.src = "//zz.bdstatic.com/linksubmit/push.js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
    </script>
</div>

</body>
</html>
