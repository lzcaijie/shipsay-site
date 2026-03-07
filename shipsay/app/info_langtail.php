<?php

$langtail_articleid = $langtail_sourceid = $matches[1];
if(!file_exists(__THEME_DIR__.'/tpl_info.php')) Url::ss_errpage();

// 长尾表 langid 使用的是长尾自身 id；sourceid 存的是真实 articleid。
if($is_multiple) $langtail_sourceid = ss_sourceid($langtail_sourceid);
$langtail_sql = 'SELECT sourceid,langname,sourcename FROM shipsay_article_langtail WHERE langid = '.intval($langtail_sourceid);
$lang_res = $db->ss_getone($langtail_sql);
if(!is_array($lang_res) || empty($lang_res['sourceid'])) Url::ss_errpage();

// 注意：这里必须按真实 articleid 查书，不能套普通详情页的 articlecode 分支，
// 否则开启 is_acode=1 时长尾详情会直接查空。
$sourceid = intval($lang_res['sourceid']);
$articleid = $is_multiple ? ss_newid($sourceid) : $sourceid;
// 长尾详情页的“查看目录/全部目录”应跳真实书籍目录，不走长尾伪目录。
$index_url = Url::index_url($articleid);
$articlename = $lang_res['langname'];
$sourcename = $lang_res['sourcename'];

$sql = $rico_sql.'AND articleid = '.$sourceid;
if(isset($redis))
{
    $infoarr = $redis->ss_redis_getrows($sql,$info_cache_time);
}
else
{
    $infoarr = $db->ss_getrows($sql);
}
if(!is_array($infoarr) || empty($infoarr[0])) Url::ss_errpage();

if($is_langtail===1)
{
    if($is_ft) $sourcename = Convert::jt2ft($sourcename,1);
    include_once __ROOT_DIR__.'/shipsay/include/langtail.php';
}
$author = $infoarr[0]['author'];
$author_arr = explode(',',$author);
$author_url = $infoarr[0]['author_url'];
$keywords = $infoarr[0]['keywords'];
$keywords_arr = !empty($infoarr[0]['keywords_arr']) ? $infoarr[0]['keywords_arr'] : explode(',',$keywords);
$img_url = $infoarr[0]['img_url'];
$sortid = $infoarr[0]['sortid'];
$sortname = $infoarr[0]['sortname'];
$sorturl = Sort::ss_sorturl($sortid);
$isfull = $infoarr[0]['isfull'];
$words_w = $infoarr[0]['words_w'];
$intro = $infoarr[0]['intro'];
$intro_des = $infoarr[0]['intro_des'];
$intro_p = $infoarr[0]['intro_p'];
$allvisit = $infoarr[0]['allvisit'];
$goodnum = $infoarr[0]['goodnum'];
$ratenum = $infoarr[0]['ratenum'];
$ratesum = $infoarr[0]['ratesum'];
$score = isset($infoarr[0]['score']) ? $infoarr[0]['score'] : ($ratenum>0?sprintf('%.1f ',$ratesum/$ratenum):'0.0');

$sql='SELECT chapterid,chaptername,lastupdate,chaptertype,chapterorder FROM '.$dbarr['pre'].$db->get_cindex($sourceid).' WHERE articleid = '.$sourceid.' AND chaptertype = 0 ORDER BY chapterorder ASC';
$chapterrows=array();
if(isset($redis)&&$redis->ss_get($sql))
{
    $chapterrows=$redis->ss_get($sql);
}
else
{
    $res=$db->ss_query($sql);
    if($res && $res->num_rows)
    {
        $k=0;
        while($row=mysqli_fetch_assoc($res))
        {
            $cid=$use_orderid?$row['chapterorder']:$row['chapterid'];
            if($is_multiple)$cid=ss_newid($cid);
            $chapterrows[$k]['chaptertype']=$row['chaptertype'];
            $chapterrows[$k]['lastupdate']=$row['lastupdate'];
            $chapterrows[$k]['cid_url']=Url::chapter_url($articleid,$cid);
            $chapterrows[$k]['cname']=Text::ss_toutf8($row['chaptername']);
            if($is_ft)$chapterrows[$k]['cname']=Convert::jt2ft($chapterrows[$k]['cname']);
            $k++;
        }
        if(isset($redis))$redis->ss_setex($sql,$info_cache_time,$chapterrows);
    }
}
if(empty($chapterrows)) Url::ss_errpage();
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
$lm_ts=$lastupdate_stamp-8*60*60;
$lm_gmt=date('D, d M Y H:i:s',$lm_ts).' GMT';
$etag='"langtail-info-'.$sourceid.'-'.$lastupdate_stamp.'-uo'.(int)$use_orderid.'-m'.(int)$is_multiple.'-ft'.(int)$is_ft.'"';
header('Last-Modified: '.$lm_gmt);
header('ETag: '.$etag);
$max_age=(int)$info_cache_time;
if($max_age<=0)$max_age=300;
if($max_age>86400)$max_age=86400;
header('Cache-Control: public, max-age='.$max_age.', s-maxage='.$max_age);
$inm=isset($_SERVER['HTTP_IF_NONE_MATCH'])?trim($_SERVER['HTTP_IF_NONE_MATCH']):'';
if($inm!=='' && $inm===$etag){header('HTTP/1.1 304 Not Modified');exit;}
$ims=isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])?strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']):0;
if($ims>0 && $ims>=$lm_ts){header('HTTP/1.1 304 Not Modified');exit;}
require_once __THEME_DIR__.'/tpl_info.php';
?>
