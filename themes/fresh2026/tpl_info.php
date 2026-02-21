<?php if (!defined('__ROOT_DIR__')) exit;

$author_link = !empty($author_url) ? $author_url : '';

$sort_link = '';
if (!empty($sorturl)) {
  $sort_link = $sorturl;
} elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'ss_sorturl')) {
  $sort_link = Sort::ss_sorturl($sortid);
} elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'category_url')) {
  $sort_link = Sort::category_url($sortid, 1);
}

$chapter_source = array();
if (!empty($allarr) && is_array($allarr)) {
  $chapter_source = $allarr;
} elseif (!empty($chapterarr) && is_array($chapterarr)) {
  $chapter_source = $chapterarr;
} elseif (!empty($chapterrows) && is_array($chapterrows)) {
  $chapter_source = $chapterrows;
} elseif (!empty($chapters) && is_array($chapters)) {
  $chapter_source = $chapters;
} elseif (!empty($lastarr) && is_array($lastarr)) {
  $chapter_source = $lastarr;
}

$chapter_show = array();
if (!empty($chapter_source) && is_array($chapter_source)) {
  $tmp = array();
  $i = 0;
  foreach ($chapter_source as $v) {
    $i++;
    if (!is_array($v)) continue;
    $sid = 0;
    if (isset($v['cid']) && is_numeric($v['cid'])) {
      $sid = intval($v['cid']);
    } elseif (isset($v['chapterid']) && is_numeric($v['chapterid'])) {
      $sid = intval($v['chapterid']);
    } elseif (isset($v['chapterorder']) && is_numeric($v['chapterorder'])) {
      $sid = intval($v['chapterorder']);
    } else {
      $sid = $i;
    }
    $v['_sid'] = $sid;
    $tmp[] = $v;
  }
  usort($tmp, function ($a, $b) {
    $aa = isset($a['_sid']) ? intval($a['_sid']) : 0;
    $bb = isset($b['_sid']) ? intval($b['_sid']) : 0;
    if ($aa == $bb) return 0;
    return ($aa < $bb) ? -1 : 1;
  });
  $chapter_show = array_slice($tmp, 0, 50);
}

$last_show = array();
if (!empty($lastarr) && is_array($lastarr)) {
  $last_show = array_slice($lastarr, 0, 12);
}

$rec_rows = array();
if (!empty($neighbor) && is_array($neighbor)) {
  $rec_rows = $neighbor;
} elseif (!empty($commend) && is_array($commend)) {
  $rec_rows = $commend;
}
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>《<?=$articlename?>》_<?=$author?>_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$articlename?>,<?=$author?>,<?=$sortname?>">
<meta name="description" content="<?=$intro_des?>">
<link href="<?=$site_url?><?=$uri?>" rel="canonical">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
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

