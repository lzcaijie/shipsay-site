<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$title_arr = [
  'allvisit' => '总点击榜',
  'monthvisit' => '月点击榜',
  'weekvisit' => '周点击榜',
  'dayvisit' => '日点击榜',
  'allvote' => '总推荐榜',
  'monthvote' => '月推荐榜',
  'weekvote' => '周推荐榜',
  'dayvote' => '日推荐榜',
  'goodnum' => '收藏榜'
];
$current_query = isset($query) && $query ? (string)$query : 'allvisit';
$current_title = isset($title_arr[$current_query]) ? $title_arr[$current_query] : '排行榜';

$rank_entry_url_raw = '';
if (!empty($rank_entry_url)) {
  $rank_entry_url_raw = rtrim((string)$rank_entry_url, '/') . '/';
} elseif (!empty($fake_top)) {
  $rank_entry_url_raw = rtrim((string)$fake_top, '/') . '/';
}
$rank_detail_base_raw = !empty($rank_detail_base) ? rtrim((string)$rank_detail_base, '/') . '/' : $rank_entry_url_raw;
$rank_url_raw = !empty($uri) ? (string)$uri : ($rank_detail_base_raw !== '' ? $rank_detail_base_raw . $current_query . '/' : '');
$rank_url_attr = htmlspecialchars($rank_url_raw, ENT_QUOTES, 'UTF-8');

require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
  $seo_title = $current_title . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
  $seo_keywords = $current_title . ',' . SITE_NAME . ',排行榜,热门小说';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
  $seo_description = $current_title . '榜单，尽在' . SITE_NAME . '。';
}
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($rank_url_raw !== ''): ?>
<link rel="canonical" href="<?=$rank_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$rank_url_attr?>">
<meta property="og:url" content="<?=$rank_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="<?=$site_home_url_attr?>"><?=$site_name_html?></a>
    <form class="search" method="get"<?php if($search_url_raw !== ''): ?> action="<?=$search_url_attr?>"<?php else: ?> onsubmit="return false;"<?php endif; ?>>
      <input type="text" name="searchkey" placeholder="<?=$search_placeholder_attr?>" autocomplete="off">
      <button type="submit"<?php if($search_url_raw === ''): ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>搜索</button>
    </form>
    <?php if($recentread_url_raw !== ''): ?><a class="link" href="<?=$recentread_url_attr?>">记录</a><?php else: ?><span class="link" aria-disabled="true">记录</span><?php endif; ?>
  </div>
</header>

<main class="wrap">
  <section class="card">
    <div class="chips">
      <?php foreach($title_arr as $key => $label): ?>
        <?php if($rank_detail_base_raw !== ''): ?>
          <a class="chip<?=$key === $current_query ? ' active' : ''?>" href="<?=htmlspecialchars($rank_detail_base_raw . $key . '/', ENT_QUOTES, 'UTF-8')?>"><?=$label?></a>
        <?php else: ?>
          <span class="chip<?=$key === $current_query ? ' active' : ''?>" aria-disabled="true"><?=$label?></span>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="card">
    <div class="card-hd"><h1 class="h2"><?=$current_title?></h1></div>

    <div class="list">
      <?php if(!empty($articlerows) && is_array($articlerows)): $i=0; foreach($articlerows as $v): $i++; ?>
        <?php
          if(empty($v) || !is_array($v)) continue;
          $info_url = !empty($v['info_url']) ? $v['info_url'] : '';
          $articlename = !empty($v['articlename']) ? $v['articlename'] : '';
          if(empty($info_url) || empty($articlename)) continue;

          $author_url = !empty($v['author_url']) ? $v['author_url'] : '';
          $author = !empty($v['author']) ? $v['author'] : '';
          $sortid = isset($v['sortid']) ? $v['sortid'] : '';
          $sortname = !empty($v['sortname']) ? $v['sortname'] : (!empty($v['sortname_2']) ? $v['sortname_2'] : '');
          $sort_link = '';
          if (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'ss_sorturl')) {
            $sort_link = Sort::ss_sorturl($sortid);
          } elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'category_url')) {
            $sort_link = Sort::category_url($sortid, 1);
          }
        ?>
        <div class="list-item">
          <span class="rank-no"><?=$i?></span>
          <div class="li-main">
            <div class="li-title"><a href="<?=$info_url?>"><?=$articlename?></a></div>
            <div class="li-sub">
              <?php if(!empty($author_url) && !empty($author)): ?><a href="<?=$author_url?>"><?=$author?></a><?php elseif(!empty($author)): ?><?=$author?><?php endif; ?>
              <?php if((!empty($author) && !empty($sortname))): ?><span class="dot">·</span><?php endif; ?>
              <?php if(!empty($sort_link) && !empty($sortname)): ?><a href="<?=$sort_link?>"><?=$sortname?></a><?php elseif(!empty($sortname)): ?><?=$sortname?><?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; else: ?>
        <div class="muted">暂无排行榜数据。</div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
