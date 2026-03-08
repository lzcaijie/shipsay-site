<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$home_url_attr = htmlspecialchars($home_url_raw, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container" style="padding:18px 10px;">
    <div class="section link" style="text-align:center;">
        <p class="title"><i class="fa fa-warning">&nbsp;</i>404 页面不存在</p>
        <p style="color:#666;line-height:1.8;margin:0 0 14px;">你访问的页面可能已删除或地址错误。</p>
        <p style="margin:0 0 14px;">
            <a href="<?=$home_url_attr?>" style="margin-right:12px;">返回首页</a>
            <a href="javascript:history.back();">返回上一页</a>
        </p>
        <form method="get" action="<?=$search_url_attr?>" style="max-width:520px;margin:0 auto;display:flex;gap:8px;">
            <input name="searchkey" type="text" placeholder="搜索书名 / 作者" style="flex:1;padding:10px;" required>
            <button type="submit" style="padding:10px 16px;">搜索</button>
        </form>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
