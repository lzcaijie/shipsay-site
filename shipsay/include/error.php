<?php
// Theme-aware 404 page
@header('Status: 404 Not Found', true);
@header('HTTP/1.1 404 Not Found');

// Prefer per-theme template (tpl_404.php or tpl_error.php)
$theme_base = '';
if (defined('__THEME_DIR__')) {
    $theme_base = __THEME_DIR__;
} elseif (defined('__ROOT_DIR__') && isset($theme_dir) && $theme_dir) {
    $theme_base = __ROOT_DIR__ . '/themes/' . $theme_dir;
}

if ($theme_base) {
    $candidates = [
        $theme_base . '/tpl_404.php',
        $theme_base . '/tpl_error.php',
    ];
    foreach ($candidates as $f) {
        if (is_file($f)) {
            require $f;
            exit;
        }
    }
}

// Fallback: optimized default error page (with home + search)
$site_name = defined('SITE_NAME') ? SITE_NAME : '网站';
$search_url = '/search/';
if (function_exists('ss_search_url')) {
    $search_url = ss_search_url();
} elseif (isset($fake_search) && $fake_search) {
    $search_url = $fake_search;
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>404 - 页面不存在 - <?=$site_name?></title>
<style>
    body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"PingFang SC","Microsoft YaHei",sans-serif;background:#f7f7f7;color:#222;}
    .wrap{max-width:680px;margin:0 auto;padding:40px 16px;}
    .card{background:#fff;border-radius:12px;padding:28px 18px;box-shadow:0 6px 20px rgba(0,0,0,.06);text-align:center;}
    h1{margin:0 0 10px;font-size:28px;}
    p{margin:0 0 16px;color:#666;line-height:1.6;}
    .actions{margin:18px 0 18px;display:flex;gap:10px;justify-content:center;flex-wrap:wrap;}
    .btn{display:inline-block;padding:10px 14px;border-radius:10px;text-decoration:none;border:1px solid #ddd;background:#fff;color:#222;}
    .btn.primary{background:#1677ff;border-color:#1677ff;color:#fff;}
    form{margin:0 auto;max-width:520px;display:flex;gap:8px;}
    input{flex:1;padding:10px 12px;border:1px solid #ddd;border-radius:10px;outline:none;}
    button{padding:10px 14px;border:1px solid #1677ff;background:#1677ff;color:#fff;border-radius:10px;cursor:pointer;}
    .small{margin-top:14px;color:#999;font-size:13px;}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <h1>404 页面不存在</h1>
    <p>你访问的页面可能已删除、地址输入错误，或暂时不可用。</p>
    <div class="actions">
      <a class="btn primary" href="/">返回首页</a>
      <a class="btn" href="javascript:history.back();">返回上一页</a>
    </div>
    <form action="<?=$search_url?>" method="get">
      <input type="text" name="searchkey" placeholder="搜索书名 / 作者" required>
      <button type="submit">搜索</button>
    </form>
    <div class="small">如果你认为这是系统错误，可以刷新重试。</div>
  </div>
</div>
</body>
</html>
<?php exit; ?>
