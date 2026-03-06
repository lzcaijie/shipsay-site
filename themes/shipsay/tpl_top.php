<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>排行榜_<?=SITE_NAME?></title>
<meta name="description" content="<?=SITE_NAME?>小说排行榜聚合页，按分类查看热门作品。">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container">
    <section class="section">
        <div class="bread_crumbs">
            <a href="/">首页</a> &gt; <span>排行榜</span>
        </div>
        <div class="rank-page-head">
            <h1>排行榜</h1>
            <p>按分类查看热门作品，作为母模板聚合榜入口。</p>
        </div>
        <div class="top-grid">
            <?php $sortCount = is_array($sortarr) ? count($sortarr) : 0; ?>
            <?php for ($i = 1; $i <= $sortCount; $i++): ?>
                <?php $tmp = 'allvisit' . $i; $list = isset($$tmp) ? $$tmp : []; ?>
                <div class="top-card">
                    <div class="top-card-head">
                        <h2><?=Sort::ss_sortname($i,1)?>榜</h2>
                        <a href="<?=Sort::ss_sorturl($i)?>">更多</a>
                    </div>
                    <ol>
                        <?php if (!empty($list) && is_array($list)): ?>
                            <?php foreach ($list as $k => $v): if ($k >= 10) break; ?>
                                <li>
                                    <span><?=($k + 1)?></span>
                                    <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
                                    <em><?=$v['author']?></em>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="rank-empty">暂无数据</li>
                        <?php endif; ?>
                    </ol>
                </div>
            <?php endfor; ?>
        </div>
    </section>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
