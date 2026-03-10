<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$theme_dir_raw = (string)$theme_dir;
$theme_dir_attr = htmlspecialchars($theme_dir_raw, ENT_QUOTES, 'UTF-8');
$bs_file = __ROOT_DIR__ . '/www/static/' . $theme_dir_raw . '/css/bootstrap.min.css';
$site_file = __ROOT_DIR__ . '/www/static/' . $theme_dir_raw . '/css/site.css';
$bs_ver = @filemtime($bs_file);
$site_ver = @filemtime($site_file);

$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');

$allbooks_url_raw = !empty($allbooks_url) ? (string)$allbooks_url : '';
$full_allbooks_url_raw = !empty($full_allbooks_url) ? (string)$full_allbooks_url : '';
$allbooks_url_attr = htmlspecialchars($allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');

$search_url_raw = '';
if (function_exists('ss_search_url')) {
    $tmp_search_url = trim((string)ss_search_url());
    if ($tmp_search_url !== '') {
        $search_url_raw = $tmp_search_url;
    }
}
if ($search_url_raw === '' && !empty($fake_search)) {
    $search_url_raw = trim((string)$fake_search);
}
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$search_placeholder_raw = isset($search_placeholder) && trim((string)$search_placeholder) !== '' ? (string)$search_placeholder : '搜索作品';
$search_placeholder_attr = htmlspecialchars($search_placeholder_raw, ENT_QUOTES, 'UTF-8');

$top_url_raw = '';
if (!empty($rank_entry_url)) {
    $top_url_raw = (string)$rank_entry_url;
} elseif (!empty($fake_top)) {
    $top_url_raw = (string)$fake_top;
}
$top_url_attr = htmlspecialchars($top_url_raw, ENT_QUOTES, 'UTF-8');

$recentread_url_raw = '';
if (function_exists('ss_recentread_url')) {
    $tmp_recentread_url = trim((string)ss_recentread_url());
    if ($tmp_recentread_url !== '') {
        $recentread_url_raw = $tmp_recentread_url;
    }
}
if ($recentread_url_raw === '' && !empty($fake_recentread)) {
    $recentread_url_raw = trim((string)$fake_recentread);
}
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
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
<link href="/static/<?=$theme_dir_attr?>/css/bootstrap.min.css<?php if ($bs_ver) echo '?v=' . $bs_ver; ?>" rel="stylesheet">
<link href="/static/<?=$theme_dir_attr?>/css/site.css<?php if ($site_ver) echo '?v=' . $site_ver; ?>" rel="stylesheet">
</head>
<body>
<header class="header_46f navbar navbar-inverse" id="header">
    <div class="con_46f container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a class="navbar-brand-left-none visible-xs" href="<?=$site_home_url_attr?>"></a>
            <a class="navbar-brand hidden-xs" href="<?=$site_home_url_attr?>"><?=$site_name_html?></a>
            <a class="navbar-brand visible-xs" href="<?=$site_home_url_attr?>"><?=$site_name_html?></a>
        </div>
        <nav class="navbar_46f collapse navbar-collapse bs-navbar-collapse" role="navigation" id="nav-header">
            <ul class="nav navbar-nav nav_46f">
                <li class="46f_index"><a id="nav_index" href="<?=$site_home_url_attr?>">首页</a></li>
                <?php if ($allbooks_url_raw !== ''): ?><li class="46f_all"><a id="nav_sort" href="<?=$allbooks_url_attr?>">书库</a></li><?php endif; ?>
                <?php if ($top_url_raw !== ''): ?><li class="46f_top"><a id="nav_top" href="<?=$top_url_attr?>">排行</a></li><?php endif; ?>
                <?php if ($full_allbooks_url_raw !== ''): ?><li class="46f_over"><a id="nav_full" href="<?=$full_allbooks_url_attr?>">全本</a></li><?php endif; ?>
                <?php if ($recentread_url_raw !== ''): ?><li class="46f_bookcase"><a id="nav_his" href="<?=$recentread_url_attr?>" rel="nofollow">轨迹</a></li><?php endif; ?>
            </ul>
            <form class="search_46f navbar-form navbar-left" name="search" method="get"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
                <div class="input-group">
                    <input type="text" class="form-control" size="10" maxlength="50" placeholder="<?=$search_placeholder_attr?>" name="searchkey"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?> required>
                    <span class="input-group-btn"><button class="btn btn-info" type="submit"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜 索</button></span>
                </div>
            </form>
        </nav>
    </div>
</header>
<!-- /header -->
