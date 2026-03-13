<?php
// shipsay/seo.php
// 分站 SEO/TDK 渲染：总控下发 seo_*_tpl 为主，shipsay/configs/seo_tpl.php 为本地默认兜底。
// 最后一层兜底仍由模板自身负责，避免页面 title/keywords/description 完全空白。

if (!defined('__ROOT_DIR__')) { exit; }

if (!function_exists('ss_seo_try_load_local_tpl_defaults')) {
  function ss_seo_try_load_local_tpl_defaults(){
    static $loaded = false;
    if ($loaded) return;
    $loaded = true;

    global $seo_profile,
      $seo_home_title_tpl, $seo_home_keywords_tpl, $seo_home_desc_tpl,
      $seo_info_title_tpl, $seo_info_keywords_tpl, $seo_info_desc_tpl,
      $seo_indexlist_title_tpl, $seo_indexlist_keywords_tpl, $seo_indexlist_desc_tpl,
      $seo_reader_title_tpl, $seo_reader_keywords_tpl, $seo_reader_desc_tpl,
      $seo_category_title_tpl, $seo_category_keywords_tpl, $seo_category_desc_tpl,
      $seo_author_title_tpl, $seo_author_keywords_tpl, $seo_author_desc_tpl,
      $seo_search_title_tpl, $seo_search_keywords_tpl, $seo_search_desc_tpl,
      $seo_rank_title_tpl, $seo_rank_keywords_tpl, $seo_rank_desc_tpl;

    $file = __ROOT_DIR__ . '/shipsay/configs/seo_tpl.php';
    if (is_file($file)) {
      require $file;
    }
  }
}

if (!function_exists('ss_seo_render')) {
  function ss_seo_render($page){
    $page = (string)$page;

    $k_title = 'seo_'.$page.'_title_tpl';
    $k_kw    = 'seo_'.$page.'_keywords_tpl';
    $k_desc  = 'seo_'.$page.'_desc_tpl';

    $title_tpl = isset($GLOBALS[$k_title]) ? (string)$GLOBALS[$k_title] : '';
    $kw_tpl    = isset($GLOBALS[$k_kw]) ? (string)$GLOBALS[$k_kw] : '';
    $desc_tpl  = isset($GLOBALS[$k_desc]) ? (string)$GLOBALS[$k_desc] : '';

    // 主链路没有拿到时，回退到本地 seo_tpl.php 默认模板
    if ($title_tpl === '' || $kw_tpl === '' || $desc_tpl === '') {
      ss_seo_try_load_local_tpl_defaults();
      if ($title_tpl === '' && isset($GLOBALS[$k_title])) $title_tpl = (string)$GLOBALS[$k_title];
      if ($kw_tpl === '' && isset($GLOBALS[$k_kw])) $kw_tpl = (string)$GLOBALS[$k_kw];
      if ($desc_tpl === '' && isset($GLOBALS[$k_desc])) $desc_tpl = (string)$GLOBALS[$k_desc];
    }

    // 最后一层保底：避免模板输出完全空白
    if ($title_tpl === '') $title_tpl = '{SITE_NAME}';
    if ($kw_tpl === '') $kw_tpl = '{SITE_NAME}';
    if ($desc_tpl === '') $desc_tpl = '{SITE_NAME}';

    $map = [
      '{SITE_NAME}'   => defined('SITE_NAME') ? (string)SITE_NAME : '',
      '{articlename}' => isset($GLOBALS['articlename']) ? (string)$GLOBALS['articlename'] : (isset($GLOBALS['articlename_safe']) ? (string)$GLOBALS['articlename_safe'] : ''),
      '{author}'      => isset($GLOBALS['author']) ? (string)$GLOBALS['author'] : '',
      '{chaptername}' => isset($GLOBALS['chaptername']) ? (string)$GLOBALS['chaptername'] : '',
      '{sortname}'    => isset($GLOBALS['sortname']) ? (string)$GLOBALS['sortname'] : '',
      '{page}'        => isset($GLOBALS['page']) ? (string)$GLOBALS['page'] : (isset($GLOBALS['pid']) ? (string)$GLOBALS['pid'] : (isset($GLOBALS['now_pid']) ? (string)$GLOBALS['now_pid'] : '')),
      '{searchkey}'   => isset($GLOBALS['searchkey']) ? (string)$GLOBALS['searchkey'] : '',
      '{ranktitle}'   => isset($GLOBALS['page_title']) ? (string)$GLOBALS['page_title'] : '',
      '{intro_p}'     => isset($GLOBALS['intro_p']) ? (string)$GLOBALS['intro_p'] : (isset($GLOBALS['intro_des']) ? (string)$GLOBALS['intro_des'] : ''),
    ];

    $seo_title = strtr($title_tpl, $map);
    $seo_keywords = strtr($kw_tpl, $map);
    $seo_description = strtr($desc_tpl, $map);

    if (isset($map['{page}']) && (string)$map['{page}'] === '1') {
      $seo_title = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_title);
      $seo_keywords = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_keywords);
      $seo_description = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_description);
    }

    return [$seo_title, $seo_keywords, $seo_description];
  }
}
?>
