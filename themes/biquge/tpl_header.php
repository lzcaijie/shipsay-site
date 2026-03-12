<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$theme_dir_raw = (string)$theme_dir;
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$recentread_url_raw = isset($fake_recentread) && $fake_recentread ? (string)$fake_recentread : '';
$rank_entry_raw = '';
if (isset($rank_entry_url) && $rank_entry_url) {
    $rank_entry_raw = (string)$rank_entry_url;
} elseif (isset($fake_top) && $fake_top) {
    $rank_entry_raw = (string)$fake_top;
}
$theme_dir_attr = htmlspecialchars($theme_dir_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
if ($search_url_raw === '') $search_url_raw = '/search/';
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$rank_entry_attr = htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8');
$site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$site_url_text_html = htmlspecialchars((string)SITE_URL, ENT_QUOTES, 'UTF-8');
$v = defined('SITE_VERSION') ? SITE_VERSION : date('Ymd');
?>
<!-- header -->
<meta name="applicable-device" content="pc,mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/style.css?v=<?=$v?>">
<script>
window.ssSearchAction = <?=json_encode($search_url_raw, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
</script>
<script src="/static/<?=$theme_dir_attr?>/js/jquery.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir_attr?>/js/jquery.cookie.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir_attr?>/js/jquery.lazyload.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir_attr?>/common.js?v=<?=$v?>"></script>

</head>

<body>
<header>
    <a class="logo" href="<?=$site_home_url_attr?>"><em><?=$site_name_html?></em><?=$site_url_text_html?></a>
    <div class="search">
        <form class="flex" name="t_frmsearch" method="post"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
            <input id="searchkey" type="text" name="searchkey" class="search_input" placeholder="书名或作者,请您少字也别错字" autocomplete="off">
            <button type="submit" name="Submit" class="search_btn" title="搜索"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>> 搜 索 </button>
        </form>
    </div>
</header>
<nav>
    <a href="<?=$site_home_url_attr?>">首页</a>
    <?php foreach (Sort::ss_sorthead() as $k => $v): ?>
        <?php
        if ($rank_entry_raw !== '' && rtrim((string)$v['sorturl'], '/') === rtrim($rank_entry_raw, '/')) continue;
        $sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8');
        $sort_name_html = htmlspecialchars((string)(isset($v['sortname_2']) ? $v['sortname_2'] : $v['sortname']), ENT_QUOTES, 'UTF-8');
        ?>
        <a href="<?=$sort_url_attr?>"><?=$sort_name_html?></a>
    <?php endforeach ?>
    <?php if ($rank_entry_raw !== ''): ?><a href="<?=$rank_entry_attr?>">排行</a><?php endif; ?>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow">阅读记录</a><?php endif; ?>
</nav>
