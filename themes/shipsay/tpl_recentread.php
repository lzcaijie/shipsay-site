<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = isset($site_home_url_raw) && $site_home_url_raw ? (string)$site_home_url_raw : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_page_title = '最近阅读_' . SITE_NAME;
$recentread_page_title_html = htmlspecialchars($recentread_page_title, ENT_QUOTES, 'UTF-8');
$recentread_page_description = SITE_NAME . '最近阅读与阅读记录页面。';
$recentread_page_description_html = htmlspecialchars($recentread_page_description, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$recentread_page_title_html?></title>
<meta name="description" content="<?=$recentread_page_description_html?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="section_mark">
        <div class="bread_crumbs">
            <a href="<?=$site_home_url_attr?>">首页</a> &gt; <span>阅读记录</span>
        </div>
        <div id="tempBookcase"></div>
        <script>showtempbooks();</script>
    </div>
    <aside>
        <p class="title"><i class="fa fa-fire fa-lg">&nbsp;</i>猜你喜欢</p>
        <ul class="popular odd">
            <?php if (is_array($popular)): foreach ($popular as $v): ?>
                <?php
                $info_url_attr = htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars((string)($v['articlename'] ?? ''), ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars((string)($v['author_url'] ?? ''), ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars((string)($v['author'] ?? ''), ENT_QUOTES, 'UTF-8');
                ?>
                <li><a href="<?=$info_url_attr?>"><?=$title_html?></a><a class="gray" href="<?=$author_url_attr?>"><?=$author_html?></a></li>
            <?php endforeach; endif; ?>
        </ul>
    </aside>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
