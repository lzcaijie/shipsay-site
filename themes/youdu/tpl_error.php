<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/index.css">
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
</head>
<body>
<?php
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="g_wrap hom-gutter" style="padding-top:18px;">
  <div class="hom-bd">
    <h2 class="hom-h1">404 页面不存在</h2>
    <p style="color:#666;line-height:1.8;margin:0 0 14px;">你访问的页面可能已删除或地址错误。</p>
    <p style="margin:0 0 14px;">
      <a href="/" style="margin-right:12px;">返回首页</a>
      <a href="javascript:history.back();">返回上一页</a>
    </p>
    <form action="<?=$search_url_safe?>" method="get" style="display:flex;gap:8px;max-width:520px;">
      <input name="searchkey" type="text" placeholder="搜索书名 / 作者" required style="flex:1;padding:10px;">
      <button type="submit" style="padding:10px 16px;">搜索</button>
    </form>
  </div>
</div>

<div class="g_footer">
  <div class="g_row">
    <div class="g_col_9">
      <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
    </div>
  </div>
</div>
</body>
</html>
