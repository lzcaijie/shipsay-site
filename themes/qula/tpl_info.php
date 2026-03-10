<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_qh')) {
    function ss_qh($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}

$site_home_url_raw = '/';
$site_home_url_attr = ss_qh($site_home_url_raw);
$sort_url_raw = isset($sortid) ? (string)Sort::ss_sorturl($sortid) : '';
$sort_url_attr = ss_qh($sort_url_raw);
$info_url_raw = isset($info_url) ? (string)$info_url : '';
$info_url_attr = ss_qh($info_url_raw);
$index_url_raw = isset($index_url) ? (string)$index_url : '';
$index_url_attr = ss_qh($index_url_raw);
$author_url_raw = isset($author_url) ? (string)$author_url : '';
$author_url_attr = ss_qh($author_url_raw);
$uri_raw = isset($uri) ? (string)$uri : $info_url_raw;
$uri_attr = ss_qh($uri_raw);
$img_url_attr = ss_qh(isset($img_url) ? $img_url : '');
$first_url_attr = ss_qh(isset($first_url) ? $first_url : '');
$last_url_attr = ss_qh(isset($last_url) ? $last_url : '');
$intro_html = isset($intro_des) ? (string)$intro_des : '';
$latest_rows = (isset($lastarr) && is_array($lastarr)) ? $lastarr : [];
$preview_rows = [];
if (isset($preview_chapters) && is_array($preview_chapters) && !empty($preview_chapters)) {
    $preview_rows = $preview_chapters;
} elseif (isset($chapterrows) && is_array($chapterrows)) {
    $preview_rows = array_slice($chapterrows, 0, 50);
}
$related_rows = (isset($langtailrows) && is_array($langtailrows)) ? $langtailrows : [];

