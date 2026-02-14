<?php if (!defined('__ROOT_DIR__')) exit;?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title><?=$page_title?>_小说排行榜_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$page_title?>小说排行榜" />
<meta name="description" content="<?=SITE_NAME?>是广大书友最值得收藏的网络小说阅读网，网站收录了当前最火热的<?=$page_title?>小说排行榜，免费提供高质量的小说最新章节。" />
<?php require_once 'tpl_header.php'; ?>
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
<?php require_once 'tpl_footer.php'; ?>
