<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>最近阅读_<?=SITE_NAME?></title>
<meta name="description" content="<?=htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8')?>最近阅读与阅读记录页面。">
<?php
$home_url_safe = !empty($site_url) ? rtrim($site_url, '/') . '/' : '/';
require_once __THEME_DIR__ . '/tpl_header.php';
?>
<div class="container">
    <div class="section_mark">
        <div class="bread_crumbs">
            <a href="<?=htmlspecialchars($home_url_safe, ENT_QUOTES, 'UTF-8')?>">首页</a> &gt; <span>阅读记录</span>
        </div>
        <div id="tempBookcase"></div>
        <script>showtempbooks();</script>
    </div>
    <aside>
        <p class="title"><i class="fa fa-fire fa-lg">&nbsp;</i>猜你喜欢</p>
        <ul class="popular odd">
            <?php if (is_array($popular)): foreach ($popular as $v): ?>
                <?php
                $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8');
                ?>
                <li><a href="<?=$info_url_attr?>"><?=$title_html?></a><a class="gray" href="<?=$author_url_attr?>"><?=$author_html?></a></li>
            <?php endforeach; endif; ?>
        </ul>
    </aside>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
