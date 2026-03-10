<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_qh')) {
    function ss_qh($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_entry_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$rank_entry_attr = ss_qh($rank_entry_raw);
$rank_base_raw = !empty($rank_detail_base) ? (string)$rank_detail_base : '';
$rank_base_attr = ss_qh($rank_base_raw);
$rank_tabs = [
    'allvisit' => '总榜',
    'monthvisit' => '月榜',
    'weekvisit' => '周榜',
    'dayvisit' => '日榜',
    'goodnum' => '收藏榜',
    'allvote' => '推荐榜',
];
$current_title = isset($page_title) && $page_title ? (string)$page_title : '排行榜';
$rank_rows = isset($articlerows) && is_array($articlerows) ? $articlerows : [];
?>
<!DOCTYPE html>
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
                <strong><?=ss_qh($current_title)?></strong>
                <?php if($rank_entry_raw !== ''): ?>
                <a href="<?=$rank_entry_attr?>" class="qula-rank-back">返回聚合榜</a>
                <?php endif; ?>
            </div>
            <div class="qula-rank-nav">
                <?php foreach($rank_tabs as $rank_key => $rank_label): ?>
                    <?php if($rank_base_raw !== ''): ?>
                    <a href="<?=ss_qh($rank_base_raw . $rank_key . '/')?>"<?php if($current_title === $rank_label || strpos($current_title, $rank_label) !== false): ?> class="active"<?php endif; ?>><?=ss_qh($rank_label)?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="tab-bd">
                <ul class="txt-list txt-list-row3 qula-rank-single">
                    <?php if(!empty($rank_rows)): ?>
                        <?php foreach($rank_rows as $k => $v): ?>
                        <li>
                            <span class="s1"><?=($k + 1)?></span>
                            <span class="s2"><a href="<?=ss_qh($v['info_url'])?>"><?=ss_qh($v['articlename'])?></a></span>
                            <span class="s4 xs-hidden"><?=ss_qh($v['author'])?></span>
                            <span class="s5"><?=(isset($v['lastupdate']) && $v['lastupdate']) ? date('m-d', (int)$v['lastupdate']) : ''?></span>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><span class="s2">暂无榜单数据</span></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
