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
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '');
$error_home_url = !empty($site_url) ? $site_url : '/';
?>
<div class="rank">
  <h4>404 页面不存在<a class="pull-right" href="<?=$error_home_url?>">返回首页</a></h4>
  <div class="content">
    <p>你访问的页面可能已删除或地址错误。</p>
    <p>
      <a href="<?=$error_home_url?>">返回首页</a>
      <a href="#" id="goBackError">返回上一页</a>
    </p>
    <form name="search"<?php if ($search_url_safe !== ""): ?> action="<?=$search_url_safe?>"<?php else: ?> onsubmit="return false;"<?php endif; ?> method="get">
      <input type="text" placeholder="搜索书名/作者" value="" name="searchkey" class="search" id="searchkey" autocomplete="on" required>
      <button type="submit"<?php if ($search_url_safe === ""): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜 索</button>
    </form>
  </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
<script>
$(document).on('click', '#goBackError', function(e){
  e.preventDefault();
  history.back();
});
</script>
</body>
</html>
