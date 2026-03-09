<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$search_url_raw = function_exists('ss_search_url')
    ? (string)ss_search_url()
    : ((isset($fake_search) && $fake_search) ? (string)$fake_search : '');
$search_url_attr = htmlspecialchars($search_url_raw, ENT_QUOTES, 'UTF-8');
$searchkey_value_raw = isset($searchkey) ? (string)$searchkey : '';
$searchkey_value_attr = htmlspecialchars($searchkey_value_raw, ENT_QUOTES, 'UTF-8');
$search_placeholder_raw = isset($search_placeholder) && $search_placeholder !== ''
    ? (string)$search_placeholder
    : '输入书名/作者';
$search_placeholder_attr = htmlspecialchars($search_placeholder_raw, ENT_QUOTES, 'UTF-8');
?>
<form id="post" name="t_frmsearch" method="post" class="search"<?php if ($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
  <input
    name="searchkey"
    id="s_key"
    value="<?=$searchkey_value_attr?>"
    placeholder="<?=$search_placeholder_attr?>"
    type="text"
    class="searchinput"
    autocomplete="off"
    maxlength="50"
    required
  >
  <input name="searchtype" id="type" type="hidden" value="all">
  <input type="submit" name="t_btnsearch" value="搜索" class="go"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>
</form>
