<?php

require_once __ROOT_DIR__.'/shipsay/configs/filter.ini.php';
// [MODLOG 2026-02-12] 兜底补章：缺章/短章时读取补丁表并可远端拉取
require_once __ROOT_DIR__.'/shipsay/include/chapter_patch.php';

$now_pid=1;
$articleid=$sourceid=$matches[1];

if($is_acode)
{
	$sql='SELECT articleid FROM '.$dbarr['pre'].'article_article WHERE articlecode = "'.$sourceid.'"';
	$sourceid=$db->ss_getone($sql)['articleid'];
}

$chapterid_raw=$matches[2];
if(isset($matches[3]))$now_pid=str_replace('_','',$matches[3]);

// url param (chapter)
$sourcecid_raw=$chapterid_raw;
$sourcecid=intval($sourcecid_raw);
$sourcecid_mixed_candidate=null; // real chapterid candidate (decoded from mixed)

// decode novel id always when multiple
if($is_multiple)
{
	$sourceid=ss_sourceid($sourceid);
	// when use_orderid=1: chapter param is chapterorder, MUST NOT be decoded;
	// but we still keep a candidate to support old mixed chapterid links.
	if(!$use_orderid)
	{
		$sourcecid=ss_sourceid($sourcecid_raw);
	}
	else
	{
		$sourcecid_mixed_candidate=ss_sourceid($sourcecid_raw);
	}
}

// keep current chapter param for paging links; if we later normalize cid, we will overwrite it
$chapterid=$sourcecid;

$max_pid=1;
$prevpage_url='';
$nextpage_url='';
$subaid=intval($sourceid/1000);

// article info
$sql=$rico_sql.'AND articleid = '.$sourceid;
if(isset($redis))
{
	$infoarr=$redis->ss_redis_getrows($sql,$cache_time);
}
else
{
	$infoarr=$db->ss_getrows($sql);
}
if(!is_array($infoarr))Url::ss_errpage();

$articlename=$infoarr[0]['articlename'];
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

// chapter list cache (must include use_orderid/is_multiple dimensions)
$uri_key=$uri.'|uo='.(int)$use_orderid.'|m='.(int)$is_multiple.'|ft='.(int)$is_ft.'|ac='.(int)$is_acode;

$chapterids=array();
$chapterid_list=array();
$chaptername_list=array();
$chapterwords_list=array();
$lastupdate_list=array();

$chaptername='';
$chapterwords='';
$lastupdate='';
$chapterorder_real=0;
$chapterid_real=0;
$txt_sourceid=null; // IMPORTANT: may be 0, so use null as "unset"

$cache_ok=false;
if(isset($redis))
{
	$ret=$redis->ss_get($uri_key);
	if(is_array($ret))
	{
		// require txt_sourceid presence when use_orderid=1 (0 is valid)
		if(!$use_orderid || array_key_exists('txt_sourceid',$ret))
		{
			$chapterids=$ret['chapterids'];
			$chaptername=$ret['chaptername'];
			$chapterwords=$ret['chapterwords'];
			$lastupdate=$ret['lastupdate'];
			$txt_sourceid=array_key_exists('txt_sourceid',$ret)?$ret['txt_sourceid']:null;
			$chapterorder_real=array_key_exists('chapterorder_real',$ret)?intval($ret['chapterorder_real']):0;
			$chapterid_real=array_key_exists('chapterid_real',$ret)?intval($ret['chapterid_real']):0;
			if(array_key_exists('cid_norm',$ret))$sourcecid=intval($ret['cid_norm']);
			$cache_ok=true;
		}
	}
}

