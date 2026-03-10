<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404-<?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
<header class="topbar">
  <div class="wrap">
    <a class="brand" href="<?=$site_home_url_attr?>"><?=$site_name_html?></a>
    <div class="crumb">页面不存在</div>
    <div class="spacer"></div>
    <?php if($recentread_url_raw !== ''): ?><a class="link" href="<?=$recentread_url_attr?>">记录</a><?php endif; ?>
  </div>
</header>
<div class="wrap" style="padding-top:16px;">
  <section class="card">
    <h1 style="font-size:20px;margin:0 0 10px;">页面不存在</h1>
    <p style="opacity:.8;">您访问的页面可能已删除或地址错误。</p>
    <div style="margin:12px 0;">
      <a href="<?=$site_home_url_attr?>" rel="nofollow">返回首页</a>
      &nbsp;|&nbsp;<a href="javascript:history.back();" rel="nofollow">返回上一页</a>
    </div>
    <form method="get" style="margin:12px 0;"<?php if($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
      <input type="text" name="searchkey" placeholder="搜索书名/作者" style="padding:8px;width:240px;max-width:80%;"<?php if($search_url_raw !== ''): ?> required<?php endif; ?>>
      <button type="submit" style="padding:8px 12px;"<?php if($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
    </form>
  </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
