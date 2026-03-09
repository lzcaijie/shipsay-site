<?php if (!defined('__ROOT_DIR__')) exit;?>
<?php
if (!function_exists('ss_e')) { function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$info_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($info_url) && $info_url) ? (string)$info_url : '');
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$sort_url_raw = (string)Sort::ss_sorturl($sortid);
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$index_url_attr = htmlspecialchars((string)$index_url, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$status_html = htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8');
$lastchapter_html = htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8');
$last_url_attr = htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8');
$lastupdate_html = htmlspecialchars((string)$lastupdate, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
  $info_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
      ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => $sort_url_raw],
      ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url_raw],
    ],
  ];
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">

  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$info_url_attr?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="canonical" href="<?=$info_url_attr?>" />
  <?php if ($index_url_attr !== ''): ?><link rel="prefetch" href="<?=$index_url_attr?>" as="document" /><?php endif; ?>

  <script type="application/ld+json"><?=
json_encode([
  '@context'=>'https://schema.org',
  '@type'=>'Book',
  'name'=>(string)$articlename,
  'author'=>['@type'=>'Person','name'=>(string)$author],
  'bookFormat'=>'EBook',
  'datePublished'=>(string)$lastupdate,
  'numberOfPages'=>(string)$chapters,
  'publisher'=>['@type'=>'Organization','name'=>(string)SITE_NAME],
  'image'=>(string)$img_url,
  'description'=>(string)$intro_p
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>
  <script type="application/ld+json"><?=json_encode($info_breadcrumb_ld, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>

  <meta property="og:type" content="novel"/>
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>"/>
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>"/>
  <meta property="og:image" content="<?=$img_url_attr?>"/>
  <meta property="og:url" content="<?=$info_url_attr?>"/>
  <meta property="og:novel:category" content="<?=$sortname_html?>"/>
  <meta property="og:novel:author" content="<?=$author_html?>"/>
  <meta property="og:novel:book_name" content="<?=$article_title_html?>"/>
  <meta property="og:novel:read_url" content="<?=$info_url_attr?>"/>
  <meta property="og:novel:status" content="<?=$status_html?>"/>
  <meta property="og:novel:author_link" content="<?=$author_url_attr?>">
  <meta property="og:novel:update_time" content='<?=$lastupdate_html?>' />
  <meta property="og:novel:latest_chapter_name" content="<?=$lastchapter_html?>"/>
  <meta property="og:novel:latest_chapter_url" content="<?=$last_url_attr?>"/>
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<body>
    <?php
    $page_title = $articlename;
    $page_back_url = $sort_url_raw !== '' ? $sort_url_raw : $site_home_url_raw;
    require __THEME_DIR__ . '/tpl_page_top.php';
    ?>
    <div id="content">
      <div class="cover">
        <div class="block">
          <div class="block_img">
            <img src="<?=$img_url_attr?>"
                 alt="<?=$article_title_html?>"
                 loading="lazy"
                 width="120"
                 height="160"
                 style="background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); object-fit: cover;"
                 onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg'; this.onerror=null;">
          </div>
		  <div class="block_txt">
			<h2 id="bookname"><a href="<?=$info_url_attr?>"><?=$article_title_html?></a></h2>
			<p>作者：<a href="<?=$author_url_attr?>"><?=$author_html?></a></p>
			<p>分类：<a href="<?=$sort_url_attr?>"><?=$sortname_html?></a></p>
			<p>状态：<?=$status_html?></p>
			<p>更新：<?=$lastupdate_html?></p>
			<p>最新：<a href="<?=$last_url_attr?>"><?=$lastchapter_html?></a></p>
		  </div>
	    </div>
	    <div class="clear"></div>
	    <div class="ablum_read" id="chapterlist">
		  <span class="left"><a href="<?=$first_url_attr?>">开始阅读</a></span>
          <span><a href="<?=$index_url_attr?>">查看目录</a></span>
          <span><a href="<?=$site_home_url_attr?>">返回首页</a></span>
	    </div>
	    <div class="intro"><?=$article_title_html?> 小说简介</div>
	    <div class="intro_info">
          <?=$intro_p?>
          <?php if (isset($is_langtail) && $is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)): ?>
          <p>相关推荐：</p>
          <?php foreach ($langtailrows as $v) : ?>
			<a href="<?= htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8') ?></a>&nbsp;
		  <?php endforeach ?>
          <?php endif; ?>
        </div>
	    <div class="intro"><?=$article_title_html?> 最新章节 更新时间：<?=$lastupdate_html?></div>
	    <ul class="chapter" id="chapterlist2" style="">	
	      <?php foreach($lastarr as $k => $v): ?>
          <?php $cid_url_attr = htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8'); $cname_html = htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8'); ?>
	      <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=$cid_url_attr?>"><?=$cname_html?></a></li>
	      <?php endforeach ?>
	      <li class="more"><a href="<?=$index_url_attr?>">更多章节&gt;&gt;</a></li>
        </ul>
        <?php if (!empty($preview_chapters) && is_array($preview_chapters)): ?>
        <div class="intro"><?=$article_title_html?> 前50章顺序预览</div>
        <ul class="chapter" id="chapterlist_preview">
          <?php foreach ($preview_chapters as $k => $v): ?>
          <?php $preview_url_attr = htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8'); $preview_name_html = htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8'); ?>
          <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=$preview_url_attr?>"><?=$preview_name_html?></a></li>
          <?php endforeach; ?>
          <li class="more"><a href="<?=$index_url_attr?>">查看完整目录&gt;&gt;</a></li>
        </ul>
        <?php endif; ?>
      </div>
    </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
