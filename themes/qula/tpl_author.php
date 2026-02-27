<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
 
          <div class="container">
        <div class="row">
            
                <div class="layout layout-col2 layout-col3">

  <?php foreach($res as $k => $v): ?>
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
   <?php endforeach ?>
    </div></div>
      <div class="layout layout-col2 layout-col3" style="
    padding: 20px;
    font-size: 20px;
">     

		  作者简介：
<?=$v['author']?>是一名出色的小说作者，他的作品包括： 
			<?php if(is_array($res)): ?><?php foreach($res as $k => $v): ?>	<?=$v['articlename']?>、	<?php endforeach ?><?php endif ?>等，本本精品，字字珠玑，<?=$v['author']?>的小说情节跌宕起伏、扣人心弦，情节与文笔俱佳。<?=SITE_NAME?>强烈建议您到正版网站阅读<?=$v['author']?>的作品，您的每一次阅读都是对作者<?=$v['author']?>的认可！如果您在<?=SITE_NAME?>小说网阅读<?=$v['author']?>作品时，遇到问题，请及时反馈，我们将第一时间解决，争取为您奉上! </div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
