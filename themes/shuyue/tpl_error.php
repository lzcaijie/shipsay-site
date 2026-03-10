<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404-<?=SITE_NAME?></title>
<?php
$search_url_safe = '';
if (function_exists('ss_search_url')) {
    $tmp_search_url = trim((string)ss_search_url());
    if ($tmp_search_url !== '') {
        $search_url_safe = $tmp_search_url;
    }
}
if ($search_url_safe === '' && isset($fake_search) && trim((string)$fake_search) !== '') {
    $search_url_safe = trim((string)$fake_search);
}
?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container" style="max-width:1200px;margin:0 auto;padding:16px;">
  <h1 style="font-size:20px;margin:10px 0;">页面不存在</h1>
  <p style="opacity:.8;">您访问的页面可能已删除或地址错误。</p>
  <div style="margin:12px 0;">
    <a href="/" rel="nofollow">返回首页</a>
    &nbsp;|&nbsp;<a href="javascript:history.back();" rel="nofollow">返回上一页</a>
  </div>
  <form<?php if($search_url_safe !== ''): ?> action="<?=$search_url_safe?>"<?php endif; ?> method="get" style="margin:12px 0;"<?php if($search_url_safe === ''): ?> onsubmit="return false;"<?php endif; ?>>
    <input type="text" name="searchkey" placeholder="搜索书名/作者" style="padding:8px;width:240px;max-width:80%;"<?php if($search_url_safe === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?> required>
    <button type="submit" style="padding:8px 12px;"<?php if($search_url_safe === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
  </form>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
