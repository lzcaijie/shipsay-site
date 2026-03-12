<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
$index_url_raw = isset($index_url) && $index_url ? (string)$index_url : '';
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars(isset($first_url) ? (string)$first_url : '', ENT_QUOTES, 'UTF-8');
$langtailrows_safe = (!empty($langtailrows) && is_array($langtailrows)) ? $langtailrows : [];
$lastarr_safe = (!empty($lastarr) && is_array($lastarr)) ? $lastarr : [];
$canonical_raw = function_exists('ss_abs_url') ? ss_abs_url(isset($uri) ? (string)$uri : '') : (isset($uri) ? (string)$uri : '');
$canonical_attr = htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8');
$author_abs_url_raw = function_exists('ss_abs_url') ? ss_abs_url(isset($author_url) ? (string)$author_url : '') : (isset($author_url) ? (string)$author_url : '');
$author_abs_url_attr = htmlspecialchars($author_abs_url_raw, ENT_QUOTES, 'UTF-8');
$info_abs_url_raw = function_exists('ss_abs_url') ? ss_abs_url(isset($info_url) ? (string)$info_url : '') : (isset($info_url) ? (string)$info_url : '');
$info_abs_url_attr = htmlspecialchars($info_abs_url_raw, ENT_QUOTES, 'UTF-8');
$last_abs_url_raw = function_exists('ss_abs_url') ? ss_abs_url(isset($last_url) ? (string)$last_url : '') : (isset($last_url) ? (string)$last_url : '');
$last_abs_url_attr = htmlspecialchars($last_abs_url_raw, ENT_QUOTES, 'UTF-8');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($canonical_raw !== ""): ?><link rel="canonical" href="<?=$canonical_attr?>"><?php endif; ?>
<meta property="og:type" content="novel">
<meta property="og:title" content="<?=htmlspecialchars((string)$articlename . '(' . (string)$author . ')_' . (string)$articlename . '全文免费阅读无弹窗_' . (string)$articlename . '最新章节阅读_' . (string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:image" content="<?=htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars((string)$intro_des, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:category" content="<?=htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:author" content="<?=htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8')?>">
<?php if ($author_abs_url_raw !== ""): ?><meta property="og:novel:author_link" content="<?=$author_abs_url_attr?>"><?php endif; ?>
<meta property="og:novel:book_name" content="<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>">
<?php if ($canonical_raw !== ""): ?><meta property="og:novel:read_url" content="<?=$canonical_attr?>"><?php endif; ?>
<?php if ($info_abs_url_raw !== ""): ?><meta property="og:novel:url" content="<?=$info_abs_url_attr?>"><?php elseif ($canonical_raw !== ""): ?><meta property="og:novel:url" content="<?=$canonical_attr?>"><?php endif; ?>
<meta property="og:novel:status" content="<?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:update_time" content="<?=htmlspecialchars((string)$lastupdate, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:novel:lastest_chapter_name" content="<?=htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8')?>">
<?php if ($last_abs_url_raw !== ""): ?><meta property="og:novel:lastest_chapter_url" content="<?=$last_abs_url_attr?>"><?php endif; ?>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<?php ss_render_page_top(['page_title' => (string)$articlename, 'show_back' => true]); ?>
<div class="bookinfo">
    <table cellpadding="0" cellspacing="0"><tr>
        <td><img src="<?=htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8')?>" border="0" width="100" height="130" alt="<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>"/></td>
        <td valign="top" class="info">
            <p><strong><?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?></strong></p>
            <p>作者：<a href="<?=htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8')?></a></p>
            <p>类别：<a href="<?=htmlspecialchars((string)Sort::ss_sorturl($sortid), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8')?></a></p>
            <p>状态：<?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?></p>
            <p>更新：<?=htmlspecialchars((string)$lastupdate, ENT_QUOTES, 'UTF-8')?></p>
            <p>最新：<a href="<?=htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8')?></a></p>
        </td>
    </tr></table>
    <table cellpadding="0" cellspacing="0" class="book-op"><tr>
        <td><?php $recentread_url_raw = ss_recentread_url(); ?><?php if ($recentread_url_raw !== ""): ?><a href="<?=ss_h($recentread_url_raw)?>" rel="nofollow">阅读记录</a><?php else: ?><span>阅读记录</span><?php endif; ?></td>
        <td><?php if ($index_url_raw !== ''): ?><a href="<?=$index_url_attr?>">章节目录</a><?php else: ?><span>章节目录</span><?php endif; ?></td>
        <td><?php if (!empty($first_url)): ?><a href="<?=$first_url_attr?>">立即阅读</a><?php else: ?><span>立即阅读</span><?php endif; ?></td>
    </tr></table>
</div>
<div class="book-itemtitle">小说简介</div>
<div class="intro"><?=$intro_p?></div>
<div class="lb_mulu">
    <div class="book-itemtitle">最新章节预览</div>
    <div class="cc"></div>
    <ul class="last9">
        <?php foreach($lastarr_safe as $k => $v): ?>
            <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8')?></a></li>
        <?php endforeach ?>
        <?php if ($index_url_raw !== ''): ?><li class="more"><a href="<?=$index_url_attr?>">更多章节&gt;&gt;</a></li><?php endif; ?>
    </ul>
</div>
<?php if ($is_langtail == 1 && !empty($langtailrows_safe)) : ?>
<p>相关推荐：
    <?php foreach ($langtailrows_safe as $v) : ?>
        <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8')?></a>&nbsp;
    <?php endforeach ?>
</p>
<?php endif; ?>
<script>
(function(){
    var bp = document.createElement('script');
    bp.src = '//zz.bdstatic.com/linksubmit/push.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
