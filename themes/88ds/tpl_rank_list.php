<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__ . '/shipsay/seo.php';
  list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('rank');
  $rank_entry_url = isset($rank_entry_url) && $rank_entry_url ? $rank_entry_url : ((isset($fake_top) && $fake_top) ? $fake_top : '/rank/');
  $rank_detail_base = isset($rank_detail_base) && $rank_detail_base ? $rank_detail_base : $rank_entry_url;
  $title_arr = isset($title_arr) && is_array($title_arr) ? $title_arr : [
    'allvisit'   => '总点击榜',
    'monthvisit' => '月点击榜',
    'weekvisit'  => '周点击榜',
    'dayvisit'   => '日点击榜',
    'allvote'    => '总推荐榜',
    'monthvote'  => '月推荐榜',
    'weekvote'   => '周推荐榜',
    'dayvote'    => '日推荐榜',
    'goodnum'    => '收藏榜'
  ];
  $canonical_query = isset($query) ? trim((string)$query) : 'allvisit';
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <link rel="canonical" href="<?=$site_url . $rank_detail_base . $canonical_query . '/')?>">
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
  <style>
    form.search{
      display:flex;
      align-items:center;
      gap:8px;
      flex-wrap:nowrap;
      box-sizing:border-box;
    }
    form.search .searchinput{
      flex:1 1 auto;
      min-width:0;
      box-sizing:border-box;
    }
    form.search .go{
      flex:0 0 auto;
      white-space:nowrap;
      padding:0 12px;
    }
    .rank-switch-list{
      display:flex;
      flex-wrap:wrap;
      margin:0 -4px;
      padding:0;
    }
    .rank-switch-list li{
      width:50%;
      box-sizing:border-box;
      border-bottom:none;
      white-space:normal;
      line-height:1.4;
      padding:0;
    }
    .rank-switch-list a{
      display:block;
      margin:4px;
      padding:10px 12px;
      border:1px solid #dfeaea;
      border-radius:4px;
      background:#fff;
      color:#333;
    }
    .rank-switch-list a.active{
      background:#208181;
      border-color:#208181;
      color:#fff;
      font-weight:700;
    }
    .rank-switch-list a.active strong{
      color:#fff;
    }
    .rank-list-items li{
      white-space:normal;
      overflow:hidden;
      text-overflow:ellipsis;
    }
    .rank-list-items li a{
      color:#208181;
    }
    @media (max-width:480px){
      .header h1{
        width:42%;
        font-size:18px;
      }
      .reg{
        font-size:14px;
      }
      .login_topbtn{
        padding:4px 6px;
        margin-left:3px;
      }
      form.search{
        gap:6px;
        padding:10px;
      }
      form.search .searchinput{
        font-size:14px;
        padding:0 8px;
      }
      form.search .go{
        padding:0 10px;
        min-width:56px;
      }
      .rank-switch-list li{
        width:50%;
      }
      .rank-switch-list a{
        padding:9px 10px;
        font-size:14px;
      }
    }
  </style>
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
        <ul class="rank-switch-list">
          <li><a href="<?=$rank_entry_url?>"<?=$canonical_query === '' ? ' class="active"' : ''?>>聚合排行</a></li>
          <?php foreach ($title_arr as $k => $t): ?>
            <li>
              <a href="<?=$rank_detail_base . $k . '/'?>"<?=(isset($query) && $query === $k) ? ' class="active"' : ''?>><?php if (isset($query) && $query === $k): ?><strong><?=$t?></strong><?php else: ?><?=$t?><?php endif; ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="article">
      <h2><span><?=$page_title?></span></h2>
      <div class="block">
        <ul class="rank-list-items">
          <?php if (!empty($articlerows) && is_array($articlerows)): ?>
            <?php foreach ($articlerows as $k => $v): ?><?php if ($k < 48): ?>
              <?php
                $info_url = isset($v['info_url']) ? $v['info_url'] : '';
                $name = isset($v['articlename']) ? $v['articlename'] : '';
                $author = isset($v['author']) ? $v['author'] : '';
                if ($info_url === '' || $name === '') continue;
              ?>
              <li><span style="color:#999;margin-right:6px;"><?=($k + 1)?>.</span><a href="<?=$info_url?>"><?=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?></a><?php if ($author !== ''): ?> / <?=htmlspecialchars($author, ENT_QUOTES, 'UTF-8')?><?php endif; ?></li>
            <?php endif; ?><?php endforeach; ?>
          <?php else: ?>
            <li>暂无排行榜数据</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
