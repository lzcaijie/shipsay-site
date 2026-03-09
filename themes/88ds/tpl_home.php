<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
$home_url_raw = (isset($uri) && $uri) ? (string)$uri : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$home_url_attr = htmlspecialchars($home_url_raw, ENT_QUOTES, 'UTF-8');
$rank_entry_raw = '';
if (isset($rank_entry_url) && $rank_entry_url) {
    $rank_entry_raw = (string)$rank_entry_url;
} elseif (isset($fake_top) && $fake_top) {
    $rank_entry_raw = (string)$fake_top;
}
$rank_entry_attr = htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8');
$full_allbooks_url_raw = (isset($full_allbooks_url) && $full_allbooks_url)
    ? (string)$full_allbooks_url
    : ((isset($allbooks_url) && $allbooks_url) ? ('/quanben' . $allbooks_url) : '');
$full_allbooks_url_attr = htmlspecialchars($full_allbooks_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_raw = isset($fake_recentread) ? (string)$fake_recentread : '';
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$home_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => SITE_NAME,
    'url' => $home_url_raw,
    'description' => $seo_description,
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$home_url_attr?>">
<link rel="canonical" href="<?=$home_url_attr?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$home_url_attr?>">
<script type="application/ld+json"><?=json_encode($home_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
    <div class="header">
      <div class="logo">
        <a href="<?=$home_url_attr?>"><?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></a>
      </div>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
        <a href="<?=$home_url_attr?>" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>

    <div class="nav">
      <ul>
        <li><a href="javascript:;" onclick="return toggleSort();" rel="nofollow">分类</a></li>
        <li><?php if ($rank_entry_raw !== ''): ?><a href="<?=$rank_entry_attr?>">排行</a><?php else: ?><span>排行</span><?php endif; ?></li>
        <li><?php if ($full_allbooks_url_raw !== ''): ?><a href="<?=$full_allbooks_url_attr?>">全本</a><?php else: ?><span>全本</span><?php endif; ?></li>
        <li><?php if ($recentread_url_raw !== ''): ?><a href="<?=$recentread_url_attr?>" rel="nofollow">足迹</a><?php else: ?><span>足迹</span><?php endif; ?></li>
      </ul>
    </div>

    <div class="sort c_sort" id="submenu" style="display:none;">
        <ul>
            <?php foreach(Sort::ss_sorthead() as $v): ?>
                <?php $sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8'); $sort_name_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8'); ?>
                <li><a href="<?=$sort_url_attr?>"><?=$sort_name_html?></a></li>
            <?php endforeach ?>
            <div class="cc"></div>
        </ul>
    </div>

    <?php ss_render_search_form(); ?>

    <div class="article">
      <h2><span>推荐排行</span></h2>
      <div class="block">
        <?php foreach($commend as $k => $v): ?><?php if($k == 0):?>
          <?php $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8'); ?>
          <div class="block_img">
            <a href="<?=$info_url_attr?>">
              <img src="<?=$img_url_attr?>" alt="<?=$title_html?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3 class="book-title"><a href="<?=$info_url_attr?>"><?=$title_html?></a></h3>
            <p class="book-meta">作者：<?=$author_html?></p>
            <p class="book-desc"><?=$intro_html?></p>
          </div>
        <div class="clear"></div>
        <ul>
        <?php else: ?>
          <?php $sort_html = htmlspecialchars((string)$v['sortname'], ENT_QUOTES, 'UTF-8'); $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); ?>
          <li><span>[<?=$sort_html?>]</span> <a href="<?=$info_url_attr?>" class="blue"><?=$title_html?></a> / <?=$author_html?></li>
        <?php endif?><?php endforeach?>
        </ul>
      </div>
    </div>

    <div class="article">
      <h2><span>热门小说</span></h2>
      <div class="block">
        <?php foreach($popular as $k => $v): ?><?php if($k == 0):?>
          <?php $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8'); ?>
          <div class="block_img">
            <a href="<?=$info_url_attr?>">
              <img src="<?=$img_url_attr?>" alt="<?=$title_html?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3 class="book-title"><a href="<?=$info_url_attr?>"><?=$title_html?></a></h3>
            <p class="book-meta">作者：<?=$author_html?></p>
            <p class="book-desc"><?=$intro_html?></p>
          </div>
        <div class="clear"></div>
        <ul>
        <?php else: ?>
          <?php $sort_html = htmlspecialchars((string)$v['sortname'], ENT_QUOTES, 'UTF-8'); $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); ?>
          <li><span>[<?=$sort_html?>]</span> <a href="<?=$info_url_attr?>" class="blue"><?=$title_html?></a> / <?=$author_html?></li>
        <?php endif?><?php endforeach?>
        </ul>
      </div>
    </div>

    <div class="article">
      <h2><span>最近更新</span></h2>
      <div class="block">
        <?php foreach($lastupdate as $k => $v): ?><?php if($k == 0):?>
          <?php $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8'); ?>
          <div class="block_img">
            <a href="<?=$info_url_attr?>">
              <img src="<?=$img_url_attr?>" alt="<?=$title_html?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3 class="book-title"><a href="<?=$info_url_attr?>"><?=$title_html?></a></h3>
            <p class="book-meta">作者：<?=$author_html?></p>
            <p class="book-desc"><?=$intro_html?></p>
          </div>
        <div class="clear"></div>
        <ul>
        <?php else: ?>
          <?php $sort_html = htmlspecialchars((string)$v['sortname'], ENT_QUOTES, 'UTF-8'); $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); ?>
          <li><span>[<?=$sort_html?>]</span> <a href="<?=$info_url_attr?>" class="blue"><?=$title_html?></a> / <?=$author_html?></li>
        <?php endif?><?php endforeach?>
        </ul>
      </div>
    </div>

    <div class="article">
      <h2><span>新书上架</span></h2>
      <div class="block">
        <?php foreach($postdate as $k => $v): ?><?php if($k == 0):?>
          <?php $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8'); ?>
          <div class="block_img">
            <a href="<?=$info_url_attr?>">
              <img src="<?=$img_url_attr?>" alt="<?=$title_html?>" loading="lazy" onerror="this.src='/static/images/nocover.jpg';this.onerror=null;">
            </a>
          </div>
          <div class="block_txt">
            <h3 class="book-title"><a href="<?=$info_url_attr?>"><?=$title_html?></a></h3>
            <p class="book-meta">作者：<?=$author_html?></p>
            <p class="book-desc"><?=$intro_html?></p>
          </div>
        <div class="clear"></div>
        <ul>
        <?php else: ?>
          <?php $sort_html = htmlspecialchars((string)$v['sortname'], ENT_QUOTES, 'UTF-8'); $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8'); $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8'); $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8'); ?>
          <li><span>[<?=$sort_html?>]</span> <a href="<?=$info_url_attr?>" class="blue"><?=$title_html?></a> / <?=$author_html?></li>
        <?php endif?><?php endforeach?>
        </ul>
      </div>
    </div>

    <?php if (!empty($link_html)): ?>
    <div class="article"><h2>友情链接</h2></div>
    <p><?=$link_html?></p>
    <?php endif; ?>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
