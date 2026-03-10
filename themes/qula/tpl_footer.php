<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!-- footer -->
<?php
$footer_recentread_url = function_exists('ss_recentread_url') ? ss_recentread_url() : ((isset($fake_recentread) && $fake_recentread) ? $fake_recentread : '');
$footer_top_url = !empty($rank_entry_url) ? $rank_entry_url : (!empty($fake_top) ? $fake_top : '');
?>
<div class="footer" id="footer">
    <div class="pc-footer">
        <p><?=SITE_NAME?>所有小说均由根据搜索引擎转码而来</p>
        <p>本站不保存小说内容及数据，仅作宣传展示。</p>
        <p><?=SITE_NAME?>基于搜索引擎技术为您提供检索服务</p>
        <p>版权投诉及建议请联系我们 <?=SITE_NAME?></p>
        <p>Copyright &copy; 2025 <?=SITE_NAME?></p>
        <p><a href="/sitemap/sitemap.xml" title="XML SiteMap">SiteMap</a> | <a href="/sitemap/sm_sitemap.xml" title="神马 SiteMap">神马SiteMap</a></p>
    </div>
    <div class="m-footer">
        <a href="/">首页</a>
        <?php if ($footer_recentread_url): ?>
            <a href="<?=htmlspecialchars($footer_recentread_url, ENT_QUOTES, 'UTF-8')?>" rel="nofollow">阅读记录</a>
        <?php endif; ?>
        <?php if ($footer_top_url): ?>
            <a href="<?=htmlspecialchars($footer_top_url, ENT_QUOTES, 'UTF-8')?>">排行榜</a>
        <?php endif; ?>
        <a href="#">顶部↑</a>
    </div>
</div>
<script>
function myFunction(){
    alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置！");
}
function myFunction1(){
    alert("浏览器不支持此操作, 请手动设为首页！");
}
</script>
<script src="/static/<?=$theme_dir?>/js/jquery.lazyload.min.js"></script>
<?php include_once __ROOT_DIR__ . '/shipsay/configs/count.ini.php';foreach($count as $v) {if($v['enable'])echo $v['html'];}?>
</body></html>
