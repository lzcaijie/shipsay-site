<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title>用户注册_笔趣阁</title>
<?php $page_title="新用户注册"; require_once __THEME_DIR__  . '/tpl_header.php'; ?>
</nav>
<link rel="stylesheet" href="/static/biquge/user.css">
<script src="/static/2025/vendor/jquery.cookie.min.js"></script>
<script src="/static/biquge/user.js"></script>
<div id="main" class="main-height  container flex-wrap section-bottom mb20">
<div class="hotcontent">
<div class="l login">
<h2>用户注册<a href="/login/" style="float: right;margin-right: .5rem;">已有账号？点击登录</a></h2>
<form name="frmlogin" method="post" action="/register/" onsubmit="return register_check()">
<div class="form-group">
<div class="form-title">账号：</div>
<div class="form-content">
<input name="username" id="regname" type="text" class="login_name" placeholder="请输入帐号(4-10位英文和数字)" autocomplete="off"></div>
</div>
<div class="form-group">
<div class="form-title">密码：</div>
<div class="form-content"><input id="regpass" type="password" name="password" class="login_name" placeholder="请输入密码(6-20位英文和数字)" autocomplete="off"> </div></div>
<div class="form-group">
<div class="form-title">重复：</div>
<div class="form-content"><input id="repass" type="password" name="repassword" class="login_name" placeholder="再输入一次密码" autocomplete="off"></div>
</div>
<div class="form-group">
<div class="form-title">邮箱：</div>
<div class="form-content"><input name="email" id="regemail" type="text" size="20" maxlength="40" class="login_name" placeholder="请输入邮箱"></div>
</tr>

</table>

<input type="hidden" name="action" value="register"><input type="hidden" name="jumpurl" value="/bookcase/">
</div>
<div class="form-submit">
<div class="tc"><button type="submit" class="loginb" name="submit">确认注册</button></div>
</form>
<div style="height:250px;"></div>
</div>
</div>
</div>
<script>reloadcode();</script>
<script>topdom();$('nav a:first-child').addClass('orange');</script>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>