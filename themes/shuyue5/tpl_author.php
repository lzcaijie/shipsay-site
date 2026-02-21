<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$author?>的全部作品-<?=SITE_NAME?></title>
    <meta name="keywords" content="<?=$author?>的全部小说">
    <meta name="description" content="<?=$author?>的全部小说-<?=SITE_NAME?>">
    <link rel="canonical" href="<?=$site_url?><?=$uri?>">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="/" title="<?=SITE_NAME?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li class="active"><?=$author?></li>
    </ol>

    <div class="panel panel-default hidden-xs">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=$author?> 作品简介
        </div>
        <div class="panel-body">
            <p>
                <a href="<?=$author_url?>"><?=$author?></a>是一名非常出色的小说作者，TA的作品包括：
                <?php if(is_array($res)): ?><?php foreach($res as $k => $v): ?>
                    《<a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>》
                <?php endforeach ?><?php endif?>
                等等，小说可谓是本本精品，字字珠玑。
                <a href="<?=$author_url?>"><?=$author?></a>所写的小说情节跌宕起伏、扣人心弦，情节与文笔俱佳。
                <?=SITE_NAME?>强烈建议您到正版网站阅读<a href="<?=$author_url?>"><?=$author?></a>的小说作品，您的每一次阅读都是对作者的认可！
                如果您在<?=SITE_NAME?>阅读<a href="<?=$author_url?>"><?=$author?></a>作品时，遇到问题，请及时反馈，我们将第一时间解决，争取为您奉上一场阅读盛宴！
            </p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=$author?> 的全部<?=$author_count?>部小说
        </div>
        <div class="panel-body">
            <div class="row">
                <?php if(is_array($res)): ?><?php foreach($res as $k => $v): ?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5">
                            <a href="<?=$v['info_url']?>" class="thumbnail" style="background-image:url(<?=$v['img_url']?>)"></a>
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
                <?php endforeach ?><?php endif?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="pages"><ul class="pagination" id="pagelink"></ul></div>
        <div class="clear"></div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
