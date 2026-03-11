<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$theme_dir_raw = (string)$theme_dir;
$theme_dir_attr = htmlspecialchars($theme_dir_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$search_url_raw = function_exists('ss_search_url')
    ? (string)ss_search_url()
    : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$allbooks_url_raw = isset($allbooks_url) && $allbooks_url ? (string)$allbooks_url : '';
$full_allbooks_url_raw = isset($full_allbooks_url) && $full_allbooks_url ? (string)$full_allbooks_url : '';
$rank_entry_raw = isset($rank_entry_url) && $rank_entry_url ? (string)$rank_entry_url : ((isset($fake_top) && $fake_top) ? (string)$fake_top : '');
$recentread_url_raw = isset($fake_recentread) && $fake_recentread ? (string)$fake_recentread : '';
$allbooks_url_attr = htmlspecialchars($allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$rank_entry_attr = htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
?>

<!-- header -->
<meta name="robots" content="all">
<meta name="googlebot" content="all">
<meta name="baiduspider" content="all">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/css/font-awesome.min.css">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/style.css" />
<script src="/static/<?=$theme_dir_attr?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/common.js"></script>

</head>
<body>

<div class="header">
    <div class="container">
        <div class="header-left">
            <a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>" class="logo"><?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></a>
        </div>
        <div class="header-right"></div>
        <div class="header-nav">
            <a href="<?=$site_home_url_attr?>" title="首页">首 页</a>
            <?php if ($allbooks_url_raw !== ''): ?><a href="<?=$allbooks_url_attr?>" title="书库">书 库</a><?php else: ?><a aria-disabled="true">书 库</a><?php endif; ?>
            <?php if ($full_allbooks_url_raw !== ''): ?><a href="<?=$full_allbooks_url_attr?>" title="完本">全 本</a><?php else: ?><a aria-disabled="true">全 本</a><?php endif; ?>
            <?php if ($rank_entry_raw !== ''): ?><a href="<?=$rank_entry_attr?>" title="排行">排 行</a><?php else: ?><a aria-disabled="true">排 行</a><?php endif; ?>
            <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" title="阅读记录" rel="nofollow">记 录</a><?php else: ?><a aria-disabled="true" rel="nofollow">记 录</a><?php endif; ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
