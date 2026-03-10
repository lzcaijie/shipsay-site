<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_qh')) {
    function ss_qh($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_entry_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$rank_entry_attr = ss_qh($rank_entry_raw);
$sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=ss_qh($seo_title)?></title>
<meta name="keywords" content="<?=ss_qh($seo_keywords)?>">
<meta name="description" content="<?=ss_qh($seo_description)?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="row row-rank">
        <div class="layout layout-col1">
            <div class="layout-tit qula-rank-head">
                <strong>排行榜</strong>
                <?php if($rank_entry_raw !== ''): ?>
                <a href="<?=$rank_entry_attr?>" class="qula-rank-back">当前聚合榜</a>
                <?php endif; ?>
            </div>
            <div class="qula-rank-grid">
                <?php foreach($sections as $section_key => $section_conf): ?>
                <?php
                    $section_title = isset($section_conf['title']) ? (string)$section_conf['title'] : '榜单';
                    $section_more = isset($section_conf['more']) ? (string)$section_conf['more'] : '';
                    $section_rows = isset($rank_lists[$section_key]) && is_array($rank_lists[$section_key]) ? $rank_lists[$section_key] : [];
                ?>
                <div class="qula-rank-card">
                    <div class="qula-rank-card-hd">
                        <strong><?=ss_qh($section_title)?></strong>
                        <?php if($section_more !== ''): ?><a href="<?=ss_qh($section_more)?>">更多</a><?php endif; ?>
                    </div>
                    <ol class="qula-rank-list">
                        <?php if(!empty($section_rows)): ?>
                            <?php foreach($section_rows as $k => $v): ?>
                                <?php if($k >= $rank_limit) break; ?>
                                <li>
                                    <span class="num"><?=($k + 1)?></span>
                                    <a href="<?=ss_qh($v['info_url'])?>" title="<?=ss_qh($v['articlename'])?>"><?=ss_qh($v['articlename'])?></a>
                                    <span class="author"><?=ss_qh($v['author'])?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="empty">暂无数据</li>
                        <?php endif; ?>
                    </ol>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
