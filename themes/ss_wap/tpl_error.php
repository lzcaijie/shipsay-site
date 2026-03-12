<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
<?php
$home_url_raw = function_exists('ss_home_url') ? (string)ss_home_url() : '/';
$home_url_attr = htmlspecialchars($home_url_raw, ENT_QUOTES, 'UTF-8');
?>
<?php ss_render_page_top(['page_title' => '404 页面不存在', 'show_back' => true]); ?>
<div class="s_m">
    <div class="q_top c_big"><p class="c_big_border">404 页面不存在</p></div>
    <div class="cc"></div>
    <p style="color:#666;line-height:1.8;">你访问的页面可能已删除或地址错误。</p>
    <p style="margin:10px 0 14px;">
        <a href="<?=$home_url_attr?>" class="btn">返回首页</a>
        <a href="javascript:history.back();" class="btn" style="margin-left:8px;">返回上一页</a>
    </p>
    <?php ss_render_search_form(['wrapper_class' => 'search', 'method' => 'get']); ?>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
