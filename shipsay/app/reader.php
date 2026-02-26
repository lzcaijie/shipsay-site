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
$chapterid=$matches[2];
$sourcecid=intval($chapterid);
if(isset($matches[3]))$now_pid=str_replace('_','',$matches[3]);
if($is_multiple)
{
	$sourceid=ss_sourceid($sourceid);
	if(!$use_orderid)
	{
		$sourcecid=ss_sourceid($sourcecid);
	}
}
$max_pid=1;
$prevpage_url='';
$nextpage_url='';
$subaid=intval($sourceid/1000);
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

$info_url=Url::info_url($articleid);
$index_url=Url::index_url($articleid);

$chapterid_real=0;
$chapterorder_real=0;
$txt_sourceid=0;

$chapter_tbl=$dbarr['pre'].$db->get_cindex($sourceid);

// use_orderid=1：章节参数为 chapterorder（1/2/3...）；旧混淆链接为 chapterid+550，需要 301 到新链接
if($use_orderid)
{
	$mixed_real_cid=$sourcecid-550;
	if($mixed_real_cid>=0)
	{
		$sql_mixed='SELECT chapterorder FROM '.$chapter_tbl.' WHERE articleid = '.$sourceid.' AND chaptertype = 0 AND chapterid = '.$mixed_real_cid.' LIMIT 1';
		$cache_key=$sql_mixed.'|uo=1';
		if(isset($redis)&&$redis->ss_get($cache_key))
		{
			$tmp=$redis->ss_get($cache_key);
		}
		else
		{
			$tmp=$db->ss_getone($sql_mixed);
			if(isset($redis))$redis->ss_setex($cache_key,$cache_time,$tmp);
		}
		$target_order=isset($tmp['chapterorder'])?intval($tmp['chapterorder']):0;
		if($target_order>0)
		{
			$location=Url::chapter_url($articleid,$target_order,$now_pid);
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.$location);
			exit;
		}
	}
	$sql_cur='SELECT chapterid,chapterorder,chaptername,'.$dbarr['words'].',lastupdate FROM '.$chapter_tbl.' WHERE articleid = '.$sourceid.' AND chaptertype = 0 AND chapterorder = '.$sourcecid.' LIMIT 1';
	$cur_key=$sql_cur.'|uo=1';
	if(isset($redis)&&$redis->ss_get($cur_key))
	{
		$row=$redis->ss_get($cur_key);
	}
	else
	{
		$row=$db->ss_getone($sql_cur);
		if(isset($redis))$redis->ss_setex($cur_key,$cache_time,$row);
	}
	if(!is_array($row)||empty($row['chapterid']))Url::ss_errpage();
	$chapterid_real=intval($row['chapterid']);
	$chapterorder_real=intval($row['chapterorder']);
	$txt_sourceid=$chapterid_real;
	$chaptername=Text::ss_toutf8($row['chaptername']);
	if($is_ft)$chaptername=Convert::jt2ft($chaptername);
	$chapterwords=round($row[$dbarr['words']]/2);
	$lastupdate=$row['lastupdate'];
}
else
{
	$sql_cur='SELECT chapterid,chapterorder,chaptername,'.$dbarr['words'].',lastupdate FROM '.$chapter_tbl.' WHERE articleid = '.$sourceid.' AND chaptertype = 0 AND chapterid = '.$sourcecid.' LIMIT 1';
	$cur_key=$sql_cur.'|uo=0|im='.(int)$is_multiple;
	if(isset($redis)&&$redis->ss_get($cur_key))
	{
		$row=$redis->ss_get($cur_key);
	}
	else
	{
		$row=$db->ss_getone($sql_cur);
		if(isset($redis))$redis->ss_setex($cur_key,$cache_time,$row);
	}
	if(!is_array($row)||empty($row['chapterid']))Url::ss_errpage();
	$chapterid_real=intval($row['chapterid']);
	$chapterorder_real=intval($row['chapterorder']);
	$txt_sourceid=$chapterid_real;
	$chaptername=Text::ss_toutf8($row['chaptername']);
	if($is_ft)$chaptername=Convert::jt2ft($chaptername);
	$chapterwords=round($row[$dbarr['words']]/2);
	$lastupdate=$row['lastupdate'];
}

// 上一章/下一章（按 chapterorder）
$pre_url=$info_url;
$next_url=$info_url;

$sql_pre='SELECT chapterid,chapterorder FROM '.$chapter_tbl.' WHERE articleid = '.$sourceid.' AND chaptertype = 0 AND chapterorder < '.$chapterorder_real.' ORDER BY chapterorder DESC LIMIT 1';
$pre_key=$sql_pre.'|uo='.(int)$use_orderid.'|im='.(int)$is_multiple;
if(isset($redis)&&$redis->ss_get($pre_key))
{
	$pre_row=$redis->ss_get($pre_key);
}
else
{
	$pre_row=$db->ss_getone($sql_pre);
	if(isset($redis))$redis->ss_setex($pre_key,$cache_time,$pre_row);
}
if(is_array($pre_row)&&!empty($pre_row['chapterid']))
{
	$pre_param=$use_orderid?intval($pre_row['chapterorder']):intval($pre_row['chapterid']);
	if(!$use_orderid&&$is_multiple)$pre_param=ss_newid($pre_param);
	$pre_url=Url::chapter_url($articleid,$pre_param);
}

$sql_next='SELECT chapterid,chapterorder FROM '.$chapter_tbl.' WHERE articleid = '.$sourceid.' AND chaptertype = 0 AND chapterorder > '.$chapterorder_real.' ORDER BY chapterorder ASC LIMIT 1';
$next_key=$sql_next.'|uo='.(int)$use_orderid.'|im='.(int)$is_multiple;
if(isset($redis)&&$redis->ss_get($next_key))
{
	$next_row=$redis->ss_get($next_key);
}
else
{
	$next_row=$db->ss_getone($sql_next);
	if(isset($redis))$redis->ss_setex($next_key,$cache_time,$next_row);
}
if(is_array($next_row)&&!empty($next_row['chapterid']))
{
	$next_param=$use_orderid?intval($next_row['chapterorder']):intval($next_row['chapterid']);
	if(!$use_orderid&&$is_multiple)$next_param=ss_newid($next_param);
	$next_url=Url::chapter_url($articleid,$next_param);
}

// txt 文件永远使用真实 chapterid
$txtfile=$txt_url.'/'.$subaid.'/'.$sourceid.'/'.$txt_sourceid.'.txt';
$content=Text::ss_get_contents($txtfile);
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
	$sql='SELECT attachment FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE chapterid = '.$chapterid_real;
	if(isset($redis)&&$redis->ss_get($sql))
	{
		$res=$redis->ss_get($sql);
	}
	else
	{
		$res=$db->ss_getone($sql);
		if(isset($redis))$redis->ss_setex($sql,$cache_time,$res);
	}
	$att_url.='/'.$subaid.'/'.$sourceid.'/'.$chapterid_real;
	$attHtml='';
	$regex='/"postfix";s:3:"(.+?)".+?"attachid";i:(\d+?);/i';
	preg_match_all($regex,$res['attachment'],$atts);
	foreach($atts[2]as $k=>$v)
	{
		$attHtml.='<img class="ss-image-content" src="'.$att_url.'/'.$v.'.'.$atts[1][$k].'"/>';
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
	header('Last-Modified: '.date('D, d M Y H:i:s',$lastupdate-8*60*60).' GMT');
	require_once __THEME_DIR__.'/tpl_reader.php';
}