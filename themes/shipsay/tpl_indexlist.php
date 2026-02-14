<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <?php
    $pageTitle = '《' . $articlename . '》章节目录_' . SITE_NAME;
    if (isset($pid) && $pid > 1) {
        $pageTitle = '《' . $articlename . '》章节目录_第' . $pid . '页_' . SITE_NAME;
    }
    ?>
    <title><?=$pageTitle?></title>
    <meta name="keywords" content="<?=$articlename?>章节目录,<?=$articlename?>最新章节,<?=$author?>" />
    <meta name="description" content="《<?=$articlename?>》章节目录第<?=$pid?>页，作者：<?=$author?>，总章节：<?=$chapters?>章。" />
    
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="mobile-agent" content="format=html5;url=<?=$uri?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="canonical" href="<?=$uri?>" />
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "《<?=$articlename?>》章节目录",
        "description": "《<?=$articlename?>》完整章节目录，作者：<?=$author?>",
        "numberOfItems": "<?=$chapters?>",
        "itemListElement": [
            <?php if (isset($list_arr) && !empty($list_arr)): ?>
            <?php foreach ($list_arr as $index => $v): ?>
            {
                "@type": "ListItem",
                "position": <?=($pid-1)*50 + $index + 1?>,
                "name": "<?=$v['cname']?>",
                "url": "<?=$site_url . $v['cid_url']?>"
            }<?=($index < count($list_arr)-1) ? ',' : ''?>
            <?php endforeach; ?>
            <?php endif; ?>
        ]
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
            },
            {
                "@type": "ListItem",
                "position": 4,
                "name": "章节目录<?=($pid > 1) ? '第' . $pid . '页' : ''?>",
                "item": "<?=$uri?>"
            }
        ]
    }
    </script>
    
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?=$pageTitle?>">
    <meta property="og:description" content="《<?=$articlename?>》章节目录第<?=$pid?>页，作者：<?=$author?>，总章节：<?=$chapters?>章。">
    <meta property="og:url" content="<?=$uri?>">
    <meta property="og:image" content="<?=$img_url?>">
    <meta property="og:image:alt" content="<?=$articlename?>封面">
    
    <?php require_once 'tpl_header.php'; ?>
</head>
<body>
    <div class="container">
        <section class="section">
            <div class="novel-basic-info">
                <div class="novel-cover">
                    <img src="<?=$img_url?>" 
                         alt="<?=$articlename?>" 
                         loading="lazy"
                         width="100"
                         height="140"
                         style="background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); object-fit: cover;"
                         onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
                </div>
                <div class="novel-meta">
                    <h1><?=$articlename?></h1>
                    <p>
                        <span>作者：<a href="<?=$author_url?>"><?=$author?></a></span>
                        <span>分类：<a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></span>
                        <span>状态：<?=$isfull?></span>
                        <span>字数：<?=$words_w?>万</span>
                    </p>
                    <p>最新章节：<a href="<?=$last_url?>"><?=$lastchapter?></a> <em style="color: #999;"><?=$lastupdate_cn?></em></p>
                    <p>总章节：<?=$chapters?>章</p>
                </div>
            </div>

            <div class="catalog-header">
                <div>
                    <h2 style="margin: 0; color: #333;">《<?=$articlename?>》章节目录</h2>
                    <?php if (isset($pid) && $pid > 1): ?>
                    <div class="page-info" style="margin-top: 5px;">
                        当前第 <?=$pid?> 页，共 <?=ceil($chapters / 50)?> 页
                    </div>
                    <?php endif; ?>
                </div>
                <div>
                    <a href="<?=$first_url?>" style="display: inline-block; padding: 8px 15px; background: linear-gradient(135deg, #4a90e2, #3a7bc8); color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                        <i class="fa fa-book"></i> 开始阅读
                    </a>
                    <a href="<?=$info_url?>" class="back-link">
                        <i class="fa fa-arrow-left"></i> 返回详情
                    </a>
                </div>
            </div>

            <div class="chapter-list-container">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <?php if (isset($list_arr) && !empty($list_arr)): ?>
                        <?php foreach ($list_arr as $k => $v): ?>
                            <?php if (isset($v['chaptertype']) && $v['chaptertype'] == 1): ?>
                                <li class="volume-title"><?=$v['cname']?></li>
                            <?php else: ?>
                                <li class="chapter-item">
                                    <a href="<?=$v['cid_url']?>" title="<?=$articlename?> <?=$v['cname']?>">
                                        <?=$v['cname']?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li style="text-align: center; padding: 40px 20px; color: #999;">
                            暂无章节数据
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="index-container">
                    <?php
                    $currentPage = isset($pid) ? $pid : 1;
                    $totalChapters = $chapters;
                    $chaptersPerPage = 50;
                    $totalPages = ceil($totalChapters / $chaptersPerPage);
                    
                    if ($currentPage > 1):
                        $prevPage = $currentPage - 1;
                        $prevUrl = ($prevPage == 1) ? $index_url : $index_url . $prevPage . '/';
                    ?>
                        <a class="index-container-btn" href="<?=$prevUrl?>">上一页</a>
                    <?php else: ?>
                        <a class="index-container-btn disabled-btn" href="javascript:void(0);">没有了</a>
                    <?php endif; ?>
                    
                    <select id="indexselect" onchange="self.location.href=options[selectedIndex].value">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php
                            $startChapter = ($i - 1) * $chaptersPerPage + 1;
                            $endChapter = min($i * $chaptersPerPage, $totalChapters);
                            $pageUrl = ($i == 1) ? $index_url : $index_url . $i . '/';
                            ?>
                            <option value="<?=$pageUrl?>" <?=($i == $currentPage) ? 'selected="selected"' : ''?>>
                                <?=$startChapter?> - <?=$endChapter?>章
                            </option>
                        <?php endfor; ?>
                    </select>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <a class="index-container-btn" href="<?=$index_url . ($currentPage + 1) . '/'?>">下一页</a>
                    <?php else: ?>
                        <a class="index-container-btn disabled-btn" href="javascript:void(0);">没有了</a>
                    <?php endif; ?>
                </div>
                
                <div class="page-navigation">
                    <div class="page-info">
                        共 <?=$chapters?> 章，每页显示50章
                    </div>
                    <div>
                        <a href="<?=$first_url?>" style="display: inline-block; padding: 8px 20px; background: linear-gradient(135deg, #4a90e2, #3a7bc8); color: white; text-decoration: none; border-radius: 4px;">
                            <i class="fa fa-play-circle"></i> 从第一章开始阅读
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <?php require_once 'tpl_footer.php'; ?>
</body>
</html>