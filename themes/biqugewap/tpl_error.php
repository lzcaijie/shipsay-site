<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex,nofollow">
<title>404 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
<header class="header">
  <div class="left"><a href="/"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
  <div class="center">404</div>
  <div class="right"><a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a></div>
  <div class="clear"></div>
</header>
<div class="fixed">
  <nav class="guide-nav">
    <a href="<?=$site_url?>" class="guide-nav-a"><i class="icon icon-home"></i><span class="guide-nav-h">首页</span></a>
    <a href="<?=$allbooks_url?>" class="guide-nav-a"><i class="icon icon-sort"></i><span class="guide-nav-h">分类</span></a>
    <a href="<?=$fake_top?>" class="guide-nav-a"><i class="icon icon-rank"></i><span class="guide-nav-h">排行榜</span></a>
    <a href="<?=$full_allbooks_url?>" class="guide-nav-a"><i class="icon icon-end"></i><span class="guide-nav-h">全本</span></a>
    <a href="<?=$fake_recentread?>" class="guide-nav-a"><i class="icon icon-free"></i><span class="guide-nav-h">记录</span></a>
  </nav>
</div>


<?php
$search_url_safe = '/search/';
if (function_exists('ss_search_url')) {
    $search_url_safe = ss_search_url();
} elseif (isset($fake_search) && $fake_search) {
    $search_url_safe = $fake_search;
}
?>
<div class="ss-404-wrap" style="max-width:720px;margin:28px auto;padding:0 16px;">
  <div class="ss-404-box" style="background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:10px;padding:18px 16px;">
    <h1 style="margin:0 0 8px;font-size:22px;line-height:1.2;">404 Not Found</h1>
    <p style="margin:0 0 14px;color:#666;">页面不存在或已被删除，你可以返回首页或搜索你要看的书。</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
      <a href="/" style="display:inline-block;padding:10px 14px;border-radius:8px;background:#111;color:#fff;text-decoration:none;">返回首页</a>
      <form action="<?=$search_url_safe?>" method="get" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin:0;">
        <input type="text" name="searchkey" placeholder="输入书名或作者" required
               style="padding:10px 12px;border:1px solid #ddd;border-radius:8px;min-width:220px;outline:none;">
        <button type="submit" style="padding:10px 14px;border:0;border-radius:8px;background:#2d6cdf;color:#fff;">搜索</button>
      </form>
    </div>
  </div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
