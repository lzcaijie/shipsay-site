<?php
$search_url_raw_local = '';
if (isset($search_url_raw) && $search_url_raw !== '') {
    $search_url_raw_local = $search_url_raw;
} elseif (!empty($search_url_attr)) {
    $search_url_raw_local = html_entity_decode($search_url_attr, ENT_QUOTES, 'UTF-8');
} elseif (!empty($fake_search)) {
    $search_url_raw_local = $fake_search;
} elseif (function_exists('ss_search_url')) {
    $search_url_raw_local = ss_search_url();
}
$search_url_attr = htmlspecialchars((string)$search_url_raw_local, ENT_QUOTES, 'UTF-8');
$search_placeholder_attr = htmlspecialchars((string)(!empty($search_placeholder) ? $search_placeholder : '可搜书名，请您少字也别输错字'), ENT_QUOTES, 'UTF-8');

if (!function_exists('ss_search_kw_url')) {
    function ss_search_kw_url($kw){
        $base = '';
        if (!empty($GLOBALS['search_url_raw_local'])) {
            $base = $GLOBALS['search_url_raw_local'];
        } elseif (!empty($GLOBALS['fake_search'])) {
            $base = $GLOBALS['fake_search'];
        } elseif (function_exists('ss_search_url')) {
            $base = ss_search_url();
        }
        if ($base === '') {
            return '';
        }
        $sep = (strpos($base, '?') !== false) ? '&' : '?';
        return $base . $sep . 'searchkey=' . rawurlencode($kw);
    }
}
?>
	<footer class="footer">
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
    		<form name="search" action="<?=$search_url_attr?>" method="get">
    			<input type="text" placeholder="<?=$search_placeholder_attr?>" value="" name="searchkey" class="search" id="searchkey" autocomplete="on" required>
    			<button type="submit">搜 索</button>
    		</form>
    		<a id="closesearch" href="javascript:" title="取消" class="icon icon-more active"></a>
    	</div>
    	<div class="searchhot">
    	    <h4>热门搜索</h4>
    	    <p>
    	        <?php if (ss_search_kw_url("重生")): ?>
            <a href="<?=ss_search_kw_url("重生")?>">重生</a><a href="<?=ss_search_kw_url("战神")?>">战神</a><a href="<?=ss_search_kw_url("超能力")?>">超能力</a><a href="<?=ss_search_kw_url("总裁")?>">总裁</a><a href="<?=ss_search_kw_url("萌宝")?>">萌宝</a><a href="<?=ss_search_kw_url("系统")?>">系统</a><a href="<?=ss_search_kw_url("聊天群")?>">聊天群</a><a href="<?=ss_search_kw_url("万界")?>">万界</a><a href="<?=ss_search_kw_url("最强")?>">最强</a><a href="<?=ss_search_kw_url("穿越")?>">穿越</a>
            <?php endif; ?>
    	    </p>
    	</div>
    </div>
