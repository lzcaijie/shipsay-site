<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif (isset($articleid) && $articleid && class_exists('Url') && method_exists('Url', 'index_url')) {
    $index_url_safe = Url::index_url($articleid);
}
$last_rows = [];
if (!empty($lastarr) && is_array($lastarr)) {
    $last_rows = $lastarr;
} elseif (!empty($lastchapter_arr) && is_array($lastchapter_arr)) {
    $last_rows = array_slice($lastchapter_arr, 0, 12);
} elseif (!empty($preview_chapters) && is_array($preview_chapters)) {
    $last_rows = array_slice($preview_chapters, 0, 12);
}
$info_url_safe = (isset($uri) && $uri) ? $uri : ((isset($info_url) && $info_url) ? $info_url : '');
$site_home_url_safe = !empty($site_url) ? rtrim($site_url, '/') . '/' : '/';
$article_title_html = htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$author_html = htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8');
$sort_url_attr = htmlspecialchars(Sort::ss_sorturl($sortid), ENT_QUOTES, 'UTF-8');
$sortname_html = htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8');
$status_html = htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8');
$words_html = htmlspecialchars((string)$words_w, ENT_QUOTES, 'UTF-8');
$last_url_attr = htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8');
$lastchapter_html = htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8');
$lastupdate_cn_html = htmlspecialchars((string)$lastupdate_cn, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8');
$index_url_attr = htmlspecialchars((string)$index_url_safe, ENT_QUOTES, 'UTF-8');
$info_url_attr = htmlspecialchars((string)$info_url_safe, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$theme_dir_safe = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$home_url_attr = htmlspecialchars((string)$site_home_url_safe, ENT_QUOTES, 'UTF-8');
$intro_html = !empty($intro) ? $intro : (!empty($intro_p) ? $intro_p : $intro_des);
$intro_plain = trim(strip_tags((string)$intro_html));
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $articlename . '最新章节目录_' . $author . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $articlename . ',' . $author . ',' . SITE_NAME . ',最新章节,全文阅读';
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = '《' . $articlename . '》作者：' . $author . '，简介：' . $intro_plain;
}
$info_breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_safe],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => Sort::ss_sorturl($sortid)],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => $info_url_safe !== '' ? $info_url_safe : $info_url],
    ],
];
$info_book_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'Book',
    'name' => $articlename,
    'author' => ['@type' => 'Person', 'name' => $author],
    'bookFormat' => 'EBook',
    'datePublished' => (string)$lastupdate,
    'numberOfPages' => (string)$chapters,
    'publisher' => ['@type' => 'Organization', 'name' => SITE_NAME],
    'image' => $img_url,
    'description' => $intro_plain,
    'url' => $info_url_safe !== '' ? $info_url_safe : $info_url,
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
<link rel="canonical" href="<?=$info_url_attr?>">
<script type="application/ld+json"><?=json_encode($info_book_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<script type="application/ld+json"><?=json_encode($info_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<meta property="og:type" content="novel">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$info_url_attr?>">
<meta property="og:image" content="<?=$img_url_attr?>">
<meta property="og:image:alt" content="<?=$article_title_html?>封面">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="<?=$home_url_attr?>">首页</a> &gt; <a href="<?=$sort_url_attr?>"><?=$sortname_html?></a> &gt; <span><?=$article_title_html?></span>
        </div>

        <div class="novel_info_main">
            <img src="<?=$img_url_attr?>" alt="<?=$article_title_html?>" loading="lazy" onerror="this.src='/static/<?=$theme_dir_safe?>/nocover.jpg';this.onerror=null;" />
            <div class="novel_info_title">
                <h1><?=$article_title_html?></h1><i>作者：<a href="<?=$author_url_attr?>"><?=$author_html?></a></i>
                <p>
                    <span><?=$sortname_html?></span><span><?=$words_html?> 万字</span>
                    <span<?php if ($isfull != '连载') : ?> class="fullflag"<?php endif; ?>><?=$status_html?></span>
                </p>
                <div class="flex to100">最新章节：<a href="<?=$last_url_attr?>"><?=$lastchapter_html?></a><em class="s_gray"><?=$lastupdate_cn_html?></em></div>
                <?php if (isset($is_langtail) && $is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)) : ?>
                    <p>相关推荐：
                        <?php foreach ($langtailrows as $v) :
                            $langtail_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
                            $langname_html = htmlspecialchars((string)$v['langname'], ENT_QUOTES, 'UTF-8');
                        ?>
                            <a href="<?=$langtail_url_attr?>"><?=$langname_html?></a>&nbsp;
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
                <div class="flex">
                    <a class="l_btn" href="<?=$first_url_attr?>"><i class="fa fa-file-text"></i> 开始阅读</a>
                    <a class="l_btn_0" href="<?=$index_url_attr?>"><i class="fa fa-list"></i> 查看目录</a>
                </div>
            </div>
        </div>

        <div id="info">
            <div class="intro">
                <?=$intro_html?>
            </div>
            <?php if (!empty($last_rows)): ?>
            <div class="section chapter_list">
                <div class="title jcc">《<?=$article_title_html?>》最新章节</div>
                <ul>
                    <?php foreach ($last_rows as $v):
                        $cid_url_attr = htmlspecialchars((string)$v['cid_url'], ENT_QUOTES, 'UTF-8');
                        $cname_html = htmlspecialchars((string)$v['cname'], ENT_QUOTES, 'UTF-8');
                    ?>
                        <li><a href="<?=$cid_url_attr?>" title="<?=$article_title_html?> <?=$cname_html?>"><?=$cname_html?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
