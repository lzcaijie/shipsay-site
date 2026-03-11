<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$footer_year = isset($year) && $year ? $year : date('Y');
$footer_site_name = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
$footer_site_url = htmlspecialchars((string)SITE_URL, ENT_QUOTES, 'UTF-8');
?>
<!-- footer -->
<div class="footer">
    <p class="hidden-xs"><?=$footer_site_name?>所有小说均由根据搜索引擎转码而来，只为让更多读者欣赏，本站不保存小说内容及数据，仅作宣传展示。</p>
    <p class="hidden-xs"><?=$footer_site_name?>基于搜索引擎技术为您提供检索服务，版权投诉删除及小说建议请联系我们。</p>
    <p class="hidden-xs">Copyright <?=$footer_year?> <?=$footer_site_name?>(<?=$footer_site_url?>) All Rights Reserved.</p>
    <p>网站地图：<a href="/sitemap/sitemap.xml" style="color: #FF0000;" title="XML SiteMap">XML地图</a> | <a href="/sitemap/sm_sitemap.xml" style="color: #FF0000;" title="XML SiteMap_TAG">TAG地图</a></p>
    <?php if (!empty($ShipSayLink['is_link']) && $ShipSayLink['is_link'] == 1): ?><p>友情链接：<?=$link_html?></p><?php endif ?>
    <div class="clear"></div>
</div>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php'; foreach($count as $v) { if($v['enable']) echo $v['html']; } ?>
</body>
</html>
