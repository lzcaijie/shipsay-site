<?php
// shipsay/seo.php
// 分站 SEO/TDK 渲染：从 config.ini.php（总控下发的 seo_*_tpl）读取，按页面变量替换后输出。
// 注意：这里不做“生成词库/随机”，只做渲染替换，确保“总控生成一次 -> 永久固定”。

if (!defined('__ROOT_DIR__')) { exit; }

if (!function_exists('ss_seo_render')) {
  function ss_seo_render($page){
    $page = (string)$page;

    // 从 config.ini.php 读取下发的模板（如果未下发则回退到空串）
    $k_title = 'seo_'.$page.'_title_tpl';
    $k_kw    = 'seo_'.$page.'_keywords_tpl';
    $k_desc  = 'seo_'.$page.'_desc_tpl';

    $title_tpl = isset($GLOBALS[$k_title]) ? (string)$GLOBALS[$k_title] : '';
    $kw_tpl    = isset($GLOBALS[$k_kw]) ? (string)$GLOBALS[$k_kw] : '';
    $desc_tpl  = isset($GLOBALS[$k_desc]) ? (string)$GLOBALS[$k_desc] : '';

    // 兼容：未配置时给一个保底，避免 <title> 为空
    if ($title_tpl === '') $title_tpl = '{SITE_NAME}';

    // 变量映射（按页面使用情况尽量覆盖）
    $map = [
      '{SITE_NAME}'   => defined('SITE_NAME') ? (string)SITE_NAME : '',
      '{articlename}' => isset($GLOBALS['articlename']) ? (string)$GLOBALS['articlename'] : (isset($GLOBALS['articlename_safe'])?(string)$GLOBALS['articlename_safe']:''),
      '{author}'      => isset($GLOBALS['author']) ? (string)$GLOBALS['author'] : '',
      '{chaptername}' => isset($GLOBALS['chaptername']) ? (string)$GLOBALS['chaptername'] : '',
      '{sortname}'    => isset($GLOBALS['sortname']) ? (string)$GLOBALS['sortname'] : '',
      '{page}'        => isset($GLOBALS['page']) ? (string)$GLOBALS['page'] : (isset($GLOBALS['pid'])?(string)$GLOBALS['pid']:''),
      '{searchkey}'   => isset($GLOBALS['searchkey']) ? (string)$GLOBALS['searchkey'] : '',
      '{ranktitle}'   => isset($GLOBALS['page_title']) ? (string)$GLOBALS['page_title'] : '',
      '{intro_p}'     => isset($GLOBALS['intro_p']) ? (string)$GLOBALS['intro_p'] : (isset($GLOBALS['intro_des'])?(string)$GLOBALS['intro_des']:''),
    ];

    // 轻量替换
    $seo_title = strtr($title_tpl, $map);
    $seo_keywords = strtr($kw_tpl, $map);
    $seo_description = strtr($desc_tpl, $map);

    // category/indexlist 等：第1页不显示“第1页”（简单处理：把“第1页/第1页”去掉）
    if (isset($map['{page}']) && (string)$map['{page}'] !== '' && (string)$map['{page}'] === '1') {
      $seo_title = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_title);
      $seo_keywords = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_keywords);
      $seo_description = str_replace(['第1页','_第1页','-第1页',' 第1页'], '', $seo_description);
    }

    return [$seo_title, $seo_keywords, $seo_description];
  }
}
?>
