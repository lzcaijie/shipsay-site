<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$theme_list_limit = isset($category_per_page) ? max(1, (int)$category_per_page) : 20;
$page_end_scripts = '<script>nav_sel(\'nav_top\');</script>';
?>

<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>小说排行榜-<?=$year?>小说排行榜-<?=SITE_NAME?></title>
    <meta name="keywords" content="小说排行榜,<?=SITE_NAME?>排行榜" />
    <meta name="description" content="小说排行榜" />
    <link rel="canonical" href="<?=$site_url?>/rank/">
    <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container body-content">
    <div class="panel panel-default">
        <div class="panel-heading"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 小说排行榜</div>
        <table class="table">
            <tr>
                <th width=48 class="hidden-xs">类型</th>
                <th>书名</th>
                <th class="hidden-xs">最新章节</th>
                <th>作者</th>
                <th class="hidden-xs">字数</th>
                <th width="72">更新</th>
                <th class="hidden-xs" width="64">状态</th>
            </tr>
            <?php if(!empty($articlerows) && is_array($articlerows)): ?>
            <?php foreach($articlerows as $k => $v): ?><?php if($k < $theme_list_limit):?>
            <tr>
                <td class="fs-12 hidden-xs"><?=$v['sortname_2']?></td>
                <td><a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a></td>
                <td class="hidden-xs"><a class="text-muted" href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></td>
                <td class="fs-12 text-muted"><?=$v['author']?></td>
                <td class="fs-12 hidden-xs"><?=$v['words_w']?>万字</td>
                <td class="fs-12"><?=date('m-d',$v['lastupdate'])?></td>
                <td class="fs-12 hidden-xs"><?=$v['isfull']?></td>
            </tr>
            <?php endif ?><?php endforeach ?>
            <?php endif ?>
        </table>
    </div>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
