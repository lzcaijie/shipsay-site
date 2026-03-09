<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$commend_list = isset($commend) && is_array($commend) ? $commend : [];
$popular_list = isset($popular) && is_array($popular) ? $popular : [];
$sort1_list = isset($sort1) && is_array($sort1) ? $sort1 : [];
$sort2_list = isset($sort2) && is_array($sort2) ? $sort2 : [];
$sort3_list = isset($sort3) && is_array($sort3) ? $sort3 : [];
$sort4_list = isset($sort4) && is_array($sort4) ? $sort4 : [];
$sort5_list = isset($sort5) && is_array($sort5) ? $sort5 : [];
$sort6_list = isset($sort6) && is_array($sort6) ? $sort6 : [];
$lastupdate_list = isset($lastupdate) && is_array($lastupdate) ? $lastupdate : [];
$postdate_list = isset($postdate) && is_array($postdate) ? $postdate : [];
$link_html_safe = isset($link_html) ? (string)$link_html : '';
$theme_dir_attr = $h(isset($theme_dir) ? $theme_dir : '');
$nocover_src = '/static/' . $theme_dir_attr . '/nocover.jpg';

$home_lastupdate_limit = isset($home_lastupdate_num) ? (int)$home_lastupdate_num : (isset($category_per_page) ? (int)$category_per_page : 20);
if ($home_lastupdate_limit <= 0) $home_lastupdate_limit = 20;
if ($home_lastupdate_limit > 100) $home_lastupdate_limit = 100;
$home_postdate_limit = isset($home_postdate_num) ? (int)$home_postdate_num : (isset($category_per_page) ? (int)$category_per_page : 20);
if ($home_postdate_limit <= 0) $home_postdate_limit = 20;
if ($home_postdate_limit > 100) $home_postdate_limit = 100;
?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title><?=$h($seo_title)?></title>
<meta name="keywords" content="<?=$h($seo_keywords)?>">
<meta name="description" content="<?=$h($seo_description)?>">

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container flex flex-wrap">
    <div class="border3 commend flex flex-between">
        <?php foreach($commend_list as $k => $v): ?><?php if($k < 4):?>
            <div class="outdiv">
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>" alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;"></a>
                <div>
                    <div class="flex flex-between commend-title"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h3><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h3></a> <span><?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                    <div class="intro indent"><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></div>
                </div>
            </div>
        <?php endif ?><?php endforeach ?>
    </div>

    <div class="border3 popular">
        <p>经典推荐</p>
        <?php foreach($popular_list as $k => $v): ?><?php if($k < 8):?>
            <div class="list-out">
                <span>[<?=$h(isset($v['sortname_2']) ? $v['sortname_2'] : '')?>] <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a></span>
                <span class="gray"><?=$h(isset($v['author']) ? $v['author'] : '')?></span>
            </div>
        <?php endif ?><?php endforeach ?>
    </div>
</div>

