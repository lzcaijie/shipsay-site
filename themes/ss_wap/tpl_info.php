<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$articlename?>(<?=$author?>)_<?=$articlename?>全文免费阅读无弹窗_<?=$articlename?>最新章节阅读_<?=SITE_NAME?>">
    <meta property="og:image" content="<?=$img_url?>">
    <meta property="og:description" content="<?=$intro_des?>">
    <meta property="og:novel:category" content="<?=$sortname?>">
    <meta property="og:novel:author" content="<?=$author?>">
    <meta property="og:novel:author_link" content="<?=$site_url?><?=$author_url?>">
    <meta property="og:novel:book_name" content="<?=$articlename?>">
    <meta property="og:novel:read_url" content="<?=$site_url?><?=$uri?>">
    <meta property="og:novel:url" content="<?=$site_url?><?=$uri?>">
    <meta property="og:novel:status" content="<?=$isfull?>">
    <meta property="og:novel:update_time" content="<?=$lastupdate?>">
    <meta property="og:novel:lastest_chapter_name" content="<?=$lastchapter?>">
    <meta property="og:novel:lastest_chapter_url" content="<?=$site_url?><?=$last_url?>">

<?php
// 变量安全兜底（不改变原展示逻辑）
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif (isset($articleid) && $articleid) {
    // ss_wap 原模板一般有 $index_url，这里仅做兜底
    $index_url_safe = Url::index_url($articleid);
}

$langtailrows_safe = (!empty($langtailrows) && is_array($langtailrows)) ? $langtailrows : [];
$lastarr_safe = (!empty($lastarr) && is_array($lastarr)) ? $lastarr : [];
?>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <a href="/bookcase/" rel="nofollow" class="bookcase">我的书架</a>
</div>
<div class="bookinfo">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td><img src="<?=$img_url?>" border="0" width='100' height='130'/></td>
            <td valign="top" class="info">
                <p><strong><?=$articlename?></strong></p>
                <p>作者：<a href="<?=$author_url?>"><?=$author?></a></p>
                <p>类别：<a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></p>
                <p>状态：<?=$isfull?></p>
                <p>更新：<?=$lastupdate?></p>
                <p>最新：<a href="<?=$last_url?>"><?=$lastchapter?></a></p>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="book-op">
        <tr>
            <td><a href="javascript:;" onclick="addbookcase('<?=$articleid?>','<?=$articlename?>')" rel="nofollow">加入书架</a></td>
            <td><a href="<?=$index_url_safe?>">章节目录</a></td>
            <td><a href="<?=$first_url?>">立即阅读</a></td>
        </tr>
    </table>
</div>
<div class="book-itemtitle">小说简介</div>

<div class="intro"><?=$intro_p?></div>

<div class="lb_mulu">
    <div class="book-itemtitle">最新章节预览</div>
    <div class="cc"></div>
    <ul class="last9">
        <?php foreach($lastarr_safe as $k => $v): ?>
            <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=$v['cid_url']?>"><?=$v['cname'] ?></a></li>
        <?php endforeach ?>
        <li class="more"><a href="<?=$index_url_safe?>">更多章节>></a></li>
    </ul>
</div>
<?php if ($is_langtail == 1 && !empty($langtailrows_safe)) : ?>
    <p>相关推荐：
        <?php foreach ($langtailrows_safe as $v) : ?>
            <a href="<?=$v['info_url']?>"><?=$v['langname']?></a>&nbsp;
        <?php endforeach ?>
    </p>
<?php endif; ?>
<script>
(function(){
    var bp = document.createElement('script');
    bp.src = "//zz.bdstatic.com/linksubmit/push.js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
