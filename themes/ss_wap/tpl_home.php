<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
$site_home_url_raw = function_exists('ss_home_url') ? (string)ss_home_url() : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$recentread_url_raw = function_exists('ss_recentread_url') ? (string)ss_recentread_url() : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_raw = function_exists('ss_full_allbooks_url') ? (string)ss_full_allbooks_url() : '';
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<div class="index-head">
    <h1><a href="<?=$site_home_url_attr?>" class="logo"><?=$site_name_html?></a></h1>
    <?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow" class="btn">记录</a><?php endif; ?>
    <?php if ($full_allbooks_url_raw !== ''): ?><a href="<?=$full_allbooks_url_attr?>" rel="nofollow" class="btn">完本</a><?php endif; ?>
    <a href="javascript:;" onclick="toggleSort();" rel="nofollow" class="btn">分类</a>
</div>
<div class="sort c_sort" id="submenu" style="display:none;">
    <ul>
        <?php $top_url_raw = function_exists('ss_top_url') ? (string)ss_top_url() : ''; ?>
        <?php foreach(Sort::ss_sorthead() as $v): ?>
            <?php if (rtrim((string)$v['sorturl'], '/') === rtrim($top_url_raw, '/') || (isset($v['sortname']) && mb_strpos((string)$v['sortname'], '排行') !== false)) continue; ?>
            <li><a href="<?=htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8')?></a></li>
        <?php endforeach ?>
        <div class="cc"></div>
    </ul>
</div>
<div class="search">
<?php
$searchkey_value = isset($searchkey) ? trim((string)$searchkey) : '';
$searchkey_attr = ss_h($searchkey_value);
$search_url_raw = function_exists('ss_search_url') ? (string)ss_search_url() : '';
$search_url_attr = ss_h($search_url_raw);
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
</div>
<div class="s_m">
    <div class="q_top c_big"><p class="c_big_border">重磅推荐</p></div>
    <div class="cc"></div>
    <?php foreach($commend as $k => $v): ?><?php if($k == 0):?>
    <div class="sort_top">
        <table>
            <tr>
                <td class="s_bt"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><img height="100" width="80" src="<?=htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8')?>" alt="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>" /></a></td>
                <td>
                    <div class="s_div"><a class="s_title" href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a> / <?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?>
                        <br/><a class="s_intro" href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"> <?=htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8')?></a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?php else: ?>
    <div class="s_list"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?>：《<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>》</a></div>
    <?php endif?><?php endforeach?>
</div>
<?php
$home_sections = [
    ['title' => '热门小说', 'more' => '', 'rows' => isset($popular) && is_array($popular) ? $popular : []],
    ['title' => Sort::ss_sortname(1,1), 'more' => Sort::ss_sorturl(1), 'rows' => isset($sort1) && is_array($sort1) ? $sort1 : []],
    ['title' => Sort::ss_sortname(2,1), 'more' => Sort::ss_sorturl(2), 'rows' => isset($sort2) && is_array($sort2) ? $sort2 : []],
    ['title' => Sort::ss_sortname(3,1), 'more' => Sort::ss_sorturl(3), 'rows' => isset($sort3) && is_array($sort3) ? $sort3 : []],
    ['title' => Sort::ss_sortname(4,1), 'more' => Sort::ss_sorturl(4), 'rows' => isset($sort4) && is_array($sort4) ? $sort4 : []],
    ['title' => Sort::ss_sortname(5,1), 'more' => Sort::ss_sorturl(5), 'rows' => isset($sort5) && is_array($sort5) ? $sort5 : []],
];
foreach ($home_sections as $section):
    $section_rows = $section['rows'];
    if (empty($section_rows)) continue;
?>
<div class="s_m">
    <div class="q_top c_big">
        <p class="c_big_border"><?=htmlspecialchars((string)$section['title'], ENT_QUOTES, 'UTF-8')?></p>
        <?php if (!empty($section['more'])): ?><div class="more"><a href="<?=htmlspecialchars((string)$section['more'], ENT_QUOTES, 'UTF-8')?>">更多</a></div><?php endif; ?>
    </div>
    <div class="cc"></div>
    <?php foreach($section_rows as $k => $v): ?><?php if($k == 0):?>
    <div class="sort_top">
        <table>
            <tr>
                <td class="s_bt"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><img height="100" width="80" src="<?=htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8')?>" alt="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>" /></a></td>
                <td>
                    <div class="s_div"><a class="s_title" href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a> / <?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?>
                        <br/><a class="s_intro" href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"> <?=htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8')?></a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?php elseif($k < 9): ?>
    <div class="s_list"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?>：《<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>》</a></div>
    <?php endif?><?php endforeach?>
</div>
<?php endforeach; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
