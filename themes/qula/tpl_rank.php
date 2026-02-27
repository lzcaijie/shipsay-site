<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
     <div class="container">
        <div class="row row-rank">
		<div>
            <div class="layout layout-col1">
        
                <div class="layout-tit">
                    <strong>总排行榜</strong>
                    <ul class="tab-hd">
                        <li class="active">总</li>
                        <li>月</li>
                        <li>周</li>
                    </ul>
                </div>
                <div class="tab-bd">
                    <ul class="txt-list txt-list-row3">
                        
                   <?php if(is_array($articlerows)) { foreach($articlerows as $k => $v){ ?>	
                                 <li>
                                     <span class="s1"></span>
                                     <span class="s2"><a href="<?=$v['info_url']?>"><?=$k+1?>. <?=$v['articlename']?></a></span>
                                     <span class="s5"><?=date('m-d',$v['lastupdate'])?></span>
                                 </li>
                                   <?php }} ?>   </ul>
                </div>
            </div>
              <div class="layout layout-col1">
                <div class="layout-tit">
                    <strong>月排行榜</strong>
                    <ul class="tab-hd">
                        <li class="active">总</li>
                        <li>月</li>
                        <li>周</li>
                    </ul>
                </div>
                <div class="tab-bd">
                    <ul class="txt-list txt-list-row3">
                        
                          <?php if(is_array($articlerows)) { foreach($articlerows as $k => $v){ ?>
                                 <li>
                                     <span class="s1"></span>
                                     <span class="s2"><a href="<?=$v['info_url']?>"><?=$k+1?>. <?=$v['articlename']?></a></span>
                                     <span class="s5"><?=date('m-d',$v['lastupdate'])?></span>
                                 </li>
                                    <?php }} ?>  </ul>
                </div>
            </div>
            <div class="layout layout-col1">
                <div class="layout-tit">
                    <strong>周排行榜</strong>
                    <ul class="tab-hd">
                        <li class="active">总</li>
                        <li>月</li>
                        <li>周</li>
                    </ul>
                </div>
                <div class="tab-bd">
                    <ul class="txt-list txt-list-row3">
                        
                          <?php if(is_array($articlerows)) { foreach($articlerows as $k => $v){ ?>
                                 <li>
                                     <span class="s1"></span>
                                     <span class="s2"><a href="<?=$v['info_url']?>"><?=$k+1?>. <?=$v['articlename']?></a></span>
                                     <span class="s5"><?=date('m-d',$v['lastupdate'])?></span>
                                 </li>
                                    <?php }} ?>  </ul>
                </div>
            </div>
            <div class="layout layout-col1 mr0">
                <div class="layout-tit">
                    <strong>收 藏 榜</strong>
                    <ul class="tab-hd">
                        <li class="active">总</li>
                        <li>月</li>
                        <li>周</li>
                    </ul>
                </div>
                <div class="tab-bd">
                    <ul class="txt-list txt-list-row3">
                        
                                 <?php if(is_array($articlerows)) { foreach($articlerows as $k => $v){ ?>
                                 <li>
                                     <span class="s1"></span>
                                     <span class="s2"><a href="<?=$v['info_url']?>"><?=$k+1?>. <?=$v['articlename']?></a></span>
                                     <span class="s5"><?=date('m-d',$v['lastupdate'])?></span>
                                 </li>
                                    <?php }} ?>
                                
                    </ul>
                  
                </div>
            </div>
			</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
