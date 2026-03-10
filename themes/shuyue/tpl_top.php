<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('rank');
$page_end_scripts = "<script>nav_sel('nav_top');</script>";
$rank_entry_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$rank_entry_attr = htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($rank_entry_raw !== ''): ?><link rel="canonical" href="<?=$rank_entry_attr?>"><?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li class="active">排行榜</li>
    </ol>

    <?php if (!empty($sections)): ?>
    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 榜单切换</div>
        <div class="panel-body" style="padding-bottom:0;">
            <?php foreach ($sections as $key => $conf): ?>
                <?php $more_url = isset($conf['more']) ? (string)$conf['more'] : ''; ?>
                <?php $title_text = isset($conf['title']) ? (string)$conf['title'] : '榜单'; ?>
                <?php if ($more_url !== ''): ?><a href="<?=htmlspecialchars($more_url, ENT_QUOTES, 'UTF-8')?>" style="display:inline-block;margin:0 12px 12px 0;"><?=htmlspecialchars($title_text, ENT_QUOTES, 'UTF-8')?></a><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($sections as $key => $conf): ?>
            <?php
            $title_text = isset($conf['title']) ? (string)$conf['title'] : '榜单';
            $more_url = isset($conf['more']) ? (string)$conf['more'] : '';
            $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
            ?>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-signal" aria-hidden="true"></span> <?=htmlspecialchars($title_text, ENT_QUOTES, 'UTF-8')?>
                        <?php if ($more_url !== ''): ?><a class="pull-right" href="<?=htmlspecialchars($more_url, ENT_QUOTES, 'UTF-8')?>">更多</a><?php endif; ?>
                    </div>
                    <ol class="list-group" style="margin-bottom:0;">
                        <?php if (!empty($list)): ?>
                            <?php foreach ($list as $i => $v): ?><?php if ($i >= $rank_limit) break; ?>
                            <li class="list-group-item">
                                <span class="badge"><?=$i + 1?></span>
                                <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>" title="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a>
                                <span class="text-muted" style="margin-left:6px;"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></span>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">暂无数据</li>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($sections)): ?>
    <div class="panel panel-default">
        <div class="panel-body text-muted">
            当前暂无聚合榜数据<?php if ($rank_entry_raw !== ''): ?>，可前往 <a href="<?=$rank_entry_attr?>">排行榜</a> 查看单榜页面。<?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
