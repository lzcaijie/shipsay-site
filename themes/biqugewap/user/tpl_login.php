<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>会员登录_<?=SITE_NAME?></title>
<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
</head>
<body>
	<header class="header">
		<div class="left"><a href="javascript:history.go(-1)"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
		<div class="center">会员登录</div>
		<div class="right">
		    <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
		    <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
		</div>
		<div class="clear"></div>
	</header>
	<div class="fixed"></div>
	<div class="login min-height">
		<h4>会员登录<a href="/register/" class="pull-right">没有账号？点击注册</a></h4>
		<form name="frmlogin" method="post" action="/login/">
			<div class="form-group">
				<div class="form-title">账号：</div>
				<div class="form-content"><input name="username" id="username" type="text" placeholder="请输入帐号" autocomplete="on"></div>
			</div>
			<div class="form-group">
				<div class="form-title">密码：</div>
				<div class="form-content"><input name="password" id="userpass" type="password" placeholder="请输入密码" autocomplete="on"></div>
			</div>
			<div class="form-submit">
				<input type="hidden" name="action" value="login">
				<input type="hidden" name="jumpurl" value="/bookcase/">
				<button type="submit" name="submit"> 登 录 </button>
			</div>
		</form>
		<div class="clear"></div>
	</div>
<?php require_once __THEME_DIR__  .'/tpl_footer.php'; ?>

<script src="/static/<?=$theme_dir?>/user.js"></script>
    <div id="guide" class="guide">
        <div class="guide-content">
    <nav class="guide-nav">
        <a href="<?=$site_url?>" class="guide-nav-a">
            <i class="icon icon-home"></i>
            <span class="guide-nav-h">首页</span>
        </a>
        <a href="<?=$allbooks_url?>" class="guide-nav-a">
            <i class="icon icon-sort"></i>
            <span class="guide-nav-h">分类</span>
        </a>
        <a href="<?=$fake_top?>" class="guide-nav-a">
            <i class="icon icon-rank"></i>
            <span class="guide-nav-h">排行榜</span>
        </a>
        <a href="<?=$full_allbooks_url?>" class="guide-nav-a">
            <i class="icon icon-end"></i>
            <span class="guide-nav-h">全本</span>
        </a>
        <a href="<?=$fake_recentread?>" class="guide-nav-a">
            <i class="icon icon-free"></i>
            <span class="guide-nav-h">记录</span>
        </a>
    </nav>
            <div class="guide-footer">
                <a href="/bookcase/"><svg id="icon-person" viewBox="0 0 16 16"><g><path d="M12 5a4 4 0 1 0-8 0 4 4 0 0 0 8 0zM3 5a5 5 0 1 1 10 0A5 5 0 0 1 3 5z"></path><path d="M8 9c-4.397 0-8 2.883-8 6.5a.5.5 0 1 0 1 0C1 12.49 4.113 10 8 10s7 2.49 7 5.5a.5.5 0 1 0 1 0C16 11.883 12.397 9 8 9z"></path></g></svg>会员书架</a>
            </div>
        </div>
    </div>

</body>
</html>