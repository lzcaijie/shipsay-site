<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$searchkey_value = isset($searchkey) ? trim((string)$searchkey) : '';
$searchkey_attr = ss_h($searchkey_value);
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : '';
$search_url_attr = ss_h($search_url_raw);
$theme_dir_attr = ss_h(isset($theme_dir) ? $theme_dir : 'ss_wap');
?>
<form id="post" name="t_frmsearch" method="post" action="<?=$search_url_attr?>"<?php if ($search_url_raw === ''): ?> onsubmit="return false;"<?php endif; ?>>
    <table cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
            <td style="width:50px;">
                <div id="type" class="type">综合</div>
            </td>
            <td style="background-color:#fff; border:1px solid #CCC;">
                <input id="s_key" name="searchkey" type="text" class="key" value="<?=$searchkey_attr?>" placeholder="输入书名/作者" maxlength="50">
                <input type="hidden" name="searchtype" value="all">
            </td>
            <td style="width:35px; background-color:#0080C0; background-image:url('/static/<?=$theme_dir_attr?>/search.png'); background-repeat:no-repeat; background-position:center">
                <input name="t_btnsearch" type="submit" value="" class="go"<?php if ($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>
            </td>
        </tr>
    </table><span id="s_tips"></span>
</form>
