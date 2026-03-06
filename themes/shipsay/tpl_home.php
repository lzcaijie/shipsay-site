<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('home');
$home_url_safe = (isset($uri) && $uri) ? $uri : (!empty($site_url) ? rtrim($site_url, '/') . '/' : '/');
$rank_base = (isset($fake_top) && $fake_top)
    ? rtrim($fake_top, '/') . '/'
    : ('/' . ((isset($fake_rankstr) && $fake_rankstr) ? trim($fake_rankstr, '/') : 'rank') . '/');
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
<meta name="mobile-agent" content="format=html5;url=<?=$home_url_safe?>">
<link rel="canonical" href="<?=$home_url_safe?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=$home_url_safe?>">
<script type="application/ld+json"><?=json_encode($home_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <div class="side_commend side_commend_width">
        <p class="title"><i class="fa fa-thumbs-o-up fa-lg">&nbsp;</i>大神小说</p>
        <ul class="flex">
            <?php if (is_array($commend)) { foreach ($commend as $k => $v) { if ($k < 6) { ?>
                <li>
                    <div class="img_span">
                        <a href="<?=$v['info_url']?>"><img src="<?=$v['img_url']?>" title="<?=$v['articlename']?>" loading="lazy" onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;"></a>
                        <span><?=$v['sortname_2']?> / <?=$v['isfull']?></span>
                    </div>
                    <div class="w100">
                        <a href="<?=$v['info_url']?>"><h2><?=$v['articlename']?></h2></a>
                        <p class="indent"><?=$v['intro_des']?></p>
                        <div class="li_bottom">
                            <a href="<?=$v['author_url']?>"><i class="fa fa-user-circle-o">&nbsp;<?=$v['author']?></i></a>
                            <div><em class="orange"><?=$v['words_w']?>万字</em><em class="blue"><?=Text::ss_lastupdate($v['lastupdate'])?></em></div>
                        </div>
                    </div>
                </li>
            <?php } } } ?>
        </ul>
    </div>

    <aside>
        <p class="title"><i class="fa fa-fire fa-lg">&nbsp;</i>热门小说</p>
        <ul class="popular odd">
            <?php if (is_array($popular)): foreach ($popular as $k => $v): if ($k < 12): ?>
                <li><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><a class="gray" href="<?=$v['author_url']?>"><?=$v['author']?></a></li>
            <?php endif; endforeach; endif; ?>
        </ul>
    </aside>
</div>

<div class="container">
    <div class="section flex">
        <?php for ($i = 1; $i <= 6; $i++) { $tmpvar = 'sort'.$i; ?>
        <div class="sortvisit"><a href="<?=Sort::ss_sorturl($i)?>"><?=Sort::ss_sortname($i,1)?></a><ul>
            <?php if (is_array($$tmpvar)): foreach ($$tmpvar as $k => $v): ?>
                <?php if ($k == 0): ?>
                    <div><a href="<?=$v['info_url']?>"><img class="lazy" src="<?=Url::nocover_url()?>" data-original="<?=$v['img_url']?>" title="<?=$v['articlename']?>"></a><p><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><i>&nbsp;/&nbsp;<?=$v['author']?></i><br>&nbsp;&nbsp;&nbsp;&nbsp;<?=$v['intro_des']?></p></div>
                <?php elseif ($k < 13): ?>
                    <li><a href="<?=$v['info_url']?>"><?=mb_substr($v['articlename'], 0, 6)?></a><i>&nbsp;/ <?=$v['author']?></i></li>
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
            <?php if (is_array($lastupdate)) { foreach ($lastupdate as $v) { ?>
                <li><span>「<?=$v['sortname_2']?>」</span><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><a class="gray" href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a><span><a class="gray" href="<?=$v['author_url']?>"><?=$v['author']?></a>&nbsp;&nbsp;<?=date('m-d',$v['lastupdate'])?></span></li>
            <?php } } ?>
        </ul>
    </div>

    <aside>
        <p class="title"><i class="fa fa-pencil fa-lg">&nbsp;</i>最新小说</p>
        <ul class="popular odd">
            <?php if (is_array($postdate)) { foreach ($postdate as $v) { ?>
                <li><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><a class="gray" href="<?=$v['author_url']?>"><?=$v['author']?></a></li>
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
