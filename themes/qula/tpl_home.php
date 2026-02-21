<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title><?=SITE_NAME?>_<?=SITE_NAME?>网_书友最值得收藏的网络小说阅读网</title>
<meta name="keywords" content="<?=SITE_NAME?>,<?=SITE_NAME?>网,最新<?=SITE_NAME?>,<?=SITE_NAME?>阅读网">
<meta name="description" content="<?=SITE_NAME?>,<?=SITE_NAME?>网,最新<?=SITE_NAME?>,<?=SITE_NAME?>阅读网，是广大书友最值得收藏的网络小说阅读网，网站收录了当前最火热的网络小说，免费提供高质量的小说最新章节，是广大网络小说爱好者必备的小说阅读网。">
<?php require_once __THEME_DIR__ . '/tpl_header.php';?>
<div class="container">
        <div class="row">
 <div class="layout layout-col2">

	<!-- 大神小说 -->
<?php if(is_array($commend)){ foreach($commend as $k => $v) { if($k < 4) { ?>
   <div class="item">
                            <div class="image">
<a href="<?=$v['info_url']?>">
                                    <img style="min-height:120px;" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'" src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" /></a>
                            </div>
                            <dl>
                                <dt><span><?=$v['author']?> </span><a href="<?=$v['info_url']?>"><?=$v['articlename']?> </a></dt>
                                <dd style="height:90px"><a href="<?=$v['info_url']?>" style="color: #555"><?=$v['intro_des']?>…</a></dd>
                            </dl>
                        </div>
                    <?php }}} ?></div>
             <div class="layout layout-col1">
                    <h2 class="layout-tit">经典推荐</h2>
                    <ul class="txt-list txt-list-row3">

	<?php if(is_array($popular)): ?><?php foreach($popular as $k => $v): ?><?php if($k < 9):?>	
	    <li>
							 <span class="s1"><?=$v['sortname_2']?></span>
                                <span class="s2"><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></span>
                                <span class="s5"><a href="<?=$v['author_url']?>"  title="<?=$v['author']?>"><?=$v['author']?></a></span>
                            </li>
	<?php endif ?><?php endforeach ?><?php endif ?>
           </ul>
                </div>
                
        </div>
	        <div class="row">
            <div class="layout">
               
		<!-- 分类 -->
        <?php for( $i = 1; $i <= 6; $i++) { $tmpvar = 'sort'.$i?>
      <div class="tp-box">
                    <h2><a href="<?=Sort::ss_sorturl($i)?>"><?=Sort::ss_sortname($i,1)?></a></h2>
			<?php if(is_array($$tmpvar)): ?><?php foreach($$tmpvar as $k => $v): ?>
				<?php if ($k == 0) : ?>	
				      <div class="top">
                                    <div class="image">
                                        <a href="<?=$v['info_url']?>"><img src="<?=$v['img_url']?>" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'" alt="<?=$v['articlename']?>" /></a>
                                    </div>
                                    <dl>
                                        <dt><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></dt>
                                        <dd><a href="<?=$v['info_url']?>" style="color: #555"><?=$v['intro_des']?>…</a></dd>
                                    </dl> </div>	 <ul>

				<?php elseif($k < 13): ?> 
			
                                <li><a href="<?=$v['info_url']?>"><?=Text::ss_substr($v['articlename'])?></a>/<?=$v['author']?></li>         
				<?php endif ?>

			<?php endforeach ?>	<?php endif ?> </ul>
                </div>
			
        <?php }; ?> 
  </div>
             </div>

 <div class="row">
            <div class="layout layout2 layout-col1 fr">
                <h2 class="layout-tit">最新入库小说</h2>
                <ul class="txt-list txt-list-row3">


	<?php if(is_array($postdate)) { foreach($postdate as $k => $v) { if( $k < 30 ){ ?>	
	<!-- 最新入库 -->
  <li>
                                <span class="s1">[<?=$v['sortname_2']?>]</span>
                                <span class="s2"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></span>
                                <span class="s5"><?=$v['author']?></span>
                            </li>
                            
    <?php }}} ?>
  </ul>
            </div>
   <div class="layout layout2 layout-col2 fl">
                <h2 class="layout-tit">最近更新小说列表</h2>
                <ul class="txt-list txt-list-row5">

	<?php if(is_array($lastupdate)){ foreach($lastupdate as $k => $v) { if( $k < 30 ) { ?>	
<li>
                                <span class="s1">[<?=$v['sortname_2']?>]</span>
                                <span class="s2">
                                    <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
                                </span>
                                <span class="s3"><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></span>
                                <span class="s4"><?=$v['author']?></span><span class="s5"><?=date('m-d',$v['lastupdate'])?></span>
                            </li>

    <?php }}} ?>

  </ul>
            </div>
        </div>
        <!-- 友情链接 -->
<div class="layout-tit">
    <div class="link">友情链接:<?=$link_html?></div>
    </div>


<!-- /home -->
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
