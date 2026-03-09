<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($fake_recentread) && $fake_recentread) ? (string)$fake_recentread : '');
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_page_title = '最近阅读_' . SITE_NAME;
$recentread_page_title_html = htmlspecialchars($recentread_page_title, ENT_QUOTES, 'UTF-8');
$recentread_page_description = SITE_NAME . '最近阅读与阅读记录页面。';
$recentread_page_description_html = htmlspecialchars($recentread_page_description, ENT_QUOTES, 'UTF-8');
$recentread_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '阅读记录', 'item' => $recentread_url_raw !== '' ? $recentread_url_raw : $site_home_url_raw],
    ],
];
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$recentread_page_title_html?></title>
<meta name="description" content="<?=$recentread_page_description_html?>">
<?php if ($recentread_url_raw !== ''): ?>
<link rel="canonical" href="<?=$recentread_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$recentread_url_attr?>">
<?php endif; ?>
<script type="application/ld+json"><?=json_encode($recentread_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container mb20 recentread-page">
    <div class="border3">
        <div class="info-title"><a href="<?=$site_home_url_attr?>">首页</a> &gt; 阅读记录</div>
        <p class="recentread-p">临时书架 - 用户浏览过的小说会自动保存到书架中（只限同一电脑）</p>
        <div class="recentread-tools">
            <button type="button" id="clear_temp" class="recentread-btn">清空记录</button>
        </div>
        <div class="recentread-main recentread-head">
            <div class="recentread-row-link">
                <span></span>
                <span>书名</span>
                <span>已读到</span>
                <span>作者</span>
                <span>最后阅读</span>
            </div>
            <div class="recentread-op">操作</div>
        </div>
        <div id="tempBookcase"></div>
    </div>
    <script src="/static/<?=$theme_dir?>/tempbookcase.js"></script>
    <script>
        showtempbooks();
        $('#clear_temp').on('click', function(){
            return removeall();
        });
        $('nav a:last-child').addClass('orange');
    </script>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
