<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta name="robots" content="noindex,follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>用户注册-<?=SITE_NAME?></title>
    <?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<div class="container body-content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 用户注册
                    <a href="/login/" class="pull-right"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 已有用户？立即登录</a></div>
                <div class="panel-body">
                    <form class="form-horizontal" name="frmlogin" method="post" action="/register/" onsubmit="return register_check()">
                        <div class="form-group mt10">
                            <label class="col-md-3 control-label">帐&nbsp;&nbsp;&nbsp;号：</label>
                            <div class="col-md-9">
                                <input name="username" id="regname" type="text" class="form-control" placeholder="请输入帐号(4-10位英文和数字)" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group mt20">
                            <label class="col-md-3 control-label">密&nbsp;&nbsp;&nbsp;码：</label>
                            <div class="col-md-9">
                                <input id="regpass" type="password" name="password" class="form-control" placeholder="请输入密码(6-20位英文和数字)" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group mt20">
                            <label class="col-md-3 control-label">重&nbsp;&nbsp;&nbsp;复：</label>
                            <div class="col-md-9">
                                <input id="repass" type="password" name="repassword" class="form-control" placeholder="请再次输入密码" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group mt10">
                            <label class="col-md-3 control-label">邮&nbsp;&nbsp;&nbsp;箱：</label>
                            <div class="col-md-9">
                                <input name="email" id="regemail" type="text" size="20" maxlength="40" class="form-control" placeholder="请输入邮箱">
                            </div>
                        </div>
                        <div class="form-group mt20">
                            <label class="col-md-3 control-label">验证码：</label>
                            <div class="col-md-4">
                                <input name="code" id="authcode" type="text" size="10" maxlength="10" class="form-control" placeholder="请输入验证码">
                            </div>
                            <div class="col-md-5">
                                <img id="showcode" src="/static/<?=$theme_dir?>/checkcode.php" id="img" onclick="reloadcode()" width="100" height="30"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
<!--                                <input type="hidden" name="act" value="newuser" />-->
                                <input type="hidden" name="action" value="register">
                                <input type="hidden" name="jumpurl" value="/bookcase/">
                                <button type="submit" class="btn btn-primary" name="submit">立即注册</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>
<script src="/static/<?=$theme_dir?>/js/user.js"></script>
<script src="/static/<?=$theme_dir?>/js/layer.js"></script>
