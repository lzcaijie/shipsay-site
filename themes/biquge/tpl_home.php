<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__ . '/shipsay/seo.php';
list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('home');
$home_url_raw = (isset($uri) && $uri) ? (string)$uri : (!empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/');
$home_url_attr = htmlspecialchars($home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$e = function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};
$home_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => SITE_NAME,
    'url' => $home_url_raw,
    'description' => $seo_description,
];
?>
<title><?=$e($seo_title)?></title>
<meta name="keywords" content="<?=$e($seo_keywords)?>">
<meta name="description" content="<?=$e($seo_description)?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="mobile-agent" content="format=html5;url=<?=$home_url_attr?>">
<link rel="canonical" href="<?=$home_url_attr?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$e($seo_title)?>">
<meta property="og:description" content="<?=$e($seo_description)?>">
<meta property="og:url" content="<?=$home_url_attr?>">
<script type="application/ld+json"><?=json_encode($home_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="biquge-home-page">
<div class="container flex flex-wrap">
    <div class="border3 commend flex flex-between">
        <?php if (!empty($commend) && is_array($commend)): ?>
            <?php foreach ($commend as $k => $v): ?><?php if ($k < 4): ?>
                <div class="outdiv">
                    <a href="<?=$e($v['info_url'] ?? '')?>"><img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$e($v['img_url'] ?? '')?>" alt="<?=$e($v['articlename'] ?? '')?>" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;"></a>
                    <div>
                        <div class="flex flex-between commend-title"><a href="<?=$e($v['info_url'] ?? '')?>"><h3><?=$e($v['articlename'] ?? '')?></h3></a> <span><?=$e($v['author'] ?? '')?></span></div>
                        <div class="intro indent"><?=$e($v['intro_des'] ?? '')?></div>
                    </div>
                </div>
            <?php endif; ?><?php endforeach; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无推荐内容</div>
        <?php endif; ?>
    </div>

    <div class="border3 popular">
        <p>经典推荐</p>
        <?php if (!empty($popular) && is_array($popular)): ?>
            <?php foreach ($popular as $k => $v): ?><?php if ($k < 8): ?>
                <div class="list-out">
                    <span>[<?=$e($v['sortname_2'] ?? '')?>] <a href="<?=$e($v['info_url'] ?? '')?>"><?=$e($v['articlename'] ?? '')?></a></span>
                    <span class="gray"><?=$e($v['author'] ?? '')?></span>
                </div>
            <?php endif; ?><?php endforeach; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无热门推荐</div>
        <?php endif; ?>
    </div>
</div>

<div class="container sort-section border3 flex flex-between flex-wrap">
    <?php for ($i = 1; $i <= 3; $i++): ?>
        <?php $tmpvar = 'sort' . $i; $list = isset($$tmpvar) && is_array($$tmpvar) ? $$tmpvar : []; ?>
        <div<?=($i === 2 ? ' class="sort-middle"' : '')?>>
            <div class="sort-title">
                <a href="<?=$e(Sort::ss_sorturl($i))?>"><?=$e(Sort::ss_sortname($i, 1))?></a>
            </div>
            <div class="sort-bottom">
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $k => $v): ?><?php if ($k == 0): ?>
                    <div class="sortdiv flex">
                        <a href="<?=$e($v['info_url'] ?? '')?>"><img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$e($v['img_url'] ?? '')?>" alt="<?=$e($v['articlename'] ?? '')?>" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;"></a>
                        <div>
                            <a href="<?=$e($v['info_url'] ?? '')?>"><h4><?=$e($v['articlename'] ?? '')?></h4></a>
                            <p><?=$e($v['intro_des'] ?? '')?></p>
                        </div>
                    </div>
                    <?php endif; ?><?php endforeach; ?>
                    <div class="sort-section-more flex flex-wrap">
                        <?php foreach ($list as $k => $v): ?><?php if ($k > 0): ?>
                        <div class="sortlist"><a href="<?=$e($v['info_url'] ?? '')?>"><?=$e($v['articlename'] ?? '')?></a><span class="s_gray">/<?=$e($v['author'] ?? '')?></span></div>
                        <?php endif; ?><?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="biquge-page-empty">暂无内容</div>
                <?php endif; ?>
            </div>
        </div>
    <?php endfor; ?>
</div>

