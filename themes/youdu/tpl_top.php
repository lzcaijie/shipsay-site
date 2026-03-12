<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_page_title = '排行榜';
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $rank_page_title . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = '排行榜,点击榜,推荐榜,收藏榜,' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = SITE_NAME . '小说排行榜聚合页，查看日榜、周榜、月榜、总榜、推荐榜、收藏榜。';
}
$site_home_url_safe = !empty($site_url) ? (string)$site_url : '/';
$rank_entry_url_safe = '';
if (isset($rank_entry_url) && $rank_entry_url) {
    $rank_entry_url_safe = (string)$rank_entry_url;
} elseif (isset($fake_top) && $fake_top) {
    $rank_entry_url_safe = (string)$fake_top;
}
$top_sections_safe = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$top_rank_lists_safe = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$top_rank_limit_safe = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta name="applicable-device" content="pc,mobile">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="apple-touch-icon" href="/static/<?=$theme_dir?>/images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">
<script async type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
<style>
.youdu-top-wrap{padding-bottom:30px}
.youdu-top-intro{padding:14px 0 2px;color:#666;font-size:15px}
.youdu-top-tabs{display:flex;flex-wrap:wrap;gap:10px;padding:14px 0 20px}
.youdu-top-tabs a{display:inline-block;padding:8px 14px;border:1px solid #ddd;border-radius:999px;background:#fff;color:#333}
.youdu-top-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
.youdu-top-card{background:#fff;border-radius:10px;padding:18px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
.youdu-top-card-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.youdu-top-card-head h2{font-size:18px;color:#222}
.youdu-top-card ol{margin-left:22px}
.youdu-top-card li{line-height:1.9;color:#666}
.youdu-top-card li span{margin-left:8px;color:#999}
@media (max-width:768px){.youdu-top-grid{grid-template-columns:1fr}.youdu-top-card{padding:14px}}
</style>
</head>
<body style="zoom: 1;">
<div class="page">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

    <div class="lst-hd g_sub_hd pop-lst-hd">
        <div class="g_wrap pr" style="text-transform:capitalize">
            <h1><?=$rank_page_title?></h1>
            <span class="_shadow"><?=$rank_page_title?></span>
        </div>
    </div>

    <div class="g_wrap youdu-top-wrap">
        <p class="youdu-top-intro"><a href="<?=$site_home_url_safe?>">首页</a> / <span>排行榜</span></p>

        <?php if (!empty($top_sections_safe)): ?>
        <div class="youdu-top-tabs">
            <?php foreach ($top_sections_safe as $key => $conf): ?>
                <a href="<?=$conf['more']?>"><?=htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8')?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="youdu-top-grid">
            <?php foreach ($top_sections_safe as $key => $conf): ?>
                <?php $list = isset($top_rank_lists_safe[$key]) && is_array($top_rank_lists_safe[$key]) ? $top_rank_lists_safe[$key] : []; ?>
                <section class="youdu-top-card">
                    <div class="youdu-top-card-head">
                        <h2><?=htmlspecialchars((string)$conf['title'], ENT_QUOTES, 'UTF-8')?></h2>
                        <a href="<?=$conf['more']?>">更多</a>
                    </div>
                    <ol>
                        <?php if (!empty($list)): ?>
                            <?php foreach (array_slice($list, 0, $top_rank_limit_safe) as $i => $v): ?>
                                <li>
                                    <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a>
                                    <span><?=$v['author']?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>暂无数据</li>
                        <?php endif; ?>
                    </ol>
                </section>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="g_footer">
        <div class="g_row">
            <div class="g_col_9"><?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?></div>
        </div>
    </div>
</div>
<div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
<script async type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>tongji();</script>
</body>
</html>
