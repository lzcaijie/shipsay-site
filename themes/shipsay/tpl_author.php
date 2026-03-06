<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('author');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $author . '作品大全_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $author . ',' . SITE_NAME . ',作品集,小说';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = '作者' . $author . '作品列表与最新章节，尽在' . SITE_NAME . '。';
}
$author_url_safe = isset($uri) && $uri ? $uri : '';
$author_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => !empty($site_url) ? $site_url : '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $author . '作品大全', 'item' => $author_url_safe],
    ],
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($author_url_safe !== ''): ?>
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$author_url_safe?>">
<link rel="canonical" href="<?=$author_url_safe?>">
<meta property="og:url" content="<?=$author_url_safe?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<script type="application/ld+json"><?=json_encode($author_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
	<div class="side_commend" style="width:100%;">
		<p class="title"><i class="fa fa-user-circle-o">&nbsp;</i> "<?=$author?>" 共有 "<?=$author_count?>" 部作品：</p>
		<ul class="flex">
			<?php if(is_array($res)): ?><?php foreach($res as $k => $v): ?>	
			<li class="searchresult">
				<div class="img_span">
					<a href="<?=$v['info_url']?>"><img class="lazy" src="<?=Url::nocover_url()?>" data-original="<?=$v['img_url']?>" title="<?=$v['articlename']?>" loading="lazy" /><span<?php if($v['isfull'] == '全本'): ?> class="full"<?php endif ?>><?=$v['sortname_2']?> / <?=$v['isfull']?></span></a>
				</div>
				<div>
					<a href="<?=$v['info_url']?>"><h3><?=$v['articlename']?></h3></a>
					<p><i class="fa fa-user-circle-o">&nbsp;</i><?=$v['author']?>&nbsp;&nbsp;<span class="s_gray"><?=$v['words_w']?> 万字&nbsp;&nbsp;<?=Text::ss_lastupdate($v['lastupdate'])?></span></p>
					<p class="searchresult_p"><?=$v['intro_des']?></p>
					<p><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></p>
				</div>
			</li>
			<?php endforeach ?><?php endif ?>
		</ul>
	</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