<main class="wrap layout">
  <div class="maincol">
    <section class="card bookhead">
      <img class="coverbig" loading="lazy"
           src="/static/<?=$theme_dir?>/nocover.jpg"
           data-src="<?=$img_url?>"
           alt="<?=$articlename?>"
           onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;">
      <div class="info">
        <h1 class="h1"><?=$articlename?></h1>
        <div class="line">作者：<?php if(!empty($author_link)): ?><a href="<?=$author_link?>"><?=$author?></a><?php else: ?><?=$author?><?php endif; ?></div>
        <div class="line">分类：<?php if(!empty($sort_link)): ?><a href="<?=$sort_link?>"><?=$sortname?></a><?php else: ?><?=$sortname?><?php endif; ?></div>
        <div class="line">状态：<?=$isfull?> · <?=$words_w?>万字 · 人气 <?=$allvisit?></div>
        <div class="line">更新：<?=$lastupdate_cn?> · <a href="<?=$last_url?>"><?=$lastchapter?></a></div>
        <div class="btnrow">
          <a class="btn primary" href="<?=$first_url?>">开始阅读</a>
          <a class="btn" href="<?=$index_url?>">章节目录</a>
        </div>
      </div>
    </section>

    <section class="card">
      <h2 class="h2">内容简介</h2>
      <div class="p"><?=$intro_p?></div>
    </section>

    <?php if(!empty($last_show) && is_array($last_show)): ?>
    <section class="card">
      <div class="card-hd">
        <h2 class="h2">最新章节</h2>
        <a class="more" href="<?=$index_url?>">全部目录</a>
      </div>
      <div class="list">
        <?php foreach($last_show as $v):
          if(empty($v) || !is_array($v)) continue;
          $n = isset($v['cname']) ? $v['cname'] : (isset($v['name']) ? $v['name'] : '');
          $u = isset($v['cid_url']) ? $v['cid_url'] : (isset($v['url']) ? $v['url'] : '');
          if(empty($n) || empty($u)) continue;
        ?>
          <a class="item" href="<?=$u?>"><?=$n?></a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($chapter_show) && is_array($chapter_show)): ?>
    <section class="card chaptercard">
      <div class="card-hd">
        <h2 class="h2">章节目录（前50章）</h2>
        <a class="more" href="<?=$index_url?>">全部目录</a>
      </div>
      <div class="chapters-grid">
        <?php foreach($chapter_show as $v):
          if(empty($v) || !is_array($v)) continue;
          $cname = '';
          if(isset($v['cname'])) $cname = $v['cname'];
          elseif(isset($v['name'])) $cname = $v['name'];
          elseif(isset($v['chaptername'])) $cname = $v['chaptername'];
          $curl = '';
          if(isset($v['cid_url'])) $curl = $v['cid_url'];
          elseif(isset($v['url'])) $curl = $v['url'];
          elseif(isset($v['link'])) $curl = $v['link'];
          elseif(isset($v['cidlink'])) $curl = $v['cidlink'];
          if(empty($cname) || empty($curl)) continue;
        ?>
          <a class="citem" href="<?=$curl?>"><?=$cname?></a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
  </div>

  <aside class="sidecol">
    <section class="card">
      <h2 class="h2">书籍信息</h2>
      <div class="kv">
        <div><span>作者</span><b><?php if(!empty($author_link)): ?><a href="<?=$author_link?>"><?=$author?></a><?php else: ?><?=$author?><?php endif; ?></b></div>
        <div><span>分类</span><b><?php if(!empty($sort_link)): ?><a href="<?=$sort_link?>"><?=$sortname?></a><?php else: ?><?=$sortname?><?php endif; ?></b></div>
        <div><span>状态</span><b><?=$isfull?></b></div>
        <div><span>更新</span><b><?=$lastupdate_cn?></b></div>
      </div>
      <div class="btnrow" style="margin-top:10px;">
        <a class="btn" href="<?=ss_recentread_url()?>">阅读记录</a>
        <a class="btn" href="/">回首页</a>
      </div>
    </section>

    <?php if (isset($is_langtail) && $is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)) : ?>
    <section class="card">
      <h2 class="h2">相关推荐</h2>
      <div class="tags">
        <?php foreach ($langtailrows as $v) :
          if(empty($v) || !is_array($v)) continue;
          if(empty($v['info_url']) || empty($v['langname'])) continue;
        ?>
          <a class="tag" href="<?=$v['info_url']?>"><?=$v['langname']?></a>
        <?php endforeach ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($rec_rows) && is_array($rec_rows)): ?>
    <section class="card">
      <h2 class="h2">推荐阅读</h2>
      <div class="list" style="margin-top:10px;">
        <?php $r=0; foreach($rec_rows as $v):
          $r++; if($r>10) break;
          if(empty($v) || !is_array($v)) continue;
          $u = isset($v['info_url']) ? $v['info_url'] : '';
          $n = isset($v['articlename']) ? $v['articlename'] : (isset($v['title']) ? $v['title'] : '');
          $a = isset($v['author']) ? $v['author'] : '';
          if(empty($u) || empty($n)) continue;
        ?>
          <a class="item" href="<?=$u?>"><?=$n?><?php if(!empty($a)): ?> <span class="muted">/ <?=$a?></span><?php endif; ?></a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
  </aside>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
