<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$footer_year = isset($year) && $year ? (string)$year : date('Y');
$footer_site_name = htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8');
?>
<p class="g_hide">本站所有小说作品均来自网友上传或转载于其他网站，版权属于原创作者</p>
<p class="g_hide">如侵犯了您的权利，请与本站联系，本站将立刻删除</p>
<p><?=$footer_site_name?>所有小说均由根据搜索引擎转码而来，只为让更多读者欣赏。</p>
<p>本站不保存小说内容及数据，仅作宣传展示，请在阅读后支持正版作品。</p>
<p><?=$footer_site_name?>基于搜索引擎技术为您提供检索服务，版权投诉删除及小说建议请联系我们。</p>
<p>Copyright &copy; <?=$footer_year?> <?=$footer_site_name?></p>
<p>
    网站地图：
    <a href="/sitemap/sitemap.xml" title="SiteMapXML">SiteMapXML</a>
    &nbsp;|&nbsp;
    <a href="/sitemap/sm_sitemap.xml" title="SMSiteMap">SMSiteMap</a>
</p>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
