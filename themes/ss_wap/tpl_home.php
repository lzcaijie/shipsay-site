<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<?php
$full_allbooks_url_safe = (isset($full_allbooks_url) && $full_allbooks_url) ? $full_allbooks_url : ('/quanben' . (isset($allbooks_url) ? $allbooks_url : '/'));
?>

<body>
    <div class="index-head">
        <h1><a href="/" class="logo"><?=SITE_NAME?></a></h1><a href="/bookcase/" rel="nofollow" class="btn">书架</a><a href="<?=$full_allbooks_url_safe?>" rel="nofollow" class="btn">完本</a><a href="javascript:;" onclick="toggleSort();" rel="nofollow" class="btn">排行</a>
    </div>
    <div class="sort c_sort" id="submenu" style="display:none;">
        <ul>
            <?php foreach(Sort::ss_sorthead() as $v): ?>
                <li><a href="<?=$v['sorturl']?>"><?=$v['sortname_2']?></a></li>
            <?php endforeach ?>
            <div class="cc"></div>
        </ul>
    </div>
    <div class="search">
        <?php require_once 'tpl_search_form.php'; ?>
    </div>
    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border">重磅推荐</p>
        </div>
        <div class="cc"></div>
        <?php foreach($commend as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php else: ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>
    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border">热门小说</p>
        </div>
        <div class="cc"></div>
        <?php foreach($popular as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php elseif($k < 9): ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>
    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border"><?=Sort::ss_sortname(1,1)?></p>
            <div class="more"><a href="<?=Sort::ss_sorturl(1)?>">更多</a>
            </div>
        </div>
        <?php foreach($sort1 as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php elseif($k < 9): ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>
    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border"><?=Sort::ss_sortname(2,1)?></p>
            <div class="more"><a href="<?=Sort::ss_sorturl(2)?>">更多</a>
            </div>
        </div>
        <?php foreach($sort2 as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php elseif($k < 9): ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>

    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border"><?=Sort::ss_sortname(3,1)?></p>
            <div class="more"><a href="<?=Sort::ss_sorturl(3)?>">更多</a>
            </div>
        </div>
        <?php foreach($sort3 as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php elseif($k < 9): ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>

    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border"><?=Sort::ss_sortname(4,1)?></p>
            <div class="more"><a href="<?=Sort::ss_sorturl(4)?>">更多</a>
            </div>
        </div>
        <?php foreach($sort4 as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php elseif($k < 9): ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>

    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border"><?=Sort::ss_sortname(5,1)?></p>
            <div class="more"><a href="<?=Sort::ss_sorturl(5)?>">更多</a>
            </div>
        </div>
        <?php foreach($sort5 as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php elseif($k < 9): ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>

    <div class="s_m">
        <div class="q_top c_big">
            <p class="c_big_border"><?=Sort::ss_sortname(6,1)?></p>
            <div class="more"><a href="<?=Sort::ss_sorturl(6)?>">更多</a>
            </div>
        </div>
        <?php foreach($sort6 as $k => $v): ?><?php if($k == 0):?>
        <div class="sort_top">
            <table>
                <tr>
                    <td class="s_bt">
                        <a href="<?=$v['info_url']?>">
                            <img height=100 width=80 src='<?=$v['img_url']?>' />
                        </a>
                    </td>
                    <td>
                        <div class="s_div"><a class="s_title" href="<?=$v['info_url']?>"><?=$v['articlename']?></a> / <?=$v['author']?>
                            <br/><a class="s_intro" href="<?=$v['info_url']?>"> <?=$v['intro_des']?></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php elseif($k < 9): ?>
        <div class="s_list"><a href="<?=$v['info_url']?>"><?=$v['author']?>：《<?=$v['articlename']?>》</a>
        </div>
        <?php endif?><?php endforeach?>
    </div>
<div class="s_m"><h4>友情链接:</h4> <?=$link_html?></div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
