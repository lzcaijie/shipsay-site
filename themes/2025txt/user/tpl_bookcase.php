<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title>永久书架_<?=SITE_NAME?></title>

<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<link rel="stylesheet" href="/static/biquge/user.css">
<article id="main" class="main-height  container flex-wrap section-bottom mb20">
<div class="hotcontent">
<div class="l rank">
<h2>会员书架<a href="/logout/" onclick="return confirm('确定要退出吗？')" style="float: right;margin-right: .5rem;">退出登录</a></h2>
</div>
</div>
</article>
<div class="container">
<div class="footer gray">
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>