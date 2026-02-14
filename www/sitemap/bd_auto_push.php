<?php
/*

 - 船说 全自动化百度推送插件 v3.7.2 逆水行舟 QQ群 249310348
 
 - 放在 /www/sitemap/ 下直接访问  http://x.com/sitemap/bd_auto_push.php 
 
 - 自动读取当前剩余配额(如配额用完,不提交) 
  
 - 自动从上一次成功提交的位置继续(不会重复提交)
 
 - 自动读取所有配置,包括链接样式,ID转换算法,数据库参数等
  
 - 搭配宝塔定时任务,全天候自动操作.
  
 */

$intid = $startid = 0; //初始化, 开始的ID号 (数据库里的ID号,填小1位, 如果起始ID是1,则填0)

$is_loop = 1;   //到达最大ID后,是否从头提交, 1-循环, 0-不循环.

$per = 10;      //每次推送的条数( 自动获取配额填 0.  否则填入大于0小于2000的整数 )

$api = 'http://data.zz.baidu.com/urls?site=https://www.taotuobook.com&token=mGiKUSrbBw6VREnx';  //推送地址

/*********  以下代码请勿修改 ***********/
header("Cache-Control: no-store, no-cache, must-revalidate");date_default_timezone_set('Asia/Chongqing');set_time_limit(300);error_reporting(0);if($per==0){$test_url=['http://www.baidu.com'];@$day_remain=json_decode(curl_post($api,$test_url))->remain;if(is_numeric($day_remain)&&$day_remain>=1){$per=$day_remain>=2000?2000:$day_remain;}else{die('未获取到配额');}}else{$per=intval($per);}define('__ROOT_DIR__',dirname(dirname(__DIR__)));require_once __ROOT_DIR__.'/shipsay/configs/config.ini.php';if(empty($site_url)){$site_url=$_SERVER['SERVER_PORT']==443?'https://':'http://';$site_url.=$_SERVER['HTTP_HOST'];}spl_autoload_register('ss_autoload');if(!empty($authcode))$dbarr['host']=$authcode;$articlecode_str=$sys_ver<2.4?'':'articlecode,';$dbarr=array_merge(['pre'=>$sys_ver<5?'jieqi_':'shipsay_','words'=>$sys_ver<2.4?'size':'words','sortarr'=>$sortarr],$dbarr);$db=new Db($dbarr);$sql_maxid='SELECT MAX(articleid) AS maxid FROM '.$dbarr['pre'].'article_article';$maxid=$db->ss_getone($sql_maxid)['maxid'];$tmpvar=explode('/',$_SERVER['SCRIPT_NAME']);$self_name=$tmpvar[count($tmpvar)-1];$txt_name=str_replace('.php','.txt',$self_name);if(is_file($txt_name)&&filesize($txt_name)>10){$file=file($txt_name);$lastline=$file[count($file)-1];if($msg=@unserialize($lastline)){$startid=intval($msg['stopid']);if($startid>=$maxid&&!$is_loop){die('已达到最大ID,且未设置循环,不做推送.');}}else{die('日志文件读取失败');}}$sql='SELECT '.$articlecode_str.'articleid FROM '.$dbarr['pre'].'article_article WHERE articleid >'.$startid.' ORDER BY articleid ASC LIMIT '.$per;$res=$db->ss_query($sql);if(!$res)die('没有查询到数据');$tmpsqlids=array();while($row=mysqli_fetch_array($res)){$tmpsqlids[]=$row['articleid'];if(strpos($fake_info_url,'{acode}')!==false){$row['articleid']=$row['articlecode'];}else{if($is_multiple)$row['articleid']=ss_newid($row['articleid']);}if($is_3in1){$urls[]=$site_url.Url::index_url($row['articleid']);}else{$urls[]=$site_url.Url::info_url($row['articleid']);}}$json=curl_post(trim($api),$urls);$tmparr=json_decode($json,true);$ret['date']=date('Y-m-d H:i:s');if($tmparr['error']){$ret['diemsg']='推送失败: '.$tmparr['message'];$stopid=$startid;}else{$ret['remain']=$tmparr['remain'];$ret['diemsg']='推送成功: '.intval($tmparr['success']);$stopid=$tmpsqlids[intval($tmparr['success'])-1];}$ret['startid']=$startid;if($stopid>=$maxid&&$is_loop){$ret['stopid']=$intid;}else{$ret['stopid'] = $stopid ?? $startid;}$file=array_splice($file,-100,100);$file[]="\n".serialize($ret);file_put_contents($txt_name,$file);die($ret['diemsg']);function curl_post($posturl,$urls){$curl=curl_init();curl_setopt($curl,CURLOPT_URL,trim($posturl));curl_setopt($curl,CURLOPT_POST,1);curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);curl_setopt($curl,CURLOPT_POSTFIELDS,implode("\n",$urls));curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: text/plain'));$ret=curl_exec($curl);curl_close($curl);return $ret;}function ss_autoload($classname){if(!class_exists($classname))require __ROOT_DIR__.'/shipsay/class/'.$classname.'.php';}