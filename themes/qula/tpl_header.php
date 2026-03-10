<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!-- header -->
<?php
$top_url_safe = !empty($rank_entry_url) ? $rank_entry_url : (!empty($fake_top) ? $fake_top : '');
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '');
$recentread_url_safe = function_exists('ss_recentread_url') ? ss_recentread_url() : ((isset($fake_recentread) && $fake_recentread) ? $fake_recentread : '');
$allbooks_url_safe = !empty($allbooks_url) ? $allbooks_url : '';
$full_allbooks_url_safe = !empty($full_allbooks_url) ? $full_allbooks_url : ($allbooks_url_safe ? ('/quanben' . $allbooks_url_safe) : '');
$search_placeholder = '可搜书名和作者，请您少字也别输错字。';
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="renderer" content="webkit|ie-comp|ie-stand" />
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/style.css" />
<script src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script>
<script src="/static/<?=$theme_dir?>/common.js"></script>
<script>window.SS_SEARCH_URL = <?=json_encode($search_url_safe, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)?>;</script>
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
      <?php if ($recentread_url_safe): ?>
        <a href="<?=htmlspecialchars($recentread_url_safe, ENT_QUOTES, 'UTF-8')?>" rel="nofollow">阅读历史</a>
      <?php else: ?>
        <span class="nav-disabled">阅读历史</span>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="header">
  <h1 class="logo"><a href="/"><?=SITE_NAME?></a></h1>
  <?php if ($search_url_safe): ?>
    <form name="t_frmsearch" method="get" action="<?=htmlspecialchars($search_url_safe, ENT_QUOTES, 'UTF-8')?>" class="search-form" onsubmit="return chkval()">
      <input autocomplete="off" id="searchkey" type="text" name="searchkey" class="input-text input-key" placeholder="<?=htmlspecialchars($search_placeholder, ENT_QUOTES, 'UTF-8')?>">
      <button type="submit" name="Submit" id="search_btn" class="btn-tosearch" value="搜索" title="搜索">搜索</button>
    </form>
  <?php else: ?>
    <form class="search-form search-form-disabled" onsubmit="return false;">
      <input autocomplete="off" type="text" class="input-text input-key" placeholder="<?=htmlspecialchars($search_placeholder, ENT_QUOTES, 'UTF-8')?>" disabled>
      <button type="button" class="btn-tosearch" disabled>搜索</button>
    </form>
  <?php endif; ?>
</div>

<ul class="nav">
  <li><a href="/">首页</a></li>
  <?php foreach (Sort::ss_sorthead() as $v): ?>
    <li><a href="<?=$v['sorturl']?>"><?=$v['sortname_2']?>小说</a></li>
  <?php endforeach ?>

  <?php if ($top_url_safe): ?>
    <li><a href="<?=htmlspecialchars($top_url_safe, ENT_QUOTES, 'UTF-8')?>">排行榜单</a></li>
  <?php endif; ?>
  <?php if ($allbooks_url_safe): ?>
    <li><a href="<?=htmlspecialchars($allbooks_url_safe, ENT_QUOTES, 'UTF-8')?>">书库榜单</a></li>
  <?php endif; ?>
  <?php if ($full_allbooks_url_safe): ?>
    <li><a href="<?=htmlspecialchars($full_allbooks_url_safe, ENT_QUOTES, 'UTF-8')?>">完本小说</a></li>
  <?php endif; ?>
  <?php if ($recentread_url_safe): ?>
    <li><a rel="nofollow" href="<?=htmlspecialchars($recentread_url_safe, ENT_QUOTES, 'UTF-8')?>">阅读记录</a></li>
  <?php endif; ?>
</ul>
<ul class="m-nav">
  <?php if ($top_url_safe): ?><li><a href="<?=htmlspecialchars($top_url_safe, ENT_QUOTES, 'UTF-8')?>">排行</a></li><?php endif; ?>
  <?php if ($allbooks_url_safe): ?><li><a href="<?=htmlspecialchars($allbooks_url_safe, ENT_QUOTES, 'UTF-8')?>">书库</a></li><?php endif; ?>
  <?php if ($full_allbooks_url_safe): ?><li><a href="<?=htmlspecialchars($full_allbooks_url_safe, ENT_QUOTES, 'UTF-8')?>">完本</a></li><?php endif; ?>
  <?php if ($recentread_url_safe): ?><li><a href="<?=htmlspecialchars($recentread_url_safe, ENT_QUOTES, 'UTF-8')?>" rel="nofollow">阅读记录</a></li><?php endif; ?>
  <?php if ($search_url_safe): ?><li><a href="<?=htmlspecialchars($search_url_safe, ENT_QUOTES, 'UTF-8')?>" rel="nofollow">搜索</a></li><?php endif; ?>
</ul>
