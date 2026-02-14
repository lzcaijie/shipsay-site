<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php $year = isset($year) ? $year : date('Y'); ?>
<!-- footer -->
<div class="container">
    <div class="footer gray">
        <p><?=SITE_NAME?>所有小说均由根据搜索引擎转码而来</p>
        <p>本站不保存小说内容及数据，仅作宣传展示。</p>
        <p><?=SITE_NAME?>基于搜索引擎技术为您提供检索服务</p>
        <p>版权投诉及建议请联系我们 <?=SITE_NAME?></p>

        <p>
            Copyright <?=$year?> <?=SITE_NAME?> All Rights Reserved.
            | <a href="/sitemap/sitemap.xml" title="XML SiteMap" target="_blank">谷歌网站地图</a>
            | <a href="/sitemap/sm_sitemap.xml" title="XML SiteMap" target="_blank">神马网站地图</a>
        </p>
    </div>
</div>

<script>setEcho();</script>

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
