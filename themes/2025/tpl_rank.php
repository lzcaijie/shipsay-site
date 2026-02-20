<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<title><?=$page_title?> - <?=SITE_NAME?></title>
<meta name="keywords" content="小说排行榜,<?=$page_title?>,<?=SITE_NAME?>" />
<meta name="description" content="<?=SITE_NAME?>提供<?=$page_title?>，展示热门小说排行。" />
<link rel="canonical" href="<?=$site_url?>/rank/<?=$query?>/">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="applicable-device" content="pc,mobile">

<link rel="stylesheet" href="/static/<?=$theme_dir?>/css/2025.css?v=20221207" />
</head>

<body class="rank-page">

<?php require_once 'tpl_header.php'; ?>

<div class="container visible-xs">
  <div class="header-m">
    <a class="header-m-left" href="javascript:window.history.go(-1);">
      <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path d="M358.997 512l311.168-311.168a42.667 42.667 0 1 0-60.33-60.33L268.5 481.834a42.667 42.667 0 0 0 0 60.33L609.835 883.5a42.667 42.667 0 0 0 60.33-60.331L358.997 512z"></path></svg>
    </a>
    <div class="header-m-center"><?=$page_title?></div>
    <a class="header-m-right" href="/">
      <svg class="icon" viewBox="0 0 1025 1024" xmlns="http://www.w3.org/2000/svg"><path d="M938.977859 1024c-100.292785 0-198.718416 0-298.210992 0 0-113.362855 0-226.458974 0-340.355301-85.889034 0-170.17765 0-255.799948 0 0 112.829383 0 225.658765 0 339.821829-100.292785 0-199.251889 0-299.277937 0 0-4.534514 0-8.802292 0-13.07007 0-176.579318 0-352.891899 0.266736-529.471216 0-5.868195 3.46757-13.870279 8.002084-17.604585 138.436051-111.228966 277.138838-222.191196 416.108362-333.153425 0.533472-0.533472 1.600417-0.800208 3.200834-1.333681 45.345142 36.276114 91.223756 72.818963 136.835634 109.361813 91.490492 73.352436 182.980985 146.704871 275.004949 219.523834 10.402709 8.26882 14.403751 16.53764 14.403751 29.874446-0.533472 173.911956-0.266736 347.557176-0.266736 521.469133C938.977859 1013.864027 938.977859 1018.932014 938.977859 1024z"></path></svg>
    </a>
  </div>
</div>

<div class="container">
  <ol class="navigator">
    <li><a href="/"><?=SITE_NAME?></a></li>
    <li class="active"><?=$page_title?></li>
  </ol>
</div>

<?php
$title_arr = [
  'allvisit'=>'总排行榜','monthvisit'=>'月排行榜','weekvisit'=>'周排行榜','dayvisit'=>'日排行榜',
  'allvote'=>'总推荐榜','monthvote'=>'月推荐榜','weekvote'=>'周推荐榜','dayvote'=>'日推荐榜',
  'goodnum'=>'收藏榜'
];
?>

<div class="container">

  <div class="rank-switch">
    <div class="rank-switch-title">切换榜单</div>
    <div class="rank-switch-list">
      <?php foreach($title_arr as $k=>$t): ?>
        <a href="/rank/<?=$k?>/" class="<?php if($query==$k):?>active<?php endif;?>"><?=$t?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="rank-list">
    <div class="rank-title">
      <h2><?=$page_title?></h2>
      <span>Top 50</span>
    </div>

    <?php if(!empty($articlerows) && is_array($articlerows)): ?>
      <?php foreach($articlerows as $k => $v): ?>
        <?php $intro = !empty($v['intro_des']) ? $v['intro_des'] : '&nbsp;'; ?>
        <div class="rank-item">
          <a class="cover" href="<?=$v['info_url']?>" title="<?=$v['articlename']?>">
            <img class="lazy"
                 src="/static/<?=$theme_dir?>/nocover.jpg"
                 data-src="<?=$v['img_url']?>"
                 alt="<?=$v['articlename']?>"
                 width="120" height="150"
                 onerror="this.src='/static/<?=$theme_dir?>/nocover.jpg';this.onerror=null;">
            <em>No.<?=($k+1)?></em>
          </a>

          <div class="info">
            <div class="name">
              <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a>
            </div>

            <div class="meta">
              <span><?=$v['author']?></span>
              <?php if(!empty($v['sortname_2'])): ?><i>·</i><span><?=$v['sortname_2']?></span><?php endif; ?>
            </div>

            <!-- ✅ 永远输出简介占位，保证每个卡片高度更一致，减少空洞 -->
            <div class="intro"><?=$intro?></div>

            <div class="tags">
              <span><?=$v['words_w']?>万字</span>
              <span><?=Text::ss_lastupdate($v['lastupdate'])?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div style="padding:20px;color:#888;">暂无排行榜数据</div>
    <?php endif; ?>
  </div>

