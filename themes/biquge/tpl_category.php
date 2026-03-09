<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$year = isset($year) && $year ? $year : date('Y');
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$retarr_list = !empty($retarr) && is_array($retarr) ? $retarr : [];
$sort_postdate_list = !empty($sort_postdate) && is_array($sort_postdate) ? $sort_postdate : [];
$sortname_html = $h(isset($sortname) ? $sortname : '');
$theme_dir_attr = $h(isset($theme_dir) ? $theme_dir : '');
$nocover_src = '/static/' . $theme_dir_attr . '/nocover.jpg';
$sortid_num = isset($sortid) ? (int)$sortid : 0;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=$h($seo_title)?></title>
<meta name="keywords" content="<?=$h($seo_keywords)?>">
<meta name="description" content="<?=$h($seo_description)?>">

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container flex flex-wrap">
    <div class="border3 commend flex flex-between category-commend">
        <?php if(!empty($retarr_list)): ?>
            <?php foreach($retarr_list as $k => $v): ?><?php if($k < 6):?>
                <div class="category-div">
                    <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>">
                        <img class="lazy" src="<?=$nocover_src?>" data-original="<?=$h(isset($v['img_url']) ? $v['img_url'] : '')?>"
                             alt="<?=$h(isset($v['articlename']) ? $v['articlename'] : '')?>" onerror="this.src='<?=$nocover_src?>';this.onerror=null;">
                    </a>
                    <div>
                        <div class="flex flex-between commend-title"><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><h3><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></h3></a> <span><?=$h(isset($v['author']) ? $v['author'] : '')?></span></div>
                        <div class="intro indent"><?=$h(isset($v['intro_des']) ? $v['intro_des'] : '')?></div>
                    </div>
                </div>
            <?php endif ?><?php endforeach ?>
        <?php else: ?>
            <div style="padding:20px;color:#888;">暂无内容</div>
        <?php endif; ?>
    </div>
</div>

<div class="container flex flex-wrap section-bottom mb20">
    <div class="border3-1 lastupdate">
        <p><?php if($sortname_html !== ''):?>最后更新的<?=$sortname_html?>小说<?php else:?>最后更新<?php endif ?></p>
        <?php if(!empty($retarr_list)): ?>
            <?php foreach($retarr_list as $k => $v): ?><?php if($k >= 6):?>
                <div class="list-out">
                    <span class="flex w80"><em>[<?=$h(isset($v['sortname']) ? $v['sortname'] : '')?>]</em><em><a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a></em><em><a href="<?=$h(isset($v['last_url']) ? $v['last_url'] : '')?>"><?=$h(isset($v['lastchapter']) ? $v['lastchapter'] : '')?></a></em></span>
                    <span class="gray dispc"><?=$h(isset($v['author']) ? $v['author'] : '')?>&nbsp;&nbsp;<?=!empty($v['lastupdate']) ? date('m-d',(int)$v['lastupdate']) : ''?></span>
                </div>
            <?php endif ?><?php endforeach ?>
        <?php endif; ?>
    </div>

    <div class="border3-1 popular">
        <p><?php if($sortname_html !== ''):?>最新<?=$sortname_html?>小说<?php else:?>最新入库<?php endif ?></p>
        <?php if(!empty($sort_postdate_list)): ?>
            <?php $limit = max(0, count($sort_postdate_list) - 6); ?>
            <?php foreach($sort_postdate_list as $k => $v): ?>
                <?php if($k < $limit):?>
                    <div class="list-out">
                        <span>[<?=$h(isset($v['sortname_2']) ? $v['sortname_2'] : '')?>] <a href="<?=$h(isset($v['info_url']) ? $v['info_url'] : '')?>"><?=$h(isset($v['articlename']) ? $v['articlename'] : '')?></a></span>
                        <span class="gray"><?=$h(isset($v['author']) ? $v['author'] : '')?></span>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>

<script>$('nav a:nth-child(<?=$sortid_num + 1?>)').addClass('orange');</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
