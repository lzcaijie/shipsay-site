<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!-- footer -->
<div class="footer">
    <p class="hidden-xs"><?=SITE_NAME?>所有小说均由根据搜索引擎转码而来，只为让更多读者欣赏，本站不保存小说内容及数据，仅作宣传展示。</p>	
	<p class="hidden-xs"><?=SITE_NAME?>基于搜索引擎技术为您提供检索服务，版权投诉删除及小说建议请联系我们。</p>
	<p class="hidden-xs">Copyright <?=$year?> <?=SITE_NAME?>(<?=SITE_URL?>) All Rights Reserved. | <a href="/sitemap/sitemap.xml" style="color: #FF0000;" title="XML SiteMap">网站地图</a>|<a href="/sitemap/sm_sitemap.xml" style="color: #FF0000;" title="XML SiteMap_TAG">网站地图</a></p>
	<?php if($ShipSayLink['is_link']==1): ?><p>友情连接：<?=$link_html?></p><?php endif ?>
	<div class="clear"></div>
</div>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
</body>
</html>
