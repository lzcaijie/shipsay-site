<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
<?php
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
?>
<div class="s_m">
    <div class="q_top c_big"><p class="c_big_border">404 页面不存在</p></div>
    <div class="cc"></div>
    <p style="color:#666;line-height:1.8;">你访问的页面可能已删除或地址错误。</p>
    <p style="margin:10px 0 14px;">
        <a href="/" class="btn">返回首页</a>
        <a href="javascript:history.back();" class="btn" style="margin-left:8px;">返回上一页</a>
    </p>
    <div class="search" style="margin-top:12px;">
        <form name="search" action="<?=$search_url_safe?>" method="get">
            <input type="text" placeholder="搜索书名/作者" value="" name="searchkey" class="search" autocomplete="on" required>
            <button type="submit">搜 索</button>
        </form>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
