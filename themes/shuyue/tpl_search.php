<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$nocover_url_attr = '/static/' . $theme_dir_attr . '/nocover.jpg';
$searchkey_text = isset($searchkey) ? trim((string)$searchkey) : '';
$searchkey_html = htmlspecialchars($searchkey_text, ENT_QUOTES, 'UTF-8');
$has_search_res = !empty($search_count) && !empty($search_res) && is_array($search_res);
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php
    require_once __ROOT_DIR__ . '/shipsay/seo.php';
    list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('search');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li class="active">小说搜索</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
            <?php if ($searchkey_text !== ''): ?>与“<?=$searchkey_html?>”有关的小说<?php else: ?>搜索结果<?php endif; ?>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php if ($has_search_res): ?>
                    <?php foreach ($search_res as $v): ?>
                    <div class="col-xs-4 book-coverlist">
                        <div class="row">
                            <div class="col-sm-5">
                                <a href="<?=$v['info_url']?>" class="thumbnail" style="background-image:url(<?=(!empty($v['img_url']) ? $v['img_url'] : $nocover_url_attr)?>)"></a>
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
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-xs-12">
                        <p class="text-muted" style="margin:0;">暂无相关结果，请尝试更换书名或作者关键词。</p>
                    </div>
                <?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
