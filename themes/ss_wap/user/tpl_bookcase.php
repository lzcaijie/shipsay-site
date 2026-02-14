<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
    <title>我的书架-<?=SITE_NAME?></title>
<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>

<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <a href="/logout/" rel="nofollow" class="bookcase">退出</a>
    <h1>我的书架</h1>
</div>
<div style="margin-top:5px;">
    
    <?php foreach($caseArr as $k => $v): ?>   
    <div class="bookcase-item" id="<?=$v['articleid']?>">
        <a href="<?=$v['info_url']?>" class="book-img"><img style="width:80px; height:100px;" src="<?=$v['img_url']?>"></a>
        <div class="book-info">
            <a class="booktitle" href="<?=$v['info_url']?>"><?=$v['articlename']?></a>
            <p>
                最新：<a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a>
                <br>
                书签：<?php if($v['chaptername'] !=''): ?><a href="<?=$v['case_url']?>"><?=$v['chaptername']?></a><?php endif ?>
                <br>
                <a href="javascript:;" class="book-del" onclick="delbookcase('<?=$v['articleid']?>')">从书架删除</a>
            </p>
        </div>
        <div class="cc"></div>
    </div>
    
    <?php endforeach ?>  
    
</div>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>