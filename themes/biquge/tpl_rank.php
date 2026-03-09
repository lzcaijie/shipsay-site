<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$title_arr = [
    'allvisit' => '总点击榜',
    'monthvisit' => '月点击榜',
    'weekvisit' => '周点击榜',
    'dayvisit' => '日点击榜',
    'allvote' => '总推荐榜',
    'monthvote' => '月推荐榜',
    'weekvote' => '周推荐榜',
    'dayvote' => '日推荐榜',
    'goodnum' => '收藏榜',
];
$current_query = isset($query) && $query ? (string)$query : 'allvisit';
$current_title = isset($title_arr[$current_query]) ? $title_arr[$current_query] : '排行榜';
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) $seo_title = $current_title . '_' . SITE_NAME;
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) $seo_keywords = $current_title . ',' . SITE_NAME . ',排行榜';
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) $seo_description = SITE_NAME . $current_title . '页面。';
$rank_entry_url_raw = isset($rank_entry_url) && $rank_entry_url ? rtrim((string)$rank_entry_url, '/') . '/' : ((isset($fake_top) && $fake_top) ? rtrim((string)$fake_top, '/') . '/' : '');
$rank_detail_base_raw = isset($rank_detail_base) && $rank_detail_base ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="border3-2 mt8 mb20">
        <div class="info-title">
            <a href="<?=htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8')?>">首页</a> &gt; <?php if ($rank_entry_url_raw !== ''): ?><a href="<?=htmlspecialchars($rank_entry_url_raw, ENT_QUOTES, 'UTF-8')?>">排行榜</a><?php else: ?>排行榜<?php endif; ?> &gt; <?=$current_title?>
        </div>
        <div class="info-chapters-title"><strong><?=$current_title?></strong></div>
        <div class="info-commend">
            <?php foreach ($title_arr as $key => $label): ?>
                <a href="<?=htmlspecialchars($rank_detail_base_raw . $key . '/', ENT_QUOTES, 'UTF-8')?>"><?=$label?></a>
            <?php endforeach; ?>
        </div>
        <div class="popular">
            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
                <?php foreach ($articlerows as $k => $v): ?>
                <div class="list-out">
                    <span>
                        <em>[<?=($k + 1)?>]</em>
                        <em><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a></em>
                        <em class="dispc"><a href="<?=htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></a></em>
                    </span>
                    <span class="gray"><?=htmlspecialchars(Text::ss_lastupdate($v['lastupdate']), ENT_QUOTES, 'UTF-8')?></span>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="padding:20px;color:#888;">暂无排行榜数据</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
