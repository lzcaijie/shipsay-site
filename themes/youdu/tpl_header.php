<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$top_url_safe = !empty($fake_top) ? $fake_top : '/rank/';
$search_url_safe = function_exists('ss_search_url') ? ss_search_url() : ((isset($fake_search) && $fake_search) ? $fake_search : '/search/');
$recent_url_safe = !empty($fake_recentread) ? $fake_recentread : '/history.html';
?>

<!-- start header -->
<div class="g_header fs16">
    <div class="g_wrap cf">
        <div class="fl">
            <a href="/" title="<?=SITE_NAME?>" class="g_logo">
                <h1 class="hide"><?=SITE_NAME?></h1>
                <svg><use xlink:href="#i-logo"></use></svg>
            </a>

            <nav class="fl">
                <ol class="fs0 wsn">
                    <li class="vam dib g_dropdown _hover g_browse">
                        <a class="g_drop_hd g_hd_link" href="javascript:" title="浏览书库">
                            <svg><use xlink:href="#i-browse"></use></svg>
                            <strong>书库</strong>
                        </a>
                        <div class="g_drop_bd _dark wsn j_browse_bd g_browse_list">
                            <ul class="fs16">
                                <?php
                                $sorthead = Sort::ss_sorthead();
                                if (!empty($sorthead) && is_array($sorthead)):
                                    foreach ($sorthead as $k => $v):
                                ?>
                                    <li class="pr">
                                        <a class="g_browse_link_main g_drop_item" href="<?=$v['sorturl']?>" title="<?=$v['sortname']?>"><?=$v['sortname']?></a>
                                    </li>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                        </div>
                    </li>

                    <li class="vam dib g_dropdown _hover">
                        <a class="g_drop_hd g_hd_link" href="javascript:" title="排行榜">
                            <svg><use xlink:href="#i-ranking"></use></svg><strong>排行</strong>
                        </a>
                        <p class="g_drop_bd _dark">
                            <a class="g_drop_item" href="<?=$top_url_safe?>" title="点击榜"><svg><use xlink:href="#i-dianji"></use></svg>点击榜</a>
                            <a class="g_drop_item" href="/rank/goodnum/" title="收藏榜"><svg><use xlink:href="#i-shoucang"></use></svg>收藏榜</a>
                            <a class="g_drop_item" href="/rank/allvote/" title="推荐榜"><svg><use xlink:href="#i-tuijian"></use></svg>推荐榜</a>
                        </p>
                    </li>

                    <li class="vam dib g_dropdown _hover">
                        <a class="g_hd_link" href="<?=$search_url_safe?>" title="搜索">
                            <svg class="mr10"><use xlink:href="#i-search"></use></svg>
                            <span>搜索</span>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="fr j_loginWrap">
            <a class="g_hd_link g_lib" href="<?=$recent_url_safe?>" rel="nofollow">书架</a>
            <a class="g_hd_link g_msg" href="/" target="_top">信息</a>
            <span class="fr pt5 g_user g_drop_sel">
                <a class="bhn" href="javascript:;" rel="nofollow"><svg class="_hd"><use xlink:href="#i-hd"></use></svg></a>
                <ul class="_bd">
                    <li><a href="/">注册</a></li>
                    <li><a href="/" class="j_logout">登录</a></li>
                </ul>
            </span>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/history.js"></script>
<!-- end header -->