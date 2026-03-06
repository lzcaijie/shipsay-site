<?php if (!defined('__ROOT_DIR__')) exit;?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
  $rank_entry_url = isset($rank_entry_url) && $rank_entry_url ? $rank_entry_url : ((isset($fake_top) && $fake_top) ? $fake_top : '/rank/');
  $rank_detail_base = isset($rank_detail_base) && $rank_detail_base ? $rank_detail_base : $rank_entry_url;
  $title_arr = isset($title_arr) && is_array($title_arr) ? $title_arr : [
    'allvisit'=>'总排行榜',
    'monthvisit'=>'月排行榜',
    'weekvisit'=>'周排行榜',
    'dayvisit'=>'日排行榜',
    'allvote'=>'总推荐榜',
    'monthvote'=>'月推荐榜',
    'weekvote'=>'周推荐榜',
    'dayvote'=>'日推荐榜',
    'goodnum'=>'收藏榜'
  ];
  $canonical_query = isset($query) ? trim((string)$query) : 'allvisit';
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <link rel="canonical" href="<?=$site_url . $rank_detail_base . $canonical_query . '/'?>">
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1><?=$page_title?></h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="/" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once 'tpl_search_form.php'; ?>

  <div id="content">
    <div class="article">
      <h2><span>榜单切换</span></h2>
      <div class="block">
        <ul>
          <li><a href="<?=$rank_entry_url?>">聚合排行</a></li>
          <?php foreach($title_arr as $k => $t): ?>
            <li>
              <a href="<?=$rank_detail_base . $k . '/'?>"<?php if(isset($query) && $query === $k): ?> class="blue"<?php endif; ?>><?=$t?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="cover">
      <?php if(!empty($articlerows) && is_array($articlerows)): ?>
        <?php foreach($articlerows as $k => $v): ?><?php if($k < 48):?>
        <div class="block">
          <div class="block_img">
            <a href="<?=$v['info_url']?>">
              <img src="<?=$v['img_url']?>" alt="<?=$v['articlename']?>" loading="lazy"
                   onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h2><span style="color:#999;margin-right:6px;">#<?=($k+1)?></span><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h2>
            <p>作者：<?=$v['author']?></p>
            <p>时间：<?=date('Y-m-d H:i:s',$v['lastupdate'])?></p>
            <p><?=$v['intro_des']?></p>
          </div>
        </div>
        <?php endif ?><?php endforeach ?>
      <?php else: ?>
        <div class="block"><div class="block_txt"><p>暂无排行榜数据</p></div></div>
      <?php endif; ?>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
