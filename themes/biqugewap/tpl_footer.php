<?php
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$footer_site_base_raw = rtrim($site_home_url_raw, '/');
$footer_sitemap_sm_attr = htmlspecialchars($footer_site_base_raw . '/sitemap/sm_sitemap.xml', ENT_QUOTES, 'UTF-8');
$footer_sitemap_xml_attr = htmlspecialchars($footer_site_base_raw . '/sitemap/sitemap.xml', ENT_QUOTES, 'UTF-8');
if (!function_exists('ss_search_kw_url')) {
    function ss_search_kw_url($kw){
        $base = function_exists('ss_search_url') ? ss_search_url() : ((isset($GLOBALS['fake_search']) && $GLOBALS['fake_search']) ? $GLOBALS['fake_search'] : '');
        if ($base === '') return 'javascript:void(0)';
        $sep = (strpos($base, '?') !== false) ? '&' : '?';
        return $base . $sep . 'searchkey=' . rawurlencode($kw);
    }
}
?>
	<footer class="footer">
        <p><a href="<?=$footer_sitemap_sm_attr?>" title="神马SiteMap">神马SiteMap</a> | <a href="<?=$footer_sitemap_xml_attr?>" title="XML SiteMap">SiteMap</a></p>
		<p><?=SITE_NAME?>所有小说均由根据搜索引擎转码而来</p>
        <p>本站不保存小说内容及数据，仅作宣传展示。</p>
        <p><?=SITE_NAME?>基于搜索引擎技术为您提供检索服务</p>
        <p>版权投诉及建议请联系我们 <?=SITE_NAME?></p>
		<p>Copyright &copy; 2025 <?=SITE_NAME?></p>
		<div class="clear"></div>
	</footer>
    <a href="#top" class="backtotop" title="返回顶部"><svg id="icon-backtop" viewBox="0 0 12 9"><g><path d="M11.5 1a.5.5 0 1 0 0-1H.5a.5.5 0 0 0 0 1h11zM6.354 3.354h-.708l5.5 5.5a.5.5 0 0 0 .708-.708l-5.5-5.5a.5.5 0 0 0-.708 0l-5.5 5.5a.5.5 0 0 0 .708.708l5.5-5.5z"></path></g></svg></a>
    <script src="/static/<?=$theme_dir?>/jquery.min.js"></script>
    <script src="/static/<?=$theme_dir?>/common.js"></script>
    <script>imglazy();</script>
    <div id="searchguide">
        <div class="search">
    		<form name="search"<?php if ($search_url_safe !== ""): ?> action="<?=$search_url_safe?>"<?php else: ?> onsubmit="return false;"<?php endif; ?> method="get">
    			<input type="text" placeholder="可搜书名，请您少字也别输错字" value="" name="searchkey" class="search" id="searchkey" autocomplete="on" required>
    			<button type="submit"<?php if ($search_url_safe === ""): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜 索</button>
    		</form>
    		<a id="closesearch" href="javascript:" title="取消" class="icon icon-more active"></a>
    	</div>
    	<div class="searchhot">
    	    <h4>热门搜索</h4>
    	    <p>
    	        <a href="<?=ss_search_kw_url("重生")?>">重生</a><a href="<?=ss_search_kw_url("战神")?>">战神</a><a href="<?=ss_search_kw_url("超能力")?>">超能力</a><a href="<?=ss_search_kw_url("总裁")?>">总裁</a><a href="<?=ss_search_kw_url("萌宝")?>">萌宝</a><a href="<?=ss_search_kw_url("系统")?>">系统</a><a href="<?=ss_search_kw_url("聊天群")?>">聊天群</a><a href="<?=ss_search_kw_url("万界")?>">万界</a><a href="<?=ss_search_kw_url("最强")?>">最强</a><a href="<?=ss_search_kw_url("穿越")?>">穿越</a>
    	    </p>
    	</div>
    </div>