if(!$cache_ok)
{
	$sql='SELECT chapterid,chapterorder,chaptername,'.$dbarr['words'].',lastupdate FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chaptertype = 0 ORDER BY chapterorder ASC';
	$res=$db->ss_query($sql);
	if(!$res->num_rows)Url::ss_errpage();
	$idx=0;
	while($row=mysqli_fetch_assoc($res))
	{
		$cid_real=intval($row['chapterid']);
		$order_val=intval($row['chapterorder']);
		$compare_id=$use_orderid?$order_val:$cid_real;

		$chapterids[]=$compare_id;
		$chapterid_list[]=$cid_real;
		$chaptername_list[]=$row['chaptername'];
		$chapterwords_list[]=$row[$dbarr['words']];
		$lastupdate_list[]=$row['lastupdate'];

		if(!$use_orderid)
		{
			if($sourcecid===$cid_real)
			{
				$txt_sourceid=$cid_real;
				$chapterorder_real=$order_val;
				$chapterid_real=$cid_real;
				$chaptername=Text::ss_toutf8($row['chaptername']);
				if($is_ft)$chaptername=Convert::jt2ft($chaptername);
				$chapterwords=round($row[$dbarr['words']]/2);
				$lastupdate=$row['lastupdate'];
			}
		}
		else
		{
			// 1) match by chapterorder
			if($sourcecid===$order_val)
			{
				$txt_sourceid=$cid_real;
				$chapterorder_real=$order_val;
				$chapterid_real=$cid_real;
				$chaptername=Text::ss_toutf8($row['chaptername']);
				if($is_ft)$chaptername=Convert::jt2ft($chaptername);
				$chapterwords=round($row[$dbarr['words']]/2);
				$lastupdate=$row['lastupdate'];
			}
			// 2) fallback: old mixed chapterid link (decoded to real chapterid)
			else if($sourcecid_mixed_candidate!==null && $cid_real===$sourcecid_mixed_candidate)
			{
				$sourcecid=$order_val; // normalize to order for prev/next/urls
				$txt_sourceid=$cid_real;
				$chapterorder_real=$order_val;
				$chapterid_real=$cid_real;
				$chaptername=Text::ss_toutf8($row['chaptername']);
				if($is_ft)$chaptername=Convert::jt2ft($chaptername);
				$chapterwords=round($row[$dbarr['words']]/2);
				$lastupdate=$row['lastupdate'];
			}
		}
		$idx++;
	}

	// 3) extra fallback: if url uses sequential index instead of chapterorder, try map by position
	if($use_orderid && $txt_sourceid===null)
	{
		$cnt=count($chapterid_list);
		// treat as 0-based index
		if($sourcecid>=0 && $sourcecid<$cnt)
		{
			$i=$sourcecid;
			$txt_sourceid=$chapterid_list[$i];
			$sourcecid=intval($chapterids[$i]);
			$chapterorder_real=intval($sourcecid);
			$chapterid_real=intval($txt_sourceid);
			$chaptername=Text::ss_toutf8($chaptername_list[$i]);
			if($is_ft)$chaptername=Convert::jt2ft($chaptername);
			$chapterwords=round($chapterwords_list[$i]/2);
			$lastupdate=$lastupdate_list[$i];
		}
		// treat as 1-based index
		else if($sourcecid>0 && ($sourcecid-1)<$cnt)
		{
			$i=$sourcecid-1;
			$txt_sourceid=$chapterid_list[$i];
			$sourcecid=intval($chapterids[$i]);
			$chapterorder_real=intval($sourcecid);
			$chapterid_real=intval($txt_sourceid);
			$chaptername=Text::ss_toutf8($chaptername_list[$i]);
			if($is_ft)$chaptername=Convert::jt2ft($chaptername);
			$chapterwords=round($chapterwords_list[$i]/2);
			$lastupdate=$lastupdate_list[$i];
		}
	}

	if(isset($redis))
	{
		$ret=[
			'chapterids'=>$chapterids,
			'chaptername'=>$chaptername,
			'chapterwords'=>$chapterwords,
			'lastupdate'=>$lastupdate,
			'txt_sourceid'=>$txt_sourceid,
			'chapterorder_real'=>$chapterorder_real,
			'chapterid_real'=>$chapterid_real,
			'cid_norm'=>$sourcecid
		];
		$redis->ss_setex($uri_key,$cache_time,$ret);
	}
}

// normalize current cid for paging (use order when use_orderid=1)
$chapterid=$use_orderid?$sourcecid:$chapterid;

$info_url=Url::info_url($articleid);
$index_url=Url::index_url($articleid);

$pre_cid=0;
$next_cid=0;
$chapters=count($chapterids);

$offset=array_search($sourcecid,$chapterids,true);
if($offset===false)$offset=0;
$offset==0?$pre_cid=0:$pre_cid=$chapterids[$offset-1];
$offset==$chapters-1?$next_cid=0:$next_cid=$chapterids[$offset+1];

if($pre_cid==0)
{
	$pre_url=$info_url;
}
else
{
	$tmpvar=($is_multiple&&!$use_orderid)?ss_newid($pre_cid):$pre_cid;
	$pre_url=Url::chapter_url($articleid,$tmpvar);
}
if($next_cid==0)
{
	$next_url=$info_url;
}
else
{
	$tmpvar=($is_multiple&&!$use_orderid)?ss_newid($next_cid):$next_cid;
	$next_url=Url::chapter_url($articleid,$tmpvar);
}

// load chapter content
if($use_orderid)
{
	if($txt_sourceid===null)
	{
		$content='';
	}
	else
	{
		$txtfile=$txt_url.'/'.$subaid.'/'.$sourceid.'/'.$txt_sourceid.'.txt';
		$content=Text::ss_get_contents($txtfile);
	}
}
else
{
	$txtfile=$txt_url.'/'.$subaid.'/'.$sourceid.'/'.$sourcecid.'.txt';
	$content=Text::ss_get_contents($txtfile);
}

