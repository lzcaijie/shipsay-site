
<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
    <title>用户注册</title>
    <?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>

<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <a href="<?=$fake_yongjiushujia?>" class="bookcase" rel="nofollow">书架</a>
    <h1>用户注册</h1>
</div>

<div class="login">
<form name="frmlogin" method="post" action="/register/" onsubmit="return register_check()">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr class="border-bottom">
            <td class="td1">帐号</td><td><input name="username" id="regname" type="text"  size="20" maxlength="30" class="login_name" placeholder="请输入帐号(4-10位英文和数字)" autocomplete="off"></td>
        </tr>
        <tr class="border-bottom">
            <td class="td1">密码</td><td><input id="regpass" size="20" maxlength="30" type="password" name="password"  class="login_name" placeholder="请输入密码(6-20位英文和数字)" autocomplete="off"></td>
        </tr>

        <tr class="border-bottom">
            <td class="td1">重复密码</td><td><input id="repass" size="20" maxlength="30" type="password" name="repassword"  class="login_name" placeholder="再输入一次密码" autocomplete="off"></td>
        </tr>

        <tr class="border-bottom">
            <td class="td1">邮箱</td><td><input name="email" id="regemail" type="text"  size="20" maxlength="40" class="login_name" placeholder="请输入邮箱"></td>
        </tr>
        <tr class="border-bottom" style="margin-bottom: 10px;">
            <td class="td1">验证码</td><td style="display:flex;align-items: center;height: 51px;"><input name="code" id="authcode" type="text"  size="20" maxlength="40" class="login_name" placeholder="请输入验证码"><img id="showcode" src="/static/<?=$theme_dir?>/checkcode.php" id="img" onclick="reloadcode()" width="100" height="30"/></td>
        </tr>
    </table>
    <input type="hidden" name="action" value="register"><input type="hidden" name="jumpurl" value="/bookcase/">

    <!-- <a class='login_btn c_login_button fl-l' href='javascript:;' onclick="register_code();" >确认注册</a> -->
    <button type="submit" class="login_btn c_login_button fl-l" style="border:none; height: 37px; font-size: 16px" name="submit">确认注册</button>
</form>
    <a class="login_btn c_login_button fl-r" href="/login/">已有账号，点击登录</a>
    <div class="cc"></div>
    <div id="logintips" class="login_tips"></div>
</div>
</body>
</html>
