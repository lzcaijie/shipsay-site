<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
        <div class="row">
            
                <div class="layout layout-col2 layout-col3">

 <?php foreach($retarr as $k => $v) { if($k<6){?>
<div class="item">
                            <div class="image">
                                <a href="<?=$v['info_url']?>">
                                    <img src="<?=$v['img_url']?>" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'"  alt="<?=$v['articlename']?>" /></a>
                            </div>
                            <dl>
                                <dt><span><?=$v['author']?> </span><a href="<?=$v['info_url']?>"><?=$v['articlename']?> </a></dt>
                                <dd style="height: 90px;"><a href="<?=$v['info_url']?>" style="color:#555;"><?=$v['intro_des']?>…</a></dd>
                            </dl>
                        </div>
    <?php }} ?>
    </div></div>
                
     <div class="row">
            <div class="layout layout2 layout-col2">
                <h2 class="layout-tit"><?php if($sortname !=''):?><?=$sortname?><?php else:?>小说书库<?php endif ?>最近更新小说列表</h2>
                <ul class="txt-list txt-list-row5">
<?php if(is_array($retarr)):?>
				<?php foreach($retarr as $k => $v): ?>
     <li>
                                <span class="s1">[<?=$v['sortname']?>]</span>
                                <span class="s2">
                                    <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
                                </span>
                                <span class="s3"><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></span>
                                <span class="s4"><?=$v['author']?></span><span class="s5"><?=date('Y-m-d', $v['lastupdate'])?></span>
                            </li>

<?php endforeach ?>
				<?php endif ?>
  </ul>
               
                 <ul class="pagination pagination-mga">
                  <!-- 一页20条 -->
                      <li> <?=$jump_html ?></li>
                         
                </ul>  
                
            </div> 

            <div class="layout layout2 layout-col1">
                <h2 class="layout-tit"><?php if($sortname !=''):?><?=$sortname?><?php else:?>小说书库<?php endif ?></h2>
                <ul class="txt-list txt-list-row3">
<?php
    $sql = $sortid > 0 ? $rico_sql.'AND sortid = '. $sortid : $rico_sql;
    $sql .= ' ORDER BY weekvisit DESC LIMIT 21';
    if(isset($redis)) {
        $weekvisit10 = $redis->ss_redis_getrows($sql, $home_cache_time);
    } else {
        $weekvisit10 = $db->ss_getrows($sql);
    }
?>
<div class="recombook">
<dl>
    <?php foreach($weekvisit10 as $k => $v) {if($k < 21 ){ ?>
        <li>
                                <span class="s1">[<?=$v['sortname']?>]</span>
                                <span class="s2"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></span>
                                <span class="s5"><?=$v['author']?></span>
                            </li>
    <?php }} ?>
 </ul>
            </div>
        </div>
    </div>


<!-- /sort -->
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
