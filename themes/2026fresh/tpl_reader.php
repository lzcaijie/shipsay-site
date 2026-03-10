<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$sort_link_raw = '';
if (!empty($sorturl)) {
  $sort_link_raw = (string)$sorturl;
} elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'ss_sorturl')) {
  $sort_link_raw = (string)Sort::ss_sorturl($sortid);
} elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'category_url')) {
  $sort_link_raw = (string)Sort::category_url($sortid, 1);
}
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$reader_url_raw = !empty($uri) ? (string)$uri : '';
$info_url_raw = !empty($info_url) ? (string)$info_url : '';
$index_url_raw = !empty($index_url) ? (string)$index_url : '';
$author_url_raw = !empty($author_url) ? (string)$author_url : '';

$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$reader_url_attr = htmlspecialchars($reader_url_raw, ENT_QUOTES, 'UTF-8');
$sort_link_attr = htmlspecialchars($sort_link_raw, ENT_QUOTES, 'UTF-8');
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars($author_url_raw, ENT_QUOTES, 'UTF-8');

$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$chapter_title_html = htmlspecialchars((string)$chaptername, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$status_html = htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$words_w_html = htmlspecialchars((string)$words_w, ENT_QUOTES, 'UTF-8');
$chapterwords_safe = intval(isset($chapterwords) ? $chapterwords : 0);

$lastupdate_text_raw = '';
if (!empty($lastupdate) && class_exists('Text') && method_exists('Text', 'ss_lastupdate')) {
  $lastupdate_text_raw = (string)Text::ss_lastupdate($lastupdate);
}
$lastupdate_text_html = htmlspecialchars($lastupdate_text_raw, ENT_QUOTES, 'UTF-8');

$now_pid_safe = max(1, intval(isset($now_pid) ? $now_pid : 1));
$max_pid_safe = max(1, intval(isset($max_pid) ? $max_pid : 1));

$left_url_raw = '';
$left_txt = '上一章';
if (!empty($prevpage_url)) {
  $left_url_raw = (string)$prevpage_url;
  $left_txt = '上一页';
} elseif (!empty($pre_url)) {
  $left_url_raw = (string)$pre_url;
}
$right_url_raw = '';
$right_txt = '下一章';
if (!empty($nextpage_url)) {
  $right_url_raw = (string)$nextpage_url;
  $right_txt = '下一页';
} elseif (!empty($next_url)) {
  $right_url_raw = (string)$next_url;
}
$left_url_attr = htmlspecialchars($left_url_raw, ENT_QUOTES, 'UTF-8');
$right_url_attr = htmlspecialchars($right_url_raw, ENT_QUOTES, 'UTF-8');
$mid_txt = ($max_pid_safe > 1) ? ('第 ' . $now_pid_safe . ' / ' . $max_pid_safe . ' 页 · 目录') : '章节目录';

require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('reader');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
  $seo_title = $chaptername . '_' . $articlename . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
  $seo_keywords = $articlename . ',' . $chaptername . ',' . SITE_NAME . ',在线阅读';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
  $seo_description = '《' . $articlename . '》最新章节：' . $chaptername . '，作者：' . $author . '。';
}
$seo_title_html = htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8');
$seo_keywords_html = htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8');
$seo_description_html = htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8');

