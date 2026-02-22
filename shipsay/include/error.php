<?php
http_response_code(404);
header('Content-Type: text/html; charset=utf-8');

$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search)&&$fake_search)?$fake_search:'/search/');

// 1) 优先主题自定义 404
if (defined('__THEME_DIR__')) {
    $candidates = [__THEME_DIR__ . '/tpl_error.php', __THEME_DIR__ . '/tpl_404.php'];
    foreach ($candidates as $f) {
        if (is_file($f)) { require $f; exit; }
    }
    // 2) 若主题没提供 tpl_error，则尽量用主题头尾输出（保证有 CSS）
    if (is_file(__THEME_DIR__ . '/tpl_header.php') && is_file(__THEME_DIR__ . '/tpl_footer.php')) {
        ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404-<?=defined('SITE_NAME')?SITE_NAME:'404'?></title>
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
<?php
        exit;
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>404</title>
<style>body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial;max-width:800px;margin:30px auto;padding:0 16px;line-height:1.6}a{color:#06c;text-decoration:none}a:hover{text-decoration:underline}</style>
</head><body>
<h1>页面不存在 (404)</h1>
<p>您访问的页面可能已删除或地址错误。</p>
<p><a href="/">返回首页</a> | <a href="javascript:history.back();">返回上一页</a></p>
<form action="<?=$search_url_safe?>" method="get">
  <input type="text" name="searchkey" placeholder="搜索书名/作者" required>
  <button type="submit">搜索</button>
</form>
</body></html>
