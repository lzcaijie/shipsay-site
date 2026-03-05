<?php

// [MODLOG 2026-02-12] 兜底补章：缺章/短章时读取补丁表并可远端拉取
require_once __ROOT_DIR__.'/shipsay/include/chapter_patch.php';

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: public, max-age=60, s-maxage=60');

$now_pid=$_POST['pid'];
$articleid=$sourceid=$_POST['articleid'];
$chapterid=$sourcecid=$_POST['chapterid'];
if($is_multiple)
{
	$sourceid=ss_sourceid($sourceid);
	// use_orderid=1: chapterid in POST is zero-based order (do NOT ss_sourceid)
	if(!$use_orderid)$sourcecid=ss_sourceid($sourcecid);
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
	$chapterorder_real=(int)$sourcecid + 1;
	$sql='SELECT chapterid,chapterorder,chaptername FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chapterorder = '.$chapterorder_real.' AND chaptertype = 0 LIMIT 1';
	$row=$db->ss_getone($sql);
	if(is_array($row)&&!empty($row['chapterid']))
	{
		$txt_sourcecid=$row['chapterid'];
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