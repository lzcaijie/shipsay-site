<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('top');
$rank_entry_url = isset($rank_entry_url) && $rank_entry_url ? $rank_entry_url : ((isset($fake_top) && $fake_top) ? $fake_top : '/rank/');
$rank_detail_base = isset($rank_detail_base) && $rank_detail_base ? $rank_detail_base : $rank_entry_url;
$rank_page_title = '排行榜';
if (trim($seo_title) === '' || trim($seo_title) === SITE_NAME) {
    $seo_title = $rank_page_title . '_' . SITE_NAME;
}
if (trim($seo_keywords) === '' || trim($seo_keywords) === SITE_NAME) {
    $seo_keywords = '排行榜,日榜,周榜,月榜,总榜,推荐榜,收藏榜,' . SITE_NAME;
}
if (trim($seo_description) === '' || trim($seo_description) === SITE_NAME) {
    $seo_description = SITE_NAME . '小说排行榜聚合页，查看日榜、周榜、月榜、总榜、推荐榜、收藏榜。';
}
$canonical_top = $rank_entry_url ?: '/rank/';
$site_home_url_safe = !empty($site_url) ? rtrim($site_url, '/') . '/' : '/';
$rank_sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [
    'dayvisit'   => ['title' => '日榜',   'field' => 'dayvisit',   'more' => $rank_detail_base . 'dayvisit/'],
    'weekvisit'  => ['title' => '周榜',   'field' => 'weekvisit',  'more' => $rank_detail_base . 'weekvisit/'],
    'monthvisit' => ['title' => '月榜',   'field' => 'monthvisit', 'more' => $rank_detail_base . 'monthvisit/'],
    'allvisit'   => ['title' => '总榜',   'field' => 'allvisit',   'more' => $rank_detail_base . 'allvisit/'],
    'allvote'    => ['title' => '推荐榜', 'field' => 'allvote',    'more' => $rank_detail_base . 'allvote/'],
    'goodnum'    => ['title' => '收藏榜', 'field' => 'goodnum',    'more' => $rank_detail_base . 'goodnum/'],
];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<link rel="canonical" href="<?=htmlspecialchars($canonical_top, ENT_QUOTES, 'UTF-8')?>">
<meta name="applicable-device" content="pc,mobile">
<meta name="mobile-agent" content="format=xhtml;url=<?=htmlspecialchars($canonical_top, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=htmlspecialchars($canonical_top, ENT_QUOTES, 'UTF-8')?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": <?=json_encode($seo_title, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
  "description": <?=json_encode($seo_description, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>,
  "url": <?=json_encode($canonical_top, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)?>
}
</script>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="<?=htmlspecialchars($site_home_url_safe, ENT_QUOTES, 'UTF-8')?>">首页</a> &gt; <span>排行榜</span>
        </div>
        <div class="rank-page-head">
            <h1><?=htmlspecialchars($rank_page_title, ENT_QUOTES, 'UTF-8')?></h1>
            <p>按榜单类型查看热门作品</p>
        </div>
        <div class="rank-tabs top-rank-tabs">
            <?php foreach ($rank_sections as $key => $conf):
                $more_attr = htmlspecialchars($conf['more'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars($conf['title'], ENT_QUOTES, 'UTF-8');
            ?>
                <a href="<?=$more_attr?>"><?=$title_html?></a>
            <?php endforeach; ?>
        </div>
        <div class="top-rank-grid">
            <?php foreach ($rank_sections as $key => $conf): ?>
                <?php
                $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
                $more_attr = htmlspecialchars($conf['more'], ENT_QUOTES, 'UTF-8');
                $title_html = htmlspecialchars($conf['title'], ENT_QUOTES, 'UTF-8');
                ?>
                <div class="top-card">
                    <div class="top-card-head">
                        <h2><?=$title_html?></h2>
                        <a href="<?=$more_attr?>">更多</a>
                    </div>
                    <ol>
                        <?php if (!empty($list)): ?>
                            <?php foreach ($list as $k => $v): if ($k >= $rank_limit) break;
                                $info_url_attr = htmlspecialchars($v['info_url'], ENT_QUOTES, 'UTF-8');
                                $title_html = htmlspecialchars($v['articlename'], ENT_QUOTES, 'UTF-8');
                                $author_html = htmlspecialchars($v['author'], ENT_QUOTES, 'UTF-8');
                            ?>
                                <li>
                                    <span><?=($k + 1)?></span>
                                    <a href="<?=$info_url_attr?>"><?=$title_html?></a>
                                    <em><?=$author_html?></em>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="rank-empty">暂无数据</li>
                        <?php endif; ?>
                    </ol>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
