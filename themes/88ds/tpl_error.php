<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<div class="article">
  <h2><span>404 页面不存在</span></h2>
  <div class="block" style="padding:12px;">
    <p style="color:#666;line-height:1.8;margin:0 0 14px;">你访问的页面可能已删除、链接已变更，或当前地址输入有误。</p>
    <p style="margin:0 0 14px;">
      <a href="<?=$site_home_url_attr?>" style="margin-right:12px;">返回首页</a>
      <a href="javascript:history.back();">返回上一页</a>
    </p>
    <form method="get" style="display:flex;gap:8px;max-width:520px;"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
      <input name="searchkey" type="text" placeholder="搜索书名 / 作者" style="flex:1;padding:10px;" required>
      <button type="submit" style="padding:10px 16px;"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
    </form>
  </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
