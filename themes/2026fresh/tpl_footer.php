<?php if (!defined('__ROOT_DIR__')) exit; ?>
<footer class="site-footer">
  <div class="wrap" style="text-align:center;">
    <div class="ft-links" style="justify-content:center;">
      <a href="<?=$site_home_url_attr?>">首页</a><span class="sep">|</span>
      <?php if ($rank_entry_raw !== ''): ?>
        <a href="<?=$rank_entry_attr?>">排行</a>
      <?php else: ?>
        <span class="footer-disabled" aria-disabled="true">排行</span>
      <?php endif; ?>
      <span class="sep">|</span>
      <?php if ($search_url_raw !== ''): ?>
        <a href="<?=$search_url_attr?>">搜索</a>
      <?php else: ?>
        <span class="footer-disabled" aria-disabled="true">搜索</span>
      <?php endif; ?>
      <span class="sep">|</span>
      <?php if ($recentread_url_raw !== ''): ?>
        <a href="<?=$recentread_url_attr?>">阅读记录</a>
      <?php else: ?>
        <span class="footer-disabled" aria-disabled="true">阅读记录</span>
      <?php endif; ?>
    </div>

    <div class="ft-links" style="justify-content:center;margin-top:8px;">
      <span class="sep">网站地图：</span>
      <a href="/sitemap.xml">sitemap.xml</a><span class="sep">|</span>
      <a href="/sm_sitemap.xml">sm_sitemap.xml</a>
    </div>

    <div class="ft-desc">声明：本站内容均来源于互联网，如有侵权请联系删除。</div>
    <div class="ft-copy">&copy; <?=date('Y')?> <?=$site_name_html?></div>
  </div>
</footer>
<script>
window.SS_THEME_DIR = <?=json_encode($theme_dir_raw, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
window.SS_STATIC_BASE = <?=json_encode('/static/' . $theme_dir_raw, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>;
</script>
<?php $v = defined('SITE_VERSION') ? SITE_VERSION : date('Ymd'); ?>
<script src="/static/<?=$theme_dir_attr?>/js/main.js?v=<?=$v?>"></script>
