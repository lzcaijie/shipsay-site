<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
// 目录页链接兜底（避免写死 /index/ 破坏后台路由/伪静态配置）
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif (isset($articleid) && $articleid && class_exists('Url') && method_exists('Url', 'index_url')) {
    $index_url_safe = Url::index_url($articleid);
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="mobile-agent" content="format=html5;url=<?=$uri?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="canonical" href="<?=$uri?>" />
    
    <link rel="prefetch" href="<?=$index_url_safe?>" as="document" />
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Book",
        "name": "<?=$articlename?>",
        "author": {
            "@type": "Person",
            "name": "<?=$author?>"
        },
        "bookFormat": "EBook",
        "datePublished": "<?=$lastupdate?>",
        "numberOfPages": "<?=$chapters?>",
        "publisher": {
            "@type": "Organization",
            "name": "<?=SITE_NAME?>"
        },
        "image": "<?=$img_url?>",
        "description": "<?=$intro_p?>"
    }
    </script>
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "<?=SITE_NAME?>",
                "item": "<?=$site_url?>"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "<?=$sortname?>",
                "item": "<?=Sort::ss_sorturl($sortid)?>"
            },
            {
                "@type": "ListItem",
                "position": 3,
                "name": "<?=$articlename?>",
                "item": "<?=$info_url?>"
            }
        ]
    }
    </script>
    
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$articlename?>">
    <meta property="og:description" content="《<?=$articlename?>》<?=$intro_des?>">
    <meta property="og:novel:category" content="<?=$sortname?>">
    <meta property="og:novel:author" content="<?=$author?>">
    <meta property="og:novel:author_link" content="<?=$author_url?>">
    <meta property="og:novel:book_name" content="<?=$articlename?>">
    <meta property="og:novel:read_url" content="<?=$uri?>">
    <meta property="og:novel:url" content="<?=$uri?>">
    <meta property="og:novel:status" content="<?=$isfull?>">
    <meta property="og:novel:update_time" content="<?=$lastupdate?>">
    <meta property="og:novel:lastest_chapter_name" content="<?=$lastchapter?>">
    <meta property="og:novel:lastest_chapter_url" content="<?=$last_url?>">
    <meta property="og:image" content="<?=$img_url?>">
    <meta property="og:image:alt" content="<?=$articlename?>封面">
    
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
    <div class="container">
        <section class="section">
            <div class="novel_info_main">
                <img src="<?=$img_url?>" 
                     alt="<?=$articlename?>" 
                     loading="lazy"
                     width="150"
                     height="210"
                     style="background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); object-fit: cover;"
                     onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
                <div class="novel_info_title">
                    <h1><?=$articlename?></h1><i>作者：<a href="<?=$author_url?>"><?=$author?></a></i>
                    <p>
                        <span><?=$sortname?></span><span><?=$words_w?> 万字</span>
                        <span<?php if ($isfull != "连载") : ?> class="fullflag" <?php endif ?>><?=$isfull?></span>
                    </p>

                    <?php if (!empty($keywords)) : ?>
                        <p>关键字：<?=$keywords?></p>
                    <?php endif; ?>

                    <div class="flex to100">最新章节：<a href="<?=$last_url?>"><?=$lastchapter?></a><em class="s_gray"><?=$lastupdate_cn?></em></div>

                    <?php if ($is_langtail == 1 && !empty($langtailrows)) : ?>
                        <p>相关推荐：
                            <?php foreach ($langtailrows as $v) : ?>
                                <a href="<?=$v['info_url']?>"><?=$v['langname']?></a>&nbsp;
                            <?php endforeach ?>
                        </p>
                    <?php else: ?>
                        <p>相关推荐：暂无相关推荐</p>
                    <?php endif; ?>

                    <div class="flex">
                        <a class="l_btn" href="<?=$first_url?>"><i class="fa fa-file-text"> 开始阅读</i></a>
                        <a class="l_btn_0" href="<?=$fake_recentread?>" rel="nofollow"><i class="fa fa-tag"> 最近阅读</i></a>
                    </div>
                </div>
            </div>

            <ul class="flex ulcard">
                <li class="act"><a id="a_info" href="javascript:a_info();">作品信息</a></li>
                <li><a id="a_catalog" href="javascript:a_catalog();">目录<span>（<?=$chapters?>章）</span></a></li>
            </ul>

            <div id="info">
                <div class="intro">
                    <p><?=$intro_p?></p>
                </div>
                <div class="section chapter_list">
                    <div class="title jcc">《<?=$articlename?>》最新章节</div>
                    <ul>
                        <?php if ($lastarr != '') : ?><?php foreach ($lastarr as $k => $v) : ?>
                        <li><a href="<?=$v['cid_url']?>" title="<?=$articlename?> <?=$v['cname']?>"><?=$v['cname']?></a></li>
                        <?php endforeach ?><?php endif ?>
                    </ul>
                </div>
            </div>

            <div id="catalog">
                <div class="section chapter_list">
                    <div class="title jcc">
                        《<?=$articlename?>》正文
                        <span style="font-size: 14px; color: #666; margin-left: 10px;">（显示前50章）</span>
                    </div>
                    
                    <div style="text-align: center; margin: 15px 0 25px;">
                        <a href="<?=$index_url_safe?>" style="display: inline-block; padding: 10px 25px; background: linear-gradient(135deg, #4a90e2, #3a7bc8); color: white; text-decoration: none; border-radius: 4px; font-weight: bold; box-shadow: 0 2px 5px rgba(74, 144, 226, 0.3); transition: all 0.3s;">
                            <i class="fa fa-list-ol"></i> 查看完整目录（共<?=$chapters?>章）
                        </a>
                    </div>
                    
                    <ul id="ul_all_chapters">
                        <?php 
                        $displayedCount = 0;
                        $maxDisplay = 50;
                        
                        if ($chapterrows != '') : 
                            foreach ($chapterrows as $k => $v) : 
                                if ($displayedCount >= $maxDisplay) break;
                                
                                if ($v['chaptertype'] == 1) : 
                        ?>
                                    <li style="width:100%"><?=$v['cname']?></li>
                                <?php else : ?>
                                    <li><a href="<?=$v['cid_url']?>" title="<?=$articlename?> <?=$v['cname']?>"><?=$v['cname']?></a></li>
                                    <?php 
                                    $displayedCount++;
                                endif;
                            endforeach;
                        endif; 
                        ?>
                    </ul>
                    
                    <?php if ($chapters > 50): ?>
                    <div style="text-align: center; margin: 25px 0 15px; padding: 15px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 6px; border: 1px solid #dee2e6;">
                        <p style="margin: 0; color: #495057; font-size: 14px;">
                            当前显示前50章，共 <?=$chapters?> 章。
                            <a href="<?=$index_url_safe?>" style="color: #4a90e2; font-weight: bold; margin-left: 8px;">
                                查看完整目录
                            </a>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <i id="gotop" class="fa fa-sign-in" onclick="gotop();"></i><i id="gofooter" class="fa fa-sign-in" onclick="gofooter();"></i>
            </div>
        </section>
    </div>

<script>
(function(){
    var bp = document.createElement('script');
    bp.src = "//zz.bdstatic.com/linksubmit/push.js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>


    <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