$need_patch = (strlen($content)===0||stripos($content,'not found'));
if(!$need_patch)
{
	$content=Text::ss_toutf8($content);
	$content=preg_replace('#<br\s*/?>#isU',"\r\n",$content);
	if(ss_cp_is_short($content,$chapter_patch_min_len))$need_patch=1;
}
else
{
	$content='';
}

if($need_patch)
{
	// 兜底：补丁表 -> Hub sources -> 远端 chapter_get（写回补丁表）
	$fb=ss_cp_get_or_fetch($sourceid,$chapterorder_real,$articlename,$author,$chaptername);
	if(strlen($fb)>0)
	{
		$content=Text::ss_toutf8($fb);
		$content=preg_replace('#<br\s*/?>#isU',"\r\n",$content);
	}
	else
	{
		$content='';
	}
}

switch($readpage_split_mode)
{
	case 1:if($readpage_split_lines<count(explode("\n",$content)))
	{
		$content_arr=Text::readpage_split($content);
		$max_pid=count($content_arr);
		if($now_pid>$max_pid)$now_pid=$max_pid;
		if($now_pid<1)$now_pid=1;
		$rico_content=$content_arr[$now_pid-1];
		if($now_pid>1)
		{
			if($now_pid==2)
			{
				$prevpage_url=Url::chapter_url($articleid,$chapterid);
			}
			else
			{
				$prevpage_url=Url::chapter_url($articleid,$chapterid,($now_pid-1));
			}
		}
		if($now_pid<$max_pid)
		{
			$nextpage_url=Url::chapter_url($articleid,$chapterid,($now_pid+1));
		}
	}
	else
	{
		$rico_content=Text::ss_txt2p($content);
	}
	break;
	case 2:$allwords=mb_strlen($content);
	$max_pid=ceil($allwords/$readpage_split_lines);
	if($now_pid>$max_pid)$now_pid=$max_pid;
	if($now_pid<1)$now_pid=1;
	$rico_content=Text::ss_txt2p(mb_substr($content,($now_pid-1)*$readpage_split_lines,$readpage_split_lines));
	if($now_pid>1)
	{
		if($now_pid==2)
		{
			$prevpage_url=Url::chapter_url($articleid,$chapterid);
		}
		else
		{
			$prevpage_url=Url::chapter_url($articleid,$chapterid,($now_pid-1));
		}
	}
	if($now_pid<$max_pid)
	{
		$nextpage_url=Url::chapter_url($articleid,$chapterid,($now_pid+1));
	}
	break;
	default:$rico_content=Text::ss_txt2p($content);
	break;
}

if($ShipSayFilter['is_filter'])$rico_content=Text::ss_filter($rico_content,$ShipSayFilter['filter_ini']);
if($is_ft)$rico_content=Convert::jt2ft($rico_content);
$reader_des=mb_substr(preg_replace('/<\/?p>/is','',$rico_content),0,200);

if($is_attachment&&!empty($att_url)&&$now_pid==$max_pid)
{
	$att_chapterid=$use_orderid?($txt_sourceid===null?0:$txt_sourceid):$sourcecid;
	$sql='SELECT attachment FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE chapterid = '.$att_chapterid;
	if(isset($redis)&&$redis->ss_get($sql))
	{
		$res=$redis->ss_get($sql);
	}
	else
	{
		$res=$db->ss_getone($sql);
		if(isset($redis))$redis->ss_setex($sql,$cache_time,$res);
	}
	$att_url.='/'.$subaid.'/'.$sourceid.'/'.$att_chapterid;
	$attHtml='';
	$regex='/("postfix";s:3:"(.+?)".+?"attachid";i:(\d+?);)/i';
	preg_match_all($regex,$res['attachment'],$atts);
	foreach($atts[3]as $k=>$v)
	{
		$attHtml.='<img class="ss-image-content" src="'.$att_url.'/'.$v.'.'.$atts[2][$k].'"/>';
	}
	$rico_content.=$attHtml;
}

if(strlen($rico_content)<=0)
{
	if(!isset($chaptername))$chaptername=$chapterwords=$lastupdate='';
	$rico_content='章节内容缺失或章节不存在！请稍后重新尝试！';
}

if(isset($_REQUEST['json']))
{
	echo json_encode($rico_content,JSON_UNESCAPED_UNICODE);
}
else
{
	if(is_numeric($lastupdate) && $lastupdate>0)
	{
		header('Last-Modified: '.date('D, d M Y H:i:s',$lastupdate-8*60*60).' GMT');
	}
	require_once __THEME_DIR__.'/tpl_reader.php';
}
