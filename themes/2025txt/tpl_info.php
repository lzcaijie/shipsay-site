<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$index_url_raw = isset($index_url) && $index_url ? (string)$index_url : '';
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
?>

<?php
if (!function_exists('ss_e')) {
	function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
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

    <?php
    $chaptersPerPage = 50;
    $displayedCount = 0;
    $maxDisplay = 50;
    $totalChapters = $chapters;
    $showViewAllLink = $totalChapters > $chaptersPerPage;
    ?>

    <?php if ($showViewAllLink && $index_url_raw !== ''): ?>
    <link rel="prefetch" href="<?=$index_url_attr?>" as="document" />
    <?php endif; ?>

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
    <meta property="og:image:width" content="150">
    <meta property="og:image:height" content="210">

    <link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20221207" />
    <link rel="stylesheet" href="/static/<?=$theme_dir?>/css/detail.css?v=20251207" />
</head>

<body class="page-detail">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
    <?php require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php'; ?>

    <div class="detail-container">
        <div class="detail-book">
            <div class="detail-book-cover">
                <img src="<?=$img_url?>"
                     alt="<?=ss_e($articlename)?>"
                     width="150"
                     height="200"
                     loading="lazy"
                     onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
            </div>

            <div class="detail-book-info">
                <h1 class="detail-book-title"><?=$articlename?></h1>

                <div class="detail-book-meta">
                    <span><a href="<?=$author_url?>"><?=$author?></a></span>
                    <span><?=$sortname?></span>
                    <span><?=$words_w?>万字</span>
                    <span><?=$allvisit?>人气</span>
                    <span><?=$lastupdate_cn?></span>
                    <span><?=$isfull?></span>
                </div>

                <div class="detail-book-status">
                    最新章节：<a href="<?=$last_url?>"><?=$lastchapter?></a>
                </div>

                <div class="detail-book-buttons">
                    <a href="<?=$first_url?>" class="detail-book-btn start">开始阅读</a>
                    <?php if ($index_url_raw !== ""): ?>
                    <a href="<?=$index_url_attr?>" class="detail-book-btn directory">章节目录</a>
                    <?php else: ?>
                    <span class="detail-book-btn directory disabled" aria-disabled="true">章节目录</span>
                    <?php endif; ?>
                </div>

                <div class="detail-book-intro">
                    <strong>小说简介：</strong><?=$intro_des?>
                </div>
            </div>
        </div>

        <div class="detail-chapters">
            <div class="detail-chapters-header">
                <h2 class="detail-chapters-title">最新章节</h2>
                <div class="detail-chapters-count">更新时间：<?=$lastupdate_cn?></div>
            </div>

            <div class="detail-chapters-list">
                <?php if (isset($lastarr) && !empty($lastarr)) : ?>
                <?php foreach ($lastarr as $k => $v) : ?>
                <div class="detail-chapter-item">
                    <a href="<?=$v['cid_url']?>"><?=$v['cname']?></a>
                </div>
                <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>

        <div class="detail-chapters">
            <div class="detail-chapters-header">
                <h2 class="detail-chapters-title">章节目录</h2>
                <div class="detail-chapters-count">共<?=$chapters?>章</div>
            </div>

            <?php if ($showViewAllLink && $index_url_raw !== ""): ?>
            <div class="detail-view-all">
                <a href="<?=$index_url_attr?>" class="detail-view-all-btn">
                    查看完整目录（共<?=$chapters?>章）
                </a>
            </div>
            <?php endif; ?>

            <div class="detail-chapters-list">
                <?php
                if (isset($chapterrows) && !empty($chapterrows)) :
                    foreach ($chapterrows as $k => $v) :
                        if ($displayedCount >= $maxDisplay) break;

                        if ($v['chaptertype'] == 1) :
                ?>
                            <div class="detail-chapter-item chapter-title">
                                <?=$v['cname']?>
                            </div>
                        <?php else : ?>
                            <div class="detail-chapter-item">
                                <a href="<?=$v['cid_url']?>"><?=$v['cname']?></a>
                            </div>
                            <?php
                            $displayedCount++;
                        endif;
                    endforeach;
                endif;
                ?>
            </div>

            <?php if ($showViewAllLink && $index_url_raw !== ""): ?>
            <div class="detail-view-all">
                <a href="<?=$index_url_attr?>" class="detail-view-all-btn">
                    查看完整目录（共<?=$chapters?>章）
                </a>
            </div>
            <?php endif; ?>
        </div>

<?php if ($is_langtail == 1 && !empty($langtailrows)) : ?>
<div class="detail-view-all">
    <div class="langtail-title">相关推荐</div>
    <div class="langtail-box">
        <?php foreach ($langtailrows as $v) : ?>
            <a href="<?=$v['info_url']?>"><?=$v['langname']?></a>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<div class="detail-view-all">
    <div class="langtail-title">相关推荐</div>
    <div class="langtail-box">
        <span>暂无相关推荐</span>
    </div>
</div>
<?php endif; ?>





        <?php if (isset($neighbor) && !empty($neighbor)): ?>
        <div class="detail-recommend">
            <div class="detail-recommend-header">
                <h2 class="detail-recommend-title">推荐阅读</h2>
            </div>

            <div class="detail-recommend-grid">
                <?php
                $neighborCount = 0;
                foreach($neighbor as $k => $v):
                    if ($neighborCount >= 6) break;
                    if (!isset($v['info_url']) || !isset($v['articlename'])) continue;
                ?>
                <div class="detail-recommend-item">
                    <div class="detail-recommend-cover">
                        <img src="<?=isset($v['img_url']) ? $v['img_url'] : '/static/'.$theme_dir.'/nocover.jpg'?>"
                             alt="<?=htmlspecialchars($v['articlename'])?>"
                             width="100"
                             height="140"
                             loading="lazy"
                             onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
                        <span><?=isset($v['sortname_2']) ? $v['sortname_2'] : ''?> / <?=isset($v['isfull']) ? $v['isfull'] : ''?></span>
                    </div>

                    <div class="detail-recommend-content">
                        <div>
                            <h3 class="detail-recommend-name">
                                <a href="<?=$v['info_url']?>" title="<?=htmlspecialchars($v['articlename'])?>">
                                    <?=$v['articlename']?>
                                </a>
                            </h3>
                            <div class="detail-recommend-author"><?=isset($v['author']) ? $v['author'] : ''?></div>
                            <div class="detail-recommend-intro"><?=isset($v['intro_des']) ? $v['intro_des'] : ''?></div>
                        </div>

                        <div class="detail-recommend-meta">
                            <span><?=isset($v['words_w']) ? $v['words_w'] : ''?>万字</span>
                            <span><?=isset($v['lastupdate']) ? Text::ss_lastupdate($v['lastupdate']) : ''?></span>
                        </div>
                    </div>
                </div>
                <?php
                    $neighborCount++;
                endforeach;
                ?>
            </div>
        </div>
        <?php endif; ?>
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
