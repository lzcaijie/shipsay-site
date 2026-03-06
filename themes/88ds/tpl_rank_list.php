<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html lang="zh">
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
    <div class="article">
      <ul class="rankbox-list" style="list-style:none;margin:12px 10px;padding:0;background:#fff;border-radius:6px;overflow:hidden;">
        <?php foreach($articlerows as $k => $v): ?><?php if($k < 48):?>
        <li style="padding:12px;border-bottom:1px solid #f6f6f6;">
          <div style="display:flex;gap:10px;align-items:flex-start;">
            <span style="min-width:22px;text-align:center;color:#999;"><?=($k+1)?></span>
            <div style="flex:1;min-width:0;">
              <h2 style="margin:0 0 6px;font-size:16px;line-height:1.5;">
                <a href="<?=$v['info_url']?>" style="color:#333;text-decoration:none;"><?=$v['articlename']?></a>
              </h2>
              <p style="margin:0 0 4px;color:#999;font-size:13px;">作者：<?=$v['author']?><?php if(!empty($v['lastupdate'])): ?>　时间：<?=date('Y-m-d H:i:s',$v['lastupdate'])?><?php endif; ?></p>
              <?php if(!empty($v['intro_des'])): ?>
              <p style="margin:0;color:#666;font-size:13px;line-height:1.7;"><?=$v['intro_des']?></p>
              <?php endif; ?>
            </div>
          </div>
        </li>
        <?php endif ?><?php endforeach ?>
      </ul>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>