<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$year_safe = isset($year) ? (string)$year : date('Y');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = ss_h($site_home_url_raw);
$recentread_url_raw = !empty($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = ss_h($recentread_url_raw);
$rank_entry_url_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$rank_entry_url_attr = ss_h($rank_entry_url_raw);
?>
<!-- footer -->
<div class="s_m">
    <p><?=ss_h(SITE_NAME)?>所有小说均由根据搜索引擎转码而来</p>
    <p>本站不保存小说内容及数据，仅作宣传展示。</p>
    <p><?=ss_h(SITE_NAME)?>基于搜索引擎技术为您提供检索服务</p>
    <p>版权投诉及建议请联系我们 <?=ss_h(SITE_NAME)?></p>
    <p>
        网站地图：
        <a href="/sitemap/sitemap.xml" title="XML SiteMap">SiteMapXML</a>
        |
        <a href="/sitemap/sm_sitemap.xml" title="XML SiteMap_TAG">SMSiteMap</a>
    </p>
    <p>Copyright &copy; <?=ss_h($year_safe)?> <?=ss_h(SITE_NAME)?></p>
</div>
<div id="foot" class="foot">
    <a href="<?=$site_home_url_attr?>">首页</a>
    <?php if ($recentread_url_raw !== ''): ?>&nbsp;&nbsp;<a href="<?=$recentread_url_attr?>" rel="nofollow">阅读记录</a><?php endif; ?>
    <?php if ($rank_entry_url_raw !== ''): ?>&nbsp;&nbsp;<a href="<?=$rank_entry_url_attr?>">排行榜</a><?php endif; ?>
</div>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php'; foreach($count as $v) { if($v['enable']) echo $v['html']; } ?>
</body>
</html>
