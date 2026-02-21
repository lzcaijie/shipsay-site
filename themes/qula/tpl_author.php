<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
    <title><?=$author?>_<?=$author?>新书_<?=$author?>小说大全_<?=SITE_NAME?></title>
    <meta name="keywords" content="<?=$author?>,<?=$author?>新书,<?=$author?>小说大全,<?=SITE_NAME?>">
    <meta name="description" content="本站提供大量好看的免费小说、玄幻小说、穿越小说等各种好看的小说，小说排行榜每日更新各类小说居同类小说网站之首，是小说迷们最喜欢的全本小说阅读网！">

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
