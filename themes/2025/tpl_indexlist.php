<?php if (!defined('__ROOT_DIR__')) exit; require_once __ROOT_DIR__ . '/shipsay/configs/report.ini.php';?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<?php
$pageTitle = '《' . $articlename . '》章节目录_' . SITE_NAME;
if (isset($pid) && $pid > 1) {
    $pageTitle = '《' . $articlename . '》章节目录_第' . $pid . '页_' . SITE_NAME;
}

// 计算章节范围
$chaptersPerPage = 50;
$currentPage = isset($pid) ? $pid : 1;
$startChapter = ($currentPage - 1) * $chaptersPerPage + 1;
$endChapter = min($currentPage * $chaptersPerPage, $chapters);
$totalPages = ceil($chapters / $chaptersPerPage);

// 分页链接生成函数
function getPageUrl($articleid, $page = 1) {
    if ($page == 1) {
        return "/index/{$articleid}/";
    } else {
        return "/index/{$articleid}/{$page}/";
    }
}

// 当前页面URL
$currentUrl = getPageUrl($articleid, $currentPage);
?>
<title><?=$pageTitle?></title>
<meta name="keywords" content="<?= $articlename ?>章节目录,<?= $articlename ?>最新章节,<?= $author ?>" />
<meta name="description" content="《<?= $articlename ?>》章节目录第<?=$currentPage?>页，作者：<?=$author?>，总章节：<?=$chapters?>章，当前显示第<?=$startChapter?>-<?=$endChapter?>章。" />

<link rel="canonical" href="<?=$site_url?><?=$currentUrl?>">

<?php if ($currentPage > 1): ?>
<link rel="prev" href="<?=$site_url?><?=getPageUrl($articleid, $currentPage-1)?>" />
<?php endif; ?>

<?php if ($currentPage < $totalPages): ?>
<link rel="next" href="<?=$site_url?><?=getPageUrl($articleid, $currentPage+1)?>" />
<?php endif; ?>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">
<meta name="MobileOptimized" content="320">
<meta name="mobile-web-app-capable" content="yes">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "《<?=$articlename?>》章节目录",
  "description": "《<?=$articlename?>》小说章节目录第<?=$currentPage?>页",
  "numberOfItems": "<?=count($list_arr)?>",
  "itemListElement": [
    <?php if (isset($list_arr) && !empty($list_arr)): ?>
    <?php foreach ($list_arr as $index => $v): ?>
    {
      "@type": "ListItem",
      "position": <?=$startChapter + $index?>,
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
      "name": "章节目录<?=($currentPage > 1) ? '第' . $currentPage . '页' : ''?>",
      "item": "<?=$site_url?><?=$currentUrl?>"
    }
  ]
}
</script>

<meta property="og:type" content="article">
<meta property="og:title" content="<?=$pageTitle?>">
<meta property="og:description" content="《<?=$articlename?>》章节目录第<?=$currentPage?>页，作者：<?=$author?>，总章节：<?=$chapters?>章。">
<meta property="og:url" content="<?=$site_url?><?=$currentUrl?>">
<meta property="og:image" content="<?=$img_url?>">
<meta property="og:image:alt" content="<?=$articlename?>封面">

<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20221207" />
<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/chapter.css?v=<?=time()?>" />
</head>
<body>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>

<div class="container visible-xs">
<div class="header-m">
<a class="header-m-left" href="<?=$info_url?>">
  <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2585">
    <path d="M358.997 512l311.168-311.168a42.667 42.667 0 1 0-60.33-60.33L268.5 481.834a42.667 42.667 0 0 0 0 60.33L609.835 883.5a42.667 42.667 0 0 0 60.33-60.331L358.997 512z" p-id="2586"></path>
  </svg>
</a>
<div class="header-m-center">章节目录<?=($currentPage > 1) ? ' 第'.$currentPage.'页' : ''?></div>
<a class="header-m-right" href="/">
  <svg class="icon" viewBox="0 0 1025 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2094">
    <path d="M938.977859 1024c-100.292785 0-198.718416 0-298.210992 0 0-113.362855 0-226.458974 0-340.355301-85.889034 0-170.17765 0-255.799948 0 0 112.829383 0 225.658765 0 339.821829-100.292785 0-199.251889 0-299.277937 0 0-4.534514 0-8.802292 0-13.07007 0-176.579318 0-352.891899 0.266736-529.471216 0-5.868195 3.46757-13.870279 8.002084-17.604585 138.436051-111.228966 277.138838-222.191196 416.108362-333.153425 0.533472-0.533472 1.600417-0.800208 3.200834-1.333681 45.345142 36.276114 91.223756 72.818963 136.835634 109.361813 91.490492 73.352436 182.980985 146.704871 275.004949 219.523834 10.402709 8.26882 14.403751 16.53764 14.403751 29.874446-0.533472 173.911956-0.266736 347.557176-0.266736 521.469133C938.977859 1013.864027 938.977859 1018.932014 938.977859 1024zM85.422245 85.889034c57.348268 0 113.096119 0 169.910914 0 0 38.410003 0 76.820005 0 119.497786 87.222714-69.61813 171.511331-137.10237 256.866892-205.386819 22.939307 18.404793 46.14535 36.809586 69.351394 55.214379 144.570982 115.76348 289.141964 231.52696 433.979682 347.023704 6.668403 5.334723 9.602501 10.135973 9.335765 18.671529-0.800208 13.603543-0.266736 27.207085-0.266736 44.011461C852.288617 327.285231 682.644439 191.516541 512.200052 55.214379 342.022402 191.516541 172.111487 327.285231 0.066684 464.921073c0-19.205001-0.266736-35.475905 0.266736-51.480073 0-3.200834 3.734306-6.668403 6.401667-9.069028 22.672571-18.404793 45.611878-36.809586 68.817921-54.680906 7.468612-5.868195 10.135973-12.003126 9.869237-21.33889C85.422245 252.599114 85.422245 177.11279 85.422245 101.626465 85.422245 96.825215 85.422245 92.023965 85.422245 85.889034z" p-id="2095"></path>
  </svg>
