<?php if (!defined('__ROOT_DIR__')) exit; ?>
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
<div class="store shipsay-store">
    <div class="store_left">
        <i id="store_menu" class="fa fa-bars fa-3x" onclick="javascript: store_menu();" title="筛选菜单"></i>
        <div class="side_commend category-panel">
            <div class="title"><span><?=$sortname?></span></div>
            <div class="category-entry-links">
                <a href="<?=$allbooks_url?>">全部小说</a>
                <a href="<?=$full_url?>"><?=$fullflag ? '当前已筛全本' : '只看全本'?></a>
                <a href="<?=$fake_recentread?>">阅读记录</a>
            </div>
            <div id="after_menu">
                <div><a href="javascript:" onclick="document.location='<?=$full_url?>'"><label><input type="checkbox"<?php if($fullflag): ?> checked="checked"<?php endif ?> /> 只看全本</label></a></div>
                <div><a href="<?=$allbooks_url?>" <?php if($sortid == -1): ?> class="onselect"<?php endif?>>全部分类</a>
                    <?php foreach($sortcategory as $k => $v): ?>
                        <a href="<?=$v['sorturl']?>"<?php if($sortid == $k): ?> class="onselect"<?php endif?>><?=$v['sortname']?></a>
                    <?php endforeach ?>
                </div>
            </div>
            <ul class="flex category-card-list">
                <?php if(is_array($retarr)): ?>
                <?php foreach($retarr as $k => $v): ?>
                <li class="category-card">
                    <div class="img_span"><a href="<?=$v['info_url']?>"><img class="lazy" src="<?=Url::nocover_url()?>" data-original="<?=$v['img_url']?>" title="<?=$v['articlename']?>" loading="lazy" /><span<?php if($v['isfull'] != '连载'): ?> class="full"<?php endif ?>><?=$v['sortname_2']?> / <?=$v['isfull']?></span></a></div>
                    <div class="w100 category-card-main">
                        <a href="<?=$v['info_url']?>"><h2><?=$v['articlename']?></h2></a>
                        <p class="indent"><?=$v['intro_des']?></p>
                        <div class="li_bottom">
                            <a href="<?=$v['author_url']?>"><i class="fa fa-user-circle-o">&nbsp;<?=$v['author']?></i></a>
                            <div>
                                <em class="orange"><?=$v['words_w']?>万字</em><em class="blue"><?=Text::ss_lastupdate($v['lastupdate'])?></em>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach ?>
                <?php endif ?>
            </ul>
            <div class="category-pagination">
                <div class="index-container category-page-desktop"><ul><?=$jump_html?></ul></div>
                <div class="index-container category-page-mobile"><?=$jump_html_wap?></div>
            </div>
        </div>
    </div>
    <div id="store_right">
        <ul><li><a href="<?=$allbooks_url?>" <?php if($sortid == -1): ?> class="onselect"<?php endif?>>全部分类</a></li></ul>
        <ul>
            <?php foreach($sortcategory as $k => $v): ?>
                <li><a href="<?=$v['sorturl']?>"<?php if($sortid == $k): ?> class="onselect"<?php endif?>><?=$v['sortname']?></a></li>
            <?php endforeach ?>
        </ul>
        <ul>
            <li onclick="javascript: document.location='<?=$full_url?>'">
                <label><input type="checkbox"<?php if($fullflag): ?> checked="checked"<?php endif ?> /> 只看全本</label>
            </li>
        </ul>
        <ul>
            <li><a href="<?=$fake_recentread?>">阅读记录</a></li>
        </ul>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
