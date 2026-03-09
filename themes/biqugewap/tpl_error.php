<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>404 - 页面不存在 - <?=SITE_NAME?></title>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
<?php
$search_form_action = !empty($search_url_attr) ? $search_url_attr : htmlspecialchars((string)(!empty($fake_search) ? $fake_search : (function_exists('ss_search_url') ? ss_search_url() : '')), ENT_QUOTES, 'UTF-8');
$search_form_placeholder = !empty($search_placeholder_attr) ? $search_placeholder_attr : '搜索书名/作者';
?>
<div class="rank">
  <h4>404 页面不存在<a class="pull-right" href="<?=htmlspecialchars((string)$site_url, ENT_QUOTES, 'UTF-8')?>">返回首页</a></h4>
  <div class="content" style="padding:12px;">
    <p style="color:#666;line-height:1.8;margin:0 0 14px;">你访问的页面可能已删除或地址错误。</p>
    <p style="margin:0 0 14px;">
      <a href="<?=htmlspecialchars((string)$site_url, ENT_QUOTES, 'UTF-8')?>" style="margin-right:12px;">返回首页</a>
      <button type="button" onclick="history.back();" style="padding:0;border:0;background:none;color:#333;cursor:pointer;">返回上一页</button>
    </p>
    <?php if ($search_form_action !== ''): ?>
    <form name="search" action="<?=$search_form_action?>" method="get" style="display:flex;gap:8px;max-width:520px;">
      <input type="text" placeholder="<?=$search_form_placeholder?>" value="" name="searchkey" class="search" id="searchkey" autocomplete="on" required style="flex:1;padding:10px;">
      <button type="submit" style="padding:10px 16px;">搜 索</button>
    </form>
    <?php endif; ?>
  </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
