<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_url_safe = !empty($site_url) ? $site_url : '/';
$sitemap_sm_safe = '/sitemap/sm_sitemap.xml';
$sitemap_xml_safe = '/sitemap/sitemap.xml';
?>
<div id="footer">
    <footer class="container">
        <p><a href="<?=htmlspecialchars($sitemap_sm_safe, ENT_QUOTES, 'UTF-8')?>" title="神马 SiteMap" target="_blank">神马SiteMap</a> | <a href="<?=htmlspecialchars($sitemap_xml_safe, ENT_QUOTES, 'UTF-8')?>" title="XML SiteMap" target="_blank">SiteMap</a></p>
        <p><i class="fa fa-flag"></i>&nbsp;<a href="<?=htmlspecialchars($site_url_safe, ENT_QUOTES, 'UTF-8')?>"><?=SITE_NAME?></a>&nbsp;书友最值得收藏的网络小说阅读网</p>
        <p>本站所有小说为转载作品，所有章节均由网友上传</p>
        <p>转载至本站只是为了宣传本书让更多读者欣赏。</p>
        <p>本站所有小说均由程序自动从搜索引擎索引。</p>
        <p>Copyright &copy; <?=intval($year)?> <?=SITE_NAME?></p>
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
