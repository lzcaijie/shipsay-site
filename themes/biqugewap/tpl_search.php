<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$search_count_value = isset($search_count) ? (int)$search_count : 0;
$searchkey_safe = htmlspecialchars((string)(isset($searchkey) ? $searchkey : ''), ENT_QUOTES, 'UTF-8');
require_once __ROOT_DIR__.'/shipsay/seo.php';
if ($search_count_value === 0) {
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
} else {
    $seo_title = ($searchkey_safe !== '' ? $searchkey_safe . '-小说搜索-' : '小说搜索-') . SITE_NAME;
    $seo_keywords = $searchkey_safe;
    $seo_description = ($searchkey_safe !== '' ? $searchkey_safe . '有关的小说搜索结果 - ' : '') . SITE_NAME;
}
$rank_entry_url_search = !empty($rank_entry_url) ? $rank_entry_url : (!empty($fake_top) ? $fake_top : '');
$full_allbooks_url_search = !empty($full_allbooks_url) ? $full_allbooks_url : '';
$recentread_url_search = !empty($recentread_url_attr) ? $recentread_url_attr : (!empty($fake_recentread) ? $fake_recentread : '');
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars((string)$seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars((string)$seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
</head>
<body>
    <header class="header">
        <div class="left"><a href="javascript:history.go(-1)"><svg id="icon-arrow-l" viewBox="0 0 8 16"><path d="M.146 7.646a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7v.708l7-7a.5.5 0 0 0-.708-.708l-7 7z"></path></svg></a></div>
        <div class="center"><?=$search_count_value === 0 ? '热门搜索推荐' : $searchkey_safe?></div>
        <div class="right">
            <a id="opensearch" href="javascript:" title="搜索"><svg id="icon-search" viewBox="0 0 17 18"><path d="M12.775 14.482l3.371 3.372a.5.5 0 0 0 .708-.708l-3.372-3.37-1.817-1.818a.5.5 0 1 0-.707.707l1.817 1.817zM1 7.14a6 6 0 1 1 12 0 6 6 0 0 1-12 0zm13 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0z"></path></svg></a>
            <a id="openGuide" href="javascript:" class="icon icon-more" title="更多"></a>
        </div>
        <div class="clear"></div>
    </header>
    <div class="fixed">
        <?php if ($search_count_value > 0): ?>
        <div style="font-size: .75rem;padding:1rem;"><span style="color:red">提示：</span>请记住本站最新网址：<span style="color:red"><?=htmlspecialchars((string)SITE_URL, ENT_QUOTES, 'UTF-8')?></span>！为响应国家净网行动号召，本站清理了所有涉黄的小说，导致大量书籍错乱，<span style="color:red">若打开链接发现不是要看的书，请点击上方搜索图标重新搜索该书即可</span>，感谢您的访问！</div>
        <?php endif; ?>
        <div class="rank mt0 mb0 min-height">
            <h4><?=$search_count_value === 0 ? '热门搜索推荐' : ($searchkey_safe . '有关的小说')?></h4>
            <div class="content">
                <?php $search_rows = ($search_count_value === 0) ? (isset($articlerows) && is_array($articlerows) ? $articlerows : array()) : (isset($search_res) && is_array($search_res) ? $search_res : array()); ?>
                <?php foreach($search_rows as $k => $v): ?><?php if($k < 10):?>
                <dl>
                    <a href="<?=$v['info_url']?>" class="cover" title="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>"><img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$v['img_url']?>" alt="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>"></a>
                    <dt><a href="<?=$v['info_url']?>" title="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a></dt>
                    <dd><?=htmlspecialchars((string)$v['intro_des'], ENT_QUOTES, 'UTF-8')?></dd>
                    <dd><a href="<?=$v['author_url']?>"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></a><span><?=htmlspecialchars((string)$v['isfull'], ENT_QUOTES, 'UTF-8')?></span><span><?=htmlspecialchars((string)$v['words_w'], ENT_QUOTES, 'UTF-8')?>万字</span></dd>
                </dl>
                <?php endif ?><?php endforeach ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
        <div id="guide" class="guide">
            <div class="guide-content">
                <nav class="guide-nav">
                    <a href="<?=$site_url?>" class="guide-nav-a">
                        <i class="icon icon-home"></i>
                        <span class="guide-nav-h">首页</span>
                    </a>
                    <a href="<?=$allbooks_url?>" class="guide-nav-a">
                        <i class="icon icon-sort"></i>
                        <span class="guide-nav-h">分类</span>
                    </a>
                    <a href="<?=$rank_entry_url_search?>" class="guide-nav-a">
                        <i class="icon icon-rank"></i>
                        <span class="guide-nav-h">排行榜</span>
                    </a>
                    <a href="<?=$full_allbooks_url_search?>" class="guide-nav-a">
                        <i class="icon icon-end"></i>
                        <span class="guide-nav-h">全本</span>
                    </a>
                    <a href="<?=$recentread_url_search?>" class="guide-nav-a">
                        <i class="icon icon-free"></i>
                        <span class="guide-nav-h">记录</span>
                    </a>
                </nav>
                <div class="guide-footer">
                    <a href="/bookcase/"><svg id="icon-person" viewBox="0 0 16 16"><g><path d="M12 5a4 4 0 1 0-8 0 4 4 0 0 0 8 0z"></path><path d="M3 5a5 5 0 1 1 10 0A5 5 0 0 1 3 5z"></path><path d="M8 9c-4.397 0-8 2.883-8 6.5a.5.5 0 1 0 1 0C1 12.49 4.113 10 8 10s7 2.49 7 5.5a.5.5 0 1 0 1 0C16 11.883 12.397 9 8 9z"></path></g></svg>会员书架</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
