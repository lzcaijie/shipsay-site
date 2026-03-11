<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$canonical_raw = !empty($uri) ? rtrim((string)$site_url, '/') . (string)$uri : $site_home_url_raw;
$canonical_attr = htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php
    require_once __ROOT_DIR__ . '/shipsay/seo.php';
    list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('author');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <link rel="canonical" href="<?=$canonical_attr?>">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li class="active"><?=$author?></li>
    </ol>

    <div class="panel panel-default hidden-xs">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=$author?> 作品简介
        </div>
        <div class="panel-body">
            <p>
                <a href="<?=$author_url_attr?>"><?=$author?></a>是一名非常出色的小说作者，TA的作品包括：
                <?php if (is_array($res)): ?><?php foreach ($res as $v): ?>
                    《<a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>》
                <?php endforeach; ?><?php endif; ?>
                等等，小说可谓是本本精品，字字珠玑。
                <a href="<?=$author_url_attr?>"><?=$author?></a>所写的小说情节跌宕起伏、扣人心弦，情节与文笔俱佳。
                <?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>强烈建议您到正版网站阅读<a href="<?=$author_url_attr?>"><?=$author?></a>的小说作品，您的每一次阅读都是对作者的认可！
                如果您在<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>阅读<a href="<?=$author_url_attr?>"><?=$author?></a>作品时，遇到问题，请及时反馈，我们将第一时间解决，争取为您奉上一场阅读盛宴！
            </p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=$author?> 的全部<?=$author_count?>部小说
        </div>
        <div class="panel-body">
            <div class="row">
                <?php if (is_array($res)): ?><?php foreach ($res as $v): ?>
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
                <?php endforeach; ?><?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="pages"><ul class="pagination" id="pagelink"></ul></div>
        <div class="clear"></div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
