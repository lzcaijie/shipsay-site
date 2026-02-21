<?php if (!defined('__ROOT_DIR__')) exit;?>
<?php
if (!function_exists('ss_e')) { function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
?>
<!DOCTYPE html>
<html lang='zh'>
<head>
  <meta charset="UTF-8">
  <title><?=$articlename?>(<?=$author?>)最新章节免费阅读-<?=$articlename?><?=$author?>完整版全文免费在线阅读-<?=SITE_NAME?></title>
  <meta name="keywords" content="<?=$articlename?>,<?=$articlename?><?=$author?>,<?=$articlename?>TXT全文免费在线阅读" />
  <meta name="description" content="<?=$intro_p?>！<?=$articlename?>是<?=$author?>大神的最新小说，<?=SITE_NAME?>小说网提供<?=$articlename?>最新章节全文免费阅读，<?=$articlename?>完整版全文免费在线阅读，<?=$articlename?>全文免费阅读，<?=$articlename?>无弹窗全文免费阅读！请关注<?=SITE_NAME?>吧，本站最新最快更新<?=$articlename?>的最新章节。" />

  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$uri?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="canonical" href="<?=$uri?>" />

  <link rel="prefetch" href="<?=$index_url?>" as="document" />

  <script type="application/ld+json"><?=
json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"Book",
  "name"=>(string)$articlename,
  "author"=>["@type"=>"Person","name"=>(string)$author],
  "bookFormat"=>"EBook",
  "datePublished"=>(string)$lastupdate,
  "numberOfPages"=>(string)$chapters,
  "publisher"=>["@type"=>"Organization","name"=>(string)SITE_NAME],
  "image"=>(string)$img_url,
  "description"=>(string)$intro_p
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>

  <script type="application/ld+json"><?=
json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"BreadcrumbList",
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>(string)SITE_NAME,"item"=>(string)$site_url],
    ["@type"=>"ListItem","position"=>2,"name"=>(string)$sortname,"item"=>(string)Sort::ss_sorturl($sortid)],
    ["@type"=>"ListItem","position"=>3,"name"=>(string)$articlename,"item"=>(string)$info_url],
  ]
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>

  <meta property="og:type" content="novel"/>
  <meta property="og:title" content="<?=$articlename?>"/>
  <meta property="og:description" content="<?=$intro_des?>"/>
  <meta property="og:image" content="<?=$img_url?>"/>
  <meta property="og:novel:category" content="<?=$sortname?>"/>
  <meta property="og:novel:author" content="<?=$author?>"/>
  <meta property="og:novel:book_name" content="<?=$articlename?>"/>
  <meta property="og:novel:read_url" content="https://<?=SITE_URL?><?=$uri?>"/>
  <meta property="og:url" content="https://<?=SITE_URL?><?=$uri?>"/>
  <meta property="og:novel:status" content="<?=$isfull?>"/>
  <meta property="og:novel:author_link" content="https://<?=SITE_URL?><?=$author_url?>">
  <meta property="og:novel:update_time" content='<?=$lastupdate?>' />
  <meta property="og:novel:latest_chapter_name" content="<?=$lastchapter?>"/>
  <meta property="og:novel:latest_chapter_url" content="https://<?=SITE_URL?><?=$last_url?>"/>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

  <body>
    <div class="header">
      <div class="back">
        <a href="javascript:history.go(-1);">返回</a>
      </div>
      <h1><?=$articlename?></h1>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
        <a href="/" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>
    <?php require_once 'tpl_search_form.php'; ?>
	<div id="content">
      <div class="cover">
        <div class="block">
          <div class="block_img">
            <img src="<?=$img_url?>" 
                 alt="<?=$articlename?>"
                 loading="lazy"
                 width="120"
                 height="160"
                 style="background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); object-fit: cover;"
                 onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
          </div>
		  <div class="block_txt">
			<h2 id="bookname"><a href="<?=$uri?>"><?=$articlename?></a></h2>
			<a href="<?=$uri?>"></a>
			<p></p>
			<p>作者：<?=$author?></p>
			<p>分类：<?=$sortname?></p>
			<p>状态：<?=$isfull?></p>
			<p>更新：<?=$lastupdate?></p>
			<p>最新：<a href="<?=$last_url?>"><?=$lastchapter?></a></p>
		  </div>
	    </div>
	    <div class="clear"></div>
        <div id="notice" style="display: none;">
          <input type="button" onclick="location.href= '<?=$first_url?>'" value="开始阅读"><input type="button" onclick="location.href= '<?=$index_url?>'" value="查看目录">
	    </div>
	    <div class="ablum_read" id="chapterlist">
		  <span class="left"><a href="<?=$first_url?>">开始阅读</a></span>
          <span><a href="javascript:;" onclick="addbookcase('<?=$articleid?>','<?=$articlename?>','0','0')" rel="nofollow">加入书架</a></span>    
	    </div>                
	    <div class="intro"><?=$articlename?>小说简介</div>
	    <div class="intro_info"><?=$intro_p?><p>相关小说：</p><?php foreach ($langtailrows as $v) : ?>
			<a href="<?= $v['info_url'] ?>"><?= $v['langname'] ?></a>&nbsp;
			<?php endforeach ?></div>
	    <div class="intro"><?=$articlename?>最新章节 更新时间：<?=$lastupdate?></div>
	    <ul class="chapter" id="chapterlist2" style="">	
	      <?php foreach($lastarr as $k => $v): ?>
	      <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=$v['cid_url']?>"><?=$v['cname'] ?></a></li>
	      <?php endforeach ?>
	      <li class="more"><a href="<?=$index_url?>">更多章节>></a></li>
        </ul>
      </div>
    </div>
<script>
(function(){
    var bp = document.createElement('script');
    bp.src = "//zz.bdstatic.com/linksubmit/push.js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>