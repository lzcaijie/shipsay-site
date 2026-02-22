<?php
@header('Status: 404 Not Found', true);
@header('HTTP/1.1 404 Not Found');

if (defined('__THEME_DIR__')) {
    $tpl_404 = __THEME_DIR__ . '/tpl_404.php';
    $tpl_err = __THEME_DIR__ . '/tpl_error.php';
    if (is_file($tpl_404)) {
        require $tpl_404;
        exit;
    }
    if (is_file($tpl_err)) {
        require $tpl_err;
        exit;
    }
}

// fallback: minimal 404
echo <<<EOD
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="refresh" content="8; url=/">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 Not Found</title>
<style>
  body{font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,"PingFang SC","Hiragino Sans GB","Microsoft YaHei",sans-serif;margin:0;padding:0;}
  .wrap{max-width:680px;margin:40px auto;padding:0 16px;text-align:center;}
  h1{font-size:28px;margin:0 0 10px;}
  p{color:#666;margin:0 0 20px;}
  a.btn{display:inline-block;padding:10px 18px;border-radius:6px;background:#111;color:#fff;text-decoration:none;}
  form{margin:18px auto 0;display:flex;gap:8px;justify-content:center;flex-wrap:wrap}
  input{padding:10px 12px;border:1px solid #ddd;border-radius:6px;min-width:240px}
  button{padding:10px 14px;border:0;border-radius:6px;background:#2d6cdf;color:#fff}
  small{display:block;margin-top:14px;color:#999}
</style>
</head>
<body>
  <div class="wrap">
    <h1>404 Not Found</h1>
    <p>页面不存在或已被删除。</p>
    <a class="btn" href="/">返回首页</a>
    <form action="/search/" method="get">
      <input type="text" name="searchkey" placeholder="输入书名或作者" required>
      <button type="submit">搜索</button>
    </form>
    <small>8 秒后自动返回首页</small>
  </div>
</body>
</html>
EOD;
exit;
