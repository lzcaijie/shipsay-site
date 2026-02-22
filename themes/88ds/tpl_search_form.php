<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$search_url_safe = function_exists('ss_search_url')
    ? ss_search_url()
    : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
?>

<form id="post" name="t_frmsearch" method="post" action="<?=$search_url_safe?>" class="search">
  <input
    name="searchkey"
    id="s_key"
    placeholder="输入书名/作者"
    type="text"
    class="searchinput"
    autocomplete="off"
    maxlength="50"
    required
  >
  <input name="searchtype" id="type" type="hidden" value="all">
  <input type="submit" name="t_btnsearch" value="搜索" class="go">
</form>
