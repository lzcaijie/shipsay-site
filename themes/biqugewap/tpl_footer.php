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
    		<form name="search" action="/search/" method="get">
    			<input type="text" placeholder="可搜书名，请您少字也别输错字" value="" name="searchkey" class="search" id="searchkey" autocomplete="on" required>
    			<button type="submit">搜 索</button>
    		</form>
    		<a id="closesearch" href="javascript:" title="取消" class="icon icon-more active"></a>
    	</div>
    	<div class="searchhot">
    	    <h4>热门搜索</h4>
    	    <p>
    	        <a href="/search/?searchkey=重生">重生</a><a href="/search/?searchkey=战神">战神</a><a href="/search/?searchkey=超能力">超能力</a><a href="/search/?searchkey=总裁">总裁</a><a href="/search/?searchkey=萌宝">萌宝</a><a href="/search/?searchkey=系统">系统</a><a href="/search/?searchkey=聊天群">聊天群</a><a href="/search/?searchkey=万界">万界</a><a href="/search/?searchkey=最强">最强</a><a href="/search/?searchkey=穿越">穿越</a>
    	    </p>
    	</div>
    </div>

