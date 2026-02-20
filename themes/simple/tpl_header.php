<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!-- header -->
<meta name="robots" content="all">
<meta name="googlebot" content="all">
<meta name="baiduspider" content="all">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/font-awesome.min.css">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/style.css" />
<script src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir?>/common.js"></script>

</head>
<body>

<div class="header">
	<div class="container">
		<div class="header-left">
			<a href="/" title="<?=SITE_NAME?>" class="logo"><?=SITE_NAME?></a>
		</div>
		<div class="header-right"><script>login();</script></div>
		<div class="header-nav">
			<a href="/" title="首页">首 页</a>
			<a href="<?=$allbooks_url?>" title="书库">书 库</a>
			<a href="/quanben<?=$allbooks_url?>">全本</a>
		</div>
	</div>
	<div class="clear"></div>
</div>
