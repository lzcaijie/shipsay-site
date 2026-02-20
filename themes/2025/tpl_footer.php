<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $v = defined('SITE_VERSION') ? SITE_VERSION : '20251207'; ?>
<div class="footer">
<div class="container">
<p class="hidden-xs">本站所有小说为转载作品，所有章节均由网友上传，转载至本站只是为了宣传本书让更多读者欣赏。</p>
<p class="visible-xs">本站小说由程序自动索引</p>
<p>Copyright &copy; 2025 <?=SITE_NAME?></p>
<p><a href="/sitemap/sm_sitemap.xml" title="神马 SiteMap">神马SiteMap</a> | <a href="/sitemap/sitemap.xml" title="XML SiteMap">SiteMap</a></p>
<div class="cf"></div>
</div>
</div>

<script src="/static/<?=$theme_dir?>/js/jquery.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir?>/js/2025.js?v=<?=$v?>"></script>

<?php
include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';
if (!empty($count) && is_array($count)) {
    foreach($count as $vv) {
        if (!empty($vv['enable'])) echo $vv['html'];
    }
}
?>
