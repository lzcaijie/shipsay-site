<?php if (!defined('__ROOT_DIR__')) exit;?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
$h = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$res_list = !empty($res) && is_array($res) ? $res : [];
$theme_dir_attr = $h(isset($theme_dir) ? $theme_dir : '');
$nocover_src = '/static/' . $theme_dir_attr . '/nocover.jpg';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=$h($seo_title)?></title>
<meta name="keywords" content="<?=$h($seo_keywords)?>">
<meta name="description" content="<?=$h($seo_description)?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container flex flex-wrap mb20">
    <div class="border3 commend flex flex-between category-commend">
        <?php if(!empty($res_list)): ?>
            <?php foreach($res_list as $v): ?>
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
            <?php endforeach ?>
        <?php else: ?>
            <div style="padding:20px;color:#888;">暂无作品</div>
        <?php endif?>
    </div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
