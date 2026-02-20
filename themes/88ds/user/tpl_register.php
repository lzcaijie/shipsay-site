<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<body>
    <div class="header">
      <div class="back">
        <a href="javascript:history.go(-1);">返回</a>
      </div>
      <h1>注册</h1>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
        <a href="/" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>
	<?php require_once __THEME_DIR__  . '/tpl_search_form.php'; ?>
	<div id="content">
    <form name="frmlogin" method="post" action="/register/" onsubmit="return register_check()">
	<div class="login">
	<p>账号：
	<input type="text" class="login_name" maxlength="30" name="username" id="regname" placeholder="请输入帐号(4-10位英文和数字)" autocomplete="off">
	</p>
	<p>密码：
	<input type="password" class="login_name" maxlength="30" name="password" id="regpass" placeholder="请输入密码(6-20位英文和数字)" autocomplete="off">
	</p>
	<p>确认密码：
	<input class="login_name" id="repass" type="password" name="repassword"  maxlength="30" placeholder="再输入一次密码" autocomplete="off">
	</p>
	<p>邮箱：
	<input class="login_name" name="email" id="regemail" type="text"  maxlength="30" placeholder="请输入邮箱">
	</p>
	<div class="frow">
	<label class="col4 flabel">验证码：</label>
	<div class="col8 last">
	<input type="text" class="textyzm" name="code" id="authcode" placeholder="请输入验证码"><img id="showcode" src="/static/<?=$theme_dir?>/checkcode.php" id="img" onclick="reloadcode()" width="100" height="30"/>
	</div>
	</div>
	
	<input type="hidden" name="action" value="register"><input type="hidden" name="jumpurl" value="/bookcase/">
	<input type="submit" class="login_btn c_login_button" name="submit" value="确认注册">
	<a class="login_btn c_login_button" href="/login/">已有账号，点击登录</a> 
	</div>
	</form>
</div>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>
