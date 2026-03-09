<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($fake_recentread) && $fake_recentread) ? (string)$fake_recentread : '');
$recentread_url_attr = htmlspecialchars($recentread_url_raw, ENT_QUOTES, 'UTF-8');
$recentread_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => '阅读记录', 'item' => $recentread_url_raw !== '' ? $recentread_url_raw : $site_home_url_raw],
    ],
];
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>最近阅读_<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></title>
<meta name="description" content="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?> 最近阅读与阅读记录页面。">
<?php if ($recentread_url_raw !== ''): ?>
<link rel="canonical" href="<?=$recentread_url_attr?>">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$recentread_url_attr?>">
<?php endif; ?>
<script type="application/ld+json"><?=json_encode($recentread_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<style>
.history-tools{padding:10px;display:flex;justify-content:flex-end;}
.history-tools button{height:34px;padding:0 14px;border:1px solid #208181;background:#208181;color:#fff;border-radius:3px;cursor:pointer;}
.history-empty{padding:10px;color:#666;line-height:1.8;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1>阅读记录</h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="<?=$site_home_url_attr?>" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once __THEME_DIR__ . '/tpl_search_form.php'; ?>

  <div id="content">
    <div class="article">
      <h2><span>最近阅读</span></h2>
      <div class="block">
        <p>本页展示浏览器本地保存的阅读记录，不登录也可查看。</p>
      </div>
    </div>

    <div class="history-tools">
      <button type="button" id="clearRecentRead">清空记录</button>
    </div>

    <div class="cover" id="recentread-list">
      <div class="article">
        <h2><span>正在读取</span></h2>
        <div class="block"><p>正在加载本地阅读记录...</p></div>
      </div>
    </div>
  </div>

<script>
(function(){
  function esc(str){
    return String(str || '').replace(/[&<>"']/g, function(s){
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[s];
    });
  }

  function readBookList(){
    if (!window.localStorage) return [];
    var ids = (localStorage.getItem('bookList') || '').split('#').filter(Boolean).reverse();
    var rows = [];
    for (var i = 0; i < ids.length; i++) {
      var raw = localStorage.getItem(ids[i]);
      if (!raw) continue;
      var parts = raw.split('#');
      if (parts.length < 6) continue;
      rows.push({
        bid: parts[0] || '',
        url: parts[1] || '',
        bookname: parts[2] || '',
        chaptername: parts[3] || '',
        author: parts[4] || '',
        readtime: parts[5] || '',
        cover: parts[6] || '/static/88ds/nocover.jpg'
      });
    }
    return rows;
  }

  function render(){
    var box = document.getElementById('recentread-list');
    if (!box) return;
    var rows = readBookList();
    if (!rows.length) {
      box.innerHTML = '<div class="article"><h2><span>暂无记录</span></h2><div class="block history-empty">当前浏览器还没有可展示的阅读记录。</div></div>';
      return;
    }
    var html = '';
    for (var i = 0; i < rows.length; i++) {
      var item = rows[i];
      html += '<div class="block">'
        + '<div class="block_img"><a href="' + esc(item.url) + '"><img src="' + esc(item.cover) + '" alt="' + esc(item.bookname) + '" loading="lazy" onerror="this.src=\'/static/88ds/nocover.jpg\';this.onerror=null;"></a></div>'
        + '<div class="block_txt">'
        + '<h2><a href="' + esc(item.url) + '">' + esc(item.bookname) + '</a></h2>'
        + '<p>作者：' + esc(item.author) + '</p>'
        + '<p>已读到：' + esc(item.chaptername) + '</p>'
        + '<p>最后阅读：' + esc(item.readtime) + '</p>'
        + '</div></div>';
    }
    box.innerHTML = html;
  }

  var clearBtn = document.getElementById('clearRecentRead');
  if (clearBtn) {
    clearBtn.onclick = function(){
      if (!window.localStorage) return;
      var ids = (localStorage.getItem('bookList') || '').split('#').filter(Boolean);
      for (var i = 0; i < ids.length; i++) {
        localStorage.removeItem(ids[i]);
      }
      localStorage.removeItem('bookList');
      render();
    };
  }

  render();
})();
</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
