<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$articlename_safe = isset($articlename) ? $articlename : '';
$info_url_safe    = isset($info_url) ? $info_url : '';
$pid_safe         = isset($pid) ? (int)$pid : 1;

$list_arr_safe    = (!empty($list_arr) && is_array($list_arr)) ? $list_arr : [];
$htmltitle_safe   = isset($htmltitle) ? $htmltitle : '';

$articleid_safe   = isset($articleid) ? (int)$articleid : 0;
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif ($articleid_safe > 0) {
    $index_url_safe = Url::index_url($articleid_safe);
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta name="applicable-device" content="pc,mobile">
<title>《<?=$articlename_safe?>》章节目录_第<?=$pid_safe?>页_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$articlename_safe?>,章节目录,第<?=$pid_safe?>页" />
<meta name="description" content="《<?=$articlename_safe?>》章节目录，第<?=$pid_safe?>页，最新章节免费阅读。" />

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
    /* ✅ 修复原始目录页“错乱”的核心：用 flex 做章节网格，避免 float/inline 在不同屏幕断行错位 */
    .idx-wrap{padding-bottom: 20px;}
    .idx-head{margin: 15px auto 10px;}
    .idx-title{font-size: 18px; font-weight: 700;}
    .idx-back{display:inline-block; margin-top: 8px; font-size: 14px;}
    .idx-back a{color:#1a73e8; text-decoration:none;}

    .idx-chapters{margin-top: 10px;}
    .idx-grid{display:flex; flex-wrap:wrap; margin:0; padding:0; list-style:none;}
    .idx-grid li{width:33.3333%; padding:10px 10px 8px; box-sizing:border-box; border-top:1px solid rgba(0,0,0,.06);}
    .idx-grid li a{display:block; color:#222; text-decoration:none; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
    .idx-grid li a:hover{color:#1a73e8;}

    /* 适配小屏：两列/一列，避免挤压导致“错乱” */
    @media (max-width: 900px){
        .idx-grid li{width:50%;}
    }
    @media (max-width: 520px){
        .idx-grid li{width:100%;}
    }

    /* 分页块（你后台输出的 $htmltitle / $jump_html_wap）保持居中且不挤压 */
    .idx-page{margin-top: 12px;}
    .idx-page *{max-width:100%;}
</style>
</head>

<body style="zoom: 1;">

<div class="page">
    <?php require_once 'tpl_header.php'; ?>

    <div class="g_wrap idx-wrap">
        <div class="idx-head">
            <div class="idx-title">章节目录（第<?=$pid_safe?>页）</div>
            <div class="idx-back">
                <a href="<?=$info_url_safe?>">返回《<?=$articlename_safe?>》详情</a>
                <?php if(!empty($index_url_safe) && $index_url_safe != $info_url_safe): ?>
                    &nbsp;|&nbsp;<a href="<?=$index_url_safe?>">目录首页</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="idx-chapters">
            <ul class="idx-grid" id="chapterList">
                <?php foreach($list_arr_safe as $k => $v): ?>
                    <li>
                        <a href="<?=$v['cid_url']?>" title="<?=$v['cname']?>"><?=$v['cname']?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if($htmltitle_safe !== ''): ?>
            <div class="idx-page"><?=$htmltitle_safe?></div>
        <?php endif; ?>
    </div>

    <div class="g_footer">
        <div class="g_row">
            <div class="g_col_9">
                <?php require_once 'tpl_footer.php'; ?>
            </div>
        </div>
    </div>

    <div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
    <script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
    <script>tongji();</script>
</div>

</body>
</html>
