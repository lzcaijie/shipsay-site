<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$esc = static function ($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); };
$articlename_safe = isset($articlename) ? (string)$articlename : '';
$author_safe      = isset($author) ? (string)$author : '';
$sortname_safe    = isset($sortname) ? (string)$sortname : '';
$isfull_safe      = isset($isfull) ? (string)$isfull : '';
$words_w_safe     = isset($words_w) ? (string)$words_w : '';
$intro_des_safe   = isset($intro_des) ? (string)$intro_des : '';
$img_url_safe     = isset($img_url) ? (string)$img_url : '';
$info_url_safe    = isset($info_url) ? (string)$info_url : '';
$index_url_safe   = isset($index_url) && $index_url ? (string)$index_url : '';
$first_url_safe   = isset($first_url) ? (string)$first_url : '';
$last_url_safe    = isset($last_url) ? (string)$last_url : '';
$lastchapter_safe = isset($lastchapter) ? (string)$lastchapter : '';
$site_home_url_safe = !empty($site_url) ? (string)$site_url : '/';
$pid_safe         = isset($pid) ? (int)$pid : 1;
$chapters_safe    = isset($chapters) ? (int)$chapters : 0;
$list_arr_safe    = (!empty($list_arr) && is_array($list_arr)) ? $list_arr : [];
$htmltitle_safe   = isset($htmltitle) ? (string)$htmltitle : '';
$sortid_safe      = isset($sortid) ? (int)$sortid : 0;
$latest_rows_safe = [];
$langtailrows_safe = (!empty($langtailrows) && is_array($langtailrows)) ? $langtailrows : [];
$is_langtail_safe = isset($is_langtail) ? (int)$is_langtail : 0;
if (!empty($lastarr) && is_array($lastarr)) { $latest_rows_safe = array_slice($lastarr, 0, 12); } elseif (!empty($chapterrows) && is_array($chapterrows)) { $latest_rows_safe = array_reverse(array_slice($chapterrows, -12, 12)); }
$lastupdate_ts = 0;
if (isset($lastupdate_stamp) && is_numeric($lastupdate_stamp)) { $lastupdate_ts = (int)$lastupdate_stamp; } elseif (isset($lastupdate) && is_numeric($lastupdate)) { $lastupdate_ts = (int)$lastupdate; } elseif (!empty($lastupdate) && is_string($lastupdate)) { $tmp_ts = strtotime($lastupdate); if ($tmp_ts) $lastupdate_ts = $tmp_ts; }
$lastupdate_text = $lastupdate_ts > 0 ? date('Y-m-d', $lastupdate_ts) : (isset($lastupdate_cn) ? (string)$lastupdate_cn : '');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta name="applicable-device" content="pc,mobile">
<?php require_once __ROOT_DIR__.'/shipsay/seo.php'; list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist'); ?>
<title><?=$esc($seo_title)?></title>
<meta name="keywords" content="<?=$esc($seo_keywords)?>"><meta name="description" content="<?=$esc($seo_description)?>">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="renderer" content="webkit"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"><meta name="apple-mobile-web-app-title" content="<?=SITE_NAME?>">
<link rel="apple-touch-icon" href="/static/<?=$theme_dir?>/images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
<link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script><script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script><script src="/static/<?=$theme_dir?>/js/jquery.cookie.min.js"></script><script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
<style>
.youdu-book-shell{padding-bottom:18px}.youdu-meta-grid{display:flex;flex-wrap:wrap;gap:10px 16px;margin:0 0 16px}.youdu-meta-grid strong{display:inline-flex;align-items:center;min-width:calc(50% - 8px);min-height:24px}.youdu-meta-grid strong svg{flex:0 0 18px;width:18px;height:18px;color:#4f658a}.youdu-meta-grid strong span{display:inline-block;min-width:0}.youdu-action-row{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin-top:18px;align-items:stretch}.youdu-action-row .bt,.youdu-action-row .bt.alt{display:flex!important;align-items:center;justify-content:center;width:100%!important;min-height:50px;height:50px;padding:0 18px;line-height:1.2;box-sizing:border-box;margin:0!important;border-radius:4px}.youdu-action-row .bt.alt{background:#fff;color:#365899;border:1px solid #365899}.youdu-section{margin-top:18px;padding:18px 20px;background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.05)}.youdu-section-head{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:14px}.youdu-section-head h3{font-size:20px;font-weight:700;color:#222}.youdu-section-head .meta{font-size:13px;color:#777}.youdu-chapter-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 16px}.youdu-chapter-grid a{display:block;padding:10px 12px;border:1px solid #ececf2;border-radius:10px;background:#fafbff;color:#222;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.youdu-chapter-grid a:hover{color:#365899;border-color:#cfd8ef}.youdu-chapter-grid--compact a{padding:10px 12px;font-size:inherit}.youdu-page-box{margin-top:16px;text-align:center}.youdu-page-box select,.youdu-page-box .index-container-btn{margin:0 6px}.rel-novel{margin-top:18px;display:flex;flex-wrap:wrap;gap:10px;align-items:flex-start}.rel-novel .rel-title{padding:7px 0;color:#666}.rel-novel a{display:inline-flex;align-items:center;padding:7px 12px;border-radius:999px;background:#f3f6fb;border:1px solid #d8e3f5;color:#365899}.rel-novel a:hover{background:#eaf1ff}@media (max-width: 900px){.youdu-chapter-grid{grid-template-columns:1fr}}@media (max-width: 768px){.youdu-meta-grid strong{min-width:100%}.youdu-action-row{grid-template-columns:1fr}.youdu-action-row .bt,.youdu-action-row .bt.alt{width:100%!important;max-width:none}.youdu-section{padding:15px}.youdu-section-head{align-items:flex-start;flex-direction:column}.rel-novel{gap:8px}.rel-novel a{max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}}
</style>
</head>
<body style="zoom: 1;"><div class="page"><?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="det-hd pt25 mb30"><div class="g_wrap"><p class="g_bread fs16 c_strong mb30 ell"><a href="<?=$esc($site_home_url_safe)?>" class="fs12 i c_strong"><svg><use xlink:href="#i-bread"></use></svg></a><span class="vam"><a href="<?=$esc($site_home_url_safe)?>" class="c_strong vam" title="<?=SITE_NAME?>" style="text-transform: capitalize;"><?=SITE_NAME?></a>/ </span><a href="<?=Sort::ss_sorturl($sortid_safe)?>" class="c_strong vam" title="<?=$esc($sortname_safe)?>" style="text-transform: capitalize;"><?=$esc($sortname_safe)?></a><span class="vam"> / <a href="<?=$esc($info_url_safe)?>" class="c_strong vam"><?=$esc($articlename_safe)?></a> / 目录</span></p>
<div class="det-info g_row c_strong fs16 pr book-detail-x youdu-book-shell"><img src="<?=$esc($img_url_safe)?>" class="book-cover-blur hide" alt="<?=$esc($articlename_safe)?>"><div class="cover g_col_4"><span class="g_thumb"><img src="<?=$esc($img_url_safe)?>" width="300" height="400" alt="<?=$esc($articlename_safe)?>" loading="lazy"></span></div><div class="g_col_8 pr"><h1 class="mb15 lh1d2 oh"><?=$esc($articlename_safe)?></h1><div class="youdu-meta-grid"><strong><svg class="fs20 mr5"><use xlink:href="#i-author"></use></svg><span><?=$esc($author_safe)?></span></strong><strong><svg class="fs20 mr5"><use xlink:href="#i-others"></use></svg><span><?=$esc($sortname_safe)?></span></strong><strong><svg class="fs20 mr5"><use xlink:href="#i-chapter"></use></svg><span><?=$esc($isfull_safe)?></span></strong><strong><svg class="fs20 mr5"><use xlink:href="#i-all"></use></svg><span><?=$esc($words_w_safe)?>万字</span></strong></div><div class="h112 mb15 det-abt lh1d8 c_strong fs16 hm-scroll"><p><?=$esc($intro_des_safe)?><br></p></div><div class="youdu-action-row"><?php if($first_url_safe !== ''): ?><a href="<?=$esc($first_url_safe)?>" title="开始阅读" class="bt">开始阅读</a><?php endif; ?><?php if($info_url_safe !== ''): ?><a href="<?=$esc($info_url_safe)?>" title="返回详情" class="bt alt">返回详情</a><?php endif; ?></div></div></div></div></div>
<div class="g_wrap pb30 pt10"><section class="youdu-section"><div class="youdu-section-head"><h3>最新12章</h3><span class="meta"><?php if($lastchapter_safe !== ''): ?>最新：<a href="<?=$esc($last_url_safe)?>"><?=$esc($lastchapter_safe)?></a><?php endif; ?><?php if($lastupdate_text !== ''): ?>&nbsp;&nbsp;<?=$esc($lastupdate_text)?><?php endif; ?></span></div><div class="youdu-chapter-grid"><?php foreach($latest_rows_safe as $row): ?><a href="<?=$esc($row['cid_url'])?>" title="<?=$esc($row['cname'])?>"><?=$esc($row['cname'])?></a><?php endforeach; ?></div></section><section class="youdu-section"><div class="youdu-section-head"><h3>章节目录（第<?=$pid_safe?>页）</h3><span class="meta"><?php if($chapters_safe > 0): ?>共<?=$chapters_safe?>章<?php endif; ?></span></div><div class="youdu-chapter-grid youdu-chapter-grid--compact"><?php foreach($list_arr_safe as $row): ?><a href="<?=$esc($row['cid_url'])?>" title="<?=$esc($row['cname'])?>"><?=$esc($row['cname'])?></a><?php endforeach; ?></div><?php if($htmltitle_safe !== ''): ?><div class="youdu-page-box"><?=$htmltitle_safe?></div><?php endif; ?></section><?php if ($is_langtail_safe === 1 && !empty($langtailrows_safe)) : ?><section class="youdu-section"><div class="youdu-section-head"><h3>长尾词推荐</h3><span class="meta">相关推荐</span></div><div class="rel-novel"><?php foreach ($langtailrows_safe as $v) : ?><a href="<?=$esc($v['info_url'])?>" title="<?=$esc($v['langname'])?>"><?=$esc($v['langname'])?></a><?php endforeach; ?></div></section><?php endif; ?></div>
<div class="g_footer"><div class="g_row"><div class="g_col_9"><?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?></div></div></div><div class="g_goTop _on"><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div><script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script><script>tongji();</script></div></body></html>
