<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $year = isset($year) && $year ? $year : date('Y'); ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
    <meta charset="UTF-8">
    <title><?=$articlename?>(<?=$author?>)_<?=$articlename?>全文免费阅读无弹窗_<?=$articlename?>最新章节阅读_<?=SITE_NAME?></title>
    <meta name="keywords" content="<?=$articlename?>,<?=$year?><?=$articlename?>最新章节,<?=$articlename?>免费阅读,<?=$author?>的小说,<?=$author?><?=$isfull?>小说阅读">
    <meta name="description" content="<?=$articlename?>是<?=$author?><?=$year?>最热门的<?=$sortname?>类型小说，主要描写了<?=$intro_des?>，<?=SITE_NAME?>提供<?=$articlename?>最新章节,<?=$articlename?>最新更新章节,<?=SITE_NAME?>免费稳定急速专业无弹窗">
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$articlename?>(<?=$author?>)_<?=$articlename?>全文免费阅读无弹窗_<?=$articlename?>最新章节阅读_<?=SITE_NAME?>">
    <meta property="og:image" content="<?=$img_url?>">
    <meta property="og:description" content="<?=$articlename?><?=$intro_des?><?=SITE_NAME?>提供<?=$articlename?>最新章节,<?=$articlename?>最新更新章节阅读">
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

<?php require_once __THEME_DIR__ . '/tpl_header.php'; require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>

<div class="container">
    <div class="border3-2">
        <div class="info-title">
            <a href="/"><?=SITE_NAME?></a> &gt; <a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a> &gt; <?=$articlename?>最新章节列表
        </div>
        <div class="info-main">
            <img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$img_url?>" alt="<?=$articlename?>" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;">
            <div class="w100">
                <h1><?=$articlename?></h1>
                <div class="w100 dispc">
                    <span><a href="<?=$author_url?>">作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$author?></a></span>
                    动&nbsp;&nbsp;&nbsp;&nbsp;做：<a href="<?=$first_url?>">开始阅读</a>，<?=$isfull?>，<a href="javascript:gofooter();">直达底部</a>
                </div>
                <div class="dispc"><span>最后更新：<?=$lastupdate?></span><a href="<?=$last_url?>">最新章节：<?=$lastchapter?></a></div>
                <div class="info-main-intro"><?=$intro_p?></div>
            </div>
        </div>
<div class="info-commend">
    <?php if ($is_langtail == 1 && !empty($langtailrows)) : ?>
        <p>相关推荐：
            <?php foreach ($langtailrows as $v) : ?>
                <a href="<?= $v['info_url'] ?>"><?= $v['langname'] ?></a>&nbsp;
            <?php endforeach ?>
        </p>
    <?php endif; ?>
</div>

        <div class="info-commend">推荐阅读:
            <?php foreach($neighbor as $k => $v): ?>
                <a href="<?=$v['info_url'] ?>" title="<?=$articlename?>"><?=$v['articlename'] ?></a>
            <?php endforeach ?>
        </div>
    </div>

    <div class="diswap info-main-wap border3-1">
        <a href="<?=$author_url?>"><p>作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$author?></p></a>
        <p>最后更新：<?=$lastupdate?>&nbsp;&nbsp;<a href="javascript:gofooter();">直达底部</a></p>
        <a href="<?=$last_url?>"><p>最新章节：<?=$lastchapter?></p></a>
    </div>
</div>

<div class="container border3-2 mt8">
    <div class="info-chapters-title"><strong>《<?=$articlename?>》最新章节</strong><span class="dispc">（提示：已启用缓存技术，最新章节可能会延时显示。）</span></div>
    <div class="info-chapters flex flex-wrap">
        <?php foreach($lastarr as $k => $v): ?>
            <a href="<?=$v['cid_url'] ?>" title="<?=$articlename?> <?=$v['cname'] ?>"><?=$v['cname'] ?></a>
        <?php endforeach ?>
    </div>
</div>

<div class="container border3-2 mt8 mb20">
    <div class="info-chapters-title">
        <strong>《<?=$articlename?>》正文</strong>
        <?php if ($chapters > 50): ?>
        <a href="/index/<?=$articleid?>/" style="float: right; font-size: 14px; color: #4a90e2; text-decoration: none;">
            查看完整目录（共<?=$chapters?>章）
        </a>
        <?php endif; ?>
    </div>
    <div class="info-chapters flex flex-wrap">
        <?php
        $displayedCount = 0;
        foreach($chapterrows as $k => $v):
            if ($displayedCount >= 50) break;
        ?>
            <a href="<?=$v['cid_url'] ?>" title="<?=$articlename?> <?=$v['cname'] ?>"><?=$v['cname'] ?></a>
        <?php
            $displayedCount++;
        endforeach;
        ?>
    </div>

    <?php if ($chapters > 50): ?>
    <div style="text-align: center; margin-top: 20px;">
        <a href="/index/<?=$articleid?>/" style="display: inline-block; padding: 10px 25px; background: #4a90e2; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
            查看完整目录（共<?=$chapters?>章）
        </a>
    </div>
    <?php endif; ?>
</div>

<div class="container">
    <div class="info-commend">最新小说:
        <?php foreach($postdate as $k => $v): ?>
            <a href="<?=$v['info_url'] ?>" title="<?=$articlename?>"><?=$v['articlename'] ?></a>
        <?php endforeach ?>
    </div>
</div>

<button class="gotop" onclick="javascript:gotop();">顶部</button>

<script>
(function(){
    var bp = document.createElement('script');
    bp.src = "//zz.bdstatic.com/linksubmit/push.js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
