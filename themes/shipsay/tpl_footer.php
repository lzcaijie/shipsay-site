<?php if (!defined('__ROOT_DIR__')) exit; ?>


<div id="footer">
    <footer class="container">
        <p><a href="/sitemap/sm_sitemap.xml" title="神马 SiteMap" target="_blank">神马SiteMap</a> | <a href="/sitemap/sitemap.xml" title="XML SiteMap" target="_blank">SiteMap</a></p>
        <p><i class="fa fa-flag"></i>&nbsp;<a href="/"><?=SITE_NAME?></a>&nbsp;书友最值得收藏的网络小说阅读网</p>
        <p>本站所有小说为转载作品，所有章节均由网友上传</p>
        <p>转载至本站只是为了宣传本书让更多读者欣赏。</p>
        <p>本站所有小说均由程序自动从搜索引擎索引。</p>
        <p>Copyright &copy; <?=$year?> <?=SITE_NAME?></p>
        <p><a href="javascript:zh_tran('s');" class="zh_click" id="zh_click_s">简体版</a> · <a href="javascript:zh_tran('t');" class="zh_click" id="zh_click_t">繁體版</a></p>
    </footer>
</div>
<script>setEcho();</script>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
</body></html>