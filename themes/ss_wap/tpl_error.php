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
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : '';
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
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
        <form name="search" action="<?=$search_url_attr?>" method="get"<?php if ($search_url_raw === ''): ?> onsubmit="return false;"<?php endif; ?>>
            <input type="text" placeholder="搜索书名/作者" value="" name="searchkey" class="search" autocomplete="on" required>
            <button type="submit"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜 索</button>
        </form>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
