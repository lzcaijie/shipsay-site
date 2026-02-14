<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-Hans">
<head>
    <title>与“<?=htmlspecialchars(isset($searchkey)?$searchkey:'', ENT_QUOTES)?>”有关的小说-<?=SITE_NAME?></title>
    <meta name="keywords" content="<?=SITE_NAME?>搜索结果" />
    <meta name="description" content="<?=htmlspecialchars(isset($searchkey)?$searchkey:'', ENT_QUOTES)?>的搜索结果">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="applicable-device" content="pc,mobile">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-title" content="<?=SITE_NAME?>">
    <link rel="apple-touch-icon" href="/static/<?=$theme_dir?>/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir?>/images/favicon.ico" media="screen">
    <link rel="stylesheet" data-ignore="true" href="/static/<?=$theme_dir?>/css/index.css">
    <script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/iconfont.0.6.js" data-ignore="true"></script>
    <script type="text/javascript" src="/static/<?=$theme_dir?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/<?=$theme_dir?>/js/common.js"></script>
    <script>var userlogin = 0;</script>
</head>
<body style="zoom: 1;">
<div class="page">

    <!-- start header -->
    <?php require_once 'tpl_header.php'; ?>
    <!-- end header -->

    <div class="ser-wrap">
        <form id="searchForm" name="t_frmsearch" action="/search" method="post" class="ser-form mb10 pr">
            <input
                type="text"
                name="searchkey"
                placeholder="搜索"
                class="w100p f_serif lh1"
                id="search"
                autocomplete="off"
                value="<?=htmlspecialchars(isset($searchkey)?$searchkey:'', ENT_QUOTES)?>"
            >
            <label for="submit" class="pa t50p l0 _i">
                <svg><use xlink:href="#i-search"></use></svg>
                <button id="submit" type="submit" class="hide">submit</button>
            </label>
        </form>
    </div>

    <div class="ser-wrap">
        <div class="j_result_wrap">
            <div class="j_list_container" id="imgload">
                <!-- start 搜索结果列表 -->
                <ul class="ser-ret lh1d5">

                    <?php if(isset($search_count) && $search_count > 0 && !empty($search_res)): ?>
                        <?php foreach($search_res as $k => $v): ?>
                            <?php
                                $info_url = isset($v['info_url']) ? $v['info_url'] : '#';
                                $img_url  = isset($v['img_url']) ? $v['img_url'] : '';
                                $nopic    = "/static/{$theme_dir}/images/nopic.jpg";
                            ?>
                            <li class="pr pb20 mb20">
                                <a href="<?=$info_url?>" class="g_thumb pa l0 oh" title="<?=htmlspecialchars(isset($v['articlename'])?$v['articlename']:'', ENT_QUOTES)?>">
                                    <img
                                        src="<?=$nopic?>"
                                        <?php if(!empty($img_url)): ?>_src="<?=$img_url?>"<?php endif; ?>
                                        width="140"
                                        height="186"
                                        alt="<?=htmlspecialchars(isset($v['articlename'])?$v['articlename']:'', ENT_QUOTES)?>"
                                        onerror="this.onerror=null;this.src='<?=$nopic?>';"
                                    >
                                </a>

                                <h3 class="mb5 fs20 f_mbo pt5 ell">
                                    <a href="<?=$info_url?>" class="c_strong" title="<?=htmlspecialchars(isset($v['articlename'])?$v['articlename']:'', ENT_QUOTES)?>">
                                        <?=isset($v['articlename'])?$v['articlename']:''?>
                                    </a>
                                </h3>

                                <em class="c_small db mb5 ell ttc fs14">
                                    <svg class="mr5"><use xlink:href="#i-others"></use></svg>
                                    <span class="vam mr10"><?=isset($v['sortname_2'])?$v['sortname_2']:''?></span>
                                    <svg class="mr5"><use xlink:href="#i-pen"></use></svg>
                                    <span class="vam mr10"><?=isset($v['author'])?$v['author']:''?></span>
                                </em>

                                <p class="fs16 mb10 c_strong g_ells"><?=isset($v['intro_des'])?$v['intro_des']:''?></p>

                                <p class="db mb5 ell ttc fs16">
                                    <svg class="mr5"><use xlink:href="#i-all"></use></svg>
                                    <span class="vam">最新章节:
                                        <?php if(!empty($v['last_url'])): ?>
                                            <a href="<?=$v['last_url']?>"><?=isset($v['lastchapter'])?$v['lastchapter']:''?></a>
                                        <?php else: ?>
                                            <?=isset($v['lastchapter'])?$v['lastchapter']:''?>
                                        <?php endif; ?>
                                    </span>
                                </p>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="pr pb20 mb20" style="text-align:center;color:#999;">暂无搜索结果</li>
                    <?php endif; ?>

                </ul>
                <!-- end 搜索结果列表 -->
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

</div>

<!-- start footer -->
<div class="g_footer">
    <div class="g_row">
        <div class="g_col_9">
            <?php require_once 'tpl_footer.php'; ?>
        </div>
    </div>
</div>
<!-- end footer -->

<div class="g_goTop _on" style=""><a href="javascript:;" class="t_on"><svg><use xlink:href="#i-goTop"></use></svg></a></div>
<script async="" type="text/javascript" src="/static/<?=$theme_dir?>/js/transform.js"></script>
<script>
    // 触发一次站内懒加载（有则执行）
    try{ if(typeof imgload === 'function') imgload(); }catch(e){}
    tongji();
</script>
</body>
</html>
