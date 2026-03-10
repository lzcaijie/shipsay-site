<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$search_url_raw = '';
if (function_exists('ss_search_url')) {
    $tmp_search_url = trim((string)ss_search_url());
    if ($tmp_search_url !== '') {
        $search_url_raw = $tmp_search_url;
    }
}
if ($search_url_raw === '' && !empty($fake_search)) {
    $search_url_raw = trim((string)$fake_search);
}
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$page_end_scripts = "<script>nav_sel('nav_index');</script>";
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404-<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <div class="panel panel-default" style="max-width:720px;margin:30px auto;">
        <div class="panel-heading"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 页面不存在</div>
        <div class="panel-body text-center">
            <p class="text-muted">您访问的页面可能已删除，或地址填写有误。</p>
            <p>
                <a class="btn btn-default" href="<?=$site_home_url_attr?>" rel="nofollow">返回首页</a>
                <a class="btn btn-link" href="javascript:history.back();" rel="nofollow">返回上一页</a>
            </p>
            <form class="form-inline"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?> method="get" style="margin-top:16px;">
                <div class="form-group">
                    <input type="text" name="searchkey" class="form-control" placeholder="搜索书名/作者"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?> required>
                </div>
                <button type="submit" class="btn btn-info"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
            </form>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
