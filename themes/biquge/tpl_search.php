<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container flex flex-wrap mb20">
    <div class="border3 commend flex flex-between category-commend">
        <?php if(!empty($search_count) && !empty($search_res) && is_array($search_res)) :?>
            <?php foreach($search_res as $k => $v): ?>
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
            <?php endforeach ?>
        <?php else: ?>
            <div style="padding:20px;color:#888;">暂无搜索结果</div>
        <?php endif?>
    </div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
