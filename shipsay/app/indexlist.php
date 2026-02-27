<?php

$articleid=$sourceid=$matches[1];
$index_url=Url::index_url($articleid);
if(!file_exists(__THEME_DIR__.'/tpl_indexlist.php'))header('Location:'.$index_url);
$pid=1;
if(isset($matches[2]))$pid=$matches[2];
$per_page=$per_indexlist?:100;
if($is_multiple)$sourceid=ss_sourceid($articleid);
if($is_acode)
{
	$sql=$rico_sql.'AND articlecode = "'.$sourceid.'"';
}
else
{
	$sql=$rico_sql.'AND articleid = '.$sourceid;
}
if(isset($redis))
{
	$infoarr=$redis->ss_redis_getrows($sql,$info_cache_time);
}
else
{
	$infoarr=$db->ss_getrows($sql);
}
if(!is_array($infoarr))Url::ss_errpage();
if($is_acode)$sourceid=$infoarr[0]['articleid'];
$articlename=$sourcename=$infoarr[0]['articlename'];
$author=$infoarr[0]['author'];
$author_url=$infoarr[0]['author_url'];
$img_url=$infoarr[0]['img_url'];
$sortid=$infoarr[0]['sortid'];
$sortname=$infoarr[0]['sortname'];
$sorturl=Sort::ss_sorturl($sortid);
$isfull=$infoarr[0]['isfull'];
$keywords=$infoarr[0]['keywords'];
$words_w=$infoarr[0]['words_w'];
$intro_des=$infoarr[0]['intro_des'];
$intro_p=$infoarr[0]['intro_p'];
$allvisit=$infoarr[0]['allvisit'];
$goodnum=$infoarr[0]['goodnum'];
$ratenum=$infoarr[0]['ratenum'];
$ratesum=$infoarr[0]['ratesum'];
$score=$infoarr[0]['score'];

$sql='SELECT chapterid,chaptername,lastupdate,chaptertype,chapterorder FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chaptertype = 0 ORDER BY chapterorder ASC';

// 注意：不能缓存“已拼好的 cid_url”（否则切换 use_orderid / is_multiple 后会出现旧链接假象）
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
		$chapterrows[$k]['chaptertype']=$row['chaptertype'];
		$chapterrows[$k]['lastupdate']=$row['lastupdate'];
		$chapterrows[$k]['cname']=Text::ss_toutf8($row['chaptername']);
		if($is_ft)$chapterrows[$k]['cname']=Convert::jt2ft($chapterrows[$k]['cname']);

		$cid=$use_orderid?intval($row['chapterorder']):intval($row['chapterid']);
		if($is_multiple && !$use_orderid)$cid=ss_newid($cid);
		$chapterrows[$k]['cid_url']=Url::chapter_url($articleid,$cid);
		$k++;
	}
}

$first_url=$chapterrows[0]['cid_url'];
$chapters=count($chapterrows);
$lastupdate=date('Y-m-d H:i:s',$chapterrows[$chapters-1]['lastupdate']);
$lastupdate_cn=Text::ss_lastupdate($chapterrows[$chapters-1]['lastupdate']);
$lastchapter=$chapterrows[$chapters-1]['cname'];
$last_url=$chapterrows[$chapters-1]['cid_url'];
$lastarr=array_reverse(array_slice($chapterrows,-12,12));
$rico_arr=array_chunk($chapterrows,$per_page);
if($pid>count($rico_arr))$pid=count($rico_arr);
$list_arr=$rico_arr[$pid-1];
if($pid>1)
{
	$htmltitle='<a class="index-container-btn" href="'.Url::index_url($articleid,($pid-1)).'">上一页</a>';
}
else
{
	$htmltitle='<a class="index-container-btn disabled-btn" href="javascript:void(0);">没有了</a>';
}
$htmltitle.='<select id="indexselect" onchange="self.location.href=options[selectedIndex].value">';
for($i=1;$i<=count($rico_arr);
$i++)
{
	$end=$i*$per_page>$chapters?$chapters:$i*$per_page;
	$htmltitle.='<option value="'.Url::index_url($articleid,$i).'"';
	if($i==$pid)$htmltitle.=' selected="selected"';
	$htmltitle.='>'.(($i-1)*$per_page+1).' - '.$end.'章</option>';
}
$htmltitle.='</select>';
if($pid<count($rico_arr))
{
	$htmltitle.='<a class="index-container-btn" href="'.Url::index_url($articleid,($pid+1)).'">下一页</a>';
}
else
{
	$htmltitle.='<a class="index-container-btn disabled-btn" href="javascript:void(0);">没有了</a>';
}
if($count_visit)require_once __ROOT_DIR__.'/shipsay/include/articlevisit.php';
header('Last-Modified: '.date('D, d M Y H:i:s',$chapterrows[$chapters-1]['lastupdate']-8*60*60).' GMT');
require_once __THEME_DIR__.'/tpl_indexlist.php';
?>
