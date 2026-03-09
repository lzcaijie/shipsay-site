<?php if (!defined('__ROOT_DIR__')) exit; ?>
<?php
$theme_dir_raw = isset($theme_dir) ? (string)$theme_dir : '88ds';
$theme_dir_attr = htmlspecialchars($theme_dir_raw, ENT_QUOTES, 'UTF-8');
$v = defined('SITE_VERSION') ? SITE_VERSION : date('Ymd');
?>
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<meta name="MobileOptimized" content="240" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<base target="_self">
<link rel="shortcut icon" type="image/x-icon" href="/static/<?=$theme_dir_attr?>/favicon.ico" media="screen">
<link rel="stylesheet" href="/static/<?=$theme_dir_attr?>/style.css?v=<?=$v?>">
<script src="/static/<?=$theme_dir_attr?>/js/jquery.min.js?v=<?=$v?>"></script>
<script src="/static/<?=$theme_dir_attr?>/common.js?v=<?=$v?>"></script>
</head>
