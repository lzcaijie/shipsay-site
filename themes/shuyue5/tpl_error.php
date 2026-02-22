<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<?php
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
?>
<div class="container" style="padding:18px 10px;">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>404 页面不存在</strong></div>
        <div class="panel-body" style="text-align:center;">
            <p style="color:#666;line-height:1.8;margin:0 0 14px;">你访问的页面可能已删除或地址错误。</p>
            <p style="margin:0 0 14px;">
                <a href="/" class="btn btn-primary" style="margin-right:10px;">返回首页</a>
                <a href="javascript:history.back();" class="btn btn-default">返回上一页</a>
            </p>
            <form method="get" action="<?=$search_url_safe?>" class="form-inline" style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">
                <input name="searchkey" type="text" class="form-control" placeholder="搜索书名 / 作者" required>
                <button type="submit" class="btn btn-info">搜索</button>
            </form>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
