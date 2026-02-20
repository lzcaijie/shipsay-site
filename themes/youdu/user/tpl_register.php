
<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
    <title>用户注册</title>
    <?php $page_title="新用户注册"; require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir?>/user.js"></script>

<style>
    img{
        height: unset;
        width: unset;
        margin-bottom: 20px;
    }
    table{width: 350px; margin: 0 auto;}

    td{height: 35px; line-height: 35px;}
    tr{margin: 5px 0;}
    .td1{
        width: 25%;
        text-align: right;
        display: inline-block;
        margin: 5px 0;

    }
    .td2{
        width: 70%;
        text-align: left;
        display: inline-block;
    }
    input{
        width: 100%;
        height: 100%;
        text-indent: 2px;
    }
    .tc{
        text-align: center;
    }
    .loginb {
        background-color: #75a4b4;
        padding: 5px 20px;
        color: #fff;
        border: 1px solid #5F91A2;
        border-bottom-width: 2px;
        font-weight: bold;
    }
</style>

<body>


<div class="container margin-header">

<form name="frmlogin" method="post" action="/register/" onsubmit="return register_check()">
    <table>
        <tr>
            <td class="td1">帐&nbsp;&nbsp;&nbsp;号：</td>
            <td class="td2"><input name="username" id="regname" type="text"  class="login_name" placeholder="请输入帐号(4-10位英文和数字)" autocomplete="off"></td>
        </tr>
        <tr>
            <td class="td1">密&nbsp;&nbsp;&nbsp;码：</td>
            <td class="td2"><input id="regpass" type="password" name="password"  class="login_name" placeholder="请输入密码(6-20位英文和数字)" autocomplete="off"></td>
        </tr>

        <tr>
            <td class="td1">重&nbsp;&nbsp;&nbsp;复：</td>
            <td class="td2"><input id="repass" type="password" name="repassword"  class="login_name" placeholder="再输入一次密码" autocomplete="off"></td>
        </tr>

        <tr>
            <td class="td1">邮&nbsp;&nbsp;&nbsp;箱：</td>
            <td class="td2"><input name="email" id="regemail" type="text"  size="20" maxlength="40" class="login_name" placeholder="请输入邮箱"></td>
        </tr>
        <!-- <tr style="margin-bottom: 10px;">
            <td class="td1">验证码：</td>
            <td class="td2"><input name="code" id="authcode" type="text" placeholder="请输入验证码"></td>
        </tr> -->
    </table>
    <!-- <div class="tc"><img id="showcode" src="/static/<?=$theme_dir?>/checkcode.php" id="img" onclick="reloadcode()" width="100" height="30"/></div> -->
    <input type="hidden" name="action" value="register"><input type="hidden" name="jumpurl" value="/bookcase/">

    <div class="tc"><button type="submit" class="loginb" name="submit">确认注册</button></div>
</form>
    <div class="tc"><br/><a class="read-btn" href="/login/">有账号？登录</a></div>
</div>
<script>reloadcode();</script>
</body>
</html>

