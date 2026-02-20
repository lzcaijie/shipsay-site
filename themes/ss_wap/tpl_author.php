<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$author_safe = isset($author) ? trim($author) : '';
$res_safe = (!empty($res) && is_array($res)) ? $res : [];
?>
<title><?=$author_safe?>作品集_<?=$author_safe?>全部小说_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$author_safe?>,<?=$author_safe?>作品集,<?=$author_safe?>全部小说,<?=SITE_NAME?>">
<meta name="description" content="<?=SITE_NAME?>为您提供<?=$author_safe?>作品集，收录<?=$author_safe?>全部小说作品，最新章节免费阅读。">

<style type="text/css">
    .list-item{border-bottom:1px dashed #D4D4D4;padding:5px;width:100%;}
    .list-item .article{height:100px; overflow:hidden; line-height:20px;}
    .list-item .fs12{font-size: 12px;}
    .list-item .red{color:red;}
    .list-item .gray{color:#7d7d7d;}
    .list-item .count{color:#333333;}
    .list-item .mr15{margin-right: 15px;}
</style>

<?php require_once 'tpl_header.php'; ?>

<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <a href="/bookcase/" rel="nofollow" class="bookcase">我的书架</a>
    <h1><?php if($author_safe != ''): ?><?=$author_safe?><?php else: ?>作者<?php endif ?>作品</h1>
</div>

<?php if (!empty($author_safe)): ?>
    <h1 class="search-title">作者：<span class="red"><?=$author_safe?></span></h1>
<?php endif; ?>

<?php if(!empty($res_safe)): ?>
    <?php foreach($res_safe as $k => $v): ?>
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
                        <?php if(isset($v['isfull']) && $v['isfull'] != "连载"):?><span class="fs12 red">(完)</span><?php endif?>
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
    <div style="padding:12px;color:#999;">暂无该作者作品</div>
<?php endif; ?>

<?php require_once 'tpl_footer.php'; ?>
