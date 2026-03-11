<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<?php
$author_safe = isset($author) ? $author : '';
$sortid_safe = isset($sortid) ? $sortid : 0;
?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
    <div class="class">
        <ul>
            <?php if(!empty($sortcategory) && is_array($sortcategory)): ?>
            <?php foreach($sortcategory as $k => $v): ?>
                <li><a href="<?=$v['sorturl']?>"<?php if($sortid_safe == $k): ?> class="onselect"<?php endif?>><?=$v['sortname']?></a></li>
            <?php endforeach ?>
            <?php endif ?>
        </ul>
    </div>
    <div class="content book" id="fengtui">
        <h2 class="text-center"><?=$author_safe?>小说全集列表</h2>
        <?php if(!empty($res) && is_array($res)): ?><?php foreach($res as $k => $v): ?> 
        <div class="bookbox">
            <div class="p10"><span class="num"><?=$k+1?></span>
                <div class="bookinfo">
                    <h4 class="bookname"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h4>
                    <div class="author">作者：<?=$v['author']?></div>
                    <div class="author">字数：<?=$v['words_w']?>万字</div>
                    <div class="author">阅读量：<?=$v['allvisit']?></div>
                    <div class="cat"><span>更新到：</span><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></div>
                    <div class="update"><span>简介：</span><?=$v['intro_des']?></div>
                </div>
                <div class="delbutton"><a class="del_but" href="<?=$v['info_url']?>">阅读</a></div>
            </div>
        </div>
        <?php endforeach ?>
        <?php endif ?>
    </div>
    <div class="clear"></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
