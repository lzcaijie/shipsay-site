<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$allbooks_url_safe = !empty($allbooks_url) ? $allbooks_url : '/sort/';
$full_allbooks_url_safe = !empty($full_allbooks_url)
    ? $full_allbooks_url
    : ('/quanben' . $allbooks_url_safe);
$search_url_safe = function_exists('ss_search_url')
    ? ss_search_url()
    : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
$recentread_url_safe = !empty($fake_recentread) ? $fake_recentread : '/history.html';
$site_home_url_safe = !empty($site_url) ? $site_url : '/';
$theme_dir_safe = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$site_name_safe = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$site_url_text_safe = htmlspecialchars((string)SITE_URL, ENT_QUOTES, 'UTF-8');
$search_placeholder = isset($search_placeholder) && $search_placeholder !== ''
    ? $search_placeholder
    : '输入书名/作者';
$rank_entry_safe = '';
if (isset($fake_top) && $fake_top) {
    $rank_entry_safe = $fake_top;
} elseif (isset($fake_rankstr) && $fake_rankstr) {
    $rank_entry_safe = '/' . trim($fake_rankstr, '/') . '/';
} else {
    $rank_entry_safe = '/rank/';
}
?>
<meta name="robots" content="all">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="Cache-Control" content="no-transform">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
<meta name="mobile-web-app-capable" content="yes">
<base target="_self">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_safe?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_safe?>/font-awesome.min.css">
<link rel="stylesheet" href="/static/<?=$theme_dir_safe?>/style.css">
<script src="/static/<?=$theme_dir_safe?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir_safe?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir_safe?>/js/jquery.lazyload.min.js"></script>
<script src="/static/<?=$theme_dir?>/common.js"></script>
</head>
<body>
<header>
    <div class="container head">
        <a id="logo" href="<?=htmlspecialchars($site_home_url_safe, ENT_QUOTES, 'UTF-8')?>">
            <span><?=$site_name_safe?></span>
            <p><?=$site_url_text_safe?></p>
        </a>

        <form class="site-search" name="t_frmsearch" method="post" action="<?=$search_url_safe?>" onsubmit="return chkval();">
            <input autocomplete="off" id="searchkey" type="text" name="searchkey" class="search_input" placeholder="<?=htmlspecialchars($search_placeholder, ENT_QUOTES, 'UTF-8')?>">
            <input type="hidden" name="searchtype" value="all">
            <button type="submit" name="Submit" id="search_btn" title="搜索"><i class="fa fa-search fa-lg"></i></button>
        </form>

        <div class="header_right">
            <a id="home" href="<?=htmlspecialchars($site_home_url_safe, ENT_QUOTES, 'UTF-8')?>"><i class="fa fa-home fa-lg"></i><br>首页</a>
            <a href="<?=htmlspecialchars($allbooks_url_safe, ENT_QUOTES, 'UTF-8')?>"><i class="fa fa-book fa-lg"></i><br>书库</a>
            <a href="<?=htmlspecialchars($full_allbooks_url_safe, ENT_QUOTES, 'UTF-8')?>"><i class="fa fa-coffee fa-lg"></i><br>完本</a>
            <a href="<?=htmlspecialchars($rank_entry_safe, ENT_QUOTES, 'UTF-8')?>"><i class="fa fa-bar-chart fa-lg"></i><br>排行</a>
            <a href="<?=htmlspecialchars($recentread_url_safe, ENT_QUOTES, 'UTF-8')?>" rel="nofollow"><i class="fa fa-history fa-lg"></i><br>足迹</a>
        </div>
    </div>
</header>
<div class="navigation">
    <nav class="container">
        <a href="<?=htmlspecialchars($site_home_url_safe, ENT_QUOTES, 'UTF-8')?>">首页</a>
        <?php foreach (Sort::ss_sorthead() as $v): ?>
            <?php if (rtrim($v['sorturl'], '/') === rtrim($rank_entry_safe, '/') || (isset($v['sortname']) && mb_strpos($v['sortname'], '排行') !== false)) continue; ?>
            <?php $nav_sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8'); $nav_sort_name_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8'); ?>
            <a href="<?=$nav_sort_url_attr?>"><?=$nav_sort_name_html?></a>
        <?php endforeach ?>
        <div id="user_panel"></div>
    </nav>
</div>
