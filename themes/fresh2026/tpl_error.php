<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
<?php
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
?>
<main class="wrap" style="padding:18px 10px;">
  <section class="card">
    <div class="card-hd">
      <h2 class="h2">404 页面不存在</h2>
      <a class="more" href="/">返回首页</a>
    </div>
    <div style="padding:10px 0;color:#666;line-height:1.8;">
      你访问的页面可能已删除或地址错误。
    </div>
    <div style="margin:10px 0 14px;">
      <a href="/" style="margin-right:12px;">返回首页</a>
      <a href="javascript:history.back();">返回上一页</a>
    </div>
    <form action="<?=$search_url_safe?>" method="get" style="display:flex;gap:8px;max-width:520px;">
      <input name="searchkey" type="text" placeholder="搜索书名 / 作者" required style="flex:1;padding:10px;">
      <button type="submit" style="padding:10px 16px;">搜索</button>
    </form>
  </section>
</main>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
