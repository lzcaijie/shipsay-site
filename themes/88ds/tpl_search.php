<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
// 轻量转义，防止搜索词含引号等破坏 HTML
if (!function_exists('ss_e')) {
    function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
    <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta name="MobileOptimized" content="240"/>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<body>
  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1>搜索"<?=ss_e($searchkey)?>"结果</h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="/" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once 'tpl_search_form.php'; ?>

  <div id="content">
    <div class="cover" id="jieqi_page_contents">
      <?php if (is_array($search_res)): ?>
        <?php foreach($search_res as $k => $v): ?>
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
              <p>类型：<?=$v['sortname']?></p>
              <p><?=$v['intro_des']?></p>
            </div>
          </div>
        <?php endforeach ?>
      <?php endif ?>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
