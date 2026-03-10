<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$pid = (isset($pid) && (int)$pid > 0) ? (int)$pid : 1;
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$canonical_raw = rtrim((string)$site_url, '/') . (string)$uri;
$sort_url_raw = Sort::ss_sorturl($sortid);
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$info_url_attr = htmlspecialchars((string)$info_url, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$intro_html = !empty($intro_p) ? $intro_p : $intro_des;
require_once __ROOT_DIR__ . '/shipsay/include/neighbor.php';
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php
    require_once __ROOT_DIR__ . '/shipsay/seo.php';
    list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('indexlist');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <?php if ($canonical_raw !== ''): ?><link rel="canonical" href="<?=htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8')?>"><?php endif; ?>
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li><a href="<?=$sort_url_attr?>"><?=$sortname?></a></li>
        <li><a href="<?=$info_url_attr?>"><?=$articlename?></a></li>
        <li class="active">章节目录<?php if ($pid > 1): ?>（第<?=$pid?>页）<?php endif; ?></li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2 hidden-xs"><img class="img-thumbnail" alt="<?=$articlename?>" src="<?=$img_url_attr?>" title="<?=$articlename?>" width="140" height="180" /></div>
                <div class="col-sm-10 pl0">
                    <h1 class="bookTitle" style="margin-top:0;"><a href="<?=$info_url_attr?>" title="<?=$articlename?>"><?=$articlename?></a> <small class="text-muted" style="font-size:14px;">章节目录</small></h1>
                    <p class="booktag">
                        <a class="red" href="<?=$author_url_attr?>" title="<?=$author?>"><i class="glyphicon glyphicon-user fs-12" aria-hidden="true"></i> <?=$author?></a>
                        <span class="blue"><i class="glyphicon glyphicon-font fs-12" aria-hidden="true"></i> <?=$words_w?>万字</span>
                        <span class="blue"><i class="glyphicon glyphicon-hourglass fs-12" aria-hidden="true"></i> <?=$isfull?></span>
                        <span class="blue"><i class="glyphicon glyphicon-time fs-12" aria-hidden="true"></i> <?=$lastupdate_cn?></span>
                    </p>
                    <p class="text-muted" style="margin:0;">
                        <a class="btn btn-default btn-sm" href="<?=$info_url_attr?>">返回详情页</a>
                        <a class="btn btn-danger btn-sm" href="<?=$first_url_attr?>" rel="nofollow">开始阅读</a>
                    </p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 最新章节信息</div>
        <div class="panel-body">
            <p style="margin:0;">最新章节：<a class="text-danger" href="<?=$last_url?>" title="<?=$lastchapter?>"><?=$lastchapter?></a> <span class="text-muted">（<?=$lastupdate_cn?>）</span></p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-align-left" aria-hidden="true"></span> 简介</div>
        <div class="panel-body text-justify"><?=$intro_html?></div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> 章节列表<?php if ($pid > 1): ?>（第<?=$pid?>页）<?php endif; ?></div>
        <dl class="panel-body panel-chapterlist">
            <?php if (!empty($list_arr) && is_array($list_arr)): ?>
                <?php foreach ($list_arr as $v): ?>
                    <dd class="col-sm-4"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></dd>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="clear"></div>
        </dl>
    </div>

    <?php if (!empty($htmltitle)): ?>
    <div class="panel panel-default">
        <div class="panel-body" style="text-align:center;"><?=$htmltitle?></div>
    </div>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 相关小说推荐<a class="pull-right" href="<?=$sort_url_attr?>">More+</a></div>
        <div class="panel-body">
            <div class="row">
                <?php if (!empty($neighbor) && is_array($neighbor)): ?><?php foreach ($neighbor as $k => $v): ?><?php if ($k < 6): ?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5"><a href="<?=$v['info_url']?>" class="thumbnail" style="background-image:url(<?=$v['img_url']?>)"></a></div>
                        <div class="col-sm-7 pl0">
                            <div class="caption">
                                <h4 class="fs-16 text-muted"><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></h4>
                                <small class="fs-14 text-muted"><?=$v['author']?></small>
                                <p class="fs-12 text-justify hidden-xs"><?=$v['intro_des']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?><?php endforeach; ?><?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
