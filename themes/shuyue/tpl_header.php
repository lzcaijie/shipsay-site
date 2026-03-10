<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$bs_file   = __ROOT_DIR__ . '/www/static/' . $theme_dir . '/css/bootstrap.min.css';
$site_file = __ROOT_DIR__ . '/www/static/' . $theme_dir . '/css/site.css';
$bs_ver    = @filemtime($bs_file);
$site_ver  = @filemtime($site_file);

$site_home_url_safe = !empty($site_url) ? (string)$site_url : '/';
$allbooks_url_safe = !empty($allbooks_url) ? (string)$allbooks_url : '';
$full_allbooks_url_safe = !empty($full_allbooks_url) ? (string)$full_allbooks_url : '';

$search_url_safe = '';
if (function_exists('ss_search_url')) {
    $tmp_search_url = trim((string)ss_search_url());
    if ($tmp_search_url !== '') {
        $search_url_safe = $tmp_search_url;
    }
}
if ($search_url_safe === '' && isset($fake_search) && trim((string)$fake_search) !== '') {
    $search_url_safe = trim((string)$fake_search);
}

$top_url_safe = '';
if (!empty($rank_entry_url)) {
    $top_url_safe = (string)$rank_entry_url;
} elseif (!empty($fake_top)) {
    $top_url_safe = (string)$fake_top;
}

$recentread_url_safe = '';
if (function_exists('ss_recentread_url')) {
    $tmp_recentread_url = trim((string)ss_recentread_url());
    if ($tmp_recentread_url !== '') {
        $recentread_url_safe = $tmp_recentread_url;
    }
}
if ($recentread_url_safe === '' && isset($fake_recentread) && trim((string)$fake_recentread) !== '') {
    $recentread_url_safe = trim((string)$fake_recentread);
}
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
<base target="_self">

<link href="/static/<?=$theme_dir?>/css/bootstrap.min.css<?php if($bs_ver){echo '?v='.$bs_ver;}?>" rel="stylesheet">
<link href="/static/<?=$theme_dir?>/css/site.css<?php if($site_ver){echo '?v='.$site_ver;}?>" rel="stylesheet">

</head>
<body>
<header class="header_46f navbar navbar-inverse" id="header">
    <div class="con_46f container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a class="navbar-brand-left-none visible-xs" href="<?=$site_home_url_safe?>"></a>
            <a class="navbar-brand hidden-xs" href="<?=$site_home_url_safe?>"><?=SITE_NAME?></a>
            <a class="navbar-brand visible-xs" href="<?=$site_home_url_safe?>"><?=SITE_NAME?></a>
        </div>
        <nav class="navbar_46f collapse navbar-collapse bs-navbar-collapse" role="navigation" id="nav-header">
            <ul class="nav navbar-nav nav_46f">
                <li class="46f_index"><a id="nav_index" href="<?=$site_home_url_safe?>">首页</a></li>
                <?php if($allbooks_url_safe !== ''): ?><li class="46f_all"><a id="nav_sort" href="<?=$allbooks_url_safe?>">书库</a></li><?php endif; ?>
                <?php if($top_url_safe !== ''): ?><li class="46f_top"><a id="nav_top" href="<?=$top_url_safe?>">排行</a></li><?php endif; ?>
                <?php if($full_allbooks_url_safe !== ''): ?><li class="46f_over"><a id="nav_full" href="<?=$full_allbooks_url_safe?>">全本</a></li><?php endif; ?>
                <?php if($recentread_url_safe !== ''): ?><li class="46f_bookcase"><a id="nav_his" href="<?=$recentread_url_safe?>" rel="nofollow">轨迹</a></li><?php endif; ?>
            </ul>
            <form class="search_46f navbar-form navbar-left"<?php if($search_url_safe !== ''): ?> action="<?=$search_url_safe?>"<?php endif; ?> name="search" method="get"<?php if($search_url_safe === ''): ?> onsubmit="return false;"<?php endif; ?>>
                <div class="input-group">
                    <input type="text" class="form-control" size="10" maxlength="50" placeholder="搜索作品" name="searchkey"<?php if($search_url_safe === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?> required>
                    <span class="input-group-btn"><button class="btn btn-info" type="submit"<?php if($search_url_safe === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜 索</button></span>
                </div>
            </form>
        </nav>
    </div>
</header>
<!-- /header -->
