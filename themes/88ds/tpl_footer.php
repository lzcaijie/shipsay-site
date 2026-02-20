<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $year = isset($year) ? $year : date('Y'); ?>
<div class="footer">
    <p><?=SITE_NAME?>所有小说均由根据搜索引擎转码而来</p>
    <p>只为让更多读者欣赏，本站不保存小说内容及数据。</p>
    <p><?=SITE_NAME?>基于搜索引擎技术为您提供检索服务</p>
    <p>版权投诉及建议请联系我们<?=SITE_NAME?> </p>
    <p>Copyright <?=$year?> <?=SITE_NAME?> All Rights Reserved.</p>

    <div class="site-maps">
        <a href="/sitemap/sitemap.xml" title="XML SiteMap" target="_blank">谷歌网站地图</a>
        |
        <a href="/sitemap/sm_sitemap.xml" title="XML SiteMap" target="_blank">神马网站地图</a>
    </div>
</div>

<?php
include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';
if (!empty($count) && is_array($count)) {
    foreach($count as $v) {
        if (!empty($v['enable'])) echo $v['html'];
    }
}
?>
</body>
</html>
