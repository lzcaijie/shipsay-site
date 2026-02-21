<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $year = isset($year) && $year ? $year : date('Y'); ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
	<title><?php if(!empty($sortname)):?><?=$sortname?>_好看的<?=$sortname?>_<?=$year?><?=$sortname?>小说排行榜<?php else:?>小说书库<?php endif ?>_<?=SITE_NAME?></title>
	<meta name="keywords" content="<?php if(!empty($sortname)):?><?=$sortname?>,好看的<?=$sortname?>,<?=$year?><?=$sortname?>排行榜<?php else:?>小说书库,小说大全,小说阅读<?php endif ?>" />
	<meta name="description" content="<?php if(!empty($sortname)):?><?=SITE_NAME?>是广大书友最值得收藏的<?=$sortname?>阅读网，网站收录了当前最好看的<?=$sortname?>，免费提供高质量的<?=$year?><?=$sortname?>排行榜，是广大<?=$sortname?>爱好者必备的小说阅读网。<?php else:?><?=SITE_NAME?>为您提供小说书库、分类浏览与最新更新内容，方便快速查找好看的小说。<?php endif ?>" />

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container flex flex-wrap">
    <div class="border3 commend flex flex-between category-commend">
        <?php if(!empty($retarr) && is_array($retarr)): ?>
            <?php foreach($retarr as $k => $v): ?><?php if($k < 6):?>
                <div class="category-div">
                    <a href="<?=$v['info_url']?>">
                        <img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>"
                             alt="<?=$v['articlename']?>" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;">
                    </a>
                    <div>
                        <div class="flex flex-between commend-title"><a href="<?=$v['info_url']?>"><h3><?=$v['articlename']?></h3></a> <span><?=$v['author']?></span></div>
                        <div class="intro indent"><?=$v['intro_des']?></div>
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
        <p><?php if(!empty($sortname)):?>最后更新的<?=$sortname?>小说<?php else:?>最后更新<?php endif ?></p>
        <?php if(!empty($retarr) && is_array($retarr)): ?>
            <?php foreach($retarr as $k => $v): ?><?php if($k >= 6):?>
                <div class="list-out">
                    <span class="flex w80"><em>[<?=$v['sortname']?>]</em><em><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></em><em><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></em></span>
                    <span class="gray dispc"><?=$v['author']?>&nbsp;&nbsp;<?=date('m-d',$v['lastupdate'])?></span>
                </div>
            <?php endif ?><?php endforeach ?>
        <?php endif; ?>
    </div>

    <div class="border3-1 popular">
        <p><?php if(!empty($sortname)):?>最新<?=$sortname?>小说<?php else:?>最新入库<?php endif ?></p>
        <?php if(!empty($sort_postdate) && is_array($sort_postdate)): ?>
            <?php $limit = max(0, count($sort_postdate) - 6); ?>
            <?php foreach($sort_postdate as $k => $v): ?>
                <?php if($k < $limit):?>
                    <div class="list-out">
                        <span>[<?=$v['sortname_2']?>] <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></span>
                        <span class="gray"><?=$v['author']?></span>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>

<script>$('nav a:nth-child(<?=$sortid + 1?>)').addClass('orange');</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
