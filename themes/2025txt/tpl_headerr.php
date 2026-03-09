<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$search_url_safe = function_exists('ss_search_url')
    ? ss_search_url()
    : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
$full_allbooks_url_safe = !empty($full_allbooks_url)
    ? $full_allbooks_url
    : ('/quanben' . (isset($allbooks_url) ? $allbooks_url : '/sort/'));
$recent_url_safe = !empty($fake_recentread) ? $fake_recentread : '/history.html';
?>
<div class="header-common hidden-xs">
<div class="container">
<div class="header-common-left"><a href="/" title="<?=SITE_NAME?>" class="logo"><?=SITE_NAME?></a></div>
<div class="header-common-right">
<div class="header-common-search">
<form name="articlesearch" method="get" action="<?=$search_url_safe?>">
<input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" placeholder="搜索从这里开始..." autocomplete="off" required>
<button type="submit" name="submit"><svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3340"><path d="M902.4 889.6l-156.8-156.8c156.8-147.2 166.4-393.6 22.4-553.6S371.2 12.8 211.2 160C51.2 307.2 44.8 553.6 192 713.6c131.2 140.8 342.4 166.4 502.4 60.8l160 163.2c12.8 12.8 32 12.8 44.8 0 12.8-12.8 16-35.2 3.2-48z m-755.2-448c0-182.4 147.2-329.6 329.6-329.6 182.4 0 329.6 147.2 329.6 329.6 0 182.4-147.2 329.6-329.6 329.6C294.4 774.4 147.2 624 147.2 441.6z" p-id="3341"></path></svg></button>
</form>
</div>
</div>
</div>
<div class="cf"></div>
</div>
<div class="header-common-nav hidden-xs">
<div class="container">
<a class="active" href="/" title="<?=SITE_NAME?>">首页</a>
<a href="<?=$allbooks_url?>" title="书库">书库</a>
<a href="<?=$full_allbooks_url_safe?>" title="全本">全本</a>
<a href="<?=$search_url_safe?>">搜索</a>
<a href="<?=$recent_url_safe?>">轨迹</a>
</div>
<div class="cf"></div>
</div>
