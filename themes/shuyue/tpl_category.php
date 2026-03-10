<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$cateurl=$_SERVER['SERVER_PORT']==443?'https://':'http://';
$cateurl.=$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
$curid = 0;
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <link rel="canonical" href="<?=$cateurl?>">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; require_once __THEME_DIR__ . '/tpl_fun.php'; ?>
<div class="class">
    <ul class="container">
        <?php if(!empty($sortcategory) && is_array($sortcategory)): ?>
        <?php foreach($sortcategory as $k => $v): ?>
        <li><a id="sort<?=$k?>" href="<?=$v['sorturl']?>"><?=$v['sortname']?></a></li>
        <?php if($sortid == $k): $curid=$k; endif ?>
        <?php endforeach ?>
        <?php endif ?>
    </ul>
</div>
<div class="container body-content">
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-fire" aria-hidden="true"></span> 热门<?php if($sortname !='全部小说'):?><?=$sortname?><?php endif ?>小说<a class="pull-right" href="<?=$allbooks_url?>">More+</a>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php if(!empty($retarr) && is_array($retarr)): ?>
                <?php foreach($retarr as $k => $v): ?><?php if($k < 6):?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5">
                            <a href="<?=$v['info_url']?>" class="cover_46f thumbnail" style="background-image:url(<?=(!empty($v['img_url'])?$v['img_url']:'/static/'.$theme_dir.'/nocover.jpg')?>)" ></a>
                        </div>
                        <div class="col-sm-7 pl0">
                            <div class="caption">
                                <h4 class="fs-16 text-muted"><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>" ><?=$v['articlename']?></a></h4>
                                <small class="fs-14 text-muted"><?=$v['author']?></small>
                                <p class="fs-12 text-justify hidden-xs"><?=$v['intro_des']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?><?php endforeach ?>
                <?php endif ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?php if($sortname !='全部小说'):?><?=$sortname?><?php endif ?>小说列表</div>
        <table class="table">
            <tr>
                <th width=48 class="hidden-xs">类型</th>
                <th>书名</th>
                <th class="hidden-xs">最新章节</th>
                <th>作者</th>
                <th class="hidden-xs">字数</th>
                <th width="72">更新</th>
                <th class="hidden-xs" width="64">状态</th>
            </tr>
            <?php if(is_array($retarr)): ?><?php foreach($retarr as $k => $v): ?>
            <tr>
                <td class="fs-12 hidden-xs"><?=$v['sortname_2']?></td>
                <td><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=subtext($v['articlename'], 8)?></a></td>
                <td class="hidden-xs"><a class="text-muted" href="<?=$v['last_url']?>"><?=subtext($v['lastchapter'], 22)?></a></td>
                <td class="fs-12 text-muted"><?=$v['author']?></td>
                <td class="fs-12 hidden-xs"><?=$v['words_w']?>万字</td>
                <td class="fs-12"><?=date('m-d',$v['lastupdate'])?></td>
                <td class="fs-12 hidden-xs"><?=$v['isfull']?></td>
            </tr>
            <?php endforeach ?><?php endif?>
        </table>
    </div>
</div>
<?php
if($fullflag){
    $page_end_scripts = "<script>nav_sel('nav_full');nav_sel('sort{$curid}');</script>";
}else{
    $page_end_scripts = "<script>nav_sel('nav_sort');nav_sel('sort{$curid}');</script>";
}
?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
