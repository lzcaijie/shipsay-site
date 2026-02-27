<?php if (!defined('__ROOT_DIR__')) exit;
error_reporting(0);
date_default_timezone_set('Asia/ChongQing');
include_once __ROOT_DIR__ . '/shipsay/version.php';
define('SITE_NAME', '分站1');
$dbarr = [
     'host' => '127.0.0.1'
    ,'port' => '3306'
    ,'name' => 'zy5_9tus_com'
    ,'user' => 'zy5_9tus_com'
    ,'pass' => 'pXeKPXJ84XTeGr9N'
    ,'pconnect' => 0
];
$authcode = '';

$sys_ver = '6.0';
$root_dir = '';
$txt_url = '/www/wwwroot/zy5.9tus.com/www/files/article/txt';              
$txt_get_mode = 1;              
$remote_img_url = 'https://img5.116read.com';
$local_img = 0;            
$is_attachment = 0;    
$att_url = '';              
$site_url = '';
$use_js = 1;
$use_gzip = 1;
$enable_down = 0;
$is_ft = 0; 

$theme_dir = 'shipsay';
$is_3in1 = 0;
$commend_ids = '1113, 222, 3333, 4444, 5555, 6666, 7222, 8333, 9444, 10555';
$category_per_page = 20;
$home_lastupdate_num = 30;
$home_postdate_num = 30;
$readpage_split_mode = 2;
$readpage_split_lines = 800;
$vote_perday = 3;
$count_visit = 0;

$fake_info_url = '/book/{aid}/';      
$fake_chapter_url = '/read/{aid}/{cid}.html';
$use_orderid = '1';
$fake_sort_url = '/sort/{sortcode}/{pid}/';      
$fake_top = '/top/';        
$fake_recentread = '/history.html';
$fake_indexlist = '/indexlist/{aid}/{pid}/';  
$per_indexlist = 50;

//分类设置
$sortarr[1] = ['code' => 'xuanhuan', 'caption' => '玄幻'];
$sortarr[2] = ['code' => 'wuxia', 'caption' => '武侠'];
$sortarr[3] = ['code' => 'dushi', 'caption' => '都市'];
$sortarr[4] = ['code' => 'lishi', 'caption' => '历史'];
$sortarr[5] = ['code' => 'kehuan', 'caption' => '科幻'];
$sortarr[6] = ['code' => 'youxi', 'caption' => '游戏'];
$sortarr[7] = ['code' => 'qita', 'caption' => '其他'];

//redis缓存设置
$use_redis = 1;
$redisarr = [
     'host' => '127.0.0.1' 
    ,'port' => '6379' 
    ,'db' => '5'
    ,'pass' => 'caijie123AA'
];
$redis_scope = 'dbpool';
$redis_pool = '';
$home_cache_time = 1200;        
$info_cache_time = 7200;        
$category_cache_time = 3600;
$cache_time = 1800;                  

//ID混淆
$is_multiple = 1;
$ss_newid = '$id + 550';
function ss_newid($id){
    return $id + 550;
}
$ss_sourceid = '$id - 550';
function ss_sourceid($id){
    return $id - 550;
}

$is_langtail = 1;
$langtail_catch_cycle = 180;
$langtail_cache_time = 2592000;
$fake_langtail_info = '/books/{aid}/';
$fake_langtail_indexlist = '/indexs/{aid}/{pid}/';

$is_keywords = 1;
$keywords_num = 5;
