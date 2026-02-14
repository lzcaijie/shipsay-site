<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="cmn-Hans">
<head>
    <meta name="robots" content="noindex,follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>我的书架-<?=SITE_NAME?></title>
    <?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<div class="container body-content">
    <div class="panel panel-default" style="min-height:600px;">
        <div class="panel-heading"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> 我的书架</div>
        <div class="clear"></div>
        <table class="table">
            <tbody>
            <tr>
                <th class="hidden-xs">序号</th>
                <th>书名</th>
                <th>阅读到</th>
                <th class="hidden-xs">作者</th>
                <th style="width:50px;">删除</th>
            </tr>
            <?php foreach($caseArr as $k => $v): ?><?php if($k < 30):?>
            <tr>
                <td class="hidden-xs">No.<?=$k+1?></td>
                <td><a href="<?=$v['info_url']?>" target="_blank"><?=$v['articlename']?></a></td>
                <td><a href="<?=$v['case_url']?>"><?=$v['chaptername']?></a></td>
                <td class="hidden-xs"><?=$v['author']?></td>
                <td class="delbutton"><a class="del_but" href="javascript:;" onclick="delbookcase('<?=$v["articleid"]?>');">删除</a></td>
            </tr>
            <?php endif ?><?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>
<script src="/static/<?=$theme_dir?>/js/user.js"></script>
<script src="/static/<?=$theme_dir?>/js/layer.js"></script>
