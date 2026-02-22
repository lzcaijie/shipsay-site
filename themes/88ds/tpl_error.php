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
<div class="article">
  <h2><span>404 页面不存在</span></h2>
  <div class="block" style="padding:12px;">
    <p style="color:#666;line-height:1.8;margin:0 0 14px;">你访问的页面可能已删除或地址错误。</p>
    <p style="margin:0 0 14px;">
      <a href="/" style="margin-right:12px;">返回首页</a>
      <a href="javascript:history.back();">返回上一页</a>
    </p>
    <form action="<?=$search_url_safe?>" method="get" style="display:flex;gap:8px;max-width:520px;">
      <input name="searchkey" type="text" placeholder="搜索书名 / 作者" style="flex:1;padding:10px;" required>
      <button type="submit" style="padding:10px 16px;">搜索</button>
    </form>
  </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
