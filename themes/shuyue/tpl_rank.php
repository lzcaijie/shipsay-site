<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('rank');
$page_end_scripts = "<script>nav_sel('nav_top');</script>";
$rank_entry_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$rank_entry_attr = htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8');
$rank_base_raw = !empty($rank_detail_base) ? rtrim((string)$rank_detail_base, '/') . '/' : '';
$current_title = isset($page_title) && $page_title ? (string)$page_title : '小说排行榜';
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$canonical_raw = isset($uri) && $uri ? rtrim((string)$site_url, '/') . (string)$uri : $rank_entry_raw;
$rank_tabs = [
    'allvisit' => '总榜',
    'monthvisit' => '月榜',
    'weekvisit' => '周榜',
    'dayvisit' => '日榜',
    'goodnum' => '收藏榜',
    'allvote' => '推荐榜',
];
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <?php if ($canonical_raw !== ''): ?><link rel="canonical" href="<?=htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8')?>"><?php endif; ?>
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li><?php if ($rank_entry_raw !== ''): ?><a href="<?=$rank_entry_attr?>">排行榜</a><?php else: ?>排行榜<?php endif; ?></li>
        <li class="active"><?=htmlspecialchars($current_title, ENT_QUOTES, 'UTF-8')?></li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=htmlspecialchars($current_title, ENT_QUOTES, 'UTF-8')?>
            <?php if ($rank_entry_raw !== ''): ?><a class="pull-right" href="<?=$rank_entry_attr?>">聚合榜</a><?php endif; ?>
        </div>
        <?php if ($rank_base_raw !== ''): ?>
        <div class="panel-body" style="padding-bottom:0;">
            <?php foreach ($rank_tabs as $rank_key => $rank_label): ?>
                <a href="<?=htmlspecialchars($rank_base_raw . $rank_key . '/', ENT_QUOTES, 'UTF-8')?>" style="display:inline-block;margin:0 12px 12px 0;<?php if ($current_title === $rank_label || mb_strpos($current_title, $rank_label) !== false): ?>color:#d9534f;font-weight:700;<?php endif; ?>"><?=$rank_label?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <table class="table">
            <tr>
                <th width="48" class="hidden-xs">类型</th>
                <th>书名</th>
                <th class="hidden-xs">最新章节</th>
                <th>作者</th>
                <th class="hidden-xs">字数</th>
                <th width="72">更新</th>
                <th class="hidden-xs" width="64">状态</th>
            </tr>
            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
            <?php foreach ($articlerows as $k => $v): ?><?php if ($k < 48): ?>
            <tr>
                <td class="fs-12 hidden-xs"><?=$v['sortname_2']?></td>
                <td><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></td>
                <td class="hidden-xs"><a class="text-muted" href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></td>
                <td class="fs-12 text-muted"><?=$v['author']?></td>
                <td class="fs-12 hidden-xs"><?=$v['words_w']?>万字</td>
                <td class="fs-12"><?=date('m-d', $v['lastupdate'])?></td>
                <td class="fs-12 hidden-xs"><?=$v['isfull']?></td>
            </tr>
            <?php endif; ?><?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="7" class="text-center text-muted">暂无榜单数据</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
