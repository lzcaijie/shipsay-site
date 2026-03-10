<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$pid = (isset($pid) && (int)$pid > 0) ? (int)$pid : 1;
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <link rel="canonical" href="<?=$site_url?><?=$uri?>">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="/" title="<?=SITE_NAME?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li><a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></li>
        <li><a href="<?=$info_url?>"><?=$articlename?></a></li>
        <li class="active">章节目录<?php if($pid>1):?>（第<?=$pid?>页）<?php endif;?></li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2 hidden-xs">
                    <img class="img-thumbnail" alt="<?=$articlename?>" src="<?=$img_url?>" title="<?=$articlename?>" width="140" height="180" />
                </div>
                <div class="col-sm-10 pl0">
                    <h1 class="bookTitle" style="margin-top:0;">
                        <a href="<?=$info_url?>" title="<?=$articlename?>"><?=$articlename?></a>
                        <small class="text-muted" style="font-size:14px;"> 章节目录</small>
                    </h1>
                    <p class="booktag">
                        <a class="red" href="<?=$author_url?>" title="<?=$author?>"><i class="glyphicon glyphicon-user fs-12" aria-hidden="true"></i> <?=$author?></a>
                        <span class="blue"><i class="glyphicon glyphicon-font fs-12" aria-hidden="true"></i> <?=$words_w?>万字</span>
                        <span class="blue"><i class="glyphicon glyphicon-hourglass fs-12" aria-hidden="true"></i> <?=$isfull?></span>
                        <span class="blue"><i class="glyphicon glyphicon-time fs-12" aria-hidden="true"></i> <?=$lastupdate?></span>
                    </p>
                    <p class="text-muted" style="margin:0;">
                        <a class="btn btn-default btn-sm" href="<?=$info_url?>">返回详情页</a>
                        <a class="btn btn-danger btn-sm" href="<?=$first_url?>" rel="nofollow">开始阅读</a>
                    </p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> 章节列表<?php if($pid>1):?>（第<?=$pid?>页）<?php endif;?></div>
        <dl class="panel-body panel-chapterlist">
            <?php if(!empty($list_arr) && is_array($list_arr)): ?>
                <?php foreach($list_arr as $v): ?>
                    <dd class="col-sm-4"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></dd>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="clear"></div>
        </dl>
    </div>

    <?php if(!empty($htmltitle)): ?>
    <div class="panel panel-default">
        <div class="panel-body" style="text-align:center;">
            <?=$htmltitle?>
        </div>
    </div>
    <?php endif; ?>

    <div class="clear"></div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
