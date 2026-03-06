<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$home_url_safe = !empty($site_url) ? $site_url : '/';
$recentread_page_title = '最近阅读_' . SITE_NAME;
$recentread_page_description = SITE_NAME . '最近阅读与阅读记录页面。';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=htmlspecialchars($recentread_page_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="description" content="<?=htmlspecialchars($recentread_page_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container recentread-layout">
    <section class="section_mark recentread-main">
        <div class="bread_crumbs">
            <a href="<?=htmlspecialchars($home_url_safe, ENT_QUOTES, 'UTF-8')?>">首页</a> &gt; <span>阅读记录</span>
        </div>
        <div id="tempBookcase"></div>
        <script>showtempbooks();</script>
    </section>
    <aside class="recentread-side">
        <p class="title"><i class="fa fa-fire fa-lg">&nbsp;</i>猜你喜欢</p>
        <ul class="popular odd">
            <?php if (is_array($popular)): foreach ($popular as $v): ?>
                <?php
                $recent_info_url_safe = isset($v['info_url']) ? htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8') : '#';
                $recent_author_url_safe = isset($v['author_url']) ? htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8') : '#';
                $recent_articlename_safe = isset($v['articlename']) ? htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8') : '';
                $recent_author_safe = isset($v['author']) ? htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8') : '';
                ?>
                <li><a href="<?=$recent_info_url_safe?>"><?=$recent_articlename_safe?></a><a class="gray" href="<?=$recent_author_url_safe?>"><?=$recent_author_safe?></a></li>
            <?php endforeach; endif; ?>
        </ul>
    </aside>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
