<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=SITE_NAME?>_<?=SITE_NAME?>网_书友最值得收藏的网络小说阅读网</title>
<meta name="keywords" content="<?=SITE_NAME?>,<?=SITE_NAME?>网,最新<?=SITE_NAME?>,<?=SITE_NAME?>阅读网">
<meta name="description" content="<?=SITE_NAME?>,<?=SITE_NAME?>网,最新<?=SITE_NAME?>,<?=SITE_NAME?>阅读网，是广大书友最值得收藏的网络小说阅读网，网站收录了当前最火热的网络小说，免费提供高质量的小说最新章节，是广大网络小说爱好者必备的小说阅读网。">
<link rel="canonical" href="<?=$site_url?>">
<?php require_once 'tpl_header.php'; require_once 'tpl_fun.php'; ?>
<div class="body_46f container body-content">
    <div class="section_46f panel panel-default">
        <div class="title_46f panel-heading">
            <span class="glyphicon glyphicon-fire" aria-hidden="true"></span> 推荐阅读<a class="pull-right" href="/rank/">More+</a>
        </div>
        <div class="content_46f panel-body">
            <div class="list_46f row">
                <?php if(!empty($commend) && is_array($commend)): ?>
                <?php foreach($commend as $k => $v): ?><?php if($k < 6):?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5">
                            <a href="<?=$v['info_url']?>" class="cover_46f thumbnail" style="background-image:url(<?=(!empty($v['img_url'])?$v['img_url']:'/static/'.$theme_dir.'/nocover.jpg')?>)"></a>
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
                <?php endif ?><?php endforeach ?>
                <?php endif ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="list_46f row">
        <div class="col-md-4">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=Sort::ss_sortname(1,1)?><a class="pull-right" href="<?=Sort::ss_sorturl(1)?>">More+</a>
                </div>
                <ul class="list-group list-top">
                    <?php if(!empty($sort1) && is_array($sort1)): ?>
                    <?php foreach($sort1 as $k => $v): ?><?php if($k < 4):?>
                    <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>" class="list-group-item"><span class="t"><?=$v['articlename']?></span><span class="pull-right fs-12"><?=$v['author']?></span></a>
                    <?php endif ?><?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4 pl0">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=Sort::ss_sortname(2,1)?><a class="pull-right" href="<?=Sort::ss_sorturl(2)?>">More+</a>
                </div>
                <ul class="list-group list-top">
                    <?php if(!empty($sort2) && is_array($sort2)): ?>
                    <?php foreach($sort2 as $k => $v): ?><?php if($k < 4):?>
                    <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>" class="list-group-item"><span class="t"><?=$v['articlename']?></span><span class="pull-right fs-12"><?=$v['author']?></span></a>
                    <?php endif ?><?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4 pl0">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=Sort::ss_sortname(3,1)?><a class="pull-right" href="<?=Sort::ss_sorturl(3)?>">More+</a>
                </div>
                <ul class="list-group list-top">
                    <?php if(!empty($sort3) && is_array($sort3)): ?>
                    <?php foreach($sort3 as $k => $v): ?><?php if($k < 4):?>
                        <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>" class="list-group-item"><span class="t"><?=$v['articlename']?></span><span class="pull-right fs-12"><?=$v['author']?></span></a>
                    <?php endif ?><?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=Sort::ss_sortname(4,1)?><a class="pull-right" href="<?=Sort::ss_sorturl(4)?>">More+</a>
                </div>
                <ul class="list-group list-top">
                    <?php if(!empty($sort4) && is_array($sort4)): ?>
                    <?php foreach($sort4 as $k => $v): ?><?php if($k < 4):?>
                        <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>" class="list-group-item"><span class="t"><?=$v['articlename']?></span><span class="pull-right fs-12"><?=$v['author']?></span></a>
                    <?php endif ?><?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4 pl0">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=Sort::ss_sortname(5,1)?><a class="pull-right" href="<?=Sort::ss_sorturl(5)?>">More+</a>
                </div>
                <ul class="list-group list-top">
                    <?php if(!empty($sort5) && is_array($sort5)): ?>
                    <?php foreach($sort5 as $k => $v): ?><?php if($k < 4):?>
                        <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>" class="list-group-item"><span class="t"><?=$v['articlename']?></span><span class="pull-right fs-12"><?=$v['author']?></span></a>
                    <?php endif ?><?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4 pl0">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=Sort::ss_sortname(6,1)?><a class="pull-right" href="<?=Sort::ss_sorturl(6)?>">More+</a>
                </div>
                <ul class="list-group list-top">
                    <?php if(!empty($sort6) && is_array($sort6)): ?>
                    <?php foreach($sort6 as $k => $v): ?><?php if($k < 4):?>
                        <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>" class="list-group-item"><span class="t"><?=$v['articlename']?></span><span class="pull-right fs-12"><?=$v['author']?></span></a>
                    <?php endif ?><?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="list_46f row">
        <div class="col-md-4">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 新书推荐<a class="pull-right" href="<?=$allbooks_url?>">More+</a>
                </div>
                <table class="table">
                    <tbody>
                    <?php if(!empty($postdate) && is_array($postdate)): ?>
                    <?php foreach($postdate as $k => $v) { if($k < 20) { ?>
                    <tr>
                        <td class="text-muted hidden-xs" width="48"><?=$v['sortname_2']?></td>
                        <td class=""><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=mb_substr($v['articlename'], 0, 7)?></a></td>
                        <td class="text-right fs-12" title="<?=$v['author']?>"><?=$v['author']?></td>
                    </tr>
                    <?php }} ?>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8 pl0">
            <div class="section_46f panel panel-default">
                <div class="title_46f panel-heading">
                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span> 最近更新<a class="pull-right" href="<?=$allbooks_url?>">More+</a>
                </div>
                <table class="table">
                    <tbody>
                    <?php if(!empty($lastupdate) && is_array($lastupdate)): ?>
                    <?php foreach($lastupdate as $k => $v) { if($k < 20) { ?>
                    <tr>
                        <td class="text-muted hidden-xs" width="48"><?=$v['sortname_2']?></td>
                        <td class=""><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=mb_substr($v['articlename'], 0, 7)?></a></td>
                        <td class="hidden-xs"><a href="<?=$v['last_url']?>" title="<?=$v['lastchapter']?>"><?=mb_substr($v['lastchapter'], 0, 16)?></a></td>
                        <td class="text-right fs-12" title="<?=$v['author']?>"><?=$v['author']?></td>
                        <td class="fs-12 hidden-xs" width="72"><?=date('m-d',$v['lastupdate'])?></td>
                    </tr>
                    <?php }} ?>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php require_once 'tpl_footer.php'; ?>
<script>nav_sel('nav_index');</script>
