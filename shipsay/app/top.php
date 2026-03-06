<?php

$rank_meta=ss_get_fake_top_meta(isset($fake_top)?$fake_top:'',isset($fake_rankstr)?$fake_rankstr:'rank');
$rank_entry_url=$rank_meta['entry_url'];
$rank_detail_base=$rank_meta['detail_base'];
$rank_legacy_base='/'.$rank_meta['rank_prefix'].'/';

$query=isset($matches[1])?strtolower(trim((string)$matches[1])):'';
$is_rank_detail=$query!=='';
$title_arr=[
	'allvisit'=>'总排行榜',
	'monthvisit'=>'月排行榜',
	'weekvisit'=>'周排行榜',
	'dayvisit'=>'日排行榜',
	'allvote'=>'总推荐榜',
	'monthvote'=>'月推荐榜',
	'weekvote'=>'周推荐榜',
	'dayvote'=>'日推荐榜',
	'goodnum'=>'收藏榜'
];

if($is_rank_detail)
{
	if(!isset($title_arr[$query]))
	{
		Url::ss_errpage();
		die;
	}

	$tmpvar=' WHERE '.$dbarr['words'].' > 0 ';
	$page_title=$title_arr[$query];
	if($is_ft)$page_title=Convert::jt2ft($page_title);

	$rank_cache_ttl=600;
	$site='';
	if(!empty($_SERVER['HTTP_HOST']))
	{
		$site=(string)$_SERVER['HTTP_HOST'];
	}
	elseif(!empty($site_url))
	{
		$h=@parse_url($site_url,PHP_URL_HOST);
		$site=$h?(string)$h:(string)$site_url;
	}
	elseif(defined('SITE_URL'))
	{
		$site=(string)SITE_URL;
	}
	$site=strtolower($site);
	$site=preg_replace('/:\d+$/','',$site);
	if($site==='')$site='unknown';

	$rank_cache_key='rank:'.$query.':'.$site;
	$articlerows=[];

	if(isset($redis))
	{
		$hit=$redis->get($rank_cache_key);
		if($hit!==false&&$hit!==null&&$hit!=='')
		{
			$tmp=json_decode($hit,true);
			if(is_array($tmp))$articlerows=$tmp;
		}
	}

	if(empty($articlerows)||!is_array($articlerows))
	{
		$sql=$rico_sql.'ORDER BY '.$query.' DESC LIMIT 100 ';
		$rows=$db->ss_getrows($sql);
		if(!is_array($rows))$rows=[];

		if(!empty($rows))
		{
			$seed=crc32($site.'|'.$query);
			if(function_exists('mt_srand'))mt_srand($seed);
			shuffle($rows);
			if(function_exists('mt_srand'))mt_srand();
		}

		$articlerows=array_slice($rows,0,30);

		if(isset($redis))
		{
			$redis->setex(
				$rank_cache_key,
				$rank_cache_ttl,
				json_encode($articlerows,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)
			);
		}
	}

	$detail_tpl='';
	if(file_exists(__THEME_DIR__.'/tpl_rank_list.php'))
	{
		$detail_tpl=__THEME_DIR__.'/tpl_rank_list.php';
	}
	elseif(file_exists(__THEME_DIR__.'/tpl_rank.php'))
	{
		$detail_tpl=__THEME_DIR__.'/tpl_rank.php';
	}
	elseif(file_exists(__THEME_DIR__.'/tpl_top.php'))
	{
		$detail_tpl=__THEME_DIR__.'/tpl_top.php';
	}
	else
	{
		Url::ss_errpage();
		die;
	}

	require_once $detail_tpl;
	exit;
}

$top_sections=[
	'weekvisit'=>['title'=>'周榜','field'=>'weekvisit','more'=>$rank_detail_base.'weekvisit/'],
	'monthvisit'=>['title'=>'月榜','field'=>'monthvisit','more'=>$rank_detail_base.'monthvisit/'],
	'allvisit'=>['title'=>'总榜','field'=>'allvisit','more'=>$rank_detail_base.'allvisit/'],
	'allvote'=>['title'=>'推荐榜','field'=>'allvote','more'=>$rank_detail_base.'allvote/'],
	'goodnum'=>['title'=>'收藏榜','field'=>'goodnum','more'=>$rank_detail_base.'goodnum/'],
];
$top_rank_limit=isset($category_per_page)&&intval($category_per_page)>0?intval($category_per_page):10;
$top_rank_lists=[];
foreach($top_sections as $top_key=>$top_conf)
{
	$top_rank_lists[$top_key]=[];
	$field=preg_replace('/[^a-z0-9_]/i','',(string)$top_conf['field']);
	if($field===''||!isset($rico_sql))continue;
	$top_sql=$rico_sql.'ORDER BY '.$field.' DESC LIMIT '.$top_rank_limit;
	if(isset($redis))
	{
		$rows=$redis->ss_redis_getrows($top_sql,isset($home_cache_time)?$home_cache_time:300);
	}
	else
	{
		$rows=$db->ss_getrows($top_sql);
	}
	$top_rank_lists[$top_key]=is_array($rows)?$rows:[];
}

foreach($sortarr as $k=>$v)
{
	$sql_allvisit=$rico_sql.'AND sortid = '.$k.' ORDER BY allvisit DESC LIMIT 50';
	$sql_monthvisit=$rico_sql.'AND sortid = '.$k.' ORDER BY monthvisit DESC LIMIT 50';
	$sql_weekvisit=$rico_sql.'AND sortid = '.$k.' ORDER BY weekvisit DESC LIMIT 50';
	$tmp_allvisit='allvisit'.$k;
	$tmp_monthvisit='monthvisit'.$k;
	$tmp_weekvisit='weekvisit'.$k;
	if(isset($redis))
	{
		$$tmp_allvisit=$redis->ss_redis_getrows($sql_allvisit,$cache_time);
		$$tmp_monthvisit=$redis->ss_redis_getrows($sql_monthvisit,$cache_time);
		$$tmp_weekvisit=$redis->ss_redis_getrows($sql_weekvisit,$cache_time);
	}
	else
	{
		$$tmp_allvisit=$db->ss_getrows($sql_allvisit);
		$$tmp_monthvisit=$db->ss_getrows($sql_monthvisit);
		$$tmp_weekvisit=$db->ss_getrows($sql_weekvisit);
	}
}

$tpl='';
if(file_exists(__THEME_DIR__.'/tpl_top.php'))
{
	$tpl=__THEME_DIR__.'/tpl_top.php';
}
elseif(file_exists(__THEME_DIR__.'/tpl_rank.php'))
{
	$tpl=__THEME_DIR__.'/tpl_rank.php';
}
else
{
	$tpl=__ROOT_DIR__.'/shipsay/include/tpl_top_default.php';
}

require_once $tpl;
?>
