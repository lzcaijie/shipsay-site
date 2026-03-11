<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$page_end_scripts = '<script src="/static/' . $theme_dir_attr . '/js/tempbookcase.js?v=' . date('Ymd', time()) . '"></script>'
    . '<script src="/static/' . $theme_dir_attr . '/js/layer.js"></script>'
    . '<script>showtempbooks();nav_sel(\'nav_his\');</script>';
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta name="robots" content="noindex,follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>最近阅读-<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></title>
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li class="active">最近阅读</li>
    </ol>
    <div class="panel panel-default" style="min-height:600px;">
        <div class="panel-heading"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 最近阅读<a class="pull-right" href="javascript:removeall();"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 清空记录</a></div>
        <table class="table" id="tempBookcase"></table>
    </div>
    <div class="clear"></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
