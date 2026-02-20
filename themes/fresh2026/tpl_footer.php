<?php if (!defined('__ROOT_DIR__')) exit; ?>
<footer class="site-footer">
  <div class="wrap" style="text-align:center;">
    <div class="ft-links" style="justify-content:center;">
      <a href="/">首页</a><span class="sep">|</span>
      <a href="<?= ss_top_url() ?>">排行</a><span class="sep">|</span>
      <a href="<?= ss_search_url() ?>">搜索</a><span class="sep">|</span>
      <a href="<?= ss_recentread_url() ?>">阅读记录</a>
    </div>

    <div class="ft-links" style="justify-content:center;margin-top:8px;">
      <span class="sep">网站地图：</span>
      <a href="/sitemap.xml">sitemap.xml</a><span class="sep">|</span>
      <a href="/sm_sitemap.xml">sm_sitemap.xml</a>
    </div>

    <div class="ft-desc">声明：本站内容均来源于互联网，如有侵权请联系删除。</div>
    <div class="ft-copy">&copy; <?=date('Y')?> <?=SITE_NAME?></div>
  </div>
</footer>
<?php $v = defined('SITE_VERSION') ? SITE_VERSION : date('Ymd'); ?>
<script src="/static/<?=$theme_dir?>/js/main.js?v=<?=$v?>"></script>