</div>

<style>
.rank-page .rank-switch-title{font-size:16px !important;font-weight:700 !important;padding:0 0 10px !important;border-bottom:1px solid #f0f0f0 !important;margin:12px 0 !important;}
.rank-page .rank-switch-list{display:flex !important;flex-wrap:wrap !important;gap:10px !important;margin-bottom:18px !important;}
.rank-page .rank-switch-list a{
  display:inline-flex !important;
  align-items:center !important;
  height:34px !important;
  padding:0 14px !important;
  border:1px solid #e9e9e9 !important;
  background:#fff !important;
  border-radius:18px !important;
  white-space:nowrap !important;
  line-height:34px !important;
  color:#333 !important;
  text-decoration:none !important;
}
.rank-page .rank-switch-list a.active{
  background:#ff4a4a !important;
  border-color:#ff4a4a !important;
  color:#fff !important;
  font-weight:700 !important;
}

.rank-page .rank-title{display:flex !important;align-items:flex-end !important;justify-content:space-between !important;margin:8px 0 14px !important;}
.rank-page .rank-title h2{font-size:18px !important;font-weight:700 !important;margin:0 !important;}
.rank-page .rank-title span{color:#999 !important;}

.rank-page .rank-item{
  width:49% !important;
  margin-right:2% !important;
  margin-bottom:16px !important;
  float:left !important;
  box-sizing:border-box !important;
  display:flex !important;
  gap:12px !important;
  align-items:flex-start !important;
}
.rank-page .rank-item:nth-child(2n){margin-right:0 !important;}

.rank-page .rank-item .cover{
  width:120px !important;
  height:150px !important;
  border-radius:8px !important;
  overflow:hidden !important;
  flex:0 0 120px !important;
  position:relative !important;
}
.rank-page .rank-item .cover img{
  width:120px !important;
  height:150px !important;
  object-fit:cover !important;
  display:block !important;
}
.rank-page .rank-item .cover em{
  position:absolute !important;
  left:0 !important;
  bottom:0 !important;
  padding:3px 8px !important;
  background:rgba(0,0,0,.55) !important;
  color:#fff !important;
  font-style:normal !important;
  font-size:12px !important;
}

.rank-page .rank-item .info{flex:1 1 auto !important;}
.rank-page .rank-item .name a{
  font-size:16px !important;
  font-weight:700 !important;
  line-height:1.3 !important;
  color:#222 !important;
  text-decoration:none !important;
  display:block !important;
  max-height:2.6em !important; /* 标题最多两行 */
  overflow:hidden !important;
}
.rank-page .rank-item .meta{margin:6px 0 6px !important;color:#888 !important;}
.rank-page .rank-item .meta i{margin:0 6px !important;color:#bbb !important;font-style:normal !important;}

/* ✅ 简介固定占两行高度：即便没简介也不让卡片变矮 */
.rank-page .rank-item .intro{
  color:#666 !important;
  line-height:1.6 !important;
  min-height:3.2em !important;  /* 两行占位 */
  max-height:3.2em !important;
  overflow:hidden !important;
}

.rank-page .rank-item .tags span{
  display:inline-block !important;
  margin:8px 8px 0 0 !important;
  padding:2px 8px !important;
  border-radius:6px !important;
  background:#f6f6f6 !important;
  color:#666 !important;
  font-size:12px !important;
}

.rank-page .rank-list:after{content:"" !important;display:block !important;clear:both !important;}

@media (max-width:767px){
  .rank-page .rank-item{width:100% !important;margin-right:0 !important;}
  .rank-page .rank-switch-list{gap:8px !important;}
  .rank-page .rank-switch-list a{height:32px !important;padding:0 12px !important;}
}
</style>

<?php require_once 'tpl_footer.php'; ?>
</body>
</html>
