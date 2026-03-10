<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
require_once __ROOT_DIR__.'/shipsay/seo.php';
list($seo_title,$seo_keywords,$seo_description) = ss_seo_render('rank');
$rank_entry_raw = !empty($rank_entry_url) ? (string)$rank_entry_url : (!empty($fake_top) ? (string)$fake_top : '');
$sections = isset($top_sections) && is_array($top_sections) ? $top_sections : [];
$rank_lists = isset($top_rank_lists) && is_array($top_rank_lists) ? $top_rank_lists : [];
$rank_limit = isset($top_rank_limit) && (int)$top_rank_limit > 0 ? (int)$top_rank_limit : 10;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
<meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
<?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<div class="container" style="max-width:1200px;margin:0 auto;padding:12px;">
  <h1 style="font-size:18px;margin:10px 0;">排行榜</h1>
  <?php if(!empty($sections)): ?>
  <div style="margin:10px 0;display:flex;flex-wrap:wrap;gap:10px;">
    <?php foreach($sections as $key => $conf): ?>
      <?php $more_url = isset($conf['more']) ? (string)$conf['more'] : ''; ?>
      <?php $title_text = isset($conf['title']) ? (string)$conf['title'] : '榜单'; ?>
      <?php if($more_url !== ''): ?><a href="<?=htmlspecialchars($more_url, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($title_text, ENT_QUOTES, 'UTF-8')?></a><?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php foreach($sections as $key => $conf): ?>
    <?php
      $title_text = isset($conf['title']) ? (string)$conf['title'] : '榜单';
      $more_url = isset($conf['more']) ? (string)$conf['more'] : '';
      $list = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
    ?>
    <div style="margin:14px 0;padding:12px;border:1px solid #eee;border-radius:8px;">
      <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
        <strong><?=htmlspecialchars($title_text, ENT_QUOTES, 'UTF-8')?></strong>
        <?php if($more_url !== ''): ?><a href="<?=htmlspecialchars($more_url, ENT_QUOTES, 'UTF-8')?>">更多</a><?php endif; ?>
      </div>
      <ol style="margin:10px 0 0 18px;line-height:1.8;">
        <?php if(!empty($list)): ?>
          <?php foreach($list as $k => $v): ?><?php if($k >= $rank_limit) break; ?>
            <li>
              <a href="<?=htmlspecialchars((string)$v['info_url'], ENT_QUOTES, 'UTF-8')?>" title="<?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars((string)$v['articlename'], ENT_QUOTES, 'UTF-8')?></a>
              <span style="opacity:.7;margin-left:8px;"><?=htmlspecialchars((string)$v['author'], ENT_QUOTES, 'UTF-8')?></span>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li style="opacity:.7;">暂无数据</li>
        <?php endif; ?>
      </ol>
    </div>
  <?php endforeach; ?>

  <?php if(empty($sections) && $rank_entry_raw !== ''): ?>
    <p style="opacity:.7;">当前暂无聚合榜数据，可返回单榜继续查看：<a href="<?=htmlspecialchars($rank_entry_raw, ENT_QUOTES, 'UTF-8')?>">排行榜</a></p>
  <?php endif; ?>
</div>
<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
