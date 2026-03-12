<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh"><head><meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
$list_arr_safe = (!empty($list_arr) && is_array($list_arr)) ? $list_arr : [];
$htmltitle_safe = isset($htmltitle) ? (string)$htmltitle : '';
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$sort_url_attr = htmlspecialchars((string)Sort::ss_sorturl($sortid), ENT_QUOTES, 'UTF-8');
$canonical_raw = function_exists('ss_abs_url') ? ss_abs_url(isset($uri) ? (string)$uri : ((isset($index_url) && $index_url) ? (string)$index_url : '')) : '';
$canonical_attr = htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8');
$info_abs_url_raw = function_exists('ss_abs_url') ? ss_abs_url($info_url_raw) : $info_url_raw;
$info_abs_url_attr = htmlspecialchars($info_abs_url_raw, ENT_QUOTES, 'UTF-8');
$intro_html = !empty($intro_p) ? (string)$intro_p : nl2br(htmlspecialchars((string)$intro_des, ENT_QUOTES, 'UTF-8'));
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>"><meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>"><?php if ($canonical_raw !== ''): ?><link rel="canonical" href="<?=$canonical_attr?>"><?php endif; ?>
<meta property="og:type" content="novel"><meta property="og:title" content="<?=htmlspecialchars((string)$seo_title, ENT_QUOTES, 'UTF-8')?>"><meta property="og:description" content="<?=htmlspecialchars((string)$seo_description, ENT_QUOTES, 'UTF-8')?>"><?php if ($canonical_raw !== ''): ?><meta property="og:url" content="<?=$canonical_attr?>"><?php endif; ?><?php if ($info_abs_url_raw !== ''): ?><meta property="og:novel:url" content="<?=$info_abs_url_attr?>"><?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body><?php ss_render_page_top(['page_title' => '章节目录', 'page_back_url' => $info_url_raw, 'show_back' => true]); ?>
<div class="bookinfo ss-book-panel"><table cellpadding="0" cellspacing="0"><tr>
<td><img src="<?=htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8')?>" width="100" height="130" alt="<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;"></td>
<td valign="top" class="info"><p><strong><?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?></strong></p><p>作者：<a href="<?=htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8')?></a></p><p>类别：<a href="<?=$sort_url_attr?>"><?=htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8')?></a></p><p>状态：<?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?></p><p>字数：<?=intval($words_w)?>万字</p><p>最新：<a href="<?=htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8')?></a></p><p>当前页：第<?=max(1, intval($pid))?>页</p></td>
</tr></table><table cellpadding="0" cellspacing="0" class="book-op"><tr><td><?php if (!empty($first_url)): ?><a href="<?=htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8')?>">开始阅读</a><?php else: ?><span>开始阅读</span><?php endif; ?></td><td><?php if ($info_url_raw !== ''): ?><a href="<?=$info_url_attr?>">返回详情</a><?php else: ?><span>返回详情</span><?php endif; ?></td><td><?php $recentread_url_raw = ss_recentread_url(); ?><?php if ($recentread_url_raw !== ''): ?><a href="<?=ss_h($recentread_url_raw)?>" rel="nofollow">阅读记录</a><?php else: ?><span>阅读记录</span><?php endif; ?></td></tr></table></div>
<div class="book-itemtitle">内容简介</div><div class="intro"><?=$intro_html?></div>
<div class="lb_mulu ss-indexlist-wrap" id="alllist"><div class="book-itemtitle">《<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>》章节目录</div><div class="cc"></div><ul class="last9 chapter-preview-list"><?php foreach($list_arr_safe as $k => $v): ?><?php if (isset($v['chaptertype']) && intval($v['chaptertype']) === 1): ?><li class="title"><span><?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?></span></li><?php else: ?><li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?></a></li><?php endif; ?><?php endforeach ?></ul><div class="index-container"><?=$htmltitle_safe?></div></div>
<?php if ($is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)) : ?><div class="s_m related-box"><div class="q_top c_big"><p class="c_big_border">相关推荐</p></div><div class="cc"></div><div class="related-links"><?php foreach ($langtailrows as $v) : ?><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8')?></a><?php endforeach ?></div></div><?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