<div class="container sort-section border3 flex flex-between flex-wrap">
    <?php for ($i = 4; $i <= 6; $i++): ?>
        <?php $tmpvar = 'sort' . $i; $list = isset($$tmpvar) && is_array($$tmpvar) ? $$tmpvar : []; ?>
        <div<?=($i === 5 ? ' class="sort-middle"' : '')?>>
            <div class="sort-title">
                <a href="<?=$e(Sort::ss_sorturl($i))?>"><?=$e(Sort::ss_sortname($i, 1))?></a>
            </div>
            <div class="sort-bottom">
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $k => $v): ?><?php if ($k == 0): ?>
                    <div class="sortdiv flex">
                        <a href="<?=$e($v['info_url'] ?? '')?>"><img class="lazy" src="/static/<?=$theme_dir_attr?>/nocover.jpg" data-original="<?=$e($v['img_url'] ?? '')?>" alt="<?=$e($v['articlename'] ?? '')?>" onerror="this.src='/static/<?=$theme_dir_attr?>/nocover.jpg';this.onerror=null;"></a>
                        <div>
                            <a href="<?=$e($v['info_url'] ?? '')?>"><h4><?=$e($v['articlename'] ?? '')?></h4></a>
                            <p><?=$e($v['intro_des'] ?? '')?></p>
                        </div>
                    </div>
                    <?php endif; ?><?php endforeach; ?>
                    <div class="sort-section-more flex flex-wrap">
                        <?php foreach ($list as $k => $v): ?><?php if ($k > 0): ?>
                        <div class="sortlist"><a href="<?=$e($v['info_url'] ?? '')?>"><?=$e($v['articlename'] ?? '')?></a><span class="s_gray">/<?=$e($v['author'] ?? '')?></span></div>
                        <?php endif; ?><?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="biquge-page-empty">暂无内容</div>
                <?php endif; ?>
            </div>
        </div>
    <?php endfor; ?>
</div>

<?php
$home_lastupdate_limit = isset($home_lastupdate_num) ? (int)$home_lastupdate_num : (isset($category_per_page) ? (int)$category_per_page : 20);
if ($home_lastupdate_limit <= 0) $home_lastupdate_limit = 20;
if ($home_lastupdate_limit > 100) $home_lastupdate_limit = 100;

$home_postdate_limit = isset($home_postdate_num) ? (int)$home_postdate_num : (isset($category_per_page) ? (int)$category_per_page : 20);
if ($home_postdate_limit <= 0) $home_postdate_limit = 20;
if ($home_postdate_limit > 100) $home_postdate_limit = 100;
?>

<div class="container flex flex-wrap section-bottom">
    <div class="border3-1 lastupdate">
        <p>最后更新</p>
        <?php if (!empty($lastupdate) && is_array($lastupdate)): ?>
            <?php foreach ($lastupdate as $k => $v): ?>
                <?php if ($k >= $home_lastupdate_limit) break; ?>
                <div class="list-out">
                    <span class="flex w80">
                        <em>[<?=$e($v['sortname'] ?? '')?>]</em>
                        <em><a href="<?=$e($v['info_url'] ?? '')?>"><?=$e($v['articlename'] ?? '')?></a></em>
                        <em><a href="<?=$e($v['last_url'] ?? '')?>"><?=$e($v['lastchapter'] ?? '')?></a></em>
                    </span>
                    <span class="gray dispc"><?=$e($v['author'] ?? '')?>&nbsp;&nbsp;<?=$e(!empty($v['lastupdate']) ? date('m-d', (int)$v['lastupdate']) : '')?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无更新内容</div>
        <?php endif; ?>
    </div>

    <div class="border3-1 popular">
        <p>最新入库</p>
        <?php if (!empty($postdate) && is_array($postdate)): ?>
            <?php foreach ($postdate as $k => $v): ?>
                <?php if ($k >= $home_postdate_limit) break; ?>
                <div class="list-out">
                    <span>[<?=$e($v['sortname_2'] ?? '')?>] <a href="<?=$e($v['info_url'] ?? '')?>"><?=$e($v['articlename'] ?? '')?></a></span>
                    <span class="gray"><?=$e($v['author'] ?? '')?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="biquge-page-empty">暂无入库内容</div>
        <?php endif; ?>
    </div>
</div>

<div class="container flex">
    <div class="link">友情链接:<?=$link_html?></div>
</div>
</div>
<script>$('nav a:first-child').addClass('orange');</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
