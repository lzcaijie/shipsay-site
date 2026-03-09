<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $v = defined('SITE_VERSION') ? SITE_VERSION : '20251207'; ?>
<?php
$site_home_url_raw = !empty($site_url) ? (string)$site_url : '/';
$allbooks_url_raw = !empty($allbooks_url) ? (string)$allbooks_url : '';
$full_allbooks_url_raw = !empty($full_allbooks_url) ? (string)$full_allbooks_url : '';
$search_url_raw = function_exists('ss_search_url')
    ? (string)ss_search_url()
    : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$recent_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$allbooks_url_attr = htmlspecialchars($allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$recent_url_attr = htmlspecialchars($recent_url_raw, ENT_QUOTES, 'UTF-8');
?>
<div class="header-common">
<div class="container">
<div class="header-common-left"><a href="<?=$site_home_url_attr?>" title="<?=$site_name_html?>" class="logo"><?=$site_name_html?></a></div>
<div class="header-common-right">
<div class="header-common-search">
<form name="articlesearch" method="get"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
<input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" placeholder="搜索从这里开始..." autocomplete="off" required>
<button type="submit" name="submit"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>><svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3340"><path d="M902.4 889.6l-156.8-156.8c156.8-147.2 166.4-393.6 22.4-553.6S371.2 12.8 211.2 160C51.2 307.2 44.8 553.6 192 713.6c131.2 140.8 342.4 166.4 502.4 60.8l160 163.2c12.8 12.8 32 12.8 44.8 0 12.8-12.8 16-35.2 3.2-48z m-755.2-448c0-182.4 147.2-329.6 329.6-329.6 182.4 0 329.6 147.2 329.6 329.6 0 182.4-147.2 329.6-329.6 329.6C294.4 774.4 147.2 624 147.2 441.6z" p-id="3341"></path></svg></button>
</form>
</div>
</div>
</div>
<div class="cf"></div>
</div>
<div class="header-common-nav">
<div class="container">
<a class="active" href="<?=$site_home_url_attr?>" title="<?=$site_name_html?>">首页</a>
<?php if ($allbooks_url_raw !== ''): ?><a href="<?=$allbooks_url_attr?>" title="书库">书库</a><?php else: ?><a aria-disabled="true">书库</a><?php endif; ?>
<?php if ($full_allbooks_url_raw !== ''): ?><a href="<?=$full_allbooks_url_attr?>" title="全本">全本</a><?php else: ?><a aria-disabled="true">全本</a><?php endif; ?>
<?php if ($search_url_raw !== ''): ?><a href="<?=$search_url_attr?>">搜索</a><?php else: ?><a aria-disabled="true">搜索</a><?php endif; ?>
<?php if ($recent_url_raw !== ''): ?><a href="<?=$recent_url_attr?>" rel="nofollow">足迹</a><?php else: ?><a aria-disabled="true" rel="nofollow">足迹</a><?php endif; ?>
</div>
<div class="cf"></div>
</div>
