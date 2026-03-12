<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$searchkey_raw = isset($searchkey) ? (string)$searchkey : '';
$searchkey_safe = htmlspecialchars($searchkey_raw, ENT_QUOTES, 'UTF-8');
$search_count_safe = isset($search_count) ? (int)$search_count : 0;
$search_page_url_raw = isset($uri) && $uri ? (string)$uri : (function_exists('ss_search_url') ? (string)ss_search_url() : '');
$search_page_url_attr = htmlspecialchars($search_page_url_raw, ENT_QUOTES, 'UTF-8');
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$theme_dir_attr = htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8');
$search_highlight = static function ($text) use ($searchkey_raw) {
    $text = (string)$text;
    if ($searchkey_raw === '') {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
    $quoted = preg_quote($searchkey_raw, '/');
    $escaped = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    return preg_replace('/(' . $quoted . ')/iu', '<em>$1</em>', $escaped);
};
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('search');
if (trim((string)$seo_title) === '' || trim((string)$seo_title) === SITE_NAME) {
    $seo_title = ($searchkey_raw !== '' ? $searchkey_raw . '_搜索结果_' : '搜索结果_') . SITE_NAME;
}
if (trim((string)$seo_keywords) === '' || trim((string)$seo_keywords) === SITE_NAME) {
    $seo_keywords = ($searchkey_raw !== '' ? $searchkey_raw . ',' : '') . '搜索,小说,' . SITE_NAME;
}
if (trim((string)$seo_description) === '' || trim((string)$seo_description) === SITE_NAME) {
    $seo_description = ($searchkey_raw !== '' ? '与“' . $searchkey_raw . '”相关的小说搜索结果，' : '小说搜索结果，') . '尽在' . SITE_NAME . '。';
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php if ($search_page_url_raw !== ''): ?>
<link rel="canonical" href="<?=$search_page_url_attr?>">
<meta name="mobile-agent" content="format=html5;url=<?=$search_page_url_attr?>">
<meta property="og:url" content="<?=$search_page_url_attr?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
    <div class="content">
        <div class="search">
            <form name="articlesearch" method="post" action="<?=$search_url_attr?>">
                <input name="searchkey" type="text" class="text" id="searchkey" size="10" maxlength="50" value="<?=$searchkey_safe?>" placeholder="<?=$search_placeholder_attr?>" />
                <input type="hidden" name="searchtype" value="all" />
                <button type="submit" name="submit">搜  索</button>
            </form>
        </div>
        <div class="clear"></div>
    </div>

    <div class="content book" id="fengtui">
        <?php if ($searchkey_raw !== ''): ?>
            <h2>搜索“<?=$searchkey_safe?>”共有 <?=$search_count_safe?> 条结果</h2>
        <?php else: ?>
            <h2>热门小说推荐</h2>
        <?php endif; ?>

        <?php if (!empty($search_res) && is_array($search_res)): ?>
            <?php foreach($search_res as $k => $v): ?>
            <div class="bookbox">
                <div class="p10">
                    <span class="num"><?=$k+1?></span>
                    <div class="bookinfo">
                        <h4 class="bookname"><a href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=$search_highlight($v['articlename'] ?? '')?></a></h4>
                        <div class="author">作者：<?=htmlspecialchars((string)($v['author'] ?? ''), ENT_QUOTES, 'UTF-8')?></div>
                        <div class="author">阅读量：<?=htmlspecialchars((string)($v['allvisit'] ?? ''), ENT_QUOTES, 'UTF-8')?></div>
                        <div class="cat"><span>更新到：</span><a href="<?=htmlspecialchars((string)($v['last_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)($v['lastchapter'] ?? ''), ENT_QUOTES, 'UTF-8')?></a></div>
                        <div class="update"><span>简介：</span><?=htmlspecialchars((string)($v['intro_des'] ?? ''), ENT_QUOTES, 'UTF-8')?></div>
                    </div>
                    <div class="delbutton"><a class="del_but" href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>">阅读</a></div>
                </div>
            </div>
            <?php endforeach ?>

        <?php else: ?>

            <?php if ($searchkey_raw !== ''): ?>
                <div class="bookbox">
                    <div class="p10" style="text-align:center;color:#999;">
                        未找到与“<?=$searchkey_safe?>”相关的结果，给你推荐一些热门小说：
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
                <?php foreach($articlerows as $k => $v): ?>
                <div class="bookbox">
                    <div class="p10">
                        <span class="num"><?=$k+1?></span>
                        <div class="bookinfo">
                            <h4 class="bookname"><a href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)($v['articlename'] ?? ''), ENT_QUOTES, 'UTF-8')?></a></h4>
                            <div class="author">作者：<?=htmlspecialchars((string)($v['author'] ?? ''), ENT_QUOTES, 'UTF-8')?></div>
                            <div class="author">阅读量：<?=htmlspecialchars((string)($v['allvisit'] ?? ''), ENT_QUOTES, 'UTF-8')?></div>
                            <div class="cat"><span>更新到：</span><a href="<?=htmlspecialchars((string)($v['last_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)($v['lastchapter'] ?? ''), ENT_QUOTES, 'UTF-8')?></a></div>
                            <div class="update"><span>简介：</span><?=htmlspecialchars((string)($v['intro_des'] ?? ''), ENT_QUOTES, 'UTF-8')?></div>
                        </div>
                        <div class="delbutton"><a class="del_but" href="<?=htmlspecialchars((string)($v['info_url'] ?? ''), ENT_QUOTES, 'UTF-8')?>">阅读</a></div>
                    </div>
                </div>
                <?php endforeach ?>
            <?php endif; ?>

        <?php endif; ?>

        <div class="clear"></div>
    </div>
</div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
