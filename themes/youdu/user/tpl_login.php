<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>用户登录</title>
<?php $page_title="登录"; require_once __THEME_DIR__  . '/tpl_header.php'; ?>
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
        text-align:center;
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
<form name="frmlogin" method="post" action="/login/">
    <table>
        <tr>
            <td class="td1">帐&nbsp;&nbsp;&nbsp号：</td>
            <td class="td2"><input id="username" type="text" name="username" placeholder="请输入帐号"></td>
        </tr>
        <tr>
            <td class="td1">密&nbsp&nbsp;&nbsp;码：</td>
            <td class="td2"><input id="userpass" type="password" name="password" placeholder="请输入密码">
            </td>
        </tr>

        <!-- <tr>
            <td class="td1">验证码：</td>
            <td class="td2">
                <input name="code" id="authcode" type="text" placeholder="请输入验证码">
            </td>
        </tr> -->
    </table>
    <!-- <div class="tc"><img id="showcode" src="/static/<?=$theme_dir?>/checkcode.php" id="img" onclick="reloadcode()" width="100" height="30"/></div> -->

    <input type="hidden" name="action" value="login"><input type="hidden" name="jumpurl" value="/bookcase/">
    <div class="tc"><button type="submit" class="loginb" name="submit">登&nbsp;&nbsp;&nbsp;&nbsp;录</button></div>
 </form> 
    <div class="tc"><br/><a class="read-btn" href="/register/">没账号？注册</a></div>
</div>
<script>reloadcode();</script>
</body>
</html>
