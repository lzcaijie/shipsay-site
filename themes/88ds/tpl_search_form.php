<?php if (!defined('__ROOT_DIR__')) exit; ?>

<form id="post" name="t_frmsearch" method="post" action="/search/" class="search">
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
