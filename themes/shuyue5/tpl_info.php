<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
// 目录页链接兜底（避免写死 /index/ 破坏后台路由/伪静态配置）
$index_url_safe = '';
if (isset($index_url) && $index_url) {
    $index_url_safe = $index_url;
} elseif (isset($articleid) && $articleid && class_exists('Url') && method_exists('Url', 'index_url')) {
    $index_url_safe = Url::index_url($articleid);
}
?>

<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <link rel="canonical" href="<?=$site_url?><?=$uri?>">
    <meta property="og:type" content="novel"/>
    <meta property="og:title" content="<?=$articlename?>"/>
    <meta property="og:description" content="<?=$intro_des?>"/>
    <meta property="og:image" content="<?=$img_url?>"/>
    <meta property="og:novel:category" content="<?=$sortname?>"/>
    <meta property="og:novel:author" content="<?=$author?>"/>
    <meta property="og:novel:book_name" content="<?=$articlename?>"/>
    <meta property="og:novel:read_url" content="<?=$site_url?><?=$uri?>"/>
    <meta property="og:url" content="<?=$site_url?><?=$uri?>"/>
    <meta property="og:novel:status" content="<?=$isfull?>"/>
    <meta property="og:novel:author_link" content="<?=$site_url?><?=$author_url?>">
    <meta property="og:novel:update_time" content='<?=$lastupdate?>' />
    <meta property="og:novel:latest_chapter_name" content="<?=$lastchapter?>"/>
    <meta property="og:novel:latest_chapter_url" content="<?=$site_url?><?=$last_url?>"/>
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; require_once __ROOT_DIR__ .'/shipsay/include/neighbor.php';?>
<div class="container body-content">
    <ol class="breadcrumb hidden-xs">
        <li><a href="/" title="<?=SITE_NAME?>"><i class="glyphicon glyphicon-home fs-14" aria-hidden="true"></i> 首页</a></li>
        <li><a href="<?=Sort::ss_sorturl($sortid)?>"><?=$sortname?></a></li>
        <li class="active"><?=$articlename?></li>
    </ol>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2 hidden-xs"><img class="img-thumbnail" alt="<?=$articlename?>" src="<?=$img_url?>" title="<?=$articlename?>" width="140" height="180" /></div>
                <div class="col-sm-10 pl0">
                    <h1 class="bookTitle"><?=$articlename?></h1>
                    <p class="booktag">
                        <a class="red" href="<?=$author_url?>" title="<?=$author?>"><i class="glyphicon glyphicon-user fs-12" aria-hidden="true"></i> <?=$author?></a>
                        <span class="blue"><i class="glyphicon glyphicon-font fs-12" aria-hidden="true"></i> <?=$words_w?>万字</span>
                        <span class="blue"><i class="glyphicon glyphicon-hourglass fs-12" aria-hidden="true"></i> <?=$isfull?></span>
                    </p>
                    <p id="bookIntro" class="text-justify">
                        <?=$intro_des?>
                    </p>
                    <hr/>
                    <div class="bookmore">
                        <a class="btn btn-danger" href="<?=$first_url?>" type="button" rel="nofollow"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> 全文阅读</a>
                        <a class="btn btn-success" href="javascript:addbookcase('<?=$articleid?>','<?=$articlename?>','<?=$chapterid?>','<?=$chaptername?>');" rel="nofollow" id="a_addbookcase" type="button"><i class="glyphicon glyphicon-heart-empty" aria-hidden="true"></i> 加入书架</a>
                        <div class="clear"></div>
                    </div>
                    <hr/>
                    <p>
                        最新章节：<a class="text-danger" href="<?=$last_url?>" title="<?=$lastchapter?>"><?=$lastchapter?></a>
                    </p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <p>相关推荐：
            <?php foreach ($langtailrows as $v) : ?>
                <a href="<?= $v['info_url'] ?>"><?= $v['langname'] ?></a>&nbsp;
            <?php endforeach ?>
        </p>

        <div class="panel-heading"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 最新章节列表</div>
        <dl class="panel-body panel-chapterlist">
            <?php if($lastarr != ''): ?><?php foreach($lastarr as $k => $v): ?>
                <dd class="col-sm-4"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></dd>
            <?php endforeach ?><?php endif ?>
        </dl>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> 全部章节目录</div>
        <dl class="panel-body panel-chapterlist" id="newlist">
            <?php
            $i = 0;
            if (!empty($chapterrows) && is_array($chapterrows)):
                foreach($chapterrows as $k => $v):
                    if ($i >= 50) break;
            ?>
                <dd class="col-sm-4"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></dd>
            <?php
                    $i++;
                endforeach;
            endif;
            ?>
            <div class="clear"></div>
        </dl>
    </div>

    <div class="panel panel-default">
        <div class="panel-body" style="text-align: center;">
            <a class="btn btn-primary" href="<?=$index_url_safe?>" rel="nofollow">查看更多章节目录</a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <?=$sortname?>小说相关阅读<a class="pull-right" href="<?=Sort::ss_sorturl($sortid)?>">More+</a>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php foreach($neighbor as $k => $v): ?><?php if($k < 6):?>
                <div class="col-xs-4 book-coverlist">
                    <div class="row">
                        <div class="col-sm-5">
                            <a href="<?=$site_url?><?=$v['info_url']?>" class="thumbnail" style="background-image:url(<?=$v['img_url']?>)"></a>
                        </div>
                        <div class="col-sm-7 pl0">
                            <div class="caption">
                                <h4 class="fs-16 text-muted"><a href="<?=$site_url?><?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></h4>
                                <small class="fs-14 text-muted"><?=$v['author']?></small>
                                <p class="fs-12 text-justify hidden-xs"><?=$v['intro_des']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?><?php endforeach ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <p class="hidden-xs">《<?=$articlename?>》所有内容均来自互联网或网友上传，<?=SITE_NAME?>只为原作者<?=$author?>的小说进行宣传。欢迎各位书友支持<?=$author?>并收藏《<?=$articlename?>》最新章节。</p>
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

<?php $page_end_scripts = '<script src="/static/'.$theme_dir.'/js/user.js"></script>'
    . '<script src="/static/'.$theme_dir.'/js/layer.js"></script>'; ?>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
