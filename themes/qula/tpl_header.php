<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!-- header -->
  <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand" />
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/favicon.ico" media="screen">
    <link rel="stylesheet" href="/static/<?=$theme_dir?>/style.css" />
	<script src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
	<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script>
    <script src="/static/<?=$theme_dir?>/common.js"></script>
    <script src="/static/<?=$theme_dir?>/user.js"></script>

<?php
$top_url_safe = !empty($fake_top) ? $fake_top : '/rank/';
$full_allbooks_url_safe = !empty($full_allbooks_url) ? $full_allbooks_url : ('/quanben' . (isset($allbooks_url) ? $allbooks_url : '/sort/'));
?>

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
        <a href='<?=$fake_recentread?>'>阅读历史</a> | <script>login();</script>
      </div>

    </div>
  </div>

  <div class="header">
    <h1 class="logo"><a href="/"><?=SITE_NAME?></a></h1>
     <script>search();</script>
    <div class="m-user" style="color:#fff">
       <script>MLogin();</script>
    </div>
  </div>

  <ul class="nav">
    <li><a href="/">首页</a></li>
    <li><a rel="nofollow" href="/bookcase/">永久书架</a></li>
    <?php foreach(Sort::ss_sorthead() as $v): ?>
                <li><a href="<?=$v['sorturl']?>" ><?=$v['sortname_2']?>小说</a></li>
            <?php endforeach ?>

    <li><a href="<?=$top_url_safe?>">排行榜单</a></li>
    <li><a href="<?=$allbooks_url?>">书库榜单</a></li>
    <li><a href="<?=$full_allbooks_url_safe?>">完本小说</a></li>
    <li><a rel="nofollow" href="<?=$fake_recentread?>">阅读记录</a></li>
  </ul>
  <ul class="m-nav">
    <li><a href="<?=$top_url_safe?>">排行</a></li>
    <li><a href="<?=$allbooks_url?>">书库</a></li>
    <li><a href="<?=$full_allbooks_url_safe?>">完本</a></li>
    <li><a href="<?=$fake_recentread?>">阅读记录</a></li>
    <li><a href="/bookcase/"  rel="nofollow">书架</a></li>
  </ul>