require_once __ROOT_DIR__ . '/shipsay/seo.php';
require_once __ROOT_DIR__ . '/shipsay/include/neighbor.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
$popular_rows = (isset($postdate) && is_array($postdate)) ? $postdate : [];
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title><?=ss_qh($seo_title)?></title>
    <meta name="keywords" content="<?=ss_qh($seo_keywords)?>">
    <meta name="description" content="<?=ss_qh($seo_description)?>">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="mobile-agent" content="format=html5;url=<?=$uri_attr?>">
    <?php if ($uri_raw !== ''): ?>
    <link rel="canonical" href="<?=$uri_attr?>">
    <?php endif; ?>
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=ss_qh($articlename)?>">
    <meta property="og:description" content="<?=ss_qh('《'.$articlename.'》'.$seo_description)?>">
    <meta property="og:image" content="<?=$img_url_attr?>">
    <meta property="og:novel:category" content="<?=ss_qh($sortname)?>">
    <meta property="og:novel:author" content="<?=ss_qh($author)?>">
    <meta property="og:novel:author_link" content="<?=$author_url_attr?>">
    <meta property="og:novel:book_name" content="<?=ss_qh($articlename)?>">
    <meta property="og:novel:read_url" content="<?=$uri_attr?>">
    <meta property="og:novel:url" content="<?=$info_url_attr?>">
    <meta property="og:novel:status" content="<?=ss_qh($isfull)?>">
    <meta property="og:novel:update_time" content="<?=ss_qh($lastupdate)?>">
    <meta property="og:novel:lastest_chapter_name" content="<?=ss_qh($lastchapter)?>">
    <meta property="og:novel:lastest_chapter_url" content="<?=$last_url_attr?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="row row-detail">
        <div class="layout layout-col1">
            <h2 class="layout-tit"><a href="<?=$site_home_url_attr?>"><?=SITE_NAME?></a> &gt; <?php if($sort_url_raw !== ''): ?><a href="<?=$sort_url_attr?>"><?=ss_qh($sortname)?></a> &gt; <?php endif; ?><?=ss_qh($articlename)?></h2>
            <div class="detail-box">
                <div class="imgbox">
                    <img alt="<?=ss_qh($articlename)?>" src="<?=$img_url_attr?>" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;" />
                    <i class="flag xs-hidden"></i>
                </div>
                <div class="info">
                    <div class="top">
                        <h1><?=ss_qh($articlename)?></h1>
                        <div class="fix">
                            <p>作&nbsp;&nbsp;者：<?php if($author_url_raw !== ''): ?><a href="<?=$author_url_attr?>"><?=ss_qh($author)?></a><?php else: ?><?=ss_qh($author)?><?php endif; ?></p>
                            <p>类&nbsp;&nbsp;别：<?=ss_qh($sortname)?></p>
                            <p>状&nbsp;&nbsp;态：<?=ss_qh($isfull)?></p>
                            <p>最后更新：<?=ss_qh(((isset($lastupdate_cn) && $lastupdate_cn) ? $lastupdate_cn : $lastupdate))?></p>
                            <p>字&nbsp;&nbsp;数：<span><?=ss_qh($words_w)?> 万</span></p>
                            <p>最&nbsp;&nbsp;新：<?php if($last_url_attr !== ''): ?><a href="<?=$last_url_attr?>"><?=ss_qh($lastchapter)?></a><?php else: ?><?=ss_qh($lastchapter)?><?php endif; ?></p>
                            <p class="opt">
                                <span class="xs-hidden">动&nbsp;&nbsp;作：</span>
                                <?php if($first_url_attr !== ''): ?><a href="<?=$first_url_attr?>" class="xs-show btn-read">开始阅读</a><?php endif; ?>
                                <?php if($index_url_raw !== ''): ?><a href="<?=$index_url_attr?>" class="btn-tobtm">章节目录</a><?php endif; ?>
                                <a rel="nofollow" href="#footer" class="btn-tobtm">直达底部</a>
                            </p>
                        </div>
                    </div>
                    <div class="desc xs-hidden"><?=$intro_html?></div>
                </div>
                <div class="m-desc xs-show"><strong>简介：</strong><?=$intro_html?></div>
            </div>
        </div>
    </div>

    <div class="row row-section">
        <div class="layout layout-col1">
            <h2 class="layout-tit">《<?=ss_qh($articlename)?>》最新12章</h2>
            <div class="section-box">
                <ul class="section-list fix">
                    <?php foreach($latest_rows as $v): ?>
                    <li><a href="<?=ss_qh($v['cid_url'])?>"><?=ss_qh($v['cname'])?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="row row-section">
        <div class="layout layout-col1">
            <h2 class="layout-tit">《<?=ss_qh($articlename)?>》顺序 1-50章</h2>
            <div class="section-box">
                <ul class="section-list fix">
                    <?php foreach($preview_rows as $v): ?>
                        <?php if(isset($v['chaptertype']) && (int)$v['chaptertype'] === 1): ?>
                        <li><strong><?=ss_qh($v['cname'])?></strong></li>
                        <?php else: ?>
                        <li><a href="<?=ss_qh($v['cid_url'])?>"><?=ss_qh($v['cname'])?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php if($index_url_raw !== ''): ?>
            <div class="qula-view-all">
                <a href="<?=$index_url_attr?>" class="qula-view-all-btn">查看完整目录</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row row-section">
        <div class="layout layout-col1">
            <h2 class="layout-tit">相关小说推荐</h2>
            <div class="qula-link-list">
                <?php if(!empty($related_rows)): ?>
                    <?php foreach($related_rows as $v): ?>
                    <a href="<?=ss_qh($v['info_url'])?>" title="<?=ss_qh($v['langname'])?>"><?=ss_qh($v['langname'])?></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="nav-disabled">暂无相关推荐</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row row-section">
        <div class="layout layout-col1">
            <h2 class="layout-tit">人气小说推荐</h2>
            <div class="section-box">
                <ul class="section-list fix">
                    <?php if(!empty($popular_rows)): ?>
                        <?php foreach($popular_rows as $v): ?>
                        <li><a href="<?=ss_qh($v['info_url'])?>"><?=ss_qh($v['articlename'])?></a></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>暂无人气推荐</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
