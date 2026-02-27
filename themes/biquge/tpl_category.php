<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $year = isset($year) && $year ? $year : date('Y'); ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
		<?php
	require_once __ROOT_DIR__.'/shipsay/seo.php';
	list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
	?>
	<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
	<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
	<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

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
