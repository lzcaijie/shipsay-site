<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
if (!function_exists('ss_e')) { function ss_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
?>
<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$isSearchEngine = false;
$searchEngines = [
    'Baiduspider',
    'bingbot',
    '360Spider',
    'Sogou web spider',
    'YisouSpider',
    'Googlebot'
];

foreach ($searchEngines as $bot) {
    if (stripos($userAgent, $bot) !== false) {
        $isSearchEngine = true;
        break;
    }
}

$pageTitle = $articlename . ' - ' . $chaptername;
if ($max_pid > 1) {
    $pageTitle .= '（' . $now_pid . '/' . $max_pid . '）';
}
$pageTitle .= ' - ' . SITE_NAME;

$pageDescription = '《' . $articlename . '》最新章节：' . $chaptername;
if ($max_pid > 1) {
    $pageDescription .= ' 第' . $now_pid . '页/共' . $max_pid . '页';
}
$pageDescription .= '，作者：' . $author . '。';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  $reader_url_raw = isset($uri) ? (string)$uri : '';
  $reader_url_attr = htmlspecialchars($reader_url_raw, ENT_QUOTES, 'UTF-8');
  $site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
  $site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
  $sort_url_raw = (string)Sort::ss_sorturl($sortid);
  $sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
  $info_url_attr = htmlspecialchars((string)$info_url, ENT_QUOTES, 'UTF-8');
  $index_url_attr = htmlspecialchars((string)$index_url, ENT_QUOTES, 'UTF-8');
  $author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
  $reader_breadcrumb_ld = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => SITE_NAME, 'item' => $site_home_url_raw],
          ['@type' => 'ListItem', 'position' => 2, 'name' => $sortname, 'item' => $sort_url_raw],
          ['@type' => 'ListItem', 'position' => 3, 'name' => $articlename, 'item' => (string)$info_url],
          ['@type' => 'ListItem', 'position' => 4, 'name' => $chaptername, 'item' => $reader_url_raw],
      ],
  ];
  $reader_page_url = function ($page) use ($articleid, $chapterid) {
      $page = intval($page);
      if ($page <= 1) return Url::chapter_url($articleid, $chapterid);
      return Url::chapter_url($articleid, $chapterid, $page);
  };
  ?>
  <link rel="canonical" href="<?=$reader_url_attr?>">
    <?php
  require_once __ROOT_DIR__.'/shipsay/seo.php';
  list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('reader');
  $pageTitle = $seo_title;
  $pageDescription = $seo_description;
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="applicable-device" content="pc,mobile">
  <meta name="mobile-agent" content="format=html5;url=<?=$uri?>">
  
  <meta property="og:type" content="novel">
  <meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <meta property="og:novel:category" content="<?=$sortname?>小说">
  <meta property="og:novel:author" content="<?=$author?>">
  <meta property="og:novel:book_name" content="<?=$articlename?>">
  <meta property="og:novel:index_url" content="<?=$index_url_attr?>">
  <meta property="og:novel:info_url" content="<?=$info_url_attr?>">
  <meta property="og:novel:status" content="<?=$isfull?>">
  <meta property="og:novel:chapter_name" content="<?=$chaptername?>">
  <meta property="og:novel:chapter_url" content="<?=$reader_url_attr?>">
  <script type="application/ld+json"><?=json_encode($reader_breadcrumb_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?></script>


<style>
.loading-text {
    text-align: center;
    padding: 40px 20px;
    color: #666;
    font-size: 16px;
}
.error-text {
    text-align: center;
    padding: 40px 20px;
    color: #f00;
    font-size: 16px;
}
.spider-pagination {
    position: absolute;
    left: -9999px;
    top: -9999px;
    height: 0;
    overflow: hidden;
}
.spider-pagination a {
    display: inline-block;
    margin: 0 5px;
    color: #333;
    text-decoration: none;
}
</style>

<?php require_once 'tpl_header.php'; ?>
</head>
<body id="nr_body" class="nr_all c_nr">
    <div class="header">
      <div class="back">
        <a href="javascript:history.go(-1);">返回</a>
      </div>
      <h1><a href="<?=$info_url_attr?>" id="bookname"><?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?></a></h1>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
        <a href="<?=$site_home_url_attr?>" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>
    <div class="nr_set clearfix">
      <div id="lightdiv" class="set1" onclick="nr_setbg('light')">关灯</div>
      <div id="huyandiv" class="set1" onclick="nr_setbg('huyan')">护眼</div>
      <div class="set2">
        <div id="fontbig2" onclick="nr_setbg('big2')">巨</div>
        <div id="fontbig" onclick="nr_setbg('big')">大</div>
        <div id="fontmiddle" onclick="nr_setbg('middle')">中</div>
        <div id="fontsmall" onclick="nr_setbg('small')">小</div>
      </div>
      <div class="cc"></div>
    </div>
    
    <div class="spider-pagination" aria-label="章节分页导航">
        <?php if ($max_pid > 1): ?>
            <?php if ($now_pid > 1): ?>
                <a href="<?=$prevpage_url?>" rel="prev">上一页</a>
            <?php endif; ?>
            
            <span>第<?=$now_pid?>页/共<?=$max_pid?>页</span>
            
            <?php for ($i = 1; $i <= min($max_pid, 10); $i++): ?>
                <?php if ($i == $now_pid): ?>
                    <strong><?=$i?></strong>
                <?php else: ?>
                    <a href="<?=htmlspecialchars($reader_page_url($i), ENT_QUOTES, 'UTF-8')?>"><?=$i?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if ($now_pid < $max_pid): ?>
                <a href="<?=$nextpage_url?>" rel="next">下一页</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <div class="nr_title" id="nr_title">
        <?=$chaptername?>
        <?php if ($max_pid > 1): ?>
        <span style="font-size: 14px; color: #666; margin-left: 10px;">
            （第<?=$now_pid?>页/共<?=$max_pid?>页）
        </span>
        <?php endif; ?>
    </div>
    
    <div class="nr_page">
      <a id="pt_shuq" onclick="addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')">书签</a>
      <?php if($prevpage_url != ''): ?>
      <a id="pt_prev" href="<?=$prevpage_url?>">上一页</a>
      <?php else: ?>
      <?php if($pre_cid == 0): ?>
      <a id="pt_prev" href="javascript:void(0);" class="w_gray">书首页</a>
      <?php else: ?>
      <a id="pt_prev" href="<?=$pre_url?>">上一章</a>
      <?php endif ?>
      <?php endif ?>
      <a id="pt_mulu" href="<?=$index_url_attr?>">目录</a>
      <?php if($nextpage_url != ''): ?>
      <a id="pt_next" href="<?=$nextpage_url?>">下一页</a>
      <?php else: ?>
      <?php if($next_cid == 0): ?>
      <a id="pt_next" href="javascript:void(0);" class="w_gray">书尾页</a>
      <?php else: ?>
      <a id="pt_next" href="<?=$next_url?>">下一章</a>
      <?php endif ?>
      <?php endif ?>
      <a id="pt_shuj" href="javascript:;" onclick="addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')" rel="nofollow">书架</a>
    </div>
    
    <div id="nr" class="nr_nr nr_bg">
      <div id="nr1">
        <?php if ($isSearchEngine || !Ss::use_js()): ?>
            <?php echo $rico_content; ?>
        <?php else: ?>
            <div class="loading-text">正在加载章节内容...</div>
        <?php endif; ?>
      </div>
    </div>
    
    <div class="nr_page">
      <a id="pt_shuq1" onclick="addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')">书签</a>
      <?php if($prevpage_url != ''): ?>
      <a id="pt_prev1" href="<?=$prevpage_url?>">上一页</a>
      <?php else: ?>
      <?php if($pre_cid == 0): ?>
      <a id="pt_prev1" href="javascript:void(0);" class="w_gray">书首页</a>
      <?php else: ?>
      <a id="pt_prev1" href="<?=$pre_url?>">上一章</a>
      <?php endif ?>
      <?php endif ?>
      <a id="pt_mulu1" href="<?=$index_url_attr?>">目录</a>
      <?php if($nextpage_url != ''): ?>
      <a id="pt_next1" href="<?=$nextpage_url?>">下一页</a>
      <?php else: ?>
      <?php if($next_cid == 0): ?>
      <a id="pt_next1" href="javascript:void(0);" class="w_gray">书尾页</a>
      <?php else: ?>
      <a id="pt_next1" href="<?=$next_url?>">下一章</a>
      <?php endif ?>
      <?php endif ?>
      <a id="pt_shuj1" href="javascript:;" onclick="addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>')" rel="nofollow">书架</a>
    </div>
    
    <script>getset();</script>
    
    <script>
    <?php if (Ss::use_js() && !$isSearchEngine) : ?>
        setTimeout(function() {
            $.ajax({
                type: "post",
                url: "/api/reader_js.php",
                data: {
                    articleid: '<?= $articleid ?>',
                    chapterid: '<?= $chapterid ?>',
                    pid: '<?= $now_pid ?>'
                },
                success: function(data) {
                    if (!data || data.length < 10) {
                        $('#nr1').html('<div class="error-text">内容为空，请刷新重试</div>');
                        return;
                    }
                    $('#nr1').html(data);
                },
                error: function() {
                    $('#nr1').html('<div class="error-text">加载失败，请刷新重试</div>');
                }
            });
        }, 200);
    <?php endif ?>
    </script>
<?php require_once 'tpl_footer.php'; ?>