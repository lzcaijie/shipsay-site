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
$author_url_raw = isset($uri) && $uri ? (string)$uri : '';
$author_url_attr = htmlspecialchars($author_url_raw, ENT_QUOTES, 'UTF-8');
$author_name_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$author_count_int = intval($author_count);
$nocover_url_attr = htmlspecialchars(Url::nocover_url(), ENT_QUOTES, 'UTF-8');
$author_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => !empty($site_url) ? $site_url : '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $author . '作品大全', 'item' => $author_url_raw],
    ],
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($author_url_raw !== ''): ?>
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$author_url_attr?>">
<link rel="canonical" href="<?=$author_url_attr?>">
<meta property="og:url" content="<?=$author_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<script type="application/ld+json"><?=json_encode($author_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
	<div class="side_commend side_commend_width">
		<div class="bread_crumbs"><a href="<?=htmlspecialchars((!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/'), ENT_QUOTES, 'UTF-8')?>">首页</a> &gt; <span>作者作品</span></div>
		<p class="title"><i class="fa fa-user-circle-o">&nbsp;</i>作者「<?=$author_name_html?>」共有 <?=$author_count_int?> 部作品</p>
		<ul class="flex">
			<?php if(is_array($res)): ?><?php foreach($res as $k => $v): ?>	
			<li class="searchresult">
				<?php
				$info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
				$img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8');
				$title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
				$sort_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8');
				$status_html = htmlspecialchars((string)$v['isfull'], ENT_QUOTES, 'UTF-8');
				$author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8');
				$intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8');
				$last_url_attr = htmlspecialchars((string)$v['last_url'], ENT_QUOTES, 'UTF-8');
				$lastchapter_html = htmlspecialchars((string)$v['lastchapter'], ENT_QUOTES, 'UTF-8');
				$words_html = intval($v['words_w']);
				?>
				<div class="img_span">
					<a href="<?=$info_url_attr?>"><img class="lazy" src="<?=$nocover_url_attr?>" data-original="<?=$img_url_attr?>" title="<?=$title_html?>" loading="lazy" /><span<?php if($v['isfull'] == '全本'): ?> class="full"<?php endif ?>><?=$sort_html?> / <?=$status_html?></span></a>
				</div>
				<div>
					<a href="<?=$info_url_attr?>"><h3><?=$title_html?></h3></a>
					<p><i class="fa fa-user-circle-o">&nbsp;</i><?=$author_html?>&nbsp;&nbsp;<span class="s_gray"><?=$words_html?> 万字&nbsp;&nbsp;<?=htmlspecialchars((string)Text::ss_lastupdate($v['lastupdate']), ENT_QUOTES, 'UTF-8')?></span></p>
					<p class="searchresult_p"><?=$intro_html?></p>
					<p><a href="<?=$last_url_attr?>"><?=$lastchapter_html?></a></p>
				</div>
			</li>
			<?php endforeach ?><?php endif ?>
		</ul>
	</div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
