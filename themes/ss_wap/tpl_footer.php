<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!-- footer -->
<?php $year_safe = isset($year) ? $year : date('Y'); ?>
<div class="s_m">
     <p><?=SITE_NAME?>所有小说均由根据搜索引擎转码而来</p>
        <p>本站不保存小说内容及数据，仅作宣传展示。</p>
        <p><?=SITE_NAME?>基于搜索引擎技术为您提供检索服务</p>
        <p>版权投诉及建议请联系我们 <?=SITE_NAME?></p>
        <p>
            网站地图：
            <a href="/sitemap/sitemap.xml" title="XML SiteMap">SiteMapXML</a>
            |
            <a href="/sitemap/sm_sitemap.xml" title="XML SiteMap_TAG">SMSiteMap</a>
        </p>
		<p>Copyright &copy; <?=$year_safe?> <?=SITE_NAME?></p>
</div>
<div id="foot" class="foot">
    <a href="/">首页</a>&nbsp;&nbsp;<a href="<?=$fake_yongjiushujia?>" rel="nofollow">我的书架</a>
</div>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
</body>
</html>
