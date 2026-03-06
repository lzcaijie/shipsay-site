<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
$home_url_safe = (isset($uri) && $uri) ? $uri : (!empty($site_url) ? rtrim($site_url, '/') . '/' : '/');
$site_name_safe = htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8');
$theme_dir_safe = htmlspecialchars($theme_dir, ENT_QUOTES, 'UTF-8');
$home_ld = [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => SITE_NAME,
    'url' => $home_url_safe,
    'description' => $seo_description,
];
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=html5;url=<?=htmlspecialchars($home_url_safe, ENT_QUOTES, 'UTF-8')?>">
<link rel="canonical" href="<?=htmlspecialchars($home_url_safe, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=htmlspecialchars($home_url_safe, ENT_QUOTES, 'UTF-8')?>">
<script type="application/ld+json"><?=json_encode($home_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="side_commend side_commend_width">
        <p class="title"><i class="fa fa-thumbs-o-up fa-lg">&nbsp;</i>大神小说</p>
        <ul class="flex">
            <?php if (is_array($commend)) { foreach ($commend as $k => $v) { if ($k < 6) {
                $info_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8');
                $img_url_attr = htmlspecialchars($v['img_url'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars($v['articlename'], ENT_QUOTES, 'UTF-8');
                $sort_html = htmlspecialchars($v['sortname_2'], ENT_QUOTES, 'UTF-8');
                $isfull_html = htmlspecialchars($v['isfull'], ENT_QUOTES, 'UTF-8');
                $intro_html = htmlspecialchars($v['intro_des'], ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars($v['author_url'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars($v['author'], ENT_QUOTES, 'UTF-8');
                $words_safe = intval($v['words_w']);
                $lastupdate_html = htmlspecialchars(Text::ss_lastupdate($v['lastupdate']), ENT_QUOTES, 'UTF-8');
            ?>
                <li>
                    <div class="img_span">
                        <a href="<?=$info_url_attr?>"><img src="<?=$img_url_attr?>" title="<?=$title_html?>" loading="lazy" onerror="this.src='/static/<?=$theme_dir_safe?>/nocover.jpg';this.onerror=null;"></a>
                        <span><?=$sort_html?> / <?=$isfull_html?></span>
                    </div>
                    <div class="w100">
                        <a href="<?=$info_url_attr?>"><h2><?=$title_html?></h2></a>
                        <p class="indent"><?=$intro_html?></p>
                        <div class="li_bottom">
                            <a href="<?=$author_url_attr?>"><i class="fa fa-user-circle-o">&nbsp;<?=$author_html?></i></a>
                            <div><em class="orange"><?=$words_safe?>万字</em><em class="blue"><?=$lastupdate_html?></em></div>
                        </div>
                    </div>
                </li>
            <?php } } } ?>
        </ul>
    </div>

    <aside>
        <p class="title"><i class="fa fa-fire fa-lg">&nbsp;</i>热门小说</p>
        <ul class="popular odd">
            <?php if (is_array($popular)): foreach ($popular as $k => $v): if ($k < 12):
                $info_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars($v['articlename'], ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars($v['author_url'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars($v['author'], ENT_QUOTES, 'UTF-8');
            ?>
                <li><a href="<?=$info_url_attr?>"><?=$title_html?></a><a class="gray" href="<?=$author_url_attr?>"><?=$author_html?></a></li>
            <?php endif; endforeach; endif; ?>
        </ul>
    </aside>
</div>

<div class="container">
    <div class="section flex">
        <?php for ($i = 1; $i <= 6; $i++) { $tmpvar = 'sort'.$i; $sort_url_attr = htmlspecialchars(Sort::ss_sorturl($i), ENT_QUOTES, 'UTF-8'); $sort_name_html = htmlspecialchars(Sort::ss_sortname($i,1), ENT_QUOTES, 'UTF-8'); ?>
        <div class="sortvisit"><a href="<?=$sort_url_attr?>"><?=$sort_name_html?></a><ul>
            <?php if (is_array($$tmpvar)): foreach ($$tmpvar as $k => $v):
                $info_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8');
                $img_url_attr = htmlspecialchars($v['img_url'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars($v['articlename'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars($v['author'], ENT_QUOTES, 'UTF-8');
                $intro_html = htmlspecialchars($v['intro_des'], ENT_QUOTES, 'UTF-8');
                $title_short_html = htmlspecialchars(mb_substr($v['articlename'], 0, 6), ENT_QUOTES, 'UTF-8');
            ?>
                <?php if ($k == 0): ?>
                    <div><a href="<?=$info_url_attr?>"><img class="lazy" src="<?=htmlspecialchars(Url::nocover_url(), ENT_QUOTES, 'UTF-8')?>" data-original="<?=$img_url_attr?>" title="<?=$title_html?>"></a><p><a href="<?=$info_url_attr?>"><?=$title_html?></a><i>&nbsp;/&nbsp;<?=$author_html?></i><br>&nbsp;&nbsp;&nbsp;&nbsp;<?=$intro_html?></p></div>
                <?php elseif ($k < 13): ?>
                    <li><a href="<?=$info_url_attr?>"><?=$title_short_html?></a><i>&nbsp;/ <?=$author_html?></i></li>
                <?php endif; ?>
            <?php endforeach; endif; ?>
        </ul></div>
        <?php } ?>
    </div>
</div>


<div class="container">
    <div class="lastupdate">
        <p class="title"><i class="fa fa-clock-o fa-lg">&nbsp;</i>最新章节</p>
        <ul class="odd">
            <?php if (is_array($lastupdate)) { foreach ($lastupdate as $v) {
                $sort_html = htmlspecialchars($v['sortname_2'], ENT_QUOTES, 'UTF-8');
                $info_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars($v['articlename'], ENT_QUOTES, 'UTF-8');
                $last_url_attr = htmlspecialchars($v['last_url'], ENT_QUOTES, 'UTF-8');
                $lastchapter_html = htmlspecialchars($v['lastchapter'], ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars($v['author_url'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars($v['author'], ENT_QUOTES, 'UTF-8');
                $date_html = htmlspecialchars(date('m-d',$v['lastupdate']), ENT_QUOTES, 'UTF-8');
            ?>
                <li><span>「<?=$sort_html?>」</span><a href="<?=$info_url_attr?>"><?=$title_html?></a><a class="gray" href="<?=$last_url_attr?>"><?=$lastchapter_html?></a><span><a class="gray" href="<?=$author_url_attr?>"><?=$author_html?></a>&nbsp;&nbsp;<?=$date_html?></span></li>
            <?php } } ?>
        </ul>
    </div>

    <aside>
        <p class="title"><i class="fa fa-pencil fa-lg">&nbsp;</i>最新小说</p>
        <ul class="popular odd">
            <?php if (is_array($postdate)) { foreach ($postdate as $v) {
                $info_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars($v['articlename'], ENT_QUOTES, 'UTF-8');
                $author_url_attr = htmlspecialchars($v['author_url'], ENT_QUOTES, 'UTF-8');
                $author_html = htmlspecialchars($v['author'], ENT_QUOTES, 'UTF-8');
            ?>
                <li><a href="<?=$info_url_attr?>"><?=$title_html?></a><a class="gray" href="<?=$author_url_attr?>"><?=$author_html?></a></li>
            <?php } } ?>
        </ul>
    </aside>
</div>

<div class="container">
    <div class="section link">
        <p class="title"><i class="fa fa-link">&nbsp;</i>友情链接</p>
        <?=$link_html?>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
