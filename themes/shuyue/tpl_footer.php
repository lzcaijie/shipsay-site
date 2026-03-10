<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$theme_dir_raw = (string)$theme_dir;
$theme_dir_attr = htmlspecialchars($theme_dir_raw, ENT_QUOTES, 'UTF-8');
$common_file = __ROOT_DIR__ . '/www/static/' . $theme_dir_raw . '/js/common.js';
$common_ver = @filemtime($common_file);
$site_home_url_raw = isset($site_home_url_raw) && $site_home_url_raw ? (string)$site_home_url_raw : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$footer_site_base_raw = rtrim($site_home_url_raw, '/');
$footer_sitemap_xml_attr = htmlspecialchars($footer_site_base_raw . '/sitemap/sitemap.xml', ENT_QUOTES, 'UTF-8');
$footer_sitemap_sm_attr = htmlspecialchars($footer_site_base_raw . '/sitemap/sm_sitemap.xml', ENT_QUOTES, 'UTF-8');
$footer_site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
?>
<!-- footer -->
<footer class="footer_46f text-center">
    <?php if (!empty($ShipSayLink['is_link'])): ?><p class="hidden-xs">友情链接：<?=$link_html?></p><?php endif; ?>
    <p class="hidden-xs">本站所有小说为转载作品，所有章节均由网友上传，转载至本站只是为了宣传本书让更多读者欣赏。</p>
    <p class="hidden-xs">本站所有小说均由程序自动从搜索引擎索引。</p>
    <p class="hidden-xs">Copyright &copy; <?=intval($year)?> <?=$footer_site_name_html?> All Rights Reserved.</p>
    <p class="hidden-xs"><a href="<?=$footer_sitemap_xml_attr?>" title="XML SiteMap">SiteMap</a> | <a href="<?=$footer_sitemap_sm_attr?>" title="神马 SiteMap">神马SiteMap</a></p>

    <?php if (!empty($ShipSayLink['is_link'])): ?><p class="visible-xs">友情链接：<?=$link_html?></p><?php endif; ?>
    <p class="visible-xs">本站小说为转载作品，所有章节均由网友上传。</p>
    <p class="visible-xs">转载至本站只是为了宣传本书让更多读者欣赏。</p>
    <p class="visible-xs">本站所有小说均由程序自动从搜索引擎索引。</p>
    <p class="visible-xs">Copyright &copy; <?=intval($year)?> <?=$footer_site_name_html?></p>
    <p class="visible-xs"><a href="<?=$footer_sitemap_xml_attr?>" title="XML SiteMap">SiteMap</a> | <a href="<?=$footer_sitemap_sm_attr?>" title="神马 SiteMap">神马SiteMap</a></p>
    <div class="clear"></div>
</footer>

<div class="back-to-top" id="back-to-top" title="返回顶部">
    <span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>
</div>

<script src="/static/<?=$theme_dir_attr?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/js/bootstrap.min.js"></script>
<script src="/static/<?=$theme_dir_attr?>/js/common.js<?php if ($common_ver) echo '?v=' . $common_ver; ?>"></script>
<?php if (isset($page_end_scripts) && $page_end_scripts) echo $page_end_scripts; ?>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php'; if (isset($count) && is_array($count)) { foreach ($count as $v) { if (!empty($v['enable']) && isset($v['html'])) echo $v['html']; } } ?>
</body>
</html>
