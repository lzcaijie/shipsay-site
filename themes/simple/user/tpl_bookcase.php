<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title>永久书架_<?=SITE_NAME?></title>
<style>
    .bookcase-btn{
        border: none;
        background: #fff;
        color: #969ba3;
    }
    h5 a{
        width: unset!important;
        color: #108ee9;
    }
</style>
<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>
<script src="/static/<?=$theme_dir?>/user.js"></script>

<div class="container">
    <div class="content book">
	<h2 class="text-center">会员书架</h2>
    <?php foreach($caseArr as $k => $v): ?>

		<div class="bookbox"><div class="p10">
            <span class="num"><?=$k+1?></span><div class="bookinfo"><h4 class="bookname"><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h4><div class="author">作者：<?=$v['author']?></div><div class="cat"><span>更新到：</span><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?>
</a></div><div class="update"><span>已读到：</span><a href="<?php if($v['chaptername'] !=''): ?><?=$v['case_url']?><?php endif ?>"><?php if($v['chaptername'] !=''): ?><?=$v['chaptername']?><?php endif ?></a></div></div><div class="delbutton"><a href="javascript:;" onclick="delbookcase('<?=$v['articleid']?>');">删除</a></div></div></div>
    <?php endforeach ?>

    </div>
</div>

<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>