<div class="container sort-section border3 flex flex-between flex-wrap">
    <div>
        <div class="sort-title">
            <a href="<?=Sort::ss_sorturl(1)?>"><?=Sort::ss_sortname(1,1)?></a>
        </div>
        <div class="sort-bottom">
            <?php foreach($sort1_list as $k => $v): ?><?php if($k == 0):?>
            <div class="sortdiv flex">
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>" alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;"></a>
                <div>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h4><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h4></a>
                    <p><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></p>
                </div>
            </div>
            <?php endif ?><?php endforeach ?>
            <div class="sort-section-more flex flex-wrap">
                <?php foreach($sort1_list as $k => $v): ?><?php if($k > 0):?>
                <div class="sortlist"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a><span class="s_gray">/<?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                <?php endif ?><?php endforeach ?>
            </div>
        </div>
    </div>

    <div class="sort-middle">
        <div class="sort-title">
            <a href="<?=Sort::ss_sorturl(2)?>"><?=Sort::ss_sortname(2,1)?></a>
        </div>
        <div class="sort-bottom">
            <?php foreach($sort2_list as $k => $v): ?><?php if($k == 0):?>
            <div class="sortdiv flex">
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>" alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;"></a>
                <div>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h4><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h4></a>
                    <p><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></p>
                </div>
            </div>
            <?php endif ?><?php endforeach ?>
            <div class="sort-section-more flex flex-wrap">
                <?php foreach($sort2_list as $k => $v): ?><?php if($k > 0):?>
                <div class="sortlist"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a><span class="s_gray">/<?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                <?php endif ?><?php endforeach ?>
            </div>
        </div>
    </div>

    <div>
        <div class="sort-title">
            <a href="<?=Sort::ss_sorturl(3)?>"><?=Sort::ss_sortname(3,1)?></a>
        </div>
        <div class="sort-bottom">
            <?php foreach($sort3_list as $k => $v): ?><?php if($k == 0):?>
            <div class="sortdiv flex">
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>" alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;"></a>
                <div>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h4><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h4></a>
                    <p><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></p>
                </div>
            </div>
            <?php endif ?><?php endforeach ?>
            <div class="sort-section-more flex flex-wrap">
                <?php foreach($sort3_list as $k => $v): ?><?php if($k > 0):?>
                <div class="sortlist"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a><span class="s_gray">/<?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                <?php endif ?><?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<div class="container sort-section border3 flex flex-between flex-wrap">
    <div>
        <div class="sort-title">
            <a href="<?=Sort::ss_sorturl(4)?>"><?=Sort::ss_sortname(4,1)?></a>
        </div>
        <div class="sort-bottom">
            <?php foreach($sort4_list as $k => $v): ?><?php if($k == 0):?>
            <div class="sortdiv flex">
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>" alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;"></a>
                <div>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h4><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h4></a>
                    <p><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></p>
                </div>
            </div>
            <?php endif ?><?php endforeach ?>
            <div class="sort-section-more flex flex-wrap">
                <?php foreach($sort4_list as $k => $v): ?><?php if($k > 0):?>
                <div class="sortlist"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a><span class="s_gray">/<?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                <?php endif ?><?php endforeach ?>
            </div>
        </div>
    </div>

    <div class="sort-middle">
        <div class="sort-title">
            <a href="<?=Sort::ss_sorturl(5)?>"><?=Sort::ss_sortname(5,1)?></a>
        </div>
        <div class="sort-bottom">
            <?php foreach($sort5_list as $k => $v): ?><?php if($k == 0):?>
            <div class="sortdiv flex">
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>" alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;"></a>
                <div>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h4><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h4></a>
                    <p><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></p>
                </div>
            </div>
            <?php endif ?><?php endforeach ?>
            <div class="sort-section-more flex flex-wrap">
                <?php foreach($sort5_list as $k => $v): ?><?php if($k > 0):?>
                <div class="sortlist"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a><span class="s_gray">/<?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                <?php endif ?><?php endforeach ?>
            </div>
        </div>
    </div>

    <div>
        <div class="sort-title">
            <a href="<?=Sort::ss_sorturl(6)?>"><?=Sort::ss_sortname(6,1)?></a>
        </div>
        <div class="sort-bottom">
            <?php foreach($sort6_list as $k => $v): ?><?php if($k == 0):?>
            <div class="sortdiv flex">
                <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>" alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;"></a>
                <div>
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h4><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h4></a>
                    <p><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></p>
                </div>
            </div>
            <?php endif ?><?php endforeach ?>
            <div class="sort-section-more flex flex-wrap">
                <?php foreach($sort6_list as $k => $v): ?><?php if($k > 0):?>
                <div class="sortlist"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a><span class="s_gray">/<?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                <?php endif ?><?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<div class="container flex flex-wrap section-bottom">
    <div class="border3-1 lastupdate">
        <p>最后更新</p>
        <?php foreach($lastupdate_list as $k => $v): ?>
            <?php if($k >= $home_lastupdate_limit) break; ?>
            <div class="list-out">
                <span class="flex w80">
                    <em>[<?=$h(isset($v['sortname']) ? $v['sortname'] : '')?>]</em>
                    <em><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a></em>
                    <em><a href="<?=$h(isset($v['last_url']) ? $v['last_url'] : '')?>"><?=$h(isset($v['lastchapter']) ? $v['lastchapter'] : '')?></a></em>
                </span>
                <span class="gray dispc"><?=$h(isset($v['author']) ? $v['author'] : '')?>&nbsp;&nbsp;<?=!empty($v['lastupdate']) ? date('m-d', (int)$v['lastupdate']) : ''?></span>
            </div>
        <?php endforeach ?>
    </div>

    <div class="border3-1 popular">
        <p>最新入库</p>
        <?php foreach($postdate_list as $k => $v): ?>
            <?php if($k >= $home_postdate_limit) break; ?>
            <div class="list-out">
                <span>[<?=$h(isset($v['sortname_2']) ? $v['sortname_2'] : '')?>] <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a></span>
                <span class="gray"><?=$h(isset($v['author']) ? $v['author'] : '')?></span>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php if ($link_html_safe !== ''): ?>
<div class="container flex">
    <div class="link">友情链接:<?=$link_html_safe?></div>
</div>
<?php endif; ?>
<script>$('nav a:first-child').addClass('orange');</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
