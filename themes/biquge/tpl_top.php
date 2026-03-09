<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) $seo_title = '排行榜_' . SITE_NAME;
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) $seo_keywords = '排行榜,热门小说,' . SITE_NAME;
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) $seo_description = SITE_NAME . '小说排行榜聚合页。';
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$rank_entry_url_raw = isset($rank_entry_url) && $rank_entry_url ? rtrim((string)$rank_entry_url, '/') . '/' : ((isset($fake_top) && $fake_top) ? rtrim((string)$fake_top, '/') . '/' : '');
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
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
    <div class="border3-2 mt8">
        <div class="info-title">
            <a href="<?=htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8')?>">首页</a> &gt; 排行榜
        </div>
        <div class="info-chapters-title"><strong>小说排行榜</strong></div>
        <div class="info-commend">
            <?php foreach ($rank_sections as $key => $conf): ?>
                <a href="<?=htmlspecialchars((string)$conf['more'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8')?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php if (!empty($rank_sections)): ?>
    <?php $section_keys = array_keys($rank_sections); ?>
    <?php for ($i = 0; $i < count($section_keys); $i += 2): ?>
    <div class="container flex flex-wrap section-bottom mb20">
        <?php for ($j = $i; $j < min($i + 2, count($section_keys)); $j++): ?>
            <?php
            $key = $section_keys[$j];
            $conf = $rank_sections[$key];
            $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
            ?>
            <div class="border3-1 popular">
                <p><?=htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8')?></p>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $idx => $v): ?>
                    <div class="list-out">
                        <span>[<?=($idx + 1)?>] <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a></span>
                        <span class="gray"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="padding:20px;color:#888;">暂无数据</div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
    <?php endfor; ?>
<?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
