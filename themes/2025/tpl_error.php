<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=<?=defined('SITE_VERSION')?SITE_VERSION:'20251207'?>" />
</head>
<body>
<?php
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container autoheight">
    <div class="list-index-2" style="padding:18px 0;">
        <div class="title"><h2>页面不存在</h2><span>404 Not Found</span></div>
        <div class="item" style="padding:18px;">
            <p style="color:#666;line-height:1.8;margin:0 0 14px;">你访问的页面可能已删除或地址错误。</p>
            <p style="margin:0 0 14px;">
                <a href="/" style="margin-right:12px;">返回首页</a>
                <a href="javascript:history.back();">返回上一页</a>
            </p>
            <form method="get" action="<?=$search_url_safe?>" style="max-width:520px;">
                <input name="searchkey" type="text" placeholder="搜索书名 / 作者" style="width:70%;padding:10px;" required>
                <button type="submit" style="padding:10px 16px;">搜索</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
