<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta name="robots" content="noindex,follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>最近阅读-<?=SITE_NAME?></title>
    <?php require_once 'tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="/" title="<?=SITE_NAME?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li class="active">最近阅读</li>
    </ol>
    <div class="panel panel-default" style="min-height:600px;">
        <div class="panel-heading"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 最近阅读<a class="pull-right" href="javascript:removeall();"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 清空记录</a></div>
        <table class="table" id="tempBookcase"></table>
    </div>
    <div class="clear"></div>
</div>
<?php require_once 'tpl_footer.php'; ?>
<script src="/static/<?=$theme_dir?>/js/tempbookcase.js?v=<?=date('Ymd', time())?>"></script>
<script>showtempbooks();</script>
<script src="/static/<?=$theme_dir?>/js/layer.js"></script>
<script>nav_sel('nav_his');</script>
