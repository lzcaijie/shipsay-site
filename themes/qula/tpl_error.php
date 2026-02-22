<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404-<?=SITE_NAME?></title>
<?php
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search)&&$fake_search)?$fake_search:'/search/');
?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
<div class="container" style="max-width:1200px;margin:0 auto;padding:16px;">
  <h1 style="font-size:20px;margin:10px 0;">页面不存在</h1>
  <p style="opacity:.8;">您访问的页面可能已删除或地址错误。</p>
  <div style="margin:12px 0;">
    <a href="/" rel="nofollow">返回首页</a>
    &nbsp;|&nbsp;<a href="javascript:history.back();" rel="nofollow">返回上一页</a>
  </div>
  <form action="<?=$search_url_safe?>" method="get" style="margin:12px 0;">
    <input type="text" name="searchkey" placeholder="搜索书名/作者" style="padding:8px;width:240px;max-width:80%;" required>
    <button type="submit" style="padding:8px 12px;">搜索</button>
  </form>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
