<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$home_url_attr = htmlspecialchars($home_url_raw, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container error-page">
    <div class="border3 error-page-box">
        <h1 class="error-page-title">404 页面不存在</h1>
        <p class="error-page-desc">你访问的页面可能已删除或地址错误。</p>
        <div class="error-page-actions">
            <a href="<?=$home_url_attr?>" class="error-page-link">返回首页</a>
            <button type="button" class="error-page-link error-page-link-btn" onclick="history.back();">返回上一页</button>
        </div>
        <form class="error-page-search" method="get"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
            <input name="searchkey" type="text" placeholder="搜索书名 / 作者" class="error-page-input" required>
            <button type="submit" class="error-page-submit"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
        </form>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
