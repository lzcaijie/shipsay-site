<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>搜索结果_<?=SITE_NAME?>_书友最值得收藏的网络小说阅读网</title>
<meta name="keywords" content="<?=SITE_NAME?>,免费小说网,手机小说,最新小说推荐,小说阅读网,免费小说阅读网,小说阅读器全本免费小说,小说网站排名,小说在线阅读" />
<meta name="description" content="<?=SITE_NAME?>收集了{<?=$year?>网络热门小说的最新章节免费阅读,提供玄幻、武侠、原创、网游、都市、言情、历史、军事、科幻、恐怖、官场、穿越、重生等小说,{<?=$year?>最新全本免费手机小说阅读推荐,一切精彩尽在<?=SITE_NAME?>" />
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
        <div class="row">
            <div class="layout layout2 layout-co18">
                <h2 class="layout-tit">搜索"<?=$searchkey?>" 共有 "<?=$search_count?>" 个结果</h2>
                
        <ul class="txt-list txt-list-row5">
            <li><span class="s1"><b>作品分类</b></span>
                <span class="s2"><b>作品名称</b></span>
                <span class="s3"><b>最新章节</b></span>
                <span class="s4"><b>作者</b></span>
                <span class="s5"><b>更新时间</b></span>
            </li>
            
                <?php if($search_count == 0): ?>
        <div id="tipss" class="tipss">抱歉，没有找到你想要的小说<br />请确认小说名字并尽可能的<br /><br />△ <em style="color: red;font-size: 16px;font-weight:bold;font-style:normal">减少关键词字数，如：重生</em> △<br /><br /><em style="color: red;font-style:normal">※ 不支持繁体搜索，请输入简体字 ※</em></div>
    <?php else :?>
        <?php foreach($search_res as $k => $v): ?>
              <li>
                <span class="s1">[<?=$v['sortname']?>]</span>
                <span class="s2">
                    <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
                </span>
                <span class="s3"><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></span>
                <span class="s4"><?=$v['author']?></span>
                <span class="s5"><?=date('Y-m-d',$v['lastupdate'])?></span>
                </li>

	    <?php endforeach ?>
    <?php endif; ?>
    
        <ul class="txt-list txt-list-row5">
            
</ul>
    
            </div>
        </div>
    </div>



    <div class="clearfix"></div>
</div>
</div>
<style>.tipss{text-align:center; display:none; padding:30px 0px;background: #fff;font-size:14px;}</style>
<style>@media screen and (max-width:768px){.tipss{width: 100%;border: none;}}</style>
<script>if(document.getElementById("nr") == null ){ document.getElementById("tipss").style.display = "block";}</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
