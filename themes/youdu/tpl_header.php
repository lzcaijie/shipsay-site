<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$site_home_url_safe = !empty($site_url) ? (string)$site_url : '/';
$allbooks_url_safe = isset($allbooks_url) && $allbooks_url ? (string)$allbooks_url : '';
$full_allbooks_url_safe = isset($full_allbooks_url) && $full_allbooks_url ? (string)$full_allbooks_url : '';
$search_url_safe = '';
if (function_exists('ss_search_url')) {
    $search_url_safe = (string)ss_search_url();
}
if ($search_url_safe === '' && isset($fake_search) && $fake_search) {
    $search_url_safe = (string)$fake_search;
}
if ($search_url_safe === '') {
    $search_url_safe = '/search/';
}
$recentread_url_safe = isset($fake_recentread) && $fake_recentread ? (string)$fake_recentread : '';
$rank_entry_url_safe = '';
if (isset($rank_entry_url) && $rank_entry_url) {
    $rank_entry_url_safe = (string)$rank_entry_url;
} elseif (isset($fake_top) && $fake_top) {
    $rank_entry_url_safe = (string)$fake_top;
}
$rank_detail_base_safe = isset($rank_detail_base) && $rank_detail_base ? (string)$rank_detail_base : '';
$rank_goodnum_url_safe = $rank_detail_base_safe !== '' ? $rank_detail_base_safe . 'goodnum/' : '';
$rank_allvote_url_safe = $rank_detail_base_safe !== '' ? $rank_detail_base_safe . 'allvote/' : '';
?>

<!-- start header -->
<div class="g_header fs16">
    <div class="g_wrap cf">
        <div class="fl">
            <a href="<?=$site_home_url_safe?>" title="<?=SITE_NAME?>" class="g_logo">
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
                        <?php if ($rank_entry_url_safe !== ''): ?>
                            <a class="g_drop_hd g_hd_link" href="<?=$rank_entry_url_safe?>" title="排行榜">
                                <svg><use xlink:href="#i-ranking"></use></svg><strong>排行</strong>
                            </a>
                        <?php else: ?>
                            <a class="g_drop_hd g_hd_link" href="javascript:" title="排行榜">
                                <svg><use xlink:href="#i-ranking"></use></svg><strong>排行</strong>
                            </a>
                        <?php endif; ?>
                        <p class="g_drop_bd _dark">
                            <?php if ($rank_entry_url_safe !== ''): ?><a class="g_drop_item" href="<?=$rank_entry_url_safe?>" title="聚合榜"><svg><use xlink:href="#i-ranking"></use></svg>聚合榜</a><?php endif; ?>
                            <?php if ($rank_goodnum_url_safe !== ''): ?><a class="g_drop_item" href="<?=$rank_goodnum_url_safe?>" title="收藏榜"><svg><use xlink:href="#i-shoucang"></use></svg>收藏榜</a><?php endif; ?>
                            <?php if ($rank_allvote_url_safe !== ''): ?><a class="g_drop_item" href="<?=$rank_allvote_url_safe?>" title="推荐榜"><svg><use xlink:href="#i-tuijian"></use></svg>推荐榜</a><?php endif; ?>
                        </p>
                    </li>

                    <li class="vam dib g_dropdown _hover">
                        <?php if ($search_url_safe !== ''): ?>
                            <a class="g_hd_link" href="<?=$search_url_safe?>" title="搜索">
                                <svg class="mr10"><use xlink:href="#i-search"></use></svg>
                                <span>搜索</span>
                            </a>
                        <?php else: ?>
                            <a class="g_hd_link" href="javascript:;" title="搜索" aria-disabled="true">
                                <svg class="mr10"><use xlink:href="#i-search"></use></svg>
                                <span>搜索</span>
                            </a>
                        <?php endif; ?>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="fr j_loginWrap">
            <a class="g_hd_link" href="<?=$site_home_url_safe?>" target="_top">首页</a>
            <?php if ($full_allbooks_url_safe !== ''): ?>
                <a class="g_hd_link g_msg" href="<?=$full_allbooks_url_safe?>">完本</a>
            <?php elseif ($allbooks_url_safe !== ''): ?>
                <a class="g_hd_link g_msg" href="<?=$allbooks_url_safe?>">书库</a>
            <?php endif; ?>
            <?php if ($recentread_url_safe !== ''): ?>
                <a class="g_hd_link g_lib" href="<?=$recentread_url_safe?>" rel="nofollow">阅读记录</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/<?=$theme_dir?>/js/history.js"></script>
<!-- end header -->
