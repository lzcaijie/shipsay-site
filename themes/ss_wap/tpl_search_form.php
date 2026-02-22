<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $searchkey_safe = isset($searchkey) ? trim($searchkey) : ''; ?>
<?php
$search_url_safe = function_exists('ss_search_url')
    ? ss_search_url()
    : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
?>

<form id="post" name="t_frmsearch" method="post" action="<?=$search_url_safe?>">
    <table cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
            <td style="width:50px;">
                <div id="type" class="type">综合</div>
            </td>
            <td style=" background-color:#fff; border:1px solid #CCC;">
                <input id="s_key" name="searchkey" type="text" class="key" value="<?=$searchkey_safe?>" placeholder="输入书名/作者" maxlength="50">
                <input type="hidden" name="searchtype" value="all">
            </td>
            <td style="width:35px; background-color:#0080C0; background-image:url('/static/<?=$theme_dir?>/search.png'); background-repeat:no-repeat; background-position:center">
                <input name="t_btnsearch" type="submit" value="" class="go">
            </td>
        </tr>
    </table><span id="s_tips"></span>
</form>
