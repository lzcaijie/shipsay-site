<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>排行榜-<?=defined('SITE_NAME')?SITE_NAME:''?></title>
<?php
// 尽量走主题头部（加载主题 CSS）
if (defined('__THEME_DIR__') && is_file(__THEME_DIR__ . '/tpl_header.php')) {
    require_once __THEME_DIR__ . '/tpl_header.php';
}
?>
</head>
<body>
<div class="container" style="max-width:1200px;margin:0 auto;padding:12px;">
  <h1 style="font-size:18px;margin:10px 0;">排行榜</h1>
  <div style="margin:10px 0;">
    <?php
      $rank_base = '/' . ((isset($fake_rankstr) && $fake_rankstr) ? trim($fake_rankstr, '/') : 'rank') . '/';
      $top_entry = (isset($fake_top) && $fake_top) ? $fake_top : ($rank_base);
    ?>
    <a href="<?=$top_entry?>" rel="nofollow">聚合榜</a>
    &nbsp;|&nbsp;<a href="<?=$rank_base?>weekvisit/">周榜</a>
    &nbsp;|&nbsp;<a href="<?=$rank_base?>monthvisit/">月榜</a>
    &nbsp;|&nbsp;<a href="<?=$rank_base?>allvisit/">总榜</a>
    &nbsp;|&nbsp;<a href="<?=$rank_base?>goodnum/">收藏榜</a>
    &nbsp;|&nbsp;<a href="<?=$rank_base?>allvote/">推荐榜</a>
  </div>

  <?php $sortCount = is_array($sortarr) ? count($sortarr) : 0; ?>
  <?php for($i=1;$i<=$sortCount;$i++): ?>
    <?php $tmp='allvisit'.$i; $list = isset($$tmp) ? $$tmp : []; ?>
    <div style="margin:14px 0;padding:12px;border:1px solid #eee;border-radius:8px;">
      <div style="display:flex;justify-content:space-between;align-items:center;">
        <strong><?=class_exists('Sort')?Sort::ss_sortname($i,1):('分类'.$i)?>榜</strong>
        <?php if(class_exists('Sort')): ?><a href="<?=Sort::ss_sorturl($i)?>" rel="nofollow">更多</a><?php endif; ?>
      </div>
      <ol style="margin:10px 0 0 18px;line-height:1.8;">
        <?php if(!empty($list) && is_array($list)): ?>
          <?php foreach($list as $k=>$v): if($k>=10) break; ?>
            <li>
              <a href="<?=$v['info_url']?>" title="<?=$v['articlename']?>"><?=$v['articlename']?></a>
              <span style="opacity:.7;margin-left:8px;"><?=$v['author']?></span>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li style="opacity:.7;">暂无数据</li>
        <?php endif; ?>
      </ol>
    </div>
  <?php endfor; ?>
</div>

<?php
// 尽量走主题底部
if (defined('__THEME_DIR__') && is_file(__THEME_DIR__ . '/tpl_footer.php')) {
    require_once __THEME_DIR__ . '/tpl_footer.php';
}
?>
</body>
</html>
