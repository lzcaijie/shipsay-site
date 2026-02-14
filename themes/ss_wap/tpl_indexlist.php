<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>《<?=$articlename?>》章节目录_第<?=$pid?>页_<?=SITE_NAME?></title>
    <meta name="keywords" content="《<?=$articlename?>》章节目录_第<?=$pid?>页"/>
    <meta name="description" content="《<?=$articlename?>》章节目录_第<?=$pid?>页"/>

    <style>
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

<?php
$list_arr_safe = (!empty($list_arr) && is_array($list_arr)) ? $list_arr : [];
$htmltitle_safe = isset($htmltitle) ? $htmltitle : '';
?>

<?php require_once 'tpl_header.php'; ?>

<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <a href="/bookcase/" rel="nofollow" class="bookcase">我的书架</a>
</div>

<div class="lb_mulu" id="alllist">
    <div class="lb_mulu">
        <ul class="last9">
            <li class="title"><a href="<?=$info_url?>" class="back">返回《<?=$articlename?>》简介</a></li>

            <?php foreach($list_arr_safe as $k => $v): ?>
                <li class="<?php if($k % 2 != 0):?>even<?php endif?>"><a href="<?=$v['cid_url']?>"><?=$v['cname']?></a></li>
            <?php endforeach ?>

        </ul>
    </div>
    <div class="index-container"><?=$htmltitle_safe?></div>
</div>

<?php require_once 'tpl_footer.php'; ?>
