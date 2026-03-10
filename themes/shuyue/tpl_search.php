<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="/" title="<?=SITE_NAME?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li class="active">小说搜索</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 与“<?php if(isset($searchkey) && $searchkey != '') echo $searchkey; ?>”有关的小说
        </div>
        <div class="panel-body">
            <div class="row">
                <?php if(!empty($search_count) && !empty($search_res) && is_array($search_res)): ?>
                <?php foreach($search_res as $k => $v): ?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5">
                            <a href="<?=$v['info_url']?>" class="thumbnail" style="background-image:url(<?=(!empty($v['img_url'])?$v['img_url']:'/static/'.$theme_dir.'/nocover.jpg')?>)"></a>
                        </div>
                        <div class="col-sm-7 pl0">
                            <div class="caption">
                                <h4 class="fs-16 text-muted"><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></h4>
                                <small class="fs-14 text-muted"><?=$v['author']?></small>
                                <p class="fs-12 text-justify hidden-xs"><?=$v['intro_des']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                <?php endif ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
