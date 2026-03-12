<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$esc = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$articlename_safe = isset($articlename) ? (string)$articlename : '';
$intro_des_safe   = isset($intro_des) ? (string)$intro_des : '';
$author_safe      = isset($author) ? (string)$author : '';
$sortname_safe    = isset($sortname) ? (string)$sortname : '';
$isfull_safe      = isset($isfull) ? (string)$isfull : '';
$words_w_safe     = isset($words_w) ? (string)$words_w : '';
$lastchapter_safe = isset($lastchapter) ? (string)$lastchapter : '';
$img_url_safe     = isset($img_url) ? (string)$img_url : '';
$first_url_safe   = isset($first_url) ? (string)$first_url : '';
$info_url_safe    = isset($info_url) ? (string)$info_url : '';
$last_url_safe    = isset($last_url) ? (string)$last_url : '';
$index_url_safe   = isset($index_url) && $index_url ? (string)$index_url : '';
$site_home_url_safe = !empty($site_url) ? (string)$site_url : '/';
$sortid_safe      = isset($sortid) ? (int)$sortid : 0;
$chapters_safe    = isset($chapters) ? (int)$chapters : 0;
$chapterrows_safe = (!empty($chapterrows) && is_array($chapterrows)) ? $chapterrows : [];
$langtailrows_safe = (!empty($langtailrows) && is_array($langtailrows)) ? $langtailrows : [];
$latest_rows_safe = [];
if (!empty($lastchapter_arr) && is_array($lastchapter_arr)) {
    $latest_rows_safe = $lastchapter_arr;
} elseif (!empty($lastarr) && is_array($lastarr)) {
    $latest_rows_safe = $lastarr;
} elseif (!empty($chapterrows_safe)) {
    $latest_rows_safe = array_reverse(array_slice($chapterrows_safe, -12, 12));
}
$latest_rows_safe = array_slice($latest_rows_safe, 0, 12);
$preview_rows_safe = [];
if (!empty($preview_chapters) && is_array($preview_chapters)) {
    $preview_rows_safe = $preview_chapters;
} elseif (!empty($chapterrows_safe)) {
    $preview_rows_safe = array_slice($chapterrows_safe, 0, 50);
}
$preview_rows_safe = array_slice($preview_rows_safe, 0, 50);
$lastupdate_ts = 0;
if (isset($lastupdate_stamp) && is_numeric($lastupdate_stamp)) {
    $lastupdate_ts = (int)$lastupdate_stamp;
} elseif (isset($lastupdate) && is_numeric($lastupdate)) {
    $lastupdate_ts = (int)$lastupdate;
} elseif (!empty($lastupdate) && is_string($lastupdate)) {
    $tmp_ts = strtotime($lastupdate);
    if ($tmp_ts) {
        $lastupdate_ts = $tmp_ts;
    }
}
$lastupdate_text = $lastupdate_ts > 0 ? date('Y-m-d', $lastupdate_ts) : (isset($lastupdate_cn) ? (string)$lastupdate_cn : '');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta name="applicable-device" content="pc,mobile">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
?>
<title><?=$esc($seo_title)?></title>
<meta name="keywords" content="<?=$esc($seo_keywords)?>">
<meta name="description" content="<?=$esc($seo_description)?>">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-title" content="<?=SITE_NAME?>">
<link rel="apple-touch-icon" href="/static/<?=$theme_dir?>/images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
<style>
@media screen and (max-width: 768px){.g_header {background-color: rgba(0,0,0,.1);}.g_drop_sel .bhn:hover {background-color: rgba(0,0,0,.1);}}
.youdu-book-shell{padding-bottom:18px}.youdu-meta-grid{display:flex;flex-wrap:wrap;gap:10px 16px;margin:0 0 16px}.youdu-meta-grid strong{display:inline-flex;align-items:center;min-width:calc(50% - 8px)}.youdu-action-row{display:flex;flex-wrap:wrap;gap:12px;margin-top:18px}.youdu-action-row .bt.alt{background:#fff;color:#365899;border:1px solid #365899}.youdu-section{margin-top:18px;padding:18px 20px;background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.05)}.youdu-section-head{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:14px}.youdu-section-head h3{font-size:20px;font-weight:700;color:#222}.youdu-section-head .meta{font-size:13px;color:#777}.youdu-chapter-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 16px}.youdu-chapter-grid a{display:block;padding:10px 12px;border:1px solid #ececf2;border-radius:10px;background:#fafbff;color:#222;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.youdu-chapter-grid a:hover{color:#365899;border-color:#cfd8ef}.youdu-preview-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px 16px}.youdu-preview-list li{list-style:none}.youdu-preview-list a{display:block;padding:8px 0;border-bottom:1px solid #f0f0f0;color:#333;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.youdu-preview-list a:hover{color:#365899}.youdu-more-link{display:inline-flex;align-items:center;justify-content:center;min-width:180px;margin-top:16px;padding:11px 16px;border-radius:999px;background:#365899;color:#fff}.youdu-more-link:hover{color:#fff;opacity:.92}.rel-novel{margin-top:18px;display:flex;flex-wrap:wrap;gap:10px;align-items:flex-start}.rel-novel .rel-title{padding:7px 0;color:#666}.rel-novel a{display:inline-flex;align-items:center;padding:7px 12px;border-radius:999px;background:#f3f6fb;border:1px solid #d8e3f5;color:#365899}.rel-novel a:hover{background:#eaf1ff}@media (max-width: 900px){.youdu-chapter-grid,.youdu-preview-list{grid-template-columns:1fr}}@media (max-width: 768px){.youdu-meta-grid strong{min-width:100%}.youdu-action-row .bt,.youdu-action-row .bt.alt{flex:1 1 calc(50% - 6px);text-align:center}.youdu-section{padding:15px}.youdu-section-head{align-items:flex-start;flex-direction:column}.rel-novel{gap:8px}.rel-novel a{max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}}
</style>
</head>
<body style="zoom: 1;">
<div class="page">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="det-hd pt25 mb30">
    <div class="g_wrap">
        <p class="g_bread fs16 c_strong mb30 ell">
            <a href="<?=$esc($site_home_url_safe)?>" class="fs12 i c_strong"><svg><use xlink:href="#i-bread"></use></svg></a>
            <span class="vam"><a href="<?=$esc($site_home_url_safe)?>" class="c_strong vam" title="<?=SITE_NAME?>" style="text-transform: capitalize;"><?=SITE_NAME?></a>/ </span>
            <a href="<?=Sort::ss_sorturl($sortid_safe)?>" class="c_strong vam" title="<?=$esc($sortname_safe)?>" style="text-transform: capitalize;"><?=$esc($sortname_safe)?></a>
            <span class="vam"> / <?=$esc($articlename_safe)?></span>
        </p>
        <div class="det-info g_row c_strong fs16 pr book-detail-x youdu-book-shell">
            <img src="<?=$esc($img_url_safe)?>" class="book-cover-blur hide" alt="<?=$esc($articlename_safe)?>">
            <div class="cover g_col_4"><span class="g_thumb"><img src="<?=$esc($img_url_safe)?>" width="300" height="400" alt="<?=$esc($articlename_safe)?>" loading="lazy"></span></div>
            <div class="g_col_8 pr">
                <h1 class="mb15 lh1d2 oh"><?=$esc($articlename_safe)?></h1>
                <div class="youdu-meta-grid">
                    <strong><svg class="fs20 mr5"><use xlink:href="#i-pen"></use></svg><span><?=$esc($author_safe)?></span></strong>
                    <strong><svg class="fs20 mr5"><use xlink:href="#i-others"></use></svg><span><?=$esc($sortname_safe)?></span></strong>
                    <strong><svg class="fs20 mr5"><use xlink:href="#i-chapter"></use></svg><span><?=$esc($isfull_safe)?></span></strong>
                    <strong><svg class="fs20 mr5"><use xlink:href="#i-all"></use></svg><span><?=$esc($words_w_safe)?>万字</span></strong>
                </div>
                <div class="h112 mb15 det-abt lh1d8 c_strong fs16 hm-scroll"><p><?=$esc($intro_des_safe)?><br></p></div>
                <div class="youdu-action-row">
                    <?php if($first_url_safe !== ''): ?><a id="j_read" href="<?=$esc($first_url_safe)?>" title="立即阅读" class="bt">立即阅读</a><?php endif; ?>
                    <?php if($index_url_safe !== ''): ?><a href="<?=$esc($index_url_safe)?>" title="查看目录" class="bt alt">查看目录</a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="g_wrap det-con pb30 pt10" id="Contents">
    <section class="youdu-section">
        <div class="youdu-section-head">
            <h3>最新12章</h3>
            <span class="meta"><?php if($lastchapter_safe !== ''): ?>最新：<a href="<?=$esc($last_url_safe)?>"><?=$esc($lastchapter_safe)?></a><?php endif; ?><?php if($lastupdate_text !== ''): ?>&nbsp;&nbsp;<?=$esc($lastupdate_text)?><?php endif; ?></span>
        </div>
        <div class="youdu-chapter-grid"><?php foreach($latest_rows_safe as $row): ?><a href="<?=$esc($row['cid_url'])?>" title="<?=$esc($row['cname'])?>"><?=$esc($row['cname'])?></a><?php endforeach; ?></div>
    </section>
    <section class="youdu-section">
        <div class="youdu-section-head"><h3>顺序预览（前50章）</h3><span class="meta"><?php if($chapters_safe > 0): ?>共<?=$chapters_safe?>章<?php endif; ?></span></div>
        <ol class="youdu-preview-list"><?php foreach($preview_rows_safe as $row): ?><li><a href="<?=$esc($row['cid_url'])?>" title="<?=$esc($articlename_safe . ' ' . $row['cname'])?>"><?=$esc($row['cname'])?></a></li><?php endforeach; ?></ol>
        <?php if(!empty($index_url_safe)): ?><a class="youdu-more-link" href="<?=$esc($index_url_safe)?>">查看更多章节<?php if($chapters_safe > 0): ?>（共<?=$chapters_safe?>章）<?php endif; ?></a><?php endif; ?>
    </section>
    <?php if ($is_langtail == 1 && !empty($langtailrows_safe)) : ?>
        <div class="rel-novel"><span class="rel-title">相关小说：</span><?php foreach ($langtailrows_safe as $v) : ?><a href="<?=$esc($v['info_url'])?>" title="<?=$esc($v['langname'])?>"><?=$esc($v['langname'])?></a><?php endforeach; ?></div>
    <?php endif; ?>
    <div id="lv-container" data-id="city" data-uid="MTAyMC8zMDYwMy83MTU4" style="padding-top:30px;"></div>
</div>
<div class="g_footer"><div class="g_row"><div class="g_col_9"><?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?></div></div></div>
<div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>tongji();</script>
<script>(function(){var bp = document.createElement('script');bp.src = "//zz.bdstatic.com/linksubmit/push.js";var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(bp, s);})();</script>
</div>
</body>
</html>