$reader_breadcrumb_ld = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
  ],
];
if ($sort_link_raw !== '') {
  $reader_breadcrumb_ld['itemListElement'][] = ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => $sort_link_raw];
}
if ($info_url_raw !== '') {
  $reader_breadcrumb_ld['itemListElement'][] = ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url_raw];
}
if ($reader_url_raw !== '') {
  $reader_breadcrumb_ld['itemListElement'][] = ['@type' => 'ListItem', 'position' => 4, 'name' => $chaptername, 'item' => $reader_url_raw];
}
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$seo_title_html?></title>
<meta name="keywords" content="<?=$seo_keywords_html?>">
<meta name="description" content="<?=$seo_description_html?>">
<?php if ($reader_url_raw !== ''): ?>
<link rel="canonical" href="<?=$reader_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$reader_url_attr?>">
<meta property="og:url" content="<?=$reader_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="novel">
<meta property="og:title" content="<?=$seo_title_html?>">
<meta property="og:description" content="<?=$seo_description_html?>">
<?php if ($sortname_html !== ''): ?><meta property="og:novel:category" content="<?=$sortname_html?>小说"><?php endif; ?>
<?php if ($author_html !== ''): ?><meta property="og:novel:author" content="<?=$author_html?>"><?php endif; ?>
<?php if ($article_title_html !== ''): ?><meta property="og:novel:book_name" content="<?=$article_title_html?>"><?php endif; ?>
<?php if ($index_url_raw !== ''): ?><meta property="og:novel:index_url" content="<?=$index_url_attr?>"><?php endif; ?>
<?php if ($info_url_raw !== ''): ?><meta property="og:novel:info_url" content="<?=$info_url_attr?>"><?php endif; ?>
<?php if ($status_html !== ''): ?><meta property="og:novel:status" content="<?=$status_html?>"><?php endif; ?>
<?php if ($chapter_title_html !== ''): ?><meta property="og:novel:chapter_name" content="<?=$chapter_title_html?>"><?php endif; ?>
<?php if ($reader_url_raw !== ''): ?><meta property="og:novel:chapter_url" content="<?=$reader_url_attr?>"><?php endif; ?>
<script type="application/ld+json"><?=json_encode($reader_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body class="readbg" id="readbg">

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

<main class="wrap layout">
  <div class="maincol">
    <section class="card">
      <div class="muted" style="margin-bottom:10px;line-height:1.7;">
        <a href="<?=$site_home_url_attr?>">首页</a>
        <?php if ($sort_link_raw !== ''): ?> &gt; <a href="<?=$sort_link_attr?>"><?=$sortname_html?></a><?php elseif ($sortname_html !== ''): ?> &gt; <span><?=$sortname_html?></span><?php endif; ?>
        <?php if ($info_url_raw !== ''): ?> &gt; <a href="<?=$info_url_attr?>"><?=$article_title_html?></a><?php elseif ($article_title_html !== ''): ?> &gt; <span><?=$article_title_html?></span><?php endif; ?>
        &gt; <span><?=$chapter_title_html?></span>
      </div>

      <div class="card-hd">
        <h1 class="h2" style="margin:0;line-height:1.45;"><?=$chapter_title_html?></h1>
        <?php if($max_pid_safe > 1): ?><span class="muted"><?=$now_pid_safe?>/<?=$max_pid_safe?></span><?php endif; ?>
      </div>

      <div class="muted" style="margin-top:-2px;margin-bottom:12px;line-height:1.8;">
        <?php if($info_url_raw !== ''): ?><a href="<?=$info_url_attr?>"><?=$article_title_html?></a><?php else: ?><?=$article_title_html?><?php endif; ?>
        <?php if($author_html !== ''): ?> · <?php if($author_url_raw !== ''): ?><a href="<?=$author_url_attr?>"><?=$author_html?></a><?php else: ?><?=$author_html?><?php endif; ?><?php endif; ?>
        <?php if($chapterwords_safe > 0): ?> · <?=$chapterwords_safe?> 字<?php endif; ?>
        <?php if($lastupdate_text_html !== ''): ?> · <?=$lastupdate_text_html?><?php endif; ?>
      </div>

      <div id="ss_reader_content" class="content">
        <?php if(empty($use_js)): ?>
          <?=$rico_content?>
        <?php else: ?>
          <div class="muted" id="ss_loading">正在加载章节内容...</div>
          <noscript><?=$rico_content?></noscript>
        <?php endif; ?>
      </div>

      <div class="pager readnav" style="margin-top:14px;">
        <?php if($left_url_raw !== ''): ?><a href="<?=$left_url_attr?>"><?=htmlspecialchars($left_txt, ENT_QUOTES, 'UTF-8')?></a><?php else: ?><span class="muted"><?=htmlspecialchars($left_txt, ENT_QUOTES, 'UTF-8')?></span><?php endif; ?>
        <?php if($index_url_raw !== ''): ?><a class="mid" href="<?=$index_url_attr?>"><?=htmlspecialchars($mid_txt, ENT_QUOTES, 'UTF-8')?></a><?php else: ?><span class="mid" aria-disabled="true"><?=htmlspecialchars($mid_txt, ENT_QUOTES, 'UTF-8')?></span><?php endif; ?>
        <?php if($right_url_raw !== ''): ?><a href="<?=$right_url_attr?>"><?=htmlspecialchars($right_txt, ENT_QUOTES, 'UTF-8')?></a><?php else: ?><span class="muted"><?=htmlspecialchars($right_txt, ENT_QUOTES, 'UTF-8')?></span><?php endif; ?>
      </div>

      <div class="readtools">
        <?php if($info_url_raw !== ''): ?><a class="toolbtn" href="<?=$info_url_attr?>">书籍详情</a><?php else: ?><span class="toolbtn" aria-disabled="true">书籍详情</span><?php endif; ?>
        <?php if($recentread_url_raw !== ''): ?><a class="toolbtn" href="<?=$recentread_url_attr?>">阅读记录</a><?php else: ?><span class="toolbtn" aria-disabled="true">阅读记录</span><?php endif; ?>
        <button class="toolbtn" type="button" id="btnNight">夜间</button>
      </div>
    </section>
  </div>

  <aside class="sidecol">
    <section class="card">
      <div class="bookhead">
        <img class="coverbig" loading="lazy" src="<?=ss_nocover_url()?>" data-src="<?=$img_url_attr?>" alt="<?=$article_title_html?>" onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
        <div class="info">
          <div class="h2" style="margin-bottom:6px;"><?php if($info_url_raw !== ''): ?><a href="<?=$info_url_attr?>"><?=$article_title_html?></a><?php else: ?><?=$article_title_html?><?php endif; ?></div>
          <div class="line">作者：<?php if($author_url_raw !== ''): ?><a href="<?=$author_url_attr?>"><?=$author_html?></a><?php else: ?><?=$author_html?><?php endif; ?></div>
          <div class="line">分类：<?php if($sort_link_raw !== ''): ?><a href="<?=$sort_link_attr?>"><?=$sortname_html?></a><?php else: ?><?=$sortname_html?><?php endif; ?></div>
          <div class="line">状态：<?=$status_html?><?php if($words_w_html !== ''): ?> · <?=$words_w_html?>万字<?php endif; ?></div>
        </div>
      </div>
    </section>
  </aside>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>

<script>
(function(){
  var bg=document.getElementById('readbg');
  var btn=document.getElementById('btnNight');
  if(bg && btn){
    var night=false;
    try{ night = localStorage.getItem('ss_night')==='1'; }catch(e){}
    function apply(){
      if(night){ bg.classList.add('night'); btn.textContent='日间'; }
      else{ bg.classList.remove('night'); btn.textContent='夜间'; }
    }
    apply();
    btn.addEventListener('click', function(){
      night=!night;
      try{ localStorage.setItem('ss_night', night?'1':'0'); }catch(e){}
      apply();
    });
  }

  function saveLastRead(){
    try{
      var key='ss_lastread';
      var it={
        info_url: <?php echo json_encode($info_url_raw, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        read_url: <?php echo json_encode($reader_url_raw, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        title: <?php echo json_encode((string)$articlename, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        chapter: <?php echo json_encode((string)$chaptername, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        author: <?php echo json_encode((string)$author, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        cover: <?php echo json_encode((string)$img_url, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        t: Date.now()
      };
      var arr=JSON.parse(localStorage.getItem(key)||'[]');
      if(!Array.isArray(arr)) arr=[];
      arr = arr.filter(function(x){ return x && x.info_url !== it.info_url; });
      arr.unshift(it);
      if(arr.length>50) arr=arr.slice(0,50);
      localStorage.setItem(key, JSON.stringify(arr));
    }catch(e){}
  }

  var canAjax = <?php echo !empty($use_js) ? '1' : '0'; ?>;
  var box = document.getElementById('ss_reader_content');
  if(!box){ return; }
  if(!canAjax){ saveLastRead(); return; }

  var xhr = new XMLHttpRequest();
  xhr.open('POST','/api/reader_js.php',true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
  xhr.onreadystatechange = function(){
    if(xhr.readyState===4){
      var ok = (xhr.status===200 && xhr.responseText);
      if(ok){
        box.innerHTML = xhr.responseText;
      }else{
        box.innerHTML = <?php echo json_encode($rico_content, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>;
      }
      saveLastRead();
      if(window.ssLazy) window.ssLazy();
    }
  };
  var params = 'pid=' + encodeURIComponent(<?php echo json_encode((string)$now_pid_safe, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>)
    + '&articleid=' + encodeURIComponent(<?php echo json_encode((string)$articleid, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>)
    + '&chapterid=' + encodeURIComponent(<?php echo json_encode((string)$chapterid, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>);
  xhr.send(params);
})();
</script>

</body>
</html>
