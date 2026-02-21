<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
    <meta charset="UTF-8">
    <?php
    $chaptersPerPage = 50;

    $chapters = isset($chapters) ? (int)$chapters : 0;
    if ($chapters < 0) $chapters = 0;

    $totalPages = ($chapters > 0) ? (int)ceil($chapters / $chaptersPerPage) : 1;

    $currentPage = isset($pid) ? (int)$pid : 1;
    if ($currentPage < 1) $currentPage = 1;
    if ($currentPage > $totalPages) $currentPage = $totalPages;

    $startChapter = ($currentPage - 1) * $chaptersPerPage + 1;
    $endChapter = min($currentPage * $chaptersPerPage, $chapters);

    function getChapterPageUrl($articleid, $page = 1) {
        $page = (int)$page;
        if ($page < 1) $page = 1;

        // 优先走 CMS 的 Url::index_url（避免写死 /index/ 破坏后台路由/伪静态配置）
        if (class_exists('Url') && method_exists('Url', 'index_url')) {
            return Url::index_url($articleid, $page);
        }

        // 兜底（保持旧结构）
        if ($page == 1) return "/index/{$articleid}/";
        return "/index/{$articleid}/{$page}/";
    }

    $pageTitle = ($currentPage > 1) ?
        "《{$articlename}》章节目录第{$currentPage}页_{$articlename}最新章节_{$author}_".SITE_NAME :
        "《{$articlename}》章节目录_{$articlename}最新章节_{$author}_".SITE_NAME;

    $description = "《{$articlename}》是{$author}创作的{$sortname}小说";
    if ($currentPage > 1) {
        $description .= "，本站提供{$articlename}章节目录第{$currentPage}页在线阅读";
    } else {
        $description .= "，本站提供{$articlename}完整章节目录在线免费阅读";
    }
    $description .= "，总章节{$chapters}章";
    if ($chapters > 0) $description .= "，当前显示第{$startChapter}-{$endChapter}章";

    $keywords = "{$articlename}章节目录,{$articlename}最新章节,{$articlename}目录,{$articlename}免费阅读";
    if ($currentPage > 1) $keywords .= ",{$articlename}第{$currentPage}页";
    $keywords .= ",{$author}小说,{$sortname}小说";
    ?>

    <title><?=$pageTitle?></title>
    <meta name="keywords" content="<?=$keywords?>" />
    <meta name="description" content="<?=$description?>" />

<?php require_once __THEME_DIR__ . '/tpl_header.php'; require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>

<div class="container">
    <div class="border3-2">
        <div class="info-title">
            <a href="/"><?=SITE_NAME?></a> &gt; <a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a> &gt; <a href="<?=$info_url?>"><?=$articlename?></a> &gt; 章节目录
        </div>
        <div class="info-main">
            <img class="lazy" src="/static/<?=$theme_dir?>/nocover.jpg" data-original="<?=$img_url?>" alt="<?=$articlename?>" width="120" height="150"
                 onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;">
            <div class="w100">
                <h1><?=$articlename?></h1>
                <div class="w100 dispc">
                    <span><a href="<?=$author_url?>">作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$author?></a></span>
                    动&nbsp;&nbsp;&nbsp;&nbsp;做：<a href="<?=$first_url?>">开始阅读</a>，<?=$isfull?>，<a href="javascript:gofooter();">直达底部</a>
                </div>
                <div class="dispc"><span>最后更新：<?=$lastupdate?></span><a href="<?=$last_url?>">最新章节：<?=$lastchapter?></a></div>
                <div class="info-main-intro"><?=$intro_p?></div>
            </div>
        </div>
    </div>
<div class="info-commend">
    <?php if ($is_langtail == 1 && !empty($langtailrows)) : ?>
        <p>相关推荐：
            <?php foreach ($langtailrows as $v) : ?>
                <a href="<?= $v['info_url'] ?>"><?= $v['langname'] ?></a>&nbsp;
            <?php endforeach ?>
        </p>
    <?php endif; ?>
</div>
    <div class="diswap info-main-wap border3-1">
        <a href="<?=$author_url?>"><p>作&nbsp;&nbsp;&nbsp;&nbsp;者：<?=$author?></p></a>
        <p>最后更新：<?=$lastupdate?>&nbsp;&nbsp;<a href="javascript:gofooter();">直达底部</a></p>
        <a href="<?=$last_url?>"><p>最新章节：<?=$lastchapter?></p></a>
    </div>
</div>

<div class="chapter-range-info">
    <strong>共 <?=$chapters?> 章</strong>
    <?php if ($chapters > 0): ?>
    - 当前显示：第 <?=$startChapter?> - <?=$endChapter?> 章（第 <?=$currentPage?> 页 / 共 <?=$totalPages?> 页）
    <?php else: ?>
    - 暂无目录
    <?php endif; ?>
</div>

<div class="container border3-2 mt8">
    <div class="info-chapters-title"><strong>《<?=$articlename?>》章节目录</strong></div>
    <div class="info-chapters flex flex-wrap">
        <?php if(!empty($list_arr) && is_array($list_arr)): ?>
            <?php foreach($list_arr as $index => $v):
                $chapterNumber = $startChapter + $index;
            ?>
                <a href="<?=$v['cid_url']?>" title="<?=$articlename?> <?=$v['cname']?>">第<?=$chapterNumber?>章 <?=$v['cname']?></a>
            <?php endforeach ?>
        <?php else: ?>
            <div style="padding:20px;color:#888;">暂无目录</div>
        <?php endif; ?>
    </div>
</div>

<?php if ($totalPages > 1): ?>
<div class="chapter-pagination">
    <?php if ($currentPage > 1): ?>
    <a href="<?=getChapterPageUrl($articleid, $currentPage-1)?>" class="chapter-page-btn">上一页</a>
    <?php endif; ?>

    <div class="chapter-page-info">
        第 <?=$currentPage?> 页 / 共 <?=$totalPages?> 页
    </div>

    <?php if ($currentPage < $totalPages): ?>
    <a href="<?=getChapterPageUrl($articleid, $currentPage+1)?>" class="chapter-page-btn">下一页</a>
    <?php endif; ?>
</div>
<?php endif; ?>

<button class="gotop" onclick="javascript:gotop();">顶部</button>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
</body>
</html>
