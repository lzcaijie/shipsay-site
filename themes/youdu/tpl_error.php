<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('error');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = '页面不存在_' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = '您访问的页面不存在，您可以返回首页或使用站内搜索继续查找。';
}
$site_home_url_safe = !empty($site_url) ? (string)$site_url : '/';
$search_url_safe = '';
if (function_exists('ss_search_url')) {
    $search_url_safe = (string)ss_search_url();
}
if ($search_url_safe === '' && isset($fake_search) && $fake_search) {
    $search_url_safe = (string)$fake_search;
}
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta name="applicable-device" content="pc,mobile">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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

    <div class="g_wrap" style="padding:24px 0 36px;">
        <div class="box" style="max-width:760px; margin:0 auto; background:#fff; padding:24px; border-radius:10px;">
            <h1 style="font-size:24px; margin-bottom:12px; color:#222;">页面不存在</h1>
            <p style="font-size:16px; line-height:1.8; color:#666; margin-bottom:16px;">您访问的页面可能已删除、链接失效，或者地址输入错误。</p>
            <div style="margin-bottom:18px; font-size:15px;">
                <a href="<?=$site_home_url_safe?>" rel="nofollow">返回首页</a>
                &nbsp;|&nbsp;
                <a href="javascript:history.back();" rel="nofollow">返回上一页</a>
            </div>
            <form<?php if ($search_url_safe !== ''): ?> action="<?=$search_url_safe?>" method="post"<?php else: ?> action="javascript:;" onsubmit="return false;"<?php endif; ?> style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <input type="text" name="searchkey" placeholder="搜索书名/作者" style="padding:10px 12px; width:260px; max-width:100%; border:1px solid #ddd; border-radius:6px;"<?php if ($search_url_safe === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>
                <input type="hidden" name="searchtype" value="all">
                <button type="submit"<?php if ($search_url_safe === ''): ?> disabled="disabled" aria-disabled="true" style="padding:10px 16px; border:0; border-radius:6px; background:#bbb; color:#fff;"<?php else: ?> style="padding:10px 16px; border:0; border-radius:6px; background:#5e8e9e; color:#fff; cursor:pointer;"<?php endif; ?>>搜索</button>
            </form>
        </div>
    </div>

    <div class="g_footer">
        <div class="g_row">
            <div class="g_col_9"><?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?></div>
        </div>
    </div>
</div>
<div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
<script async type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>tongji();</script>
</body>
</html>
