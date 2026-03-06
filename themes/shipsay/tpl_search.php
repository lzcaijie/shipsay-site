<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
$searchkey_raw = isset($searchkey) ? (string)$searchkey : '';
$searchkey_safe = htmlspecialchars($searchkey_raw, ENT_QUOTES, 'UTF-8');
$search_count_safe = isset($search_count) ? intval($search_count) : 0;
$search_lower = function ($text) {
    return function_exists('mb_strtolower') ? mb_strtolower((string)$text, 'UTF-8') : strtolower((string)$text);
};
$search_highlight = function ($text) use ($searchkey_raw, $search_lower) {
    $text = (string)$text;
    if ($searchkey_raw === '') return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $parts = preg_split('/(' . preg_quote($searchkey_raw, '/') . ')/iu', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
    if (!is_array($parts)) return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $out = '';
    $needle = $search_lower($searchkey_raw);
    foreach ($parts as $part) {
        $safe = htmlspecialchars($part, ENT_QUOTES, 'UTF-8');
        if ($part !== '' && $search_lower($part) === $needle) {
            $out .= '<span class="hot">' . $safe . '</span>';
        } else {
            $out .= $safe;
        }
    }
    return $out;
};
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
	<div class="side_commend" style="width:100%;">
		<p class="title"><i class="fa fa-search">&nbsp;</i>搜索 "<?=$searchkey_safe?>" 共有 "<?=$search_count_safe?>" 条数据</p>
		<ul class="flex">
			<?php if(is_array($search_res)): ?><?php foreach($search_res as $k => $v): ?>	
			<li class="searchresult">
				<div class="img_span">
					<a href="<?=$v['info_url']?>"><img class="lazy" src="<?=Url::nocover_url()?>" data-original="<?=$v['img_url']?>" title="<?=$v['articlename']?>" loading="lazy" /><span<?php if($v['isfull'] == '全本'): ?> class="full"<?php endif ?>><?=$v['sortname_2']?> / <?=$v['isfull']?></span></a>
				</div>
				<div>
					<a href="<?=$v['info_url']?>"><h3><?=$search_highlight($v['articlename'])?></h3></a>
					<p><i class="fa fa-user-circle-o">&nbsp;</i><?=$search_highlight($v['author'])?>&nbsp;&nbsp;<span class="s_gray"><?=$v['words_w']?> 万字&nbsp;&nbsp;<?=Text::ss_lastupdate($v['lastupdate'])?></span></p>
					<p class="searchresult_p"><?=$v['intro_des']?></p>
					<p><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></p>
				</div>
			</li>
			<?php endforeach ?><?php endif ?>
		</ul>
		<div class="s_gray tc">注意：最多显示100条结果</div>
	</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
