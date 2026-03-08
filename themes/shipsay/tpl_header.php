<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$allbooks_url_raw = isset($allbooks_url) && $allbooks_url ? (string)$allbooks_url : '';
$full_allbooks_url_raw = isset($full_allbooks_url) && $full_allbooks_url ? (string)$full_allbooks_url : '';
$search_url_raw = function_exists('ss_search_url')
    ? (string)ss_search_url()
    : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$recentread_url_raw = isset($fake_recentread) && $fake_recentread ? (string)$fake_recentread : '';
$site_home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$theme_dir_raw = (string)$theme_dir;
$search_placeholder_raw = isset($search_placeholder) && $search_placeholder !== ''
    ? (string)$search_placeholder
    : '输入书名/作者';
$rank_entry_raw = '';
if (isset($rank_entry_url) && $rank_entry_url) {
    $rank_entry_raw = (string)$rank_entry_url;
} elseif (isset($fake_top) && $fake_top) {
    $rank_entry_raw = (string)$fake_top;
} elseif (isset($fake_rankstr) && $fake_rankstr) {
    $rank_entry_raw = '/' . trim((string)$fake_rankstr, '/') . '/';
}
$theme_dir_attr = htmlspecialchars($theme_dir_raw, ENT_QUOTES, 'UTF-8');
$site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$site_url_text_html = htmlspecialchars((string)SITE_URL, ENT_QUOTES, 'UTF-8');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$allbooks_url_attr = htmlspecialchars($allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$rank_entry_attr = htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8');
$search_placeholder_attr = htmlspecialchars($search_placeholder_raw, ENT_QUOTES, 'UTF-8');
?>
<meta name="robots" content="all">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="Cache-Control" content="no-transform">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
<meta name="mobile-web-app-capable" content="yes">
<base target="_self">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/font-awesome.min.css">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/style.css">
<script src="/static/<?=$theme_dir_attr?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/js/jquery.lazyload.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/common.js"></script>
</head>
<body>
<header>
    <div class="container head">
        <a id="logo" href="<?=$site_home_url_attr?>">
            <span><?=$site_name_html?></span>
            <p><?=$site_url_text_html?></p>
        </a>

        <form class="site-search" name="t_frmsearch" method="post"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>" onsubmit="return chkval();"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
            <input autocomplete="off" id="searchkey" type="text" name="searchkey" class="search_input" placeholder="<?=$search_placeholder_attr?>">
            <input type="hidden" name="searchtype" value="all">
            <button type="submit" name="Submit" id="search_btn" title="搜索"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>><i class="fa fa-search fa-lg"></i></button>
        </form>

        <div class="header_right">
            <a id="home" href="<?=$site_home_url_attr?>"><i class="fa fa-home fa-lg"></i><br>首页</a>
            <?php if ($allbooks_url_raw !== ''): ?><a href="<?=$allbooks_url_attr?>"><i class="fa fa-book fa-lg"></i><br>书库</a><?php else: ?><a class="w_gray" aria-disabled="true"><i class="fa fa-book fa-lg"></i><br>书库</a><?php endif; ?>
            <?php if ($full_allbooks_url_raw !== ''): ?><a href="<?=$full_allbooks_url_attr?>"><i class="fa fa-coffee fa-lg"></i><br>完本</a><?php else: ?><a class="w_gray" aria-disabled="true"><i class="fa fa-coffee fa-lg"></i><br>完本</a><?php endif; ?>
            <?php if ($rank_entry_raw !== ''): ?><a href="<?=$rank_entry_attr?>"><i class="fa fa-bar-chart fa-lg"></i><br>排行</a><?php else: ?><a class="w_gray" aria-disabled="true"><i class="fa fa-bar-chart fa-lg"></i><br>排行</a><?php endif; ?>
            <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow"><i class="fa fa-history fa-lg"></i><br>足迹</a><?php else: ?><a class="w_gray" aria-disabled="true" rel="nofollow"><i class="fa fa-history fa-lg"></i><br>足迹</a><?php endif; ?>
        </div>
    </div>
</header>
<div class="navigation">
    <nav class="container">
        <a href="<?=$site_home_url_attr?>">首页</a>
        <?php foreach (Sort::ss_sorthead() as $v): ?>
            <?php if (rtrim((string)$v['sorturl'], '/') === rtrim($rank_entry_raw, '/') || (isset($v['sortname']) && mb_strpos($v['sortname'], '排行') !== false)) continue; ?>
            <?php $nav_sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8'); $nav_sort_name_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8'); ?>
            <a href="<?=$nav_sort_url_attr?>"><?=$nav_sort_name_html?></a>
        <?php endforeach ?>
        <div id="user_panel"></div>
    </nav>
</div>
