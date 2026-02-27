<?php if (!defined('__ROOT_DIR__')) exit; ?>

<?php
$page_end_scripts = '<script>nav_sel(\'nav_top\');</script>';
?>

<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
    require_once __ROOT_DIR__.'/shipsay/seo.php';
    list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
    ?>
    <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
    <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
    <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
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
            <?php foreach($articlerows as $k => $v): ?><?php if($k < 48):?>
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
