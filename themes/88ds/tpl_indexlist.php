<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_e')) { function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
$pid = (isset($pid) && (int)$pid>0) ? (int)$pid : 1;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  $pageTitle = '《' . $articlename . '》章节目录_' . SITE_NAME;
  if (isset($pid) && $pid > 1) {
      $pageTitle = '《' . $articlename . '》章节目录_第' . $pid . '页_' . SITE_NAME;
  }
  ?>
  <title><?=$pageTitle?></title>
  <meta name="keywords" content="<?=$articlename?>章节目录,<?=$articlename?>最新章节,<?=$author?>" />
  <meta name="description" content="《<?=$articlename?>》章节目录第<?=$pid?>页，作者：<?=$author?>，总章节：<?=$chapters?>章。" />

  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$uri?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="canonical" href="<?=$uri?>" />

  <script type="application/ld+json"><?php
$itemlist_elements = [];
if (!empty($list_arr)) {
  foreach ($list_arr as $i => $v) {
    $itemlist_elements[] = [
      "@type"=>"ListItem",
      "position"=>($pid-1)*50 + $i + 1,
      "name"=>(string)($v['cname'] ?? ''),
      "url"=>(string)($site_url . ($v['cid_url'] ?? '')),
    ];
  }
}
echo json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"ItemList",
  "name"=>"《{$articlename}》章节目录",
  "description"=>"《{$articlename}》完整章节目录，作者：{$author}",
  "numberOfItems"=>(string)$chapters,
  "itemListElement"=>$itemlist_elements
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
?></script>

  <script type="application/ld+json"><?=
json_encode([
  "@context"=>"https://schema.org",
  "@type"=>"BreadcrumbList",
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>(string)SITE_NAME,"item"=>(string)$site_url],
    ["@type"=>"ListItem","position"=>2,"name"=>(string)$sortname,"item"=>(string)Sort::ss_sorturl($sortid)],
    ["@type"=>"ListItem","position"=>3,"name"=>(string)$articlename,"item"=>(string)$info_url],
    ["@type"=>"ListItem","position"=>4,"name"=>"章节目录".($pid>1 ? "第{$pid}页" : ""),"item"=>(string)$uri],
  ]
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>

  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

  <body>
    <div class="header">
      <div class="back">
        <a href="<?=$info_url?>">返回详情</a>
      </div>
      <h1><a href="<?=$info_url?>"><?=$articlename?></a></h1>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
		<a href="/" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>

	<div class="cover">
      <div class="read">
        <h3><?=$articlename?> - 章节目录<?php if (isset($pid) && $pid > 1): ?>（第<?=$pid?>页）<?php endif; ?></h3>
        <span>共<?=$chapters?>章，当前显示<?=($pid-1)*50+1?>-<?=min($pid*50, $chapters)?>章</span>
      </div>
      <ul class="chapter">
	    <?php foreach($list_arr as $v): ?>
        <li><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></li>
		<?php endforeach ?>
      </ul>
    </div>
	<div class="index-container"><?=$htmltitle?></div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>