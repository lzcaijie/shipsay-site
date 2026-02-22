<?php
http_response_code(404);
header('Content-Type: text/html; charset=utf-8');
if (defined('__THEME_DIR__')) {
    $candidates = [__THEME_DIR__ . '/tpl_error.php', __THEME_DIR__ . '/tpl_404.php'];
    foreach ($candidates as $f) {
        if (is_file($f)) { require $f; exit; }
    }
}
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search)&&$fake_search)?$fake_search:'/search/');
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
