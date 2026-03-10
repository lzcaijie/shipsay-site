<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!-- header -->
<?php
$site_home_url_safe = !empty($site_url) ? (string)$site_url : '/';

$top_url_safe = '';
if (!empty($rank_entry_url)) {
    $top_url_safe = (string)$rank_entry_url;
} elseif (!empty($fake_top)) {
    $top_url_safe = (string)$fake_top;
}

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
if ($search_url_safe === '') {
    $search_url_safe = '/search/';
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

$full_allbooks_url_safe = !empty($full_allbooks_url) ? (string)$full_allbooks_url : '';
$search_placeholder = '可搜书名和作者，请您少字也别输错字。';

$site_home_url_attr = htmlspecialchars($site_home_url_safe, ENT_QUOTES, 'UTF-8');
$top_url_attr = htmlspecialchars($top_url_safe, ENT_QUOTES, 'UTF-8');
$search_url_attr = htmlspecialchars($search_url_safe, ENT_QUOTES, 'UTF-8');
$recentread_url_attr = htmlspecialchars($recentread_url_safe, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_safe, ENT_QUOTES, 'UTF-8');
$search_placeholder_attr = htmlspecialchars($search_placeholder, ENT_QUOTES, 'UTF-8');
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="renderer" content="webkit|ie-comp|ie-stand" />
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/style.css" />
<script src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir?>/common.js"></script>
<script>window.SS_SEARCH_URL = <?=json_encode($search_url_safe, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;</script>
</head>

<body>
<div class="topbar">
  <div class="topbar-con">
    <div class="topbar-sethome">
      <a onclick="myFunction1()">将本站设为首页</a>
    </div>
    <div class="topbar-addfavorite">
      <a onclick="myFunction()">收藏<?=SITE_NAME?></a>
    </div>

    <div class="topbar-right">
      <?php if ($recentread_url_safe !== ''): ?>
        <a href="<?=$recentread_url_attr?>" rel="nofollow">阅读历史</a>
      <?php else: ?>
        <span class="nav-disabled">阅读历史</span>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="header">
  <h1 class="logo"><a href="<?=$site_home_url_attr?>"><?=SITE_NAME?></a></h1>
  <form name="t_frmsearch" method="get" action="<?=$search_url_attr?>" class="search-form" onsubmit="return chkval()">
    <input
      autocomplete="off"
      id="searchkey"
      type="text"
      name="searchkey"
      class="input-text input-key"
      placeholder="<?=$search_placeholder_attr?>"
    >
    <button type="submit" name="Submit" id="search_btn" class="btn-tosearch" value="搜索" title="搜索">搜索</button>
  </form>
</div>

<ul class="nav">
  <li><a href="<?=$site_home_url_attr?>">首页</a></li>
  <?php foreach (Sort::ss_sorthead() as $v): ?>
    <?php
    $sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8');
    $sort_name_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8');
    ?>
    <li><a href="<?=$sort_url_attr?>"><?=$sort_name_html?>小说</a></li>
  <?php endforeach; ?>

  <?php if ($top_url_safe !== ''): ?>
    <li><a href="<?=$top_url_attr?>">排行榜单</a></li>
  <?php endif; ?>
  <?php if ($full_allbooks_url_safe !== ''): ?>
    <li><a href="<?=$full_allbooks_url_attr?>">完本小说</a></li>
  <?php endif; ?>
  <?php if ($recentread_url_safe !== ''): ?>
    <li><a rel="nofollow" href="<?=$recentread_url_attr?>">阅读记录</a></li>
  <?php endif; ?>
</ul>

<ul class="m-nav">
  <li><a href="<?=$site_home_url_attr?>">首页</a></li>
  <?php if ($top_url_safe !== ''): ?>
    <li><a href="<?=$top_url_attr?>">排行</a></li>
  <?php endif; ?>
  <?php if ($full_allbooks_url_safe !== ''): ?>
    <li><a href="<?=$full_allbooks_url_attr?>">完本</a></li>
  <?php endif; ?>
  <?php if ($recentread_url_safe !== ''): ?>
    <li><a href="<?=$recentread_url_attr?>" rel="nofollow">阅读记录</a></li>
  <?php endif; ?>
</ul>
