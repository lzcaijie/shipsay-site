<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!-- header -->
<meta name="applicable-device" content="pc,mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php $v = defined('SITE_VERSION') ? SITE_VERSION : date('Ymd'); ?>
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/style.css?v=<?=$v?>">
<script src="/static/<?=$theme_dir?>/js/jquery.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.lazyload.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir?>/common.js?v=<?=$v?>"></script>

</head>

<body>
<header>
    <a href="/"><div class="logo"><em><?=SITE_NAME?></em><?=SITE_URL?></div></a>
    <div class="diswap">
        <button id="menu-btn" type="text" onclick="javascript:menu_toggle();" class="search_btn">菜单</button>
    </div>
    <!-- 搜索框 -->
    <div class="search dispc"><script>search();</script></div>
</header>
<nav class="dispc">
    <a href="/">首页</a>
    <?php foreach(Sort::ss_sorthead() as $k => $v): ?>
        <a href="<?=$v['sorturl']?>"><?=$v['sortname']?></a>
    <?php endforeach ?>
    <a href="<?=$fake_recentread?>">阅读记录</a>
</nav>
