<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta name="robots" content="noindex,follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>用户登录-<?=SITE_NAME?></title>
    <?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<div class="container body-content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 用户登录
                    <a href="/register/" class="pull-right"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 新用户注册</a></div>
                <div class="panel-body">
                    <form class="form-horizontal" name="frmlogin" method="post" action="/login/" onsubmit="return login_check()">
                        <div class="form-group mt10">
                            <label class="col-sm-2 control-label">帐&nbsp;&nbsp;&nbsp;号：</label>
                            <div class="col-sm-10">
                                <input id="username" type="text" name="username" class="form-control" placeholder="请输入帐号">
                            </div>
                        </div>
                        <div class="form-group mt20">
                            <label class="col-sm-2 control-label">密&nbsp;&nbsp;&nbsp;码：</label>
                            <div class="col-sm-10">
                                <input id="userpass" type="password" name="password" class="form-control" placeholder="请输入密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" name="action" value="login">
                                <input type="hidden" name="jumpurl" value="/bookcase/">
                                <button type="submit" name="submit" class="btn btn-primary">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
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
