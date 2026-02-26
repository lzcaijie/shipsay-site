<?php

// [MODLOG 2026-02-12] 兜底补章：缺章/短章时读取补丁表并可远端拉取
require_once __ROOT_DIR__.'/shipsay/include/chapter_patch.php';

$now_pid=$_POST['pid'];
$articleid=$sourceid=$_POST['articleid'];
$chapterid=$sourcecid=$_POST['chapterid'];
if($is_multiple)
{
	$sourceid=ss_sourceid($sourceid);
	// use_orderid=1 时 chapterid 传的是 chapterorder（不参与混淆解混淆）
	if(!$use_orderid)
	{
		$sourcecid=ss_sourceid($sourcecid);
	}
}

$subaid=intval($sourceid/1000);

// 章节ID/顺序号解析（use_orderid=1 时 chapterid 传的是 chapterorder）
$txt_sourcecid=$sourcecid;
$chapterorder_real=0;
$chaptername='';
$articlename='';
$author='';

if($use_orderid)
{
	global $redis, $cache_time;
	$chapterorder_real=(int)$sourcecid;
	$mapped_ok=0;

	// use_orderid 会导致每次 reader_js 请求额外做一次 chapterorder→chapterid 映射查询：
	// 这里用 Redis 缓存映射结果，降低 DB 读放大（TTL>=1h，默认复用 cache_time）
	$ckey='cp_map:aid='.$sourceid.'&ord='.$chapterorder_real;
	$row=null;
	if(isset($redis))
	{
		$row=$redis->ss_get($ckey);
	}
	if(!is_array($row)||empty($row['chapterid']))
	{
		$sql='SELECT chapterid,chapterorder,chaptername FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chapterorder = '.$chapterorder_real.' AND chaptertype = 0 LIMIT 1';
		$row=$db->ss_getone($sql);
		if(isset($redis)&&is_array($row)&&!empty($row['chapterid']))
		{
			$ttl=isset($cache_time)?max(3600,(int)$cache_time):3600;
			// 仅缓存必要字段（chaptername 保留原编码，取用时再 ss_toutf8）
			$redis->ss_setex($ckey,$ttl,[
				'chapterid'=>(int)$row['chapterid'],
				'chapterorder'=>(int)$row['chapterorder'],
				'chaptername'=>(string)$row['chaptername'],
			]);
		}
	}

	if(is_array($row)&&!empty($row['chapterid']))
	{
		$txt_sourcecid=$row['chapterid'];
		$mapped_ok=1;
		$chapterid=$chapterorder_real; // canonical: reader_js 返回的分页链接按 chapterorder
		$chaptername=Text::ss_toutf8($row['chaptername']);
		if($is_ft)$chaptername=Convert::jt2ft($chaptername);
	}
}

if($use_orderid && empty($mapped_ok))
{
	// 兼容旧页面/缓存：POST 的 chapterid 可能仍是旧模式（混淆后的 chapterid）
	$legacy_chapterid=$sourcecid;
	if($is_multiple)$legacy_chapterid=ss_sourceid($legacy_chapterid);
	$sql='SELECT chapterid,chapterorder,chaptername FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chapterid = '.$legacy_chapterid.' AND chaptertype = 0 LIMIT 1';
	$row=$db->ss_getone($sql);
	if(is_array($row)&&!empty($row['chapterid'])&&!empty($row['chapterorder']))
	{
		$txt_sourcecid=(int)$row['chapterid'];
		$chapterorder_real=(int)$row['chapterorder'];
		$chapterid=$chapterorder_real;
		$chaptername=Text::ss_toutf8($row['chaptername']);
		if($is_ft)$chaptername=Convert::jt2ft($chaptername);
	}
}

$txtfile=$txt_url.'/'.$subaid.'/'.$sourceid.'/'.$txt_sourcecid.'.txt';
$content=Text::ss_get_contents($txtfile);
$need_patch=(strlen($content)===0||stripos($content,'not found'));
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
	// 尽量延迟 DB 查询：只有缺章/短章才查书名作者 & 章节顺序号
	$sql='SELECT articlename,author FROM '.$dbarr['pre'].'article_article WHERE articleid = '.$sourceid.' LIMIT 1';
	$info=$db->ss_getone($sql);
	if(is_array($info))
	{
		$articlename=Text::ss_toutf8($info['articlename']);
		$author=Text::ss_toutf8($info['author']);
		if($is_ft){$articlename=Convert::jt2ft($articlename);$author=Convert::jt2ft($author);}
	}

	if(!$use_orderid)
	{
		$sql='SELECT chapterorder,chaptername FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chapterid = '.$sourcecid.' AND chaptertype = 0 LIMIT 1';
		$row=$db->ss_getone($sql);
		if(is_array($row)&&!empty($row['chapterorder']))
		{
			$chapterorder_real=(int)$row['chapterorder'];
			$chaptername=Text::ss_toutf8($row['chaptername']);
			if($is_ft)$chaptername=Convert::jt2ft($chaptername);
		}
	}

	if(!empty($articlename)&&!empty($author)&&$chapterorder_real>0)
	{
		$fb=ss_cp_get_or_fetch($sourceid,$chapterorder_real,$articlename,$author,$chaptername);
		if(strlen($fb)>0)
		{
			$content=Text::ss_toutf8($fb);
			$content=preg_replace('#<br\s*/?>#isU',"\r\n",$content);
		}
	}
}
if(strlen($content)<=0)
{
	$content='章节内容缺失或章节不存在！请稍后重新尝试！';
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
echo $rico_content;
