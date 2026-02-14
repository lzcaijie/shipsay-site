<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
  $tabs = [
    'allvisit' => '总榜',
    'monthvisit' => '月榜',
    'weekvisit' => '周榜',
    'dayvisit' => '日榜',
    'allvote' => '总推荐',
    'monthvote' => '月推荐',
    'weekvote' => '周推荐',
    'dayvote' => '日推荐',
    'goodnum' => '精品'
  ];
  if (empty($query)) $query = 'allvisit';
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$page_title?>_<?=SITE_NAME?></title>
<meta name="keywords" content="排行,<?=$page_title?>">
<meta name="description" content="<?=SITE_NAME?>小说排行榜：<?=$page_title?>。">
<?php require_once 'tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="/"><?=SITE_NAME?></a>
    <form class="search" action="<?=ss_search_url()?>" method="get">
      <input type="text" name="searchkey" placeholder="书名 / 作者" autocomplete="off">
      <button type="submit">搜索</button>
    </form>
    <a class="link" href="<?=ss_recentread_url()?>">记录</a>
  </div>
</header>

<main class="wrap">
  <section class="card">
    <div class="chips">
      <?php foreach($tabs as $k=>$t): ?>
        <a class="chip<?=$k==$query?' active':''?>" href="/rank/<?=$k?>/"><?=$t?></a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="card">
    <div class="card-hd"><h2 class="h2"><?=$page_title?></h2></div>

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
          $sortname = !empty($v['sortname']) ? $v['sortname'] : '';

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
      <?php endforeach; endif; ?>
    </div>
  </section>
</main>

<?php require_once 'tpl_footer.php'; ?>
</body>
</html>
