<?php
// shipsay/seo.php
// Subsite SEO/TDK rendering: read seo_*_tpl variables (usually from shipsay/configs/seo_tpl.php or config.ini.php),
// replace placeholders using current page variables, then output.
// This file intentionally does NOT generate random keywords; it only renders fixed templates.

if (!defined('__ROOT_DIR__')) { exit; }

// config.ini.php 为主来源；seo_tpl.php 仅在变量为空时兜底。
$seo_tpl_file = __ROOT_DIR__ . '/shipsay/configs/seo_tpl.php';
if (is_file($seo_tpl_file)) {
  include_once $seo_tpl_file;
}

if (!function_exists('ss_seo_render')) {
  function ss_seo_render($page){
    $page = (string)$page;

    // Read templates (if not set, fallback)
    $k_title = 'seo_'.$page.'_title_tpl';
    $k_kw    = 'seo_'.$page.'_keywords_tpl';
    $k_desc  = 'seo_'.$page.'_desc_tpl';

    $title_tpl = isset($GLOBALS[$k_title]) ? (string)$GLOBALS[$k_title] : '';
    $kw_tpl    = isset($GLOBALS[$k_kw]) ? (string)$GLOBALS[$k_kw] : '';
    $desc_tpl  = isset($GLOBALS[$k_desc]) ? (string)$GLOBALS[$k_desc] : '';

    // Fallback to avoid empty <title>
    if ($title_tpl === '') $title_tpl = '{SITE_NAME}';
    if ($kw_tpl === '')    $kw_tpl    = '{SITE_NAME}';
    if ($desc_tpl === '')  $desc_tpl  = '{SITE_NAME}';

    // Placeholder map
    $map = [
      '{SITE_NAME}'   => defined('SITE_NAME') ? (string)SITE_NAME : '',
      '{articlename}' => isset($GLOBALS['articlename']) ? (string)$GLOBALS['articlename'] : (isset($GLOBALS['articlename_safe'])?(string)$GLOBALS['articlename_safe']:''),
      '{author}'      => isset($GLOBALS['author']) ? (string)$GLOBALS['author'] : '',
      '{chaptername}' => isset($GLOBALS['chaptername']) ? (string)$GLOBALS['chaptername'] : '',
      '{sortname}'    => isset($GLOBALS['sortname']) ? (string)$GLOBALS['sortname'] : '',
      '{page}'        => isset($GLOBALS['page']) ? (string)$GLOBALS['page'] : (isset($GLOBALS['pid'])?(string)$GLOBALS['pid']:(isset($GLOBALS['now_pid'])?(string)$GLOBALS['now_pid']:'')),
      '{searchkey}'   => isset($GLOBALS['searchkey']) ? (string)$GLOBALS['searchkey'] : '',
      '{ranktitle}'   => isset($GLOBALS['page_title']) ? (string)$GLOBALS['page_title'] : (isset($GLOBALS['ranktitle']) ? (string)$GLOBALS['ranktitle'] : ''),
      '{intro_p}'     => isset($GLOBALS['intro_p']) ? (string)$GLOBALS['intro_p'] : (isset($GLOBALS['intro_des'])?(string)$GLOBALS['intro_des']:''),
    ];

    $seo_title = strtr($title_tpl, $map);
    $seo_keywords = strtr($kw_tpl, $map);
    $seo_description = strtr($desc_tpl, $map);

    // For list pages: remove "第1页" if page==1
    if (isset($map['{page}']) && (string)$map['{page}'] !== '' && (string)$map['{page}'] === '1') {
      $seo_title = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_title);
      $seo_keywords = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_keywords);
      $seo_description = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_description);
    }

    return [$seo_title, $seo_keywords, $seo_description];
  }
}
?>