<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$index_url_raw = '';
if (!empty($index_url)) {
    $index_url_raw = (string)$index_url;
} elseif (!empty($articleid) && class_exists('Url') && method_exists('Url', 'index_url')) {
    $index_url_raw = Url::index_url($articleid);
}
$site_home_url_raw = !empty($site_url) ? rtrim((string)$site_url, '/') . '/' : '/';
$site_home_url_attr = htmlspecialchars($site_home_url_raw, ENT_QUOTES, 'UTF-8');
$canonical_raw = rtrim((string)$site_url, '/') . (string)$uri;
$sort_url_raw = Sort::ss_sorturl($sortid);
$sort_url_attr = htmlspecialchars($sort_url_raw, ENT_QUOTES, 'UTF-8');
$index_url_attr = htmlspecialchars($index_url_raw, ENT_QUOTES, 'UTF-8');
$last_url_attr = htmlspecialchars((string)$last_url, ENT_QUOTES, 'UTF-8');
$first_url_attr = htmlspecialchars((string)$first_url, ENT_QUOTES, 'UTF-8');
$author_url_attr = htmlspecialchars((string)$author_url, ENT_QUOTES, 'UTF-8');
$img_url_attr = htmlspecialchars((string)$img_url, ENT_QUOTES, 'UTF-8');
$intro_html = !empty($intro) ? $intro : $intro_des;
require_once __ROOT_DIR__ . '/shipsay/include/neighbor.php';
?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php
    require_once __ROOT_DIR__ . '/shipsay/seo.php';
    list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('info');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <?php if ($canonical_raw !== ''): ?><link rel="canonical" href="<?=htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8')?>"><?php endif; ?>
    <meta property="og:type" content="novel"/>
    <meta property="og:title" content="<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:description" content="<?=htmlspecialchars((string)$intro_des, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:image" content="<?=$img_url_attr?>"/>
    <meta property="og:novel:category" content="<?=htmlspecialchars((string)$sortname, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:novel:author" content="<?=htmlspecialchars((string)$author, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:novel:book_name" content="<?=htmlspecialchars((string)$articlename, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:novel:read_url" content="<?=htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:url" content="<?=htmlspecialchars($canonical_raw, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:novel:status" content="<?=htmlspecialchars((string)$isfull, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:novel:author_link" content="<?=htmlspecialchars(rtrim((string)$site_url, '/') . (string)$author_url, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:novel:update_time" content="<?=htmlspecialchars((string)$lastupdate, ENT_QUOTES, 'UTF-8')?>" />
    <meta property="og:novel:latest_chapter_name" content="<?=htmlspecialchars((string)$lastchapter, ENT_QUOTES, 'UTF-8')?>"/>
    <meta property="og:novel:latest_chapter_url" content="<?=htmlspecialchars(rtrim((string)$site_url, '/') . (string)$last_url, ENT_QUOTES, 'UTF-8')?>"/>
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?=$site_home_url_attr?>" title="<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li><a href="<?=$sort_url_attr?>"><?=$sortname?></a></li>
        <li class="active"><?=$articlename?></li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2 hidden-xs"><img class="img-thumbnail" alt="<?=$articlename?>" src="<?=$img_url_attr?>" title="<?=$articlename?>" width="140" height="180" /></div>
                <div class="col-sm-10 pl0">
                    <h1 class="bookTitle"><?=$articlename?></h1>
                    <p class="booktag">
                        <a class="red" href="<?=$author_url_attr?>" title="<?=$author?>"><i class="glyphicon glyphicon-user fs-12" aria-hidden="true"></i> <?=$author?></a>
                        <span class="blue"><i class="glyphicon glyphicon-font fs-12" aria-hidden="true"></i> <?=$words_w?>万字</span>
                        <span class="blue"><i class="glyphicon glyphicon-hourglass fs-12" aria-hidden="true"></i> <?=$isfull?></span>
                        <span class="blue"><i class="glyphicon glyphicon-time fs-12" aria-hidden="true"></i> <?=$lastupdate_cn?></span>
                    </p>
                    <p id="bookIntro" class="text-justify"><?=$intro_html?></p>
                    <hr/>
                    <div class="bookmore">
                        <a class="btn btn-danger" href="<?=$first_url_attr?>" rel="nofollow"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> 全文阅读</a>
                        <?php if ($index_url_raw !== ''): ?><a class="btn btn-success" href="<?=$index_url_attr?>" rel="nofollow"><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> 章节目录</a><?php endif; ?>
                        <div class="clear"></div>
                    </div>
                    <hr/>
                    <p>最新章节：<a class="text-danger" href="<?=$last_url_attr?>" title="<?=$lastchapter?>"><?=$lastchapter?></a></p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <?php if (!empty($langtailrows) && is_array($langtailrows)): ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <strong>相关推荐：</strong>
            <?php foreach ($langtailrows as $v): ?>
                <a href="<?=$v['info_url']?>"><?=$v['langname']?></a>&nbsp;
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 最新12章</div>
        <dl class="panel-body panel-chapterlist">
            <?php if (!empty($lastarr) && is_array($lastarr)): ?><?php foreach ($lastarr as $v): ?>
                <dd class="col-sm-4"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></dd>
            <?php endforeach; ?><?php endif; ?>
            <div class="clear"></div>
        </dl>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> 顺序1-50章</div>
        <dl class="panel-body panel-chapterlist" id="newlist">
            <?php $i = 0; if (!empty($chapterrows) && is_array($chapterrows)): foreach ($chapterrows as $v): if ($i >= 50) break; ?>
                <dd class="col-sm-4"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></dd>
            <?php $i++; endforeach; endif; ?>
            <div class="clear"></div>
        </dl>
    </div>

    <?php if ($index_url_raw !== ''): ?>
    <div class="panel panel-default">
        <div class="panel-body" style="text-align:center;">
            <a class="btn btn-primary" href="<?=$index_url_attr?>" rel="nofollow">查看更多章节目录</a>
        </div>
    </div>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 相关小说推荐<a class="pull-right" href="<?=$sort_url_attr?>">More+</a>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php if (!empty($neighbor) && is_array($neighbor)): ?><?php foreach ($neighbor as $k => $v): ?><?php if ($k < 6): ?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5">
                            <a href="<?=$v['info_url']?>" class="thumbnail" style="background-image:url(<?=$v['img_url']?>)"></a>
                        </div>
                        <div class="col-sm-7 pl0">
                            <div class="caption">
                                <h4 class="fs-16 text-muted"><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></h4>
                                <small class="fs-14 text-muted"><?=$v['author']?></small>
                                <p class="fs-12 text-justify hidden-xs"><?=$v['intro_des']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?><?php endforeach; ?><?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <p class="hidden-xs">《<?=$articlename?>》所有内容均来自互联网或网友上传，<?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?>只为原作者<?=$author?>的小说进行宣传。欢迎各位书友支持<?=$author?>并收藏《<?=$articlename?>》最新章节。</p>
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
