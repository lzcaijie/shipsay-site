<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
  $use_js = (class_exists('Ss') && method_exists('Ss','use_js')) ? Ss::use_js() : 0;
  $cur_url = Url::chapter_url($articleid, $chapterid, ($now_pid>1?$now_pid:0));

  $sort_link = '';
  if (!empty($sorturl)) {
    $sort_link = $sorturl;
  } elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'ss_sorturl')) {
    $sort_link = Sort::ss_sorturl($sortid);
  } elseif (!empty($sortid) && class_exists('Sort') && method_exists('Sort', 'category_url')) {
    $sort_link = Sort::category_url($sortid, 1);
  }

  $left_url = '';
  $left_txt = '';
  if (!empty($prevpage_url)) {
    $left_url = $prevpage_url;
    $left_txt = '上一页';
  } elseif (!empty($pre_url)) {
    $left_url = $pre_url;
    $left_txt = '上一章';
  } else {
    $left_url = '';
    $left_txt = '上一章';
  }

  $right_url = '';
  $right_txt = '';
  if (!empty($nextpage_url)) {
    $right_url = $nextpage_url;
    $right_txt = '下一页';
  } elseif (!empty($next_url)) {
    $right_url = $next_url;
    $right_txt = '下一章';
  } else {
    $right_url = '';
    $right_txt = '下一章';
  }

  $mid_txt = ($max_pid>1) ? ('第 '.$now_pid.' / '.$max_pid.' 页 · 目录') : '章节目录';
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$chaptername?>_<?=$articlename?>_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$chaptername?>,<?=$articlename?>,<?=$author?>">
<meta name="description" content="<?=$reader_des?>">
<?php require_once 'tpl_header.php'; ?>
</head>
<body class="readbg" id="readbg">

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
    <section class="card">
      <div class="card-hd">
        <h1 class="h2" style="margin:0;line-height:1.35;"><?=$chaptername?></h1>
        <?php if($max_pid>1): ?><span class="muted"><?=$now_pid?>/<?=$max_pid?></span><?php endif; ?>
      </div>

      <div id="ss_reader_content" class="content">
        <?php if(!$use_js): ?>
          <?=$rico_content?>
        <?php else: ?>
          <div class="muted" id="ss_loading">正在加载章节内容...</div>
          <noscript><?=$rico_content?></noscript>
        <?php endif; ?>
      </div>

      <div class="pager readnav" style="margin-top:14px;">
        <?php if(!empty($left_url)): ?><a href="<?=$left_url?>"><?=$left_txt?></a><?php else: ?><span class="muted"><?=$left_txt?></span><?php endif; ?>
        <a class="mid" href="<?=$index_url?>"><?=$mid_txt?></a>
        <?php if(!empty($right_url)): ?><a href="<?=$right_url?>"><?=$right_txt?></a><?php else: ?><span class="muted"><?=$right_txt?></span><?php endif; ?>
      </div>

      <div class="readtools">
        <a class="toolbtn" href="<?=$info_url?>">书籍详情</a>
        <a class="toolbtn" href="<?=ss_recentread_url()?>">阅读记录</a>
        <button class="toolbtn" type="button" id="btnNight">夜间</button>
      </div>
    </section>
  </div>

  <aside class="sidecol">
    <section class="card">
      <div class="bookhead">
        <img class="coverbig" loading="lazy" src="<?=ss_nocover_url()?>" data-src="<?=$img_url?>" onerror="this.src='<?=ss_nocover_url()?>';this.onerror=null;">
        <div class="info">
          <div class="h2" style="margin-bottom:6px;"><a href="<?=$info_url?>"><?=$articlename?></a></div>
          <div class="muted">作者：<a href="<?=$author_url?>"><?=$author?></a></div>
          <div class="muted">分类：<?php if(!empty($sort_link)): ?><a href="<?=$sort_link?>"><?=$sortname?></a><?php else: ?><?=$sortname?><?php endif; ?></div>
          <div class="muted">状态：<?=$isfull?> · <?=$words_w?>万字</div>
        </div>
      </div>
    </section>
  </aside>
</main>

<?php require_once 'tpl_footer.php'; ?>

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
        info_url: <?php echo json_encode($info_url, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        read_url: <?php echo json_encode($cur_url, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        title: <?php echo json_encode($articlename, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        chapter: <?php echo json_encode($chaptername, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        author: <?php echo json_encode($author, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
        cover: <?php echo json_encode($img_url, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?>,
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

  var canAjax = <?php echo $use_js ? '1' : '0'; ?>;
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
  xhr.send('pid='+encodeURIComponent('<?php echo intval($now_pid); ?>')+'&articleid='+encodeURIComponent('<?php echo ss_h($articleid); ?>')+'&chapterid='+encodeURIComponent('<?php echo ss_h($chapterid); ?>'));
})();
</script>

</body>
</html>
