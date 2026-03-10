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
<head>
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('info');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
    <meta property="og:type" content="novel">
    <meta property="og:title" content="<?=$articlename?>">
    <meta property="og:description" content="《<?=$articlename?>》<?=$intro_des?>">
    <meta property="og:image" content="<?=$img_url?>"/>
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
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
  <div class="container">
        <div class="row row-detail">
            <div class="layout layout-col1">
                <h2 class="layout-tit"><a href="/"><?=SITE_NAME?></a> > <?=$articlename?>最新章节列表</h2>
                <div class="detail-box">
                    <div class="imgbox">
                        <img alt="<?=$articlename?>" src="<?=$img_url?>"  onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg'"  />
                        
                                <i class="flag xs-hidden"></i>
                        
                    </div>
                    <div class="info">
                        <div class="top">
                            <h1><?=$articlename?></h1>
                            <div class="fix">
                                <p>作&nbsp;&nbsp;者：<a href="<?=$author_url?>"><?=$author?></a></p>
                                <p class="xs-show">类&nbsp;&nbsp;别：<?=$sortname?></p>
                                <p class="xs-show">状&nbsp;&nbsp;态：<?=$isfull?></p>
                                <p class="opt"> <span class="xs-hidden"> 动&nbsp;&nbsp;作：</span>
                                  <a href="<?=$first_url?>" class="xs-show btn-read">开始阅读</a>
                                  <a rel="nofollow" href="#footer" class="btn-tobtm">直达底部</a> <i class="xs-hidden">、</i>
                                </p>
                                <p>最后更新：<?=$lastupdate?> </p>
                               <p>字&nbsp;&nbsp;数：<span><?=$words_w?> 万</span></p>
                            </div>
                        </div>
                        <div class="desc xs-hidden" >
                          <?=$intro_des?>
                        </div>
                    </div>
                    <div class="m-desc xs-show">
                        <strong>简介:</strong>
                        <?=$intro_des?>
                    </div>
                </div>
            </div>
            相关小说：
<?php foreach ($langtailrows as $v) : ?>
<a href="<?=$v['info_url']?>" title="<?= $v['langname'] ?>"><?= $v['langname'] ?></a>、
<?php endforeach ?></br>
        
        </div>
  <div class="row row-section">
            <div class="layout layout-col1">
                <h2 class="layout-tit">《<?=$articlename?>》最新章节</h2>
                <div class="section-box">
                    <ul class="section-list fix">
                <?php if($lastarr != ''): ?><?php foreach($lastarr as $k => $v): ?>
                 <li><a href="<?=$v['cid_url'] ?>"><?=$v['cname'] ?></a></li>
                <?php endforeach ?><?php endif ?>
          </ul>
                </div>

<h2 class="layout-tit">《<?=$articlename?>》正文（显示前50章）</h2>
                <div class="section-box">
                    <ul class="section-list fix">
                <?php
                // 详情页没有 $list_arr，直接用 $chapterrows 输出前50章（不分页）
                $chapterCount = 0;
                foreach($chapterrows as $v):
                    if ($chapterCount >= 50) break;
                ?>
                    <li><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></li>
                <?php
                    $chapterCount++;
                endforeach;
                ?>
                    </ul>
                </div>
    
    <!-- 查看完整目录链接 -->
    <div style="text-align:center; margin:20px 0;">
        <a href="<?=$index_url_safe?>" style="display:inline-block; padding:10px 25px; background:#4285f4; color:white; text-decoration:none; border-radius:4px; font-weight:bold;">
            查看完整目录
        </a>
    </div>
    
    <!-- 详情页无分页 -->
    <div class="index-container"></div>

    </div>
			<div class="clr"></div>
				</dl>
			</div>
    
    </section>

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
