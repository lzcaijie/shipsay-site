<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="renderer" content="webkit|ie-comp|ie-stand" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>用户登录_笔趣阁</title>
<meta name="applicable-device" content="pc,mobile">
<?php $page_title="新用户注册"; require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<link rel="stylesheet" href="/static/biquge/user.css">
<script src="/static/biquge/user.js"></script>
<div id="main" class="main-height  container flex-wrap section-bottom mb20">
<div class="hotcontent">
<div class="l login">
<h2>会员登录<a href="/register/" style="float: right;margin-right: .5rem;">没有账号？点击注册</a></h2>
<form name="frmlogin" method="post" action="/login/">
<div class="form-group">
<div class="form-title">账号：</div>
<div class="form-content">
<td class="td2"><input id="username" type="text" name="username" placeholder="请输入帐号"></td>
</div>
</div>
<div class="form-group">
<div class="form-title">密码：</div>
<div class="form-content">
<input id="userpass" type="password" name="password" placeholder="请输入密码">
<input type="hidden" name="action" value="login"><input type="hidden" name="jumpurl" value="/bookcase/">
</div>
</div>
<div class="form-submit">
<button type="submit" class="loginb" name="submit">登&nbsp;&nbsp;&nbsp;&nbsp;录</button></div>
</form>
</div>
</div>
</div>
</div>
<script>reloadcode();</script>
<script>topdom();$('nav a:first-child').addClass('orange');</script>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>