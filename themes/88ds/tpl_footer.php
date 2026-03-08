<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$year = isset($year) ? intval($year) : intval(date('Y'));
$site_home_url_raw = isset($site_home_url_raw) && $site_home_url_raw
    ? (string)$site_home_url_raw
    : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$footer_site_name_html = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$footer_site_base_raw = rtrim($site_home_url_raw, '/');
$footer_sitemap_xml_attr = htmlspecialchars($footer_site_base_raw . '/sitemap/sitemap.xml', ENT_QUOTES, 'UTF-8');
$footer_sitemap_sm_attr = htmlspecialchars($footer_site_base_raw . '/sitemap/sm_sitemap.xml', ENT_QUOTES, 'UTF-8');
?>
<div class="footer">
    <p><a href="<?=$site_home_url_attr?>"><?=$footer_site_name_html?></a> 所有小说均由程序自动从搜索引擎索引整理而来</p>
    <p>本站不保存小说正文内容及数据，仅提供检索与转码阅读服务。</p>
    <p>如有版权问题或内容建议，请联系站长处理。</p>
    <p>Copyright &copy; <?=$year?> <?=$footer_site_name_html?> All Rights Reserved.</p>

    <div class="site-maps">
        <a href="<?=$footer_sitemap_xml_attr?>" title="XML SiteMap" target="_blank">XML SiteMap</a>
        |
        <a href="<?=$footer_sitemap_sm_attr?>" title="神马 SiteMap" target="_blank">神马 SiteMap</a>
    </div>
</div>

<?php
$count_ini = __ROOT_DIR__ . '/shipsay/configs/count.ini.php';
if (is_file($count_ini)) {
    include_once $count_ini;
    if (!empty($count) && is_array($count)) {
        foreach ($count as $v) {
            if (!empty($v['enable']) && isset($v['html'])) echo $v['html'];
        }
    }
}
?>
</body>
</html>
