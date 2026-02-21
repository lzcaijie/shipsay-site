<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
switch ($_REQUEST['do']) {
    case "base":
        $tmp_readpage_split_mode = isset($_POST['readpage_split_mode']) ? $_POST['readpage_split_mode'] : 0;
        $tmp_home_lastupdate_num = isset($_POST['home_lastupdate_num']) ? intval($_POST['home_lastupdate_num']) : 30;
        if ($tmp_home_lastupdate_num <= 0) $tmp_home_lastupdate_num = 30;
        $tmp_home_postdate_num = isset($_POST['home_postdate_num']) ? intval($_POST['home_postdate_num']) : 30;
        if ($tmp_home_postdate_num <= 0) $tmp_home_postdate_num = 30;
        $saveStr = "<?php if (!defined('__ROOT_DIR__')) exit;
error_reporting(0);
date_default_timezone_set('Asia/ChongQing');
include_once __ROOT_DIR__ . '/shipsay/version.php';
define('SITE_NAME', '" . $_POST['sitename'] . "');
\$dbarr = [
     'host' => '" . $_POST['dbhost'] . "'
    ,'port' => '" . $_POST['dbport'] . "'
    ,'name' => '" . $_POST['dbname'] . "'
    ,'user' => '" . $_POST['dbuser'] . "'
    ,'pass' => '" . $_POST['dbpass'] . "'
    ,'pconnect' => " . $_POST['db_pconnect'] . "
];
\$authcode = '" . $_POST['authcode'] . "';

\$sys_ver = '" . $_POST['sys_ver'] . "';
\$root_dir = '" . str_replace('\\', '/', $_POST['root_dir']) . "';
\$txt_url = '" . $_POST['txt_url'] . "';              
\$txt_get_mode = " . $_POST['txt_get_mode'] . ";              
\$remote_img_url = '" . $_POST['remote_img_url'] . "';
\$local_img = " . $_POST['local_img'] . ";            
\$is_attachment = " . $_POST['is_attachment'] . ";    
\$att_url = '" . $_POST['att_url'] . "';              
\$site_url = '" . $_POST['site_url'] . "';
\$use_js = " . $_POST['use_js'] . ";
\$use_gzip = " . $_POST['use_gzip'] . ";
\$enable_down = " . $_POST['enable_down'] . ";
\$is_ft = " . $_POST['is_ft'] . "; 

\$theme_dir = '" . $_POST['theme_dir'] . "';
\$is_3in1 = " . $_POST['is_3in1'] . ";
\$commend_ids = '" . $_POST['commend_ids'] . "';
\$category_per_page = " . $_POST['category_per_page'] . ";
\$home_lastupdate_num = " . $tmp_home_lastupdate_num . ";
\$home_postdate_num = " . $tmp_home_postdate_num . ";
\$readpage_split_mode = " . $tmp_readpage_split_mode . ";
\$readpage_split_lines = " . $_POST['readpage_split_lines'] . ";
\$vote_perday = " . $_POST['vote_perday'] . ";
\$count_visit = " . $_POST['count_visit'] . ";

\$fake_info_url = '" . $_POST['fake_info_url'] . "';      
\$fake_chapter_url = '" . $_POST['fake_chapter_url'] . "';
\$use_orderid = '" . $_POST['use_orderid'] . "';
\$fake_sort_url = '" . $_POST['fake_sort_url'] . "';      
\$fake_top = '" . @$_POST['fake_top'] . "';        
\$fake_recentread = '" . $_POST['fake_recentread'] . "';
\$fake_indexlist = '" . $_POST['fake_indexlist'] . "';  
\$per_indexlist = " . $_POST['per_indexlist'] . ";

//分类设置
" . $_POST['sortarr'] . "

//redis缓存设置
\$use_redis = " . $_POST['use_redis'] . ";
\$redisarr = [
     'host' => '" . $_POST['redishost'] . "' 
    ,'port' => '" . $_POST['redisport'] . "' 
    ,'db' => '" . $_POST['redisdb'] . "'
    ,'pass' => '" . $_POST['redispass'] . "'
];
\$home_cache_time = " . $_POST['home_cache_time'] . ";        
\$info_cache_time = " . $_POST['info_cache_time'] . ";        
\$category_cache_time = " . $_POST['category_cache_time'] . ";
\$cache_time = " . $_POST['cache_time'] . ";                  

//ID混淆
\$is_multiple = " . $_POST['is_multiple'] . ";
\$ss_newid = '" . $_POST['ss_newid'] . "';
function ss_newid(\$id){
    return " . $_POST['ss_newid'] . ";
}
\$ss_sourceid = '" . $_POST['ss_sourceid'] . "';
function ss_sourceid(\$id){
    return " . $_POST['ss_sourceid'] . ";
}

\$is_langtail = " . $_POST['is_langtail'] . ";
\$langtail_catch_cycle = " . $_POST['langtail_catch_cycle'] . ";
\$langtail_cache_time = " . $_POST['langtail_cache_time'] . ";
\$fake_langtail_info = '" . $_POST['fake_langtail_info'] . "';
\$fake_langtail_indexlist = '" . $_POST['fake_langtail_indexlist'] . "';

\$is_keywords = " . $_POST['is_keywords'] . ";
\$keywords_num = " . $_POST['keywords_num'] . ";
";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
    case "report":
        $saveStr = "<?php
\$ShipSayReport['on'] = " . $_POST['report_on'] . "; 
\$ShipSayReport['delay'] = " . intval($_POST['report_delay']) . "; 
";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
    case "filter":
        $saveStr = "<?php
\$ShipSayFilter['is_filter'] = " . $_POST['is_filter'] . "; 
\$ShipSayFilter['filter_ini'] = '
" . str_replace("'", "'", $_POST['filter_ini']) . "
';";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
    case "link":
        $saveStr = "<?php
\$ShipSayLink['is_link'] = " . $_POST['is_link'] . "; 
\$ShipSayLink['link_ini'] = ' 
" . str_replace("'", "'", $_POST['link_ini']) . "
';";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
    case "article":
        $saveStr = "<?php
\$ShipSayRoot['folder'] = '" . str_replace('\\', '/', $_POST['root_folder']) . "';      //服务器端硬盘根目录
";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
    case "count":
        $saveStr = "<?php

\$count[1] = [
    'enable' => " . $_POST['count1_enable'] . ",
    'html' => '" . str_replace("'", "'", $_POST['count1_html']) . "'
];
\$count[2] = [
    'enable' => " . $_POST['count2_enable'] . ",
    'html' => '" . str_replace("'", "'", $_POST['count2_html']) . "'
];
\$count[3] = [
    'enable' => " . $_POST['count3_enable'] . ",
    'html' => '" . str_replace("'", "'", $_POST['count3_html']) . "'
];
";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
    case "search":
        $saveStr = "<?php

\$ShipSaySearch = [
    'delay' => " . $_POST['delay'] . " 
    ,'limit' => " . $_POST['limit'] . "
    ,'min_words' => " . $_POST['min_words'] . "
    ,'cache_time' => " . $_POST['cache_time'] . "
    ,'is_record' => " . intval($_POST['is_record']) . "
];
";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
    case "app":
        $saveStr = "<?php

\$commend_ids = '" . $_POST['commend_ids'] . "'; 
\$qrcode = '" . $_POST['qrcode'] . "'; 
\$swipers = [
//轮播图
" . trim($_POST['swipers']) . "
//轮播图结束
];
\$adsense = '" . $_POST['adsense'] . "'; 

\$key = '" . $_POST['key'] . "';
\$auth_mode = " . $_POST['auth_mode'] . "; 
\$json_cache_time = " . $_POST['json_cache_time'] . "; 
\$uni_app_id = '" . $_POST['uni_app_id'] . "'; 
\$current_ver = '" . $_POST['current_ver'] . "'; 
\$update_note = '" . $_POST['update_note'] . "'; 
\$download_url = '" . $_POST['download_url'] . "'; 

";
        if (ss_writefile($_POST['config_file'], $saveStr)) echo "200";
        break;
}
function ss_writefile($file_name, $data)
{
    if (!is_dir(dirname($file_name))) mkdir(dirname($file_name), 0777, true);
    @chmod($file_name, 511);
    return file_put_contents($file_name, $data);
}

?>
