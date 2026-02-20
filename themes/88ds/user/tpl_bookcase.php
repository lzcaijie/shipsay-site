<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
    <title>我的书架-<?=SITE_NAME?></title>
<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>

<body>
    <div class="header">
      <div class="back">
        <a href="javascript:history.go(-1);">返回</a>
      </div>
      <h1> 我的书架</h1>
      <div class="reg">
        <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
        <a href="/" class="login_topbtn c_index_login">首页</a>
      </div>
    </div>
	<?php require_once __THEME_DIR__  . '/tpl_search_form.php'; ?>
	<div id="content">
<style>
.block, .blockc, .blockb, .blockn {background: #fff;color: #333;}.blockcontent {padding: 0.8em;}
.blockcontent .c_row {padding: 0.8em 0;}.c_row {border-bottom: 1px dotted #e8e8e8;padding: 0.5em;}
.df {display: -webkit-box;display: box;display: -webkit-flex;display: flex;}
.cf, .row, .frow, .form {*zoom: 1;}.row_cover {flex: 0 0 84px;overflow: hidden;}.db {display: block;}.cover_i img, img.cover_i {width: 72px;height: 96px;}
img {border: 0;vertical-align: middle;}.cf:after, .row:after, .frow:after, .form:after {content: ".";display: block;height: 0;font-size: 0;clear: both;visibility: hidden;}
*, *:before, *:after {-webkit-box-sizing: inherit;-moz-box-sizing: inherit;box-sizing: inherit;}.row_text, .row_textl {width: 100%;overflow: hidden;}.row_text h4, .row_textl h4 {font-weight: normal;overflow: hidden;text-overflow: ellipsis;word-break: break-all;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;}
h1, h2, h3, h4, h5, h6 {font-size: 1rem;}a {color: #333;text-decoration: none;background-color: transparent;}.cl_gray, a.cl_gray, .gray, a.gray {color: #818a91;}
.mt {margin-top: 0.5em;}.button.warning, .button.b_hot, .btnlink.warning, .btnlink.b_hot, .filebutton.warning, .filebutton.b_hot {background: #208181;}
a.button, a.btnlink {text-decoration: none;}
.button, .btnlink, .filebutton {display: inline-block;cursor: pointer;text-decoration: none;vertical-align: middle;line-height: 1.4;padding: 0.45em 0.6em;margin: 0 0.2em;color: #fff;background: #95a5a6;border: 2px solid transparent;border-radius: 3px;}
</style>

<div class="blockb">
<div class="blockcontent" id="jieqi_page_contents">
	<?php foreach($caseArr as $k => $v): ?>   
	<div class="c_row cf df" id="<?=$v['articleid']?>">
	<div class="row_cover">
	<a class="db cf" href="<?=$v['info_url']?>">
	<img class="cover_i" src="<?=$v['img_url']?>">
	</a>
	</div>
	<div class="row_text">
	<h4><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a></h4>
    <p class="gray" style="line-height:2">
	最新：<a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a>
	</p>
	<p class="mt"><?php if($v['chaptername'] !='0'): ?><a class="btnlink b_hot" href="<?=$v['case_url']?>">继续阅读</a><?php else:?><a class="btnlink b_hot" href="#">暂无书签</a><?php endif ?> &nbsp; <a class="btnlink b_gray" href="javascript:;" onclick="delbookcase('<?=$v['articleid']?>')">移出书架</a></p>
	</div>
	</div>
	<?php endforeach ?>  
</div>
</div>
</form>
</div>
<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>