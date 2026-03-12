<?php if (!defined('__ROOT_DIR__')) exit;?>
<?php
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$sort_url_raw = isset($sortid) ? (string)Sort::ss_sorturl($sortid) : '';
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$info_url_attr = htmlspecialchars($info_url_raw, ENT_QUOTES, 'UTF-8');
$indexlist_url_raw = isset($uri) && $uri ? (string)$uri : ((isset($index_url) && $index_url) ? (string)$index_url : '');
$indexlist_url_attr = htmlspecialchars($indexlist_url_raw, ENT_QUOTES, 'UTF-8');
$author_url_raw = isset($author_url) ? (string)$author_url : '';
$author_url_attr = htmlspecialchars($author_url_raw, ENT_QUOTES, 'UTF-8');
$article_title = isset($articlename) ? (string)$articlename : '';
$article_title_html = htmlspecialchars($article_title, ENT_QUOTES, 'UTF-8');
$author_name = isset($author) ? (string)$author : '';
$author_name_html = htmlspecialchars($author_name, ENT_QUOTES, 'UTF-8');
$sort_name = isset($sortname) ? (string)$sortname : '';
$sort_name_html = htmlspecialchars($sort_name, ENT_QUOTES, 'UTF-8');
$intro_text = isset($intro_des) ? (string)$intro_des : '';
$intro_text_html = htmlspecialchars($intro_text, ENT_QUOTES, 'UTF-8');
$words_w_html = htmlspecialchars((string)($words_w ?? ''), ENT_QUOTES, 'UTF-8');
$allvisit_html = htmlspecialchars((string)($allvisit ?? ''), ENT_QUOTES, 'UTF-8');
$isfull_html = htmlspecialchars((string)($isfull ?? ''), ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)($img_url ?? ''), ENT_QUOTES, 'UTF-8');
$first_url_raw = isset($first_url) ? (string)$first_url : '';
$first_url_attr = htmlspecialchars($first_url_raw, ENT_QUOTES, 'UTF-8');
$last_url_raw = isset($last_url) ? (string)$last_url : '';
$last_url_attr = htmlspecialchars($last_url_raw, ENT_QUOTES, 'UTF-8');
$lastchapter_html = htmlspecialchars((string)($lastchapter ?? ''), ENT_QUOTES, 'UTF-8');
$lastupdate_text = isset($lastupdate_cn) && $lastupdate_cn ? (string)$lastupdate_cn : (string)($lastupdate ?? '');
$lastupdate_text_html = htmlspecialchars($lastupdate_text, ENT_QUOTES, 'UTF-8');
$current_page = isset($pid) ? max(1, (int)$pid) : 1;
$chapters_safe = isset($chapters) ? max(0, (int)$chapters) : 0;
$breadcrumb_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $sort_name, 'item' => $sort_url_raw !== '' ? $sort_url_raw : $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $article_title, 'item' => $info_url_raw !== '' ? $info_url_raw : $site_home_url_raw],
        ['@type' => 'ListItem', 'position' => 4, 'name' => '目录' . ($current_page > 1 ? '第' . $current_page . '页' : ''), 'item' => $indexlist_url_raw !== '' ? $indexlist_url_raw : $site_home_url_raw],
    ],
];
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('indexlist');
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = '《' . $article_title . '》章节目录' . ($current_page > 1 ? '第' . $current_page . '页_' : '_') . $author_name . '_' . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = $article_title . ',章节目录,' . $author_name . ',' . $sort_name . ',' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = '《' . $article_title . '》章节目录' . ($current_page > 1 ? '第' . $current_page . '页，' : '，') . '作者：' . $author_name . '，共' . $chapters_safe . '章。';
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <?php if ($indexlist_url_raw !== ''): ?>
    <link rel="canonical" href="<?=$indexlist_url_attr?>">
    <meta name="mobile-agent" content="format=html5;url=<?=$indexlist_url_attr?>">
    <meta property="og:url" content="<?=$indexlist_url_attr?>">
    <?php endif; ?>
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <script type="application/ld+json"><?=json_encode($breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
    <div class="content">
        <ol class="breadcrumb">
            <li><a href="<?=$site_home_url_attr?>" title="<?=SITE_NAME?>">首页</a></li>
            <li><?php if ($sort_url_raw !== ''): ?><a href="<?=$sort_url_attr?>"><?=$sort_name_html?></a><?php else: ?><?=$sort_name_html?><?php endif; ?></li>
            <li><?php if ($info_url_raw !== ''): ?><a href="<?=$info_url_attr?>"><?=$article_title_html?></a><?php else: ?><?=$article_title_html?><?php endif; ?></li>
            <li class="active">目录<?php if ($current_page > 1): ?> 第<?=$current_page?>页<?php endif; ?></li>
        </ol>

        <div class="book pt10">
            <div class="bookcover hidden-xs">
                <img class="thumbnail" alt="<?=$article_title_html?>" src="<?=$img_url_attr?>" title="<?=$article_title_html?>" width="140" height="180" />
            </div>
            <div class="bookinfo">
                <h1 class="booktitle"><?=$article_title_html?></h1>
                <p class="booktag">
                    <?php if ($author_url_raw !== ''): ?><a class="red" href="<?=$author_url_attr?>" title="作者：<?=$author_name_html?>"><?=$author_name_html?></a><?php else: ?><span class="red"><?=$author_name_html?></span><?php endif; ?>
                    <span class="blue"><?=$words_w_html?>万字</span>
                    <span class="blue"><?=$allvisit_html?>人读过</span>
                    <span class="red"><?=$isfull_html?></span>
                </p>
                <p>最新章节：<?php if ($last_url_raw !== ''): ?><a class="bookchapter" href="<?=$last_url_attr?>" title="<?=$lastchapter_html?>"><?=$lastchapter_html?></a><?php else: ?><span class="bookchapter"><?=$lastchapter_html?></span><?php endif; ?></p>
                <p class="booktime">更新时间：<?=$lastupdate_text_html?></p>
                <p class="bookintro"><?=$intro_text_html?></p>
                <div class="bookmore">
                    <?php if ($first_url_raw !== ''): ?><a class="btn btn-info" href="<?=$first_url_attr?>">开始阅读</a><?php else: ?><a class="btn btn-info" href="javascript:void(0);" aria-disabled="true">开始阅读</a><?php endif; ?>
                    <?php if ($info_url_raw !== ''): ?><a class="btn btn-info" href="<?=$info_url_attr?>">返回详情</a><?php else: ?><a class="btn btn-info" href="javascript:void(0);" aria-disabled="true">返回详情</a><?php endif; ?>
                </div>
                <?php if (!empty($langtailrows) && is_array($langtailrows) && !empty($is_langtail) && (int)$is_langtail === 1): ?>
                    <p>相关推荐：
                        <?php foreach ($langtailrows as $v): ?>
                            <a href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)($v['langname'] ?? ''), ENT_QUOTES, 'UTF-8')?></a>&nbsp;
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>

        <dl class="book chapterlist">
            <h2>《<?=$article_title_html?>》章节目录<?php if ($chapters_safe > 0): ?>（共<?=$chapters_safe?>章<?php if ($current_page > 1): ?>，第<?=$current_page?>页<?php endif; ?>）<?php endif; ?></h2>

            <?php if(!empty($list_arr) && is_array($list_arr)): ?>
                <?php foreach($list_arr as $k => $v): ?>
                    <dd><a href="<?=htmlspecialchars((string)($v['cid_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>" title="<?=$article_title_html?> <?=htmlspecialchars((string)($v['cname'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)($v['cname'] ?? ''), ENT_QUOTES, 'UTF-8')?></a></dd>
                <?php endforeach; ?>
            <?php else: ?>
                <dd style="width:100%;text-align:center;color:#999;">暂无章节数据</dd>
            <?php endif; ?>

            <div class="clear"></div>

            <div class="index-container" style="margin-top:10px;">
                <?=$htmltitle?>
            </div>
        </dl>

        <div class="book mt10 pt10 tuijian">
            <?=$sort_name_html?>相关阅读：<?php include __ROOT_DIR__ . '/shipsay/include/neighbor.php'; foreach($neighbor as $v):?>
            <a href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>" title="<?=$article_title_html?>"><?=htmlspecialchars((string)($v['articlename'] ?? ''), ENT_QUOTES, 'UTF-8')?></a>
            <?php endforeach ?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
