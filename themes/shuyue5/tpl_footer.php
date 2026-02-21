<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$common_file = __ROOT_DIR__ . '/www/static/' . $theme_dir . '/js/common.js';
$common_ver  = @filemtime($common_file);
?>

<!-- footer -->
<footer class="footer_46f text-center">
    <?php if($ShipSayLink['is_link']==1): ?><p class="hidden-xs">友情连接：<?=$link_html?></p><?php endif ?>
    <p class="hidden-xs">本站所有小说为转载作品，所有章节均由网友上传，转载至本站只是为了宣传本书让更多读者欣赏。</p>
    <p class="hidden-xs">本站所有小说均由程序自动从搜索引擎索引</p>
    <p class="hidden-xs">Copyright &copy; <?=$year?> <?=SITE_NAME?> All Rights Reserved.</p>
    <p class="hidden-xs"><a href="/sitemap/sitemap.xml" target="_blank" title="XML SiteMap">SiteMap</a> | <a href="/sitemap/sm_sitemap.xml" target="_blank" title="神马 SiteMap">神马SiteMap</a></p>

    <?php if($ShipSayLink['is_link']==1): ?><p class="visible-xs">友情连接：<?=$link_html?></p><?php endif ?>
    <p class="visible-xs">本站小说为转载作品，所有章节均由网友上传</p>
    <p class="visible-xs">转载至本站只是为了宣传本书让更多读者欣赏。</p>
    <p class="visible-xs">本站所有小说均由程序自动从搜索引擎索引</p>
    <p class="visible-xs">Copyright &copy; <?=$year?> <?=SITE_NAME?></p>
    <p class="visible-xs"><a href="/sitemap/sitemap.xml" target="_blank" title="XML SiteMap">SiteMap</a> | <a href="/sitemap/sm_sitemap.xml" target="_blank" title="神马 SiteMap">神马SiteMap</a></p>
    <div class="clear"></div>
</footer>

<div class="back-to-top" id="back-to-top" title='返回顶部'>
    <span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>
</div>

<script src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/bootstrap.min.js"></script>
<script src="/static/<?=$theme_dir?>/js/common.js<?php if($common_ver){echo '?v='.$common_ver;}?>"></script>
<?php if(isset($page_end_scripts) && $page_end_scripts){echo $page_end_scripts;} ?>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
</body>
</html>