</a>
</div>
</div>

<div class="chapter-container">
    <!-- 头部信息 -->
    <div class="chapter-header">
        <div class="chapter-header-content">
            <h1 class="chapter-book-title">
                <a href="<?=$info_url?>"><?= $articlename ?></a>
            </h1>

            <div class="chapter-book-meta">
                <a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a>
                <a href="<?=$author_url?>" title="<?=$author?>作品集"><?=$author?></a>
                <span><?=$words_w?>万字</span>
                <span><?=$allvisit?>点击</span>
                <span><?=$isfull?></span>
            </div>

            <div class="chapter-current-info">
                <div class="chapter-total">共 <?= $chapters ?> 章</div>
                <div class="chapter-range">当前显示：第 <?=$startChapter?> - <?=$endChapter?> 章</div>
                <div class="chapter-page">第 <?=$currentPage?> 页 / 共 <?=$totalPages?> 页</div>
            </div>
        </div>
    </div>

    <!-- 章节列表 -->
    <div class="chapter-list-container">
        <div class="chapter-list-title">
            <span>《<?= $articlename ?>》章节目录</span>
            <span class="chapter-list-count">每页显示 <?=$chaptersPerPage?> 章</span>
        </div>

        <div class="chapter-list-grid">
            <?php foreach($list_arr as $index => $v): 
                $chapterNumber = $startChapter + $index;
            ?>
            <div class="chapter-item">
                <a href="<?=$v['cid_url']?>" title="<?=$v['cname']?>">
                    <span class="chapter-number">第<?=$chapterNumber?>章</span>
                    <?=$v['cname']?>
                </a>
            </div>
            <?php endforeach ?>
        </div>

        <!-- 分页导航 -->
        <div class="chapter-pagination">
            <?php if ($currentPage > 1): ?>
            <a href="<?=getPageUrl($articleid, $currentPage-1)?>" class="chapter-page-btn prev">上一页</a>
            <?php endif; ?>

            <div class="chapter-page-info">
                第 <?=$currentPage?> 页 / 共 <?=$totalPages?> 页
            </div>

            <?php if ($currentPage < $totalPages): ?>
            <a href="<?=getPageUrl($articleid, $currentPage+1)?>" class="chapter-page-btn next">下一页</a>
            <?php endif; ?>

            <?php if ($totalPages > 1): ?>
            <div class="chapter-page-select">
                <span>跳转到：</span>
                <select onchange="window.location.href='<?=getPageUrl($articleid, '')?>' + this.value">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <option value="<?=$i?>" <?=($i == $currentPage) ? 'selected' : ''?>><?=$i?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 相关推荐（长尾词，最多10条） -->
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

    <!-- 推荐阅读 -->
    <?php if (isset($neighbor) && !empty($neighbor)): ?>
    <div class="chapter-recommend">
        <div class="chapter-recommend-header">
            <h2 class="chapter-recommend-title">推荐阅读</h2>
        </div>

        <div class="chapter-recommend-grid">
            <?php 
            $neighborCount = 0;
            foreach($neighbor as $k => $v): 
                if ($neighborCount >= 6) break;

                // 确保有封面图片
                $coverImg = !empty($v['img_url']) ? $v['img_url'] : '/static/'.$theme_dir.'/nocover.jpg';
            ?>
            <div class="chapter-recommend-item">
                <div class="chapter-recommend-cover">
                    <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
                        <img src="<?=$coverImg?>" 
                             alt="<?=$v['articlename']?>" 
                             width="300" 
                             height="120" 
                             loading="lazy"
                             style="background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); object-fit: cover;"
                             onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'; this.onerror=null;">
                    </a>
                    <span><?=$v['sortname_2']?> / <?=$v['isfull']?></span>
                </div>

                <div class="chapter-recommend-content">
                    <h3 class="chapter-recommend-name">
                        <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a>
                    </h3>

                    <div class="chapter-recommend-author"><?=$v['author']?></div>

                    <div class="chapter-recommend-meta">
                        <span><?=$v['words_w']?>万字</span>
                        <span><?=Text::ss_lastupdate($v['lastupdate'])?></span>
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

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
