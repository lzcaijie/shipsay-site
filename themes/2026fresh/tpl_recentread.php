<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = isset($site_home_url_raw) && $site_home_url_raw ? (string)$site_home_url_raw : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_page_title = '阅读记录_' . SITE_NAME;
$recentread_page_title_html = htmlspecialchars($recentread_page_title, ENT_QUOTES, 'UTF-8');
$recentread_page_description = SITE_NAME . '阅读记录页。';
$recentread_page_description_html = htmlspecialchars($recentread_page_description, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title><?=$recentread_page_title_html?></title>
<meta name="keywords" content="阅读记录,阅读历史,<?=htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=$recentread_page_description_html?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>

<header class="topbar">
  <div class="wrap">
    <a class="brand" href="<?=$site_home_url_attr?>"><?=$site_name_html?></a>
    <div class="crumb">阅读记录</div>
    <div class="spacer"></div>
    <button class="link" type="button" id="ss_clear_all">清空</button>
  </div>
</header>

<main class="wrap">
  <section class="card">
    <div class="muted" style="margin-bottom:10px;line-height:1.7;"><a href="<?=$site_home_url_attr?>">首页</a> &gt; <span>阅读记录</span></div>
    <div class="card-hd"><h2 class="h2">最近阅读</h2></div>
    <div id="ss_recent_list" class="list" style="margin-top:10px;"></div>
    <div id="ss_recent_empty" class="muted" style="display:none;margin-top:10px;">暂无阅读记录。</div>
  </section>

  <?php if(!empty($popular) && is_array($popular)): ?>
  <section class="card">
    <div class="card-hd"><h2 class="h2">大家都在看</h2></div>
    <div class="list">
      <?php $i=0; foreach($popular as $v): $i++; if($i>12) break; if(empty($v) || !is_array($v)) continue; ?>
        <?php
          $info_url_raw = !empty($v['info_url']) ? (string)$v['info_url'] : '';
          $title_raw = !empty($v['articlename']) ? (string)$v['articlename'] : '';
          $author_raw = !empty($v['author']) ? (string)$v['author'] : '';
          if($info_url_raw === '' || $title_raw === '') continue;
        ?>
        <a class="item" href="<?=htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($title_raw, ENT_QUOTES, 'UTF-8')?><?php if($author_raw !== ''): ?> <span class="muted">/ <?=htmlspecialchars($author_raw, ENT_QUOTES, 'UTF-8')?></span><?php endif; ?></a>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>
</main>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>

<script>
(function(){
  var key='ss_lastread';
  var box=document.getElementById('ss_recent_list');
  var empty=document.getElementById('ss_recent_empty');
  var btnClear=document.getElementById('ss_clear_all');

  function esc(s){
    return String(s||'').replace(/[&<>"']/g,function(c){return({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])});
  }

  function load(){
    var arr=[];
    try{ arr=JSON.parse(localStorage.getItem(key)||'[]'); }catch(e){ arr=[]; }
    if(!Array.isArray(arr)) arr=[];

    box.innerHTML='';
    if(!arr.length){
      empty.style.display='block';
      return;
    }
    empty.style.display='none';

    arr.forEach(function(it,idx){
      if(!it || !it.read_url || !it.title) return;
      var cover = it.cover || '';
      var info = it.info_url || '';
      var read = it.read_url || '';
      var title = it.title || '';
      var chapter = it.chapter || '';
      var author = it.author || '';

      var el=document.createElement('div');
      el.className='list-item';
      el.innerHTML=
        '<span class="book-cover" style="width:54px;height:72px;">'+
          '<img loading="lazy" src="<?=ss_nocover_url()?>" data-src="'+esc(cover)+'" onerror="this.src=\'<?=ss_nocover_url()?>\';this.onerror=null;">'+
        '</span>'+
        '<div class="li-main">'+
          '<div class="li-title">'+(info?('<a href="'+esc(info)+'">'+esc(title)+'</a>'):esc(title))+'</div>'+
          '<div class="li-sub">'+esc(author)+(chapter?(' · '+esc(chapter)):'')+'</div>'+
          '<div class="btnrow" style="margin-top:8px;">'+
            (read?('<a class="btn primary" href="'+esc(read)+'">继续阅读</a>'):'')+
            '<button class="btn" type="button" data-del="'+idx+'">删除</button>'+
          '</div>'+
        '</div>';
      box.appendChild(el);
    });

    if(window.ssLazy) window.ssLazy();
  }

  box.addEventListener('click', function(e){
    var t=e.target;
    if(t && t.getAttribute && t.getAttribute('data-del')!==null){
      var idx=parseInt(t.getAttribute('data-del'),10);
      var arr=[];
      try{ arr=JSON.parse(localStorage.getItem(key)||'[]'); }catch(e2){ arr=[]; }
      if(Array.isArray(arr)){
        arr.splice(idx,1);
        try{ localStorage.setItem(key, JSON.stringify(arr)); }catch(e3){}
      }
      load();
    }
  });

  if(btnClear){
    btnClear.addEventListener('click', function(){
      try{ localStorage.removeItem(key); }catch(e){}
      load();
    });
  }

  load();
})();
</script>

</body>
</html>
