<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$home_url_attr = htmlspecialchars($home_url_raw, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20251207" />
</head>
<body>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container autoheight">
  <div class="list-history">
    <div class="title"><h2>页面不存在</h2><span>404</span></div>
    <div class="other" style="margin-top:1rem;">
      <p style="margin-bottom:12px;">您访问的页面可能已删除或地址错误。</p>
      <p style="margin-bottom:12px;">
        <a href="<?=$home_url_attr?>" rel="nofollow">返回首页</a>
        &nbsp;|&nbsp;<a href="javascript:history.back();" rel="nofollow">返回上一页</a>
      </p>
      <form method="get"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
        <input type="text" name="searchkey" placeholder="搜索书名/作者" style="padding:8px;width:240px;max-width:80%;" required>
        <button type="submit" style="padding:8px 12px;"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
      </form>
    </div>
  </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
