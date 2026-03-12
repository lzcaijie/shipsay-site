<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_entry_url_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$rank_detail_base_raw = !empty($rank_detail_base) ? (string)$rank_detail_base : $rank_entry_url_raw;
$top_url_raw = $rank_entry_url_raw;
$top_url_attr = htmlspecialchars($top_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
$rank_page_title = '排行榜';
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = $rank_page_title . '_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = '排行榜,日榜,周榜,月榜,总榜,推荐榜,收藏榜,' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = SITE_NAME . '小说排行榜聚合页，查看日榜、周榜、月榜、总榜、推荐榜、收藏榜。';
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($top_url_raw !== ''): ?>
<link rel="canonical" href="<?=$top_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$top_url_attr?>">
<meta property="og:url" content="<?=$top_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<style>
.simple-rank-head{margin:12px 0 16px}.simple-rank-head h1{font-size:24px;margin:0 0 8px}.simple-rank-head p{color:#666;line-height:1.8}
.simple-rank-tabs{display:flex;flex-wrap:nowrap;gap:10px;margin:0 0 16px;overflow:hidden}
.simple-rank-tabs a{display:block;padding:8px 14px;border:1px solid #ddd;background:#fff;color:#333;text-decoration:none;box-sizing:border-box;white-space:nowrap}
.simple-rank-grid{overflow:hidden}
.simple-rank-grid:after{content:'';display:block;clear:both}
.simple-rank-card{float:left;width:49%;margin:0 2% 16px 0;border:1px solid #ddd;background:#fff;box-sizing:border-box}
.simple-rank-card:nth-child(2n){margin-right:0}
.simple-rank-card-head{display:flex;justify-content:space-between;align-items:center;padding:10px 12px;border-bottom:1px solid #eee;background:#f7f7f7}
.simple-rank-card-head h2{font-size:16px;margin:0}.simple-rank-card-head a{color:#666;text-decoration:none}
.simple-rank-list{margin:0;padding:10px 12px 12px 36px}.simple-rank-list li{line-height:2;overflow:hidden}.simple-rank-list li em{float:right;color:#999;font-style:normal}.simple-rank-empty{color:#999}
@media (max-width:768px){.simple-rank-tabs{display:flex;flex-wrap:nowrap;gap:8px;overflow-x:auto;overflow-y:hidden;-webkit-overflow-scrolling:touch;padding-bottom:2px}.simple-rank-tabs a{flex:0 0 auto;margin:0;white-space:nowrap}.simple-rank-card{float:none;width:100%;margin:0 0 16px}}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="content">
        <ol class="breadcrumb">
            <li><a href="<?=$site_home_url_attr?>">首页</a></li>
            <li class="active">排行榜</li>
        </ol>
        <div class="simple-rank-head">
            <h1>排行榜</h1>
            <p>按榜单类型查看热门作品</p>
        </div>
        <?php if (!empty($rank_sections)): ?>
        <div class="simple-rank-tabs">
            <?php foreach ($rank_sections as $key => $conf): ?>
                <?php $more_attr = htmlspecialchars((string)($conf['more'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                <?php if ($more_attr !== ''): ?><a href="<?=$more_attr?>"><?=htmlspecialchars((string)($conf['title'] ?? '榜单'), ENT_QUOTES, 'UTF-8')?></a><?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="simple-rank-grid">
            <?php foreach ($rank_sections as $key => $conf): ?>
                <?php $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : []; ?>
                <div class="simple-rank-card">
                    <div class="simple-rank-card-head">
                        <h2><?=htmlspecialchars((string)($conf['title'] ?? '榜单'), ENT_QUOTES, 'UTF-8')?></h2>
                        <?php $more_attr = htmlspecialchars((string)($conf['more'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                        <?php if ($more_attr !== ''): ?><a href="<?=$more_attr?>">更多</a><?php endif; ?>
                    </div>
                    <ol class="simple-rank-list">
                        <?php if (!empty($list)): ?>
                            <?php foreach (array_slice($list, 0, $rank_limit) as $i => $v): ?>
                                <li>
                                    <span><?=$i + 1?>.</span>
                                    <a href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)($v['articlename'] ?? ''), ENT_QUOTES, 'UTF-8')?></a>
                                    <em><?=htmlspecialchars((string)($v['author'] ?? ''), ENT_QUOTES, 'UTF-8')?></em>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="simple-rank-empty">暂无数据</li>
                        <?php endif; ?>
                    </ol>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
