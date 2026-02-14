<?php if (!defined('__ROOT_DIR__')) exit; ?>
<p class="g_hide">本站所有小说作品均来自网友上传或转载于其他网站，版权属于原创作者</p>
<p class="g_hide">如侵犯了您的权利，请与本站联系，本站将立刻删除</p>
<p><?=SITE_NAME?> - 汇集精品图书小说</p>

<p>
    网站地图：
    <a href="/sitemap/sitemap.xml" title="SiteMapXML">SiteMapXML</a>
    &nbsp;|&nbsp;
    <a href="/sitemap/sm_sitemap.xml" title="SMSiteMap">SMSiteMap</a>
</p>

<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
