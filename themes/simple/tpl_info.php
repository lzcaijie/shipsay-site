<?php if (!defined('__ROOT_DIR__')) exit;?>

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
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$articlename?>(<?=$author?>)_<?=$articlename?>全文免费阅读无弹窗_<?=$articlename?>最新章节阅读_<?=SITE_NAME?>">
    <meta property="og:image" content="<?=$img_url?>">
    <meta property="og:description" content="<?=$intro_des?>">
    <meta property="og:novel:category" content="<?=$sortname?>">
    <meta property="og:novel:author" content="<?=$author?>">
    <meta property="og:novel:author_link" content="<?=$site_url?><?=$author_url?>">
    <meta property="og:novel:book_name" content="<?=$articlename?>">
    <meta property="og:novel:read_url" content="<?=$site_url?><?=$uri?>">
    <meta property="og:novel:url" content="<?=$site_url?><?=$uri?>">
    <meta property="og:novel:status" content="<?=$isfull?>">
    <meta property="og:novel:update_time" content="<?=$lastupdate?>">
    <meta property="og:novel:lastest_chapter_name" content="<?=$lastchapter?>">
    <meta property="og:novel:lastest_chapter_url" content="<?=$site_url?><?=$last_url?>">

<?php
$index_url_safe = isset($index_url) && $index_url ? (string)$index_url : '';
$chapter_total_by_rows = 0;
if (!empty($chapterrows) && is_array($chapterrows)) {
    $chapter_total_by_rows = count($chapterrows);
}
?>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<div class="container">
    <div class="content">
        <ol class="breadcrumb">
            <li><a href="<?=$site_url?>" title="<?=SITE_NAME?>">首页</a></li>
            <li><a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></li>
            <li class="active"><?=$articlename?></li>
        </ol>
        <div class="book pt10">
            <div class="bookcover hidden-xs">
                <img class="thumbnail" alt="<?=$articlename?>" src="<?=$img_url?>" title="<?=$articlename?>" width="140" height="180" />
            </div>
            <div class="bookinfo">
                <h1 class="booktitle"><?=$articlename?></h1>
                <p class="booktag">
                    <a class="red" href="<?=$author_url?>" title="作者：<?=$author?>"><?=$author?></a>
                    <span class="blue"><?=$words_w?>万字</span>
                    <span class="blue"><?=$allvisit?>人读过</span>
                    <span class="red"><?=$isfull?></span>
                </p>
                <p class="bookintro">
                    <img class="thumbnail pull-left visible-xs" style="margin:0 5px 0 0" alt="<?=$articlename?>" src="<?=$img_url?>" title="<?=$articlename?>" width="80" height="120" /><?=$intro_des?>...<br/>《<?=$articlename?>》是<?=$author?>精心创作的<?=$sortname?>，<?=SITE_NAME?>实时更新<?=$articlename?>最新章节并且提供无弹窗阅读，书友所发表的<?=$articlename?>评论，并不代表<?=SITE_NAME?>赞同或者支持<?=$articlename?>读者的观点。
                </p>
                <p>最新章节：<a class="bookchapter" href="<?=$last_url?>" title="<?=$lastchapter?>"><?=$lastchapter?></a></p>
                <p class="booktime">更新时间：<?=$lastupdate?></p>
                <div class="bookmore">
                    <a class="btn btn-info" href="<?=$first_url?>">开始阅读</a>
                    <?php if ($index_url_safe !== ''): ?><a class="btn btn-info" href="<?=$index_url_safe?>">查看目录</a><?php endif; ?>
                </div>
                <?php if ($is_langtail == 1 && !empty($langtailrows) && is_array($langtailrows)) : ?>
                    <p>相关推荐：
                        <?php foreach ($langtailrows as $v) : ?>
                            <a href="<?= $v['info_url'] ?>"><?= $v['langname'] ?></a>&nbsp;
                        <?php endforeach ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>

        <dl class="book chapterlist">
            <h2>《<?=$articlename?>》最新章节</h2>
            <?php if(!empty($lastarr) && is_array($lastarr)): ?><?php foreach($lastarr as $k => $v): ?>
                <dd><a href="<?=$v['cid_url'] ?>"><?=$v['cname'] ?></a></dd>
            <?php endforeach ?><?php endif ?>

            <div class="clear"></div>

            <div id="list-chapterAll" style="display:block;">
                <h2>《<?=$articlename?>》正文（显示前50章）</h2>
                <?php
                $maxDisplay = 50;
                $cnt = 0;
                if(!empty($chapterrows) && is_array($chapterrows)):
                    foreach($chapterrows as $k => $v):
                        if ($cnt >= $maxDisplay) break;
                        $cnt++;
                ?>
                    <dd><a href="<?=$v['cid_url'] ?>" title="<?=$articlename?> <?=$v['cname'] ?>"><?=$v['cname'] ?></a></dd>
                <?php
                    endforeach;
                endif;
                ?>

                <?php if ($index_url_safe !== ''): ?>
                    <dd style="width:100%;text-align:center;margin:10px 0;">
                        <a class="btn btn-info" href="<?=$index_url_safe?>">
                            <?='查看目录'?><?php if(isset($chapters) && (int)$chapters>0): ?>（共<?=$chapters?>章）<?php endif; ?>
                        </a>
                    </dd>
                <?php endif; ?>

                <div class="clear"></div>
            </div>
        </dl>

        <div class="book mt10 pt10 tuijian">
            <?=$sortname?>相关阅读：<?php include __ROOT_DIR__ . '/shipsay/include/neighbor.php'; foreach($neighbor as $v):?>
            <a href="<?=$site_url?><?=$v['info_url'] ?>" title="<?=$articlename?>"><?=$v['articlename'] ?></a>
        <?php endforeach ?>
            <div class="clear"></div>
        </div>
        <p class="pt10 hidden-xs">《<?=$articlename?>》所有内容均来自互联网或网友上传，<?=SITE_NAME?>只为原作者<?=$author?>的小说进行宣传。欢迎各位书友支持<?=$author?>并收藏《<?=$articlename?>》最新章节。</p>
    </div>
    <div class="clear"></div>
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
