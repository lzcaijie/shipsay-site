<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<?php
$top_url_safe = (isset($fake_top) && $fake_top) ? $fake_top : '/rank/';
$full_allbooks_url_safe = (isset($full_allbooks_url) && $full_allbooks_url) ? $full_allbooks_url : ('/quanben' . (isset($allbooks_url) ? $allbooks_url : '/'));
?>
<body>
    <div class="header">
      <div class="logo">
        <a href="/"><?=SITE_NAME?></a>
      </div>
      <div class="reg">
        <div id="login_top">
          <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
          <script>login();</script>
        </div>
      </div>
    </div>

    <div class="nav">
      <ul>
        <li><a href="javascript:;" onclick="toggleSort();" rel="nofollow">分类</a></li>
        <li><a href="<?=$top_url_safe?>">排行</a></li>
        <li><a href="<?=$full_allbooks_url_safe?>">全本</a></li>
        <li><a href="/bookcase/" rel="nofollow">书架</a></li>
      </ul>
    </div>

	<div class="sort c_sort" id="submenu" style="display:none;">
        <ul>
            <?php foreach(Sort::ss_sorthead() as $v): ?>
                <li><a href="<?=$v['sorturl']?>"><?=$v['sortname_2']?></a></li>
            <?php endforeach ?>
            <div class="cc"></div>
        </ul>
    </div>

    <?php require_once 'tpl_search_form.php'; ?>

	<div class="article">
      <h2><span>推荐排行</span></h2>
        <div class="block">
	  <?php foreach($commend as $k => $v): ?><?php if($k == 0):?>
          <div class="block_img">
            <a href="<?=$v['info_url']?>">
              <img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h3>
            <p>作者：<?=$v['author']?></p>
            <p><?=$v['intro_des']?></p>
          </div>
        <div class="clear"></div>
        <ul>
	  <?php else: ?>
          <li><a>[<?=$v['sortname']?>]</a> <a href="<?=$v['info_url']?>" class="blue"><?=$v['articlename']?></a> / <?=$v['author']?></li>
      <?php endif?><?php endforeach?>
	    </ul>
      </div>
    </div>

	<!--热门小说-->
	<div class="article">
      <h2><span>热门小说</span></h2>
        <div class="block">
	  <?php foreach($popular as $k => $v): ?><?php if($k == 0):?>
          <div class="block_img">
            <a href="<?=$v['info_url']?>">
              <img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h3>
            <p>作者：<?=$v['author']?></p>
            <p><?=$v['intro_des']?></p>
          </div>
        <div class="clear"></div>
        <ul>
	  <?php else: ?>
          <li><a>[<?=$v['sortname']?>]</a> <a href="<?=$v['info_url']?>" class="blue"><?=$v['articlename']?></a> / <?=$v['author']?></li>
      <?php endif?><?php endforeach?>
	    </ul>
      </div>
    </div>

	<!--最近更新-->
	<div class="article">
      <h2><span>最近更新</span></h2>
        <div class="block">
	  <?php foreach($lastupdate as $k => $v): ?><?php if($k == 0):?>
          <div class="block_img">
            <a href="<?=$v['info_url']?>">
              <img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h3>
            <p>作者：<?=$v['author']?></p>
            <p><?=$v['intro_des']?></p>
          </div>
        <div class="clear"></div>
        <ul>
	  <?php else: ?>
          <li><a>[<?=$v['sortname']?>]</a> <a href="<?=$v['info_url']?>" class="blue"><?=$v['articlename']?></a> / <?=$v['author']?></li>
      <?php endif?><?php endforeach?>
	    </ul>
      </div>
    </div>

	<!--新书上架-->
	<div class="article">
      <h2><span>新书上架</span></h2>
        <div class="block">
	  <?php foreach($postdate as $k => $v): ?><?php if($k == 0):?>
          <div class="block_img">
            <a href="<?=$v['info_url']?>">
              <img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h3>
            <p>作者：<?=$v['author']?></p>
            <p><?=$v['intro_des']?></p>
          </div>
        <div class="clear"></div>
        <ul>
	  <?php else: ?>
          <li><a>[<?=$v['sortname']?>]</a> <a href="<?=$v['info_url']?>" class="blue"><?=$v['articlename']?></a> / <?=$v['author']?></li>
      <?php endif?><?php endforeach?>
	    </ul>
      </div>
    </div>

    <div class="article"><h2>友情链接</h2></div>
    <p><?=$link_html?></p>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
