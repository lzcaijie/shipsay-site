<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title>永久书架_<?=SITE_NAME?></title>

<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>

<div class="user_right">
    <div style="background: #F7F7F7; padding: 8px 0px; font-size: 14px; text-align: center; font-weight: bold; border-bottom: 1px solid #E6E6E6;">会员书架</div>
    <div class="r_2">
        <div id="history">
            <ul>
            <?php foreach($caseArr as $k => $v): ?>
                <li class="bookone">
                    <div class="bcimg"><a href="<?=$v['info_url']?>" target="_blank">
                        <img class="lazy" height="69" width="48" src="<?=Url::nocover_url()?>" data-original="<?=$v['img_url']?>" style="display: inline;"></a>
                    </div>
                    <div class="bcinfo"><div class="casename" style="margin-bottom:5px;">书名：<a href="<?=$v['info_url']?>" target="_blank"><?=$v['articlename']?></a></div>
                    <div class="upcase" style="height:25px;">
                        最新：<a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a>
                    </div>
                    <div class="upcase">
                        书签：<a href="<?php if($v['chaptername'] !=''): ?><?=$v['case_url']?><?php endif ?>"><?php if($v['chaptername'] !=''): ?><?=$v['chaptername']?><?php endif ?></a>
                    </div>
                    <div class="casedel"><a href="javascript:;" onclick="delbookcase('<?=$v['articleid']?>');">删除</a></div></div></li>
            </ul>
        <?php endforeach ?>
        </div>
    </div>
</div>

<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>