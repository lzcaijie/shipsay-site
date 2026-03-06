<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>最近阅读_<?=SITE_NAME?></title>
<meta name="description" content="<?=SITE_NAME?>最近阅读与阅读记录页面。">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container recentread-layout">
    <section class="section_mark recentread-main">
        <div class="bread_crumbs">
            <a href="/">首页</a> &gt; <span>阅读记录</span>
        </div>
        <div id="tempBookcase"></div>
        <script>showtempbooks();</script>
    </section>
    <aside class="recentread-side">
        <p class="title"><i class="fa fa-fire fa-lg">&nbsp;</i>猜你喜欢</p>
        <ul class="popular odd">
            <?php if (is_array($popular)): foreach ($popular as $v): ?>
                <li><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><a class="gray" href="<?=$v['author_url']?>"><?=$v['author']?></a></li>
            <?php endforeach; endif; ?>
        </ul>
    </aside>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
