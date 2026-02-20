<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>用户登录</title>
<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <a href="<?=$fake_yongjiushujia?>" class="bookcase" rel="nofollow">书架</a>
    <h1>用户登录</h1>
</div>
<div class="login">
<form name="frmlogin" method="post" action="/login/">
    <table  style="margin-bottom: 10px;">
        <tr class="border-bottom">
            <td class="td1">帐号：</td>
            <td><input id="username" type="text" size="20" maxlength="30" class="login_name" name="username" placeholder="请输入帐号"></td>
        </tr>
        <tr class="border-bottom">
            <td class="td1">密码：</td>
            <td><input id="userpass" size="20" maxlength="30" type="password" name="password" class="login_name" placeholder="请输入密码">
            </td>
        </tr>

        <tr class="border-bottom">
            <td class="td1">验证码</td><td style="display:flex;align-items: center;height: 51px;"><input name="code" id="authcode" type="text"  size="20" maxlength="40" class="login_name" placeholder="请输入验证码"><img id="showcode" src="/static/<?=$theme_dir?>/checkcode.php" id="img" onclick="reloadcode()" width="100" height="30"/></td>
        </tr>
    </table>
    <input type="hidden" name="action" value="login"><input type="hidden" name="jumpurl" value="/bookcase/">
    <button type="submit" class="login_btn c_login_button fl-l" style="border:none; height: 37px; font-size: 16px" name="submit">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
 </form> 


    <a class="login_btn c_login_button fl-r" href="/register/">没账号？点击注册</a>
    <div class="cc"></div>
    <div id="logintips" class="login_tips"></div>
</div>
</body>
</html>
