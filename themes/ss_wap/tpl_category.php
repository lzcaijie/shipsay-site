<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<?php
$sortname_safe = isset($sortname) ? $sortname : '';
$year_safe     = isset($year) ? $year : date('Y');
$retarr_safe   = (!empty($retarr) && is_array($retarr)) ? $retarr : [];
$jump_html_wap_safe = isset($jump_html_wap) ? $jump_html_wap : '';
?>
<title><?=$sortname_safe?>小说排行榜_<?=$year_safe?>年热门<?=$sortname_safe?>小说_<?=SITE_NAME?></title>
<meta name="keywords" content="<?=$sortname_safe?>小说排行榜,<?=$year_safe?>年热门<?=$sortname_safe?>小说,<?=$sortname_safe?>小说排行榜手机阅读" />
<meta name="description" content="<?=SITE_NAME?>提供<?=$year_safe?>年热门<?=$sortname_safe?>，更新最快的<?=$sortname_safe?>小说、无弹窗免费阅读<?=$sortname_safe?>小说排行榜手机阅读。" />
<style type="text/css">
        .list-item{border-bottom:1px dashed #D4D4D4;padding:5px;width:100%;}
        .list-item .article{height:100px; overflow:hidden; line-height:20px;}
        .list-item .fs12{font-size: 12px;}
        .list-item .red{color:red;}
        .list-item .gray{color:#7d7d7d;}
        .list-item .count{color:#333333;}
		.list-item .mr15{margin-right: 15px;}
    .index-container{
        display: flex;
        justify-content: space-between;
        padding: 10px;
    }

    #indexselect{
        width: 49%;
        margin: 0 1rem;
        text-indent: 5px;
        border: none;
        border-bottom: 1px solid #108ee9;
        background: #fff;
        outline: none;
    }
    .index-container-btn{
        background: #65bbec;
        border-radius: 3px;
        height: 34px;
        line-height: 34px;
        text-align: center;
        display: block;
        color: #fff;
        width: 25%;
    }
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>

<body>
<div class="page-head" style="margin-bottom:5px;">
    <a href="/" class="home">首页</a>
    <a href="/bookcase/" rel="nofollow" class="bookcase">我的书架</a>
    <h1><?php if($sortname_safe == ''):?>全本小说<?php endif?><?=$sortname_safe?>排行榜 </h1>
</div>

<?php foreach($retarr_safe as $k => $v): ?>
	<table class="list-item">
      <tr>
        <td width="80"><a href="<?=$v['info_url']?>"><img src="<?=$v['img_url']?>" width="80" height="100" alt="<?=$v['articlename']?>"/></a></td>
        <td>
            <div class="article">
                <a href="<?=$v['info_url']?>"><?=$v['articlename']?></a><?php if($v['isfull'] !="连载"):?><span class="fs12 red">(完)</span><?php endif?>
                <br/>
                <p class="fs12 gray"><span class="mr15">作者:<?=$v['author']?></span></p>
                <a href="<?=$v['info_url']?>"><span class="fs12 gray"><?=$v['intro_des']?></span></a>
            </div>
        </td>
      </tr>
	</table>
<?php endforeach ?>

<div class="index-container"><?=$jump_html_wap_safe?></div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
