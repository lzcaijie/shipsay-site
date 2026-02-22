<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>404 - <?=SITE_NAME?></title>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<?php
$search_url_safe = '/search/';
if (function_exists('ss_search_url')) {
    $search_url_safe = ss_search_url();
} elseif (isset($fake_search) && $fake_search) {
    $search_url_safe = $fake_search;
}
?>
<div class="ss-404-wrap" style="max-width:720px;margin:28px auto;padding:0 16px;">
  <div class="ss-404-box" style="background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:10px;padding:18px 16px;">
    <h1 style="margin:0 0 8px;font-size:22px;line-height:1.2;">404 Not Found</h1>
    <p style="margin:0 0 14px;color:#666;">页面不存在或已被删除，你可以返回首页或搜索你要看的书。</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
      <a href="/" style="display:inline-block;padding:10px 14px;border-radius:8px;background:#111;color:#fff;text-decoration:none;">返回首页</a>
      <form action="<?=$search_url_safe?>" method="get" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin:0;">
        <input type="text" name="searchkey" placeholder="输入书名或作者" required
               style="padding:10px 12px;border:1px solid #ddd;border-radius:8px;min-width:220px;outline:none;">
        <button type="submit" style="padding:10px 14px;border:0;border-radius:8px;background:#2d6cdf;color:#fff;">搜索</button>
      </form>
    </div>
  </div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
