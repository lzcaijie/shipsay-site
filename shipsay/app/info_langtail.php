<?php

$langtail_articleid=$langtail_sourceid=$matches[1];
$info_url=Url::info_url($langtail_articleid,true);
$index_url=Url::index_url($langtail_articleid,1,true);
if(!file_exists(__THEME_DIR__.'/tpl_info.php'))header('Location:'.$index_url);
if($is_multiple)$langtail_sourceid=ss_sourceid($langtail_sourceid);

$langtail_sql='SELECT sourceid,langname,sourcename FROM shipsay_article_langtail WHERE langid = '.intval($langtail_sourceid);
$lang_res=$db->ss_getone($langtail_sql);
if(!is_array($lang_res) || empty($lang_res['sourceid']))Url::ss_errpage();

$sourceid=intval($lang_res['sourceid']);
$articleid=$sourceid;
if($is_multiple)$articleid=ss_newid($articleid);
$articlename=$lang_res['langname'];
$sourcename=$lang_res['sourcename'];
if($is_ft)
{
    $articlename=Convert::jt2ft($articlename,1);
    $sourcename=Convert::jt2ft($sourcename,1);
}

// 长尾表的 sourceid 保存的是真实 articleid，这里必须始终按 articleid 查询。
// 不能套用普通详情页里的 articlecode 分支，否则在 is_acode=1 时会查空，页面直接空白。
$sql=$rico_sql.'AND articleid = '.$sourceid;
if(isset($redis))
{
	$infoarr=$redis->ss_redis_getrows($sql,$info_cache_time);
}
else
{
	$infoarr=$db->ss_getrows($sql);
}
if(!is_array($infoarr) || empty($infoarr[0]))Url::ss_errpage();

if($is_langtail===1)
{
	include_once __ROOT_DIR__.'/shipsay/include/langtail.php';
}
$author=$infoarr[0]['author'];
$author_arr=explode(',',$author);
$author_url=$infoarr[0]['author_url'];
$keywords=$infoarr[0]['keywords'];
$keywords_arr=is_array($infoarr[0]['keywords_arr'])?$infoarr[0]['keywords_arr']:explode(',',$keywords);
$img_url=$infoarr[0]['img_url'];
$sortid=$infoarr[0]['sortid'];
$sortname=$infoarr[0]['sortname'];
$sorturl=Sort::ss_sorturl($sortid);
$isfull=$infoarr[0]['isfull'];
$words_w=$infoarr[0]['words_w'];
$intro=$infoarr[0]['intro'];
$intro_des=$infoarr[0]['intro_des'];
$intro_p=$infoarr[0]['intro_p'];
$allvisit=$infoarr[0]['allvisit'];
$goodnum=$infoarr[0]['goodnum'];
$ratenum=$infoarr[0]['ratenum'];
$ratesum=$infoarr[0]['ratesum'];
$score=$infoarr[0]['score'];

$sql='SELECT chapterid,chaptername,lastupdate,chaptertype,chapterorder FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chaptertype = 0 ORDER BY chapterorder ASC';

// 注意：不能把“已拼好的 cid_url”整体缓存到 Redis（否则切换 use_orderid / is_multiple 后会出现旧链接假象）
// 做法：只缓存 SQL 原始行（ss_redis_getrows），再按当前开关动态生成 cid_url。
$rows = [];
if(isset($redis))
{
	$rows=$redis->ss_redis_getrows($sql,$info_cache_time);
}
else
{
	$rows=$db->ss_getrows($sql);
}

$chapterrows=array();
if(is_array($rows))
{
	$k=0;
	foreach($rows as $row)
	{
		$cid=$use_orderid?intval($row['chapterorder']):intval($row['chapterid']);
		if($is_multiple && !$use_orderid)$cid=ss_newid($cid);
		$chapterrows[$k]['chaptertype']=$row['chaptertype'];
		$chapterrows[$k]['lastupdate']=$row['lastupdate'];
		$chapterrows[$k]['cid_url']=Url::chapter_url($articleid,$cid);
		$chapterrows[$k]['cname']=Text::ss_toutf8($row['chaptername']);
		if($is_ft)$chapterrows[$k]['cname']=Convert::jt2ft($chapterrows[$k]['cname']);
		$k++;
	}
}
if(empty($chapterrows))Url::ss_errpage();

$first_url=$chapterrows[0]['cid_url'];
$chapters=count($chapterrows);
$lastupdate_stamp=$chapterrows[$chapters-1]['lastupdate'];
$lastupdate=date('Y-m-d H:i:s',$lastupdate_stamp);
$lastupdate_cn=Text::ss_lastupdate($lastupdate_stamp);
$lastchapter=$chapterrows[$chapters-1]['cname'];
$last_url=$chapterrows[$chapters-1]['cid_url'];
$lastarr=array_reverse(array_slice($chapterrows,-12,12));
$lastchapter_arr=$lastarr;
$preview_chapters=array_reverse(array_slice($chapterrows,-50,50));
if($count_visit)require_once __ROOT_DIR__.'/shipsay/include/articlevisit.php';
header('Last-Modified: '.date('D, d M Y H:i:s',$lastupdate_stamp-8*60*60).' GMT');
require_once __THEME_DIR__.'/tpl_info.php';
?>
