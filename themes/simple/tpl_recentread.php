<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$recentread_page_title = '阅读记录_' . SITE_NAME;
$recentread_page_title_html = htmlspecialchars($recentread_page_title, ENT_QUOTES, 'UTF-8');
$recentread_page_description = SITE_NAME . '阅读记录页面。';
$recentread_page_description_html = htmlspecialchars($recentread_page_description, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$recentread_page_title_html?></title>
<meta name="description" content="<?=$recentread_page_description_html?>">
<?php require_once 'tpl_header.php'; ?>

<div class="container">
    <div class="content book">
        <ol class="breadcrumb">
            <li><a href="<?=$site_home_url_attr?>">首页</a></li>
            <li class="active">阅读记录</li>
        </ol>
        <h2 class="text-center">阅读记录</h2>
        <div id="tempBookcase"></div>
    </div>
</div>

<script src="/static/<?=$theme_dir_attr?>/tempbookcase.js"></script>
<script>showtempbooks();</script>

<?php require_once 'tpl_footer.php'; ?>
