<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('category');
$category_name_safe = isset($sortname) && $sortname !== '' ? $sortname : '全部小说';
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $category_name_safe . (isset($page) && intval($page) > 1 ? '_第'.intval($page).'页' : '') . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = $category_name_safe . ',小说,' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = $category_name_safe . '小说列表，尽在' . SITE_NAME . '。';
}
$category_url_safe = (isset($uri) && $uri) ? $uri : Sort::ss_sorturl($sortid);
$allbooks_url_safe = !empty($allbooks_url) ? $allbooks_url : '/sort/';
$category_name_html = htmlspecialchars($category_name_safe, ENT_QUOTES, 'UTF-8');
$category_url_attr = htmlspecialchars($category_url_safe, ENT_QUOTES, 'UTF-8');
$allbooks_url_attr = htmlspecialchars($allbooks_url_safe, ENT_QUOTES, 'UTF-8');
$full_url_attr = htmlspecialchars((string)$full_url, ENT_QUOTES, 'UTF-8');
$category_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => !empty($site_url) ? $site_url : '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $category_name_safe, 'item' => $category_url_safe],
    ],
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=$category_url_attr?>">
<link rel="canonical" href="<?=$category_url_attr?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$category_url_attr?>">
<script type="application/ld+json"><?=json_encode($category_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="store">
    <div class="store_left">
        <i id="store_menu" class="fa fa-bars fa-3x" onclick="javascript: store_menu();" title="筛选菜单"></i>
        <div class="side_commend">
            <div class="title"><?=$category_name_html?></div>
            <div id="after_menu">
                <div><a href="#"></a><a href="javascript:" onclick="document.location='<?=$full_url_attr?>'"><label><input type="checkbox"<?php if($fullflag): ?> checked="checked"<?php endif ?> /> 只看全本</label></a></div>
                <div><a href="<?=$allbooks_url_attr?>" <?php if($sortid == -1): ?> class="onselect"<?php endif?>>全部分类</a>
                    <?php foreach($sortcategory as $k => $v): ?>
                        <?php $sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8'); $sort_name_html = htmlspecialchars((string)$v['sortname'], ENT_QUOTES, 'UTF-8'); ?>
                        <a href="<?=$sort_url_attr?>"<?php if($sortid == $k): ?> class="onselect"<?php endif?>><?=$sort_name_html?></a>
                    <?php endforeach ?>
                </div>
            </div>
            <ul class="flex">
                <?php if(is_array($retarr)): foreach($retarr as $k => $v): ?>
                <?php
                $info_url_attr = htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8');
                $img_url_attr = htmlspecialchars((string)$v['img_url'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8');
                $sort_html = htmlspecialchars((string)$v['sortname_2'], ENT_QUOTES, 'UTF-8');
                $status_html = htmlspecialchars((string)$v['isfull'], ENT_QUOTES, 'UTF-8');
                $intro_html = htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars((string)$v['author_url'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8');
                $words_w_safe = intval($v['words_w']);
                ?>
                <li>
                    <div class="img_span"><a href="<?=$info_url_attr?>"><img class="lazy" src="<?=htmlspecialchars(Url::nocover_url(), ENT_QUOTES, 'UTF-8')?>" data-original="<?=$img_url_attr?>" title="<?=$title_html?>" loading="lazy" /><span<?php if($v['isfull'] != '连载'): ?> class="full"<?php endif ?>><?=$sort_html?> / <?=$status_html?></span></a></div>
                    <div class="w100">
                        <a href="<?=$info_url_attr?>"><h2><?=$title_html?></h2></a>
                        <p class="indent"><?=$intro_html?></p>
                        <div class="li_bottom">
                            <a href="<?=$author_url_attr?>"><i class="fa fa-user-circle-o">&nbsp;<?=$author_html?></i></a>
                            <div>
                                <em class="orange"><?=$words_w_safe?>万字</em><em class="blue"><?=Text::ss_lastupdate($v['lastupdate'])?></em>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; endif ?>
            </ul>

            <?php if (!empty($allpage) && $allpage > 1): ?>
            <div class="category-pagination">
                <div class="pages pagination-pc-wrap">
                    <ul class="pagination-pc"><?=$jump_html?></ul>
                </div>
                <div class="index-container pagination-mobile"><?=$jump_html_wap?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="store_right">
        <ul><li><a href="<?=$allbooks_url_attr?>" <?php if($sortid == -1): ?> class="onselect"<?php endif?>>全部分类</a></li></ul>
        <ul>
            <?php foreach($sortcategory as $k => $v): ?>
                <?php $sort_url_attr = htmlspecialchars((string)$v['sorturl'], ENT_QUOTES, 'UTF-8'); $sort_name_html = htmlspecialchars((string)$v['sortname'], ENT_QUOTES, 'UTF-8'); ?>
                <li><a href="<?=$sort_url_attr?>"<?php if($sortid == $k): ?> class="onselect"<?php endif?>><?=$sort_name_html?></a></li>
            <?php endforeach ?>
        </ul>
        <ul>
            <li onclick="javascript: document.location='<?=$full_url_attr?>'">
                <label><input type="checkbox"<?php if($fullflag): ?> checked="checked"<?php endif ?> /> 只看全本</label>
            </li>
        </ul>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
