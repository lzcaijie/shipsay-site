<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$searchkey_safe = isset($searchkey) ? trim($searchkey) : '';
?>
<title><?php if($searchkey_safe !== ''): ?>搜索“<?=$searchkey_safe?>”的结果<?php else: ?>搜索小说<?php endif ?>-<?=SITE_NAME?></title>

<style type="text/css">
    .list-item{border-bottom:1px dashed #D4D4D4;padding:5px;width:100%;}
    .list-item .article{height:100px; overflow:hidden; line-height:20px;}
    .list-item .fs12{font-size: 12px;}
    .list-item .red{color:red;}
    .list-item .gray{color:#7d7d7d;}
    .list-item .count{color:#333333;}
    .list-item .mr15{margin-right: 15px;}
</style>

<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <a href="/bookcase/" rel="nofollow" class="bookcase">我的书架</a>
    <h1>搜索小说</h1>
</div>

<div class="waps_r">
    <div class="search">
        <?php require_once 'tpl_search_form.php'; ?>
    </div>
</div>

<?php if($searchkey_safe !== ''): ?>
    <h1 class="search-title">搜索<span class="red"><?=$searchkey_safe?></span>的结果</h1>
<?php endif; ?>

<?php if(!empty($search_res) && is_array($search_res)): ?>
    <?php foreach($search_res as $k => $v): ?>
        <table class="list-item">
            <tr>
                <td width="80">
                    <a href="<?=$v['info_url']?>">
                        <img src="<?=$v['img_url']?>" width="80" height="100" alt="<?=$v['articlename']?>" />
                    </a>
                </td>
                <td>
                    <div class="article">
                        <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
                        <br/>
                        <p class="fs12 gray">
                            <span class="mr15">作者:<?=$v['author']?></span>
                            阅读:<span class="count"><?=$v['allvisit']?></span>
                        </p>
                        <a href="<?=$v['info_url']?>"><span class="fs12 gray"><?=$v['intro_des']?></span></a>
                    </div>
                </td>
            </tr>
        </table>
    <?php endforeach; ?>
<?php else: ?>
    <?php if($searchkey_safe !== ''): ?>
        <div style="padding:12px;color:#999;">未找到相关结果</div>
    <?php endif; ?>
<?php endif; ?>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
