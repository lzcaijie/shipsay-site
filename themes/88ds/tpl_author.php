<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_e')) {
  function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title><?=ss_e($author)?> 的全部作品_<?=SITE_NAME?></title>
  <meta name="keywords" content="<?=ss_e($author)?>的全部小说">
  <meta name="description" content="<?=SITE_NAME?>为您提供作者<?=ss_e($author)?>的全部小说作品列表，共<?=intval($author_count)?>本。">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="/static/<?=$theme_dir?>/style.css">
</head>
<body>
  <?php require_once 'tpl_header.php'; ?>

  <div class="container">
    <div class="bread">
      <a href="/"><?=SITE_NAME?></a> &gt; <span>作者</span> &gt; <h1><?=ss_e($author)?></h1>
    </div>

    <div class="cover" id="jieqi_page_contents">
      <?php if (is_array($res)): ?>
        <?php $__i=0; ?>
        <?php foreach($res as $k => $v): $__i++; if($__i>50) break; ?>
          <div class="block">
            <div class="block_img">
              <a href="<?=$v['info_url']?>">
                <img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" loading="lazy"
                     onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
              </a>
            </div>
            <div class="block_txt">
              <p class="block_tit"><a href="<?=$v['info_url']?>"><?=ss_e($v['articlename'])?></a></p>
              <p class="block_desc"><?=ss_e($v['intro_des'])?></p>
              <p class="block_meta"><span><?=ss_e($v['sortname_2'])?></span><span><?=ss_e($v['isfull'])?></span><span><?=ss_e($v['words_w'])?>万字</span></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <?php require_once 'tpl_footer.php'; ?>
</body>
</html>
