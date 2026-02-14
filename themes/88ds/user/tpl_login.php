<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>用户登录</title>
<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<body>
    <div class="header">
      <div class="back">
        <a href="javascript:history.go(-1);">返回</a>
      </div>
      <h1> 登录</h1>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
        <a href="/" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>
	<?php require_once __THEME_DIR__  . '/tpl_search_form.php'; ?>
	<div id="content">
    <form name="frmlogin" method="post" action="/login/">
	<div class="login">
	<p>账号：
	<input type="text" class="login_name" maxlength="30" name="username" id="username" placeholder="请输入帐号">
	</p>
	<p>密码：
	<input class="login_name" id="userpass" type="password" name="password"  maxlength="30" placeholder="请输入密码">
	</p>
	<div class="frow">
	<label class="col4 flabel">验证码：</label>
	<div class="col8 last">
	<input type="text" class="textyzm" name="code" id="authcode" placeholder="请输入验证码"><img id="showcode" src="/static/<?=$theme_dir?>/checkcode.php" id="img" onclick="reloadcode()" width="100" height="30"/>
	</div>
	</div>
	
	<input type="hidden" name="action" value="login"><input type="hidden" name="jumpurl" value="/bookcase/">
	<input type="submit" class="login_btn c_login_button" name="submit" value="立即登录">
	<a class="login_btn c_login_button" href="/register/">没有账号？点击注册</a> 
	</div>
	</form>
</div>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>
