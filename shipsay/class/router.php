<?php

$fake_fullstr='quanben';
$fake_rankstr='rank';
$fake_tag='/tag/{tag}/{pid}.html';
if(!empty($authcode))$dbarr['host']=$authcode;
ss_void();
header("Content-type: text/html; charset=utf-8");
define('__THEME_DIR__',__ROOT_DIR__.'/themes/'.$theme_dir);
if(!defined('SITE_URL'))define('SITE_URL',$_SERVER['HTTP_HOST']);
if($use_gzip&&!headers_sent()&&extension_loaded("zlib")&&strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip"))
{
	ini_set('zlib.output_compression','On');
	ini_set('zlib.output_compression_level','9');
}
spl_autoload_register('ss_autoload');
if(empty($site_url))
{
	$site_url=$_SERVER['SERVER_PORT']==443?'https://':'http://';
	$site_url.=$_SERVER['HTTP_HOST'];
}
if(isset($_REQUEST['show_shipsay_version']))
{
	print_r($ShipSayVersion);
	die();
}
$use_code=0;
$year=date('Y');
$is_sortid=strpos($fake_sort_url,'{sortid}')!==false?true:false;
$is_acode=strpos($fake_info_url,'{acode}')!==false?true:false;
if($use_redis)
{
	if(!extension_loaded('redis'))
	{
		die('php的"Redis扩展"未正确安装');
	}
	else
	{
		$redis=new SsRedis($redisarr);
	}
}
$dbarr=array_merge(['pre'=>$sys_ver<5?'jieqi_':'shipsay_','words'=>$sys_ver<2.4?'size':'words','is_multiple'=>$is_multiple,'sortarr'=>$sortarr],$dbarr);
$db=new Db($dbarr);
$articlecode_str=$sys_ver<2.4?'':'articlecode,backupname,ratenum,ratesum,';
$rico_sql='SELECT '.$articlecode_str.$dbarr['words'].',articleid,articlename,intro,author,sortid,fullflag,display,lastupdate,imgflag,allvisit,allvote,goodnum,keywords,lastchapter,lastchapterid FROM '.$dbarr['pre'].'article_article WHERE display <> 1 AND '.$dbarr['words'].' >= 0 ';
if(!isset($is_oneload))$is_oneload=0;
$allbooks_url=preg_replace('/({sortid}|{sortcode}).*/i','',$fake_sort_url);
$full_allbooks_url='/'.$fake_fullstr.$allbooks_url;
if(preg_match('/^\/json\/([\s\S]+)\.php/i',$source_uri,$match_json))
{
	require_once __ROOT_DIR__.'/shipsay/json/ss_json_api.php';
	exit;
}
if($uri=='/')
{
	require_once __ROOT_DIR__.'/shipsay/app/home.php';
	exit;
}
if(strpos($uri,$allbooks_url)!==false||preg_match(Url::sort2real($fake_sort_url),$uri))
{
	require_once __ROOT_DIR__.'/shipsay/app/category.php';
	exit;
}
$tag_first_page=preg_replace('/{tag}.*$/i','',$fake_tag);
if(preg_match(Url::tag2real($fake_tag),urldecode($uri),$matches)||strpos($uri,$tag_first_page)===0)
{
	require_once __ROOT_DIR__.'/shipsay/app/tag.php';
	exit;
}

$fake_top_match=ss_match_fake_top_uri($uri,$fake_top);
if($fake_top_match!==false)
{
	$matches=['', $fake_top_match];
	require_once __ROOT_DIR__.'/shipsay/app/top.php';
	exit;
}
if(preg_match('/\/'.preg_quote($fake_rankstr,'/').'\/?([^\/]*)\/?/i',$uri,$matches))
{
	require_once __ROOT_DIR__.'/shipsay/app/rank.php';
	exit;
}
if(decide_uri($uri,'/search'))
{
	require_once __ROOT_DIR__.'/shipsay/app/search.php';
	exit;
}
if(preg_match('/^\/author\/(.+?)\/?$/i',$uri,$matches))
{
	require_once __ROOT_DIR__.'/shipsay/app/author.php';
	exit;
}
if(decide_uri($uri,$fake_recentread))
{
	require_once __ROOT_DIR__.'/shipsay/app/recentread.php';
	exit;
}
if(preg_match('/^\/api\/(.+?)\.php/i',$uri,$matches))
{
	require_once __ROOT_DIR__.'/shipsay/include/'.$matches[1].'.php';
	exit;
}
if(decide_uri($uri,'/login'))
{
	require_once __ROOT_DIR__.'/shipsay/app/user/login.php';
	exit;
}
if(decide_uri($uri,'/logout'))
{
	require_once __ROOT_DIR__.'/shipsay/app/user/logout.php';
	exit;
}
if(decide_uri($uri,'/register'))
{
	require_once __ROOT_DIR__.'/shipsay/app/user/register.php';
	exit;
}
if(decide_uri($uri,'/addbookcase'))
{
	require_once __ROOT_DIR__.'/shipsay/app/user/addbookcase.php';
	exit;
}
if(decide_uri($uri,'/delbookcase'))
{
	require_once __ROOT_DIR__.'/shipsay/app/user/delbookcase.php';
	exit;
}
if(decide_uri($uri,'/bookcase'))
{
	require_once __ROOT_DIR__.'/shipsay/app/user/bookcase.php';
	exit;
}
if(preg_match(Url::fake2real($fake_chapter_url),$uri,$matches))
{
	require_once __ROOT_DIR__.'/shipsay/app/reader.php';
	exit;
}
if(strpos($uri,'search')===false&&preg_match(Url::fake2real($fake_info_url),$uri,$matches))
{
	require_once __ROOT_DIR__.'/shipsay/app/info.php';
	exit;
}
if(preg_match(Url::indexlist2real($fake_indexlist),$uri,$matches))
{
	require_once __ROOT_DIR__.'/shipsay/app/indexlist.php';
	exit;
}
if($is_langtail===1)
{
	if(strpos($uri,'search')===false&&preg_match(Url::fake2real($fake_langtail_info),$uri,$matches))
	{
		require_once __ROOT_DIR__.'/shipsay/app/info_langtail.php';
		exit;
	}
	if(preg_match(Url::indexlist2real($fake_langtail_indexlist),$uri,$matches))
	{
		require_once __ROOT_DIR__.'/shipsay/app/indexlist_langtail.php';
		exit;
	}
}
Url::ss_errpage();
function decide_uri($uri,$fake_url)
{
	return rtrim($uri,'/')===rtrim($fake_url,'/');
}
function ss_void()
{
	global $dbarr;
	if(($dbarr['host']!=='127.0.0.1'&&(strlen($dbarr['host'])<30))||!defined('__ROOT_DIR__'))
	{
		die('船说CMS www.shipsay.com');
	}
	else
	{
		return true;
	}
}
function ss_autoload($classname)
{
	if(!class_exists($classname))require __ROOT_DIR__.'/shipsay/class/'.$classname.'.php';
}
function ss_match_fake_top_uri($uri,$fake_top)
{
	$meta=ss_get_fake_top_meta($fake_top);
	$path=parse_url((string)$uri,PHP_URL_PATH);
	if($path===null||$path===false)$path=(string)$uri;
	$path='/'.ltrim((string)$path,'/');
	$path=preg_replace('#/+#','/',$path);
	$path_no_slash=rtrim($path,'/');
	if($path_no_slash==='')$path_no_slash='/';

	foreach($meta['entry_aliases'] as $alias)
	{
		if($path_no_slash===rtrim($alias,'/'))
		{
			return '';
		}
	}

	if(preg_match('#^'.preg_quote($meta['detail_root'],'#').'/([a-z0-9_]+)/?$#i',$path,$m))
	{
		return strtolower($m[1]);
	}

	return false;
}
function ss_get_fake_top_meta($fake_top,$fake_rankstr='rank')
{
	$rank_prefix=trim((string)$fake_rankstr,'/');
	if($rank_prefix==='')$rank_prefix='rank';

	$entry=(string)$fake_top;
	if($entry==='')$entry='/'.$rank_prefix.'/';
	$entry_path=parse_url($entry,PHP_URL_PATH);
	if($entry_path===null||$entry_path===false||$entry_path==='')$entry_path=$entry;
	$entry_path='/'.ltrim((string)$entry_path,'/');
	$entry_path=preg_replace('#/+#','/',$entry_path);
	if($entry_path==='/')$entry_path='/'.$rank_prefix.'/';

	$is_html=substr($entry_path,-5)==='.html';
	$detail_root=$is_html?substr($entry_path,0,-5):rtrim($entry_path,'/');
	if($detail_root==='')$detail_root='/'.$rank_prefix;

	$entry_url=$entry_path;
	if(!$is_html&&substr($entry_url,-1)!=='/')$entry_url.='/';

	$aliases=array_values(array_unique(array_filter([
		rtrim($entry_url,'/'),
		$entry_url,
		rtrim($detail_root,'/'),
		rtrim($detail_root,'/').'.html'
	])));

	return [
		'entry_url'=>$entry_url,
		'detail_root'=>rtrim($detail_root,'/'),
		'detail_base'=>rtrim($detail_root,'/').'/',
		'entry_aliases'=>$aliases,
		'rank_prefix'=>$rank_prefix,
	];
}
?>
