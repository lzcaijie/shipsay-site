<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$bs_file   = __ROOT_DIR__ . '/www/static/' . $theme_dir . '/css/bootstrap.min.css';
$site_file = __ROOT_DIR__ . '/www/static/' . $theme_dir . '/css/site.css';
$bs_ver    = @filemtime($bs_file);
$site_ver  = @filemtime($site_file);

$ss_home_url = $site_url;
$ss_rank_url = isset($fake_top) ? $fake_top : '/rank/';
$ss_full_url = isset($fake_fullstr) ? ('/' . trim($fake_fullstr, '/') . $allbooks_url) : '/quanben' . $allbooks_url;
$ss_search_url = $site_url . '/search/';
?>

<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="applicable-device" content="pc,mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="MobileOptimized" content="320">
<meta name="mobile-web-app-capable" content="yes">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">

<link href="/static/<?=$theme_dir?>/css/bootstrap.min.css<?php if($bs_ver){echo '?v='.$bs_ver;}?>" rel="stylesheet">
<link href="/static/<?=$theme_dir?>/css/site.css<?php if($site_ver){echo '?v='.$site_ver;}?>" rel="stylesheet">

</head>
<body>
<header class="header_46f navbar navbar-inverse" id="header">
    <div class="con_46f container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a class="navbar-brand-left-none visible-xs" href="<?=$ss_home_url?>"></a>
            <a class="navbar-brand hidden-xs" href="<?=$ss_home_url?>"><?=SITE_NAME?></a>
            <a class="navbar-brand visible-xs" href="<?=$ss_home_url?>"><?=SITE_NAME?></a>
        </div>
        <nav class="navbar_46f collapse navbar-collapse bs-navbar-collapse" role="navigation" id="nav-header">
            <ul class="nav navbar-nav nav_46f">
                <li class="46f_index"><a id="nav_index" href="<?=$ss_home_url?>" style="">首页</a></li>
                <li class="46f_all"><a id="nav_sort" href="<?=$allbooks_url?>">书库</a></li>
                <li class="46f_top"><a id="nav_top" href="<?=$ss_rank_url?>">排行</a></li>
                <li class="46f_over"><a id="nav_full" href="<?=$ss_full_url?>">全本</a></li>
                <li class="46f_bookcase"><a id="nav_his" href="<?=$fake_recentread?>">轨迹</a></li>
            </ul>
            <form class="search_46f navbar-form navbar-left" action="<?=$ss_search_url?>" name="search" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" size="10" maxlength="50" placeholder="搜索作品" name="searchkey" required>
                    <span class="input-group-btn"><button class="btn btn-info" type="submit">搜 索</button></span>
                </div>
            </form>
            <ul class="login_46f nav navbar-nav navbar-right" id="header-login"></ul>
        </nav>	</div>
</header>
<!-- /header -->
