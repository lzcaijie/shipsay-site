<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = isset($site_home_url_raw) && $site_home_url_raw
    ? (string)$site_home_url_raw
    : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$footer_site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$footer_site_base_raw = rtrim($site_home_url_raw, '/');
$footer_sitemap_sm_raw = $footer_site_base_raw . '/sitemap/sm_sitemap.xml';
$footer_sitemap_xml_raw = $footer_site_base_raw . '/sitemap/sitemap.xml';
$footer_sitemap_sm_attr = htmlspecialchars($footer_sitemap_sm_raw, ENT_QUOTES, 'UTF-8');
$footer_sitemap_xml_attr = htmlspecialchars($footer_sitemap_xml_raw, ENT_QUOTES, 'UTF-8');
?>
<div id="footer">
    <footer class="container">
        <p><a href="<?=$footer_sitemap_sm_attr?>" title="神马 SiteMap" target="_blank">神马SiteMap</a> | <a href="<?=$footer_sitemap_xml_attr?>" title="XML SiteMap" target="_blank">SiteMap</a></p>
        <p><i class="fa fa-flag"></i>&nbsp;<a href="<?=$site_home_url_attr?>"><?=$footer_site_name_html?></a>&nbsp;书友最值得收藏的网络小说阅读网</p>
        <p>本站所有小说为转载作品，所有章节均由网友上传</p>
        <p>转载至本站只是为了宣传本书让更多读者欣赏。</p>
        <p>本站所有小说均由程序自动从搜索引擎索引。</p>
        <p>Copyright &copy; <?=intval($year)?> <?=$footer_site_name_html?></p>
        <p><a href="javascript:zh_tran('s');" class="zh_click" id="zh_click_s">简体版</a> · <a href="javascript:zh_tran('t');" class="zh_click" id="zh_click_t">繁體版</a></p>
    </footer>
</div>
<script>setEcho();</script>
<?php
$count_ini = __ROOT_DIR__ . '/shipsay/configs/count.ini.php';
if (is_file($count_ini)) {
    include_once $count_ini;
    if (isset($count) && is_array($count)) {
        foreach ($count as $v) {
            if (!empty($v['enable']) && isset($v['html'])) echo $v['html'];
        }
    }
}
?>
</body></html>
