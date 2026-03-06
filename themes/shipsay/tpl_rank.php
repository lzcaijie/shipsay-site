<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_base = (isset($fake_top) && $fake_top)
    ? rtrim($fake_top, '/') . '/'
    : ('/' . ((isset($fake_rankstr) && $fake_rankstr) ? trim($fake_rankstr, '/') : 'rank') . '/');
$title_arr = [
    'allvisit' => '总点击榜',
    'monthvisit' => '月点击榜',
    'weekvisit' => '周点击榜',
    'dayvisit' => '日点击榜',
    'allvote' => '总推荐榜',
    'monthvote' => '月推荐榜',
    'weekvote' => '周推荐榜',
    'dayvote' => '日推荐榜',
    'goodnum' => '收藏榜',
];
$current_query = isset($query) && $query ? $query : 'allvisit';
$current_title = isset($title_arr[$current_query]) ? $title_arr[$current_query] : '排行榜';
?>
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="/">首页</a> &gt; <span><?=$current_title?></span>
        </div>
        <div class="rank-page-head">
            <h1><?=$current_title?></h1>
            <p>支持后台自定义排行榜入口，当前页默认展示 Top 30</p>
        </div>
        <div class="rank-tabs">
            <?php foreach ($title_arr as $key => $label): ?>
                <a href="<?=$rank_base . $key . '/'?>" class="<?=$current_query === $key ? 'active' : ''?>"><?=$label?></a>
            <?php endforeach; ?>
        </div>
        <ol class="rank-page-list">
            <?php if (!empty($articlerows) && is_array($articlerows)): ?>
                <?php foreach ($articlerows as $k => $v): ?>
                    <li>
                        <span class="rank-num"><?=($k + 1)?></span>
                        <div class="rank-main">
                            <a href="<?=$v['info_url']?>" class="rank-bookname"><?=$v['articlename']?></a>
                            <div class="rank-meta">
                                <a href="<?=$v['author_url']?>"><?=$v['author']?></a>
                                <?php if (!empty($v['sortname_2'])): ?><em><?=$v['sortname_2']?></em><?php endif; ?>
                                <em><?=$v['words_w']?>万字</em>
                                <em><?=Text::ss_lastupdate($v['lastupdate'])?></em>
                            </div>
                            <p><?=$v['intro_des']?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="rank-empty">暂无排行榜数据</li>
            <?php endif; ?>
        </ol>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
