<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>小说排行_<?=SITE_NAME?>阅读网_<?=SITE_NAME?></title>
  <meta name="keywords" content="排行榜<?=SITE_NAME?>" />
  <meta name="description" content="排行榜<?=SITE_NAME?>" />
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<body>
  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1>小说排行榜</h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="/" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once 'tpl_search_form.php'; ?>

  <div id="content">
    <div class="cover">
      <?php foreach($articlerows as $k => $v): ?><?php if($k < 48):?>
      <div class="block">
        <div class="block_img">
          <a href="<?=$v['info_url']?>">
            <img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" loading="lazy"
                 onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
          </a>
        </div>
        <div class="block_txt">
          <h2><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h2>
          <p>作者：<?=$v['author']?></p>
          <p>时间：<?=date('Y-m-d H:i:s',$v['lastupdate'])?></p>
          <p><?=$v['intro_des']?></p>
        </div>
      </div>
      <?php endif ?><?php endforeach ?>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
