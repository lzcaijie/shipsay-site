<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
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
<script>(function(){var nr=document.getElementById("nr");var tipss=document.getElementById("tipss");if(!nr && tipss){tipss.style.display="block";}})();</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
