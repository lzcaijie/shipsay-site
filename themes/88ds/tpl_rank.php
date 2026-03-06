<?php if (!defined('__ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <?php
  require_once __ROOT_DIR__ . '/shipsay/seo.php';
  list($seo_title, $seo_keywords, $seo_description) = ss_seo_render('rank');
  ?>
  <title><?=htmlspecialchars($seo_title, ENT_QUOTES, 'UTF-8')?></title>
  <meta name="keywords" content="<?=htmlspecialchars($seo_keywords, ENT_QUOTES, 'UTF-8')?>">
  <meta name="description" content="<?=htmlspecialchars($seo_description, ENT_QUOTES, 'UTF-8')?>">
  <?php require_once __THEME_DIR__ . '/tpl_header.php'; ?>
<body>
<?php
$rank_entry_url = isset($rank_entry_url) && $rank_entry_url ? $rank_entry_url : ((isset($fake_top) && $fake_top) ? $fake_top : '/rank/');
$rank_detail_base = isset($rank_detail_base) && $rank_detail_base ? $rank_detail_base : $rank_entry_url;
$rank_sections = [
    'monthvisit' => ['title' => '月点击榜', 'field' => 'monthvisit', 'more' => $rank_detail_base . 'monthvisit/'],
    'weekvisit'  => ['title' => '周点击榜', 'field' => 'weekvisit',  'more' => $rank_detail_base . 'weekvisit/'],
    'allvisit'   => ['title' => '总点击榜', 'field' => 'allvisit',   'more' => $rank_detail_base . 'allvisit/'],
    'allvote'    => ['title' => '推荐榜',   'field' => 'allvote',    'more' => $rank_detail_base . 'allvote/'],
    'goodnum'    => ['title' => '收藏榜',   'field' => 'goodnum',    'more' => $rank_detail_base . 'goodnum/'],
];

$rank_lists = [];
foreach ($rank_sections as $key => $conf) {
    $rank_lists[$key] = [];

    if (!isset($conf['field']) || empty($conf['field'])) continue;
    if (!isset($rico_sql) || empty($rico_sql)) continue;

    $field = preg_replace('/[^a-z0-9_]/i', '', $conf['field']);
    if ($field === '') continue;

    $sql = $rico_sql . 'ORDER BY ' . $field . ' DESC LIMIT 10';

    if (isset($redis)) {
        $rank_lists[$key] = $redis->ss_redis_getrows($sql, (isset($home_cache_time) ? $home_cache_time : 300));
    } elseif (isset($db)) {
        $rank_lists[$key] = $db->ss_getrows($sql);
    }

    if (!is_array($rank_lists[$key])) $rank_lists[$key] = [];
}
?>

  <div class="header">
    <div class="back">
      <a href="javascript:history.go(-1);">返回</a>
    </div>
    <h1>小说排行榜</h1>
    <div class="reg">
      <a href="javascript:st();void 0;" id="st" rel="nofollow" class="login_topbtn c_index_login">繁</a>
      <a href="/" class="login_topbtn c_index_login">首页</a>
    </div>
  </div>

  <?php require_once 'tpl_search_form.php'; ?>

  <div id="content">
    <div class="article">
      <div class="article">
        <h2><span>榜单导航</span></h2>
        <div class="block">
          <ul>
            <?php foreach ($rank_sections as $key => $conf): ?>
              <li><a href="<?=$conf['more']?>"><?=$conf['title']?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <?php foreach ($rank_sections as $key => $conf): ?>
        <?php
          $title = isset($conf['title']) ? $conf['title'] : '';
          $more  = isset($conf['more']) ? $conf['more'] : '#';
          $list  = isset($rank_lists[$key]) && is_array($rank_lists[$key]) ? $rank_lists[$key] : [];
        ?>

        <div class="article">
          <h2><span><a href="<?=$more?>"><?=$title?></a></span><a style="float:right;font-size:12px;font-weight:normal;color:#999;" href="<?=$more?>">更多 &gt;</a></h2>
          <div class="block">
            <ul>
              <?php if (!empty($list)): ?>
                <?php foreach ($list as $k => $v): ?><?php if ($k < 10): ?>
                  <?php
                    $info_url = (isset($v['info_url']) && $v['info_url']) ? $v['info_url'] : '';
                    $name = (isset($v['articlename']) && $v['articlename']) ? $v['articlename'] : '';
                    $author = (isset($v['author']) && $v['author']) ? $v['author'] : '';
                    if ($info_url === '' || $name === '') continue;
                  ?>
                  <li><span style="color:#999;margin-right:6px;"><?=($k+1)?>.</span><a href="<?=$info_url?>"><?=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?></a><?php if ($author !== ''): ?> / <?=htmlspecialchars($author, ENT_QUOTES, 'UTF-8')?><?php endif; ?></li>
                <?php endif; ?><?php endforeach; ?>
              <?php else: ?>
                <li>暂无数据</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

<?php require_once __THEME_DIR__ . '/tpl_footer.php'; ?>
