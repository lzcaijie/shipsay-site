<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>阅读记录 - <?=htmlspecialchars((string)SITE_NAME, ENT_QUOTES, 'UTF-8')?></title>
<style>
.history-box .q_top{display:flex;justify-content:space-between;align-items:center;}
.history-box .q_top .more{float:none;margin:0;}
.history-box .bookcase-item .book-info{width:calc(75% - 10px);}
.history-box .bookcase-item .book-info p{margin:0;color:#666;}
.history-box .bookcase-item .book-info p a{color:#0065B5;}
.history-box .bookcase-item .booktitle{font-size:16px;color:#0065B5;display:block;margin-bottom:4px;}
</style>
<?php require_once __THEME_DIR__ . '/tpl_header.php';?>
</head>
<body>
<div class="page-head">
    <a href="/" class="home">首页</a>
    <h1>阅读记录</h1>
</div>
<div class="s_m history-box">
    <div class="q_top c_big"><p class="c_big_border">最近阅读</p><div class="more"><a href="javascript:removeall();" id="clearRecentRead" rel="nofollow">清空记录</a></div></div>
    <div class="cc"></div>
    <div id="tempBookcase"></div>
</div>
<?php if (!empty($popular) && is_array($popular)): ?>
<div class="s_m">
    <div class="q_top c_big"><p class="c_big_border">猜你喜欢</p></div>
    <div class="cc"></div>
    <?php foreach($popular as $k => $v): if ($k >= 12) break; ?>
        <div class="s_list"><a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?>：《<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>》</a></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<script src="/static/<?=htmlspecialchars((string)$theme_dir, ENT_QUOTES, 'UTF-8')?>/tempbookcase.js"></script>
<script>
showtempbooks();
document.getElementById('clearRecentRead') && document.getElementById('clearRecentRead').addEventListener('click', function(e){
    e.preventDefault();
    if (confirm('确定要清空阅读记录吗？')) {
        removeall();
    }
});
</script>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
