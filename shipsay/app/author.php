<?php

if(!file_exists(__THEME_DIR__.'/tpl_author.php'))Url::ss_errpage();
$author=Text::ss_toutf8(urldecode($matches[1]));
if($is_ft)$author=Convert::jt2ft($author,1);
$author_sql=addslashes($author);

$author_count=0;

if(isset($redis))
{
	$cnt_key='author_cnt_'.md5(strtolower($author_sql));
	$cnt_val=$redis->ss_get($cnt_key);
	if($cnt_val===false || $cnt_val===null || $cnt_val==='') {
		$sql_count='SELECT COUNT(*) AS cnt FROM '.$dbarr['pre'].'article_article WHERE display <> 1 AND '.$dbarr['words'].' >= 0 AND author = "'.$author_sql.'"';
		$cnt_row=$db->ss_getone($sql_count);
		$author_count=isset($cnt_row['cnt'])?intval($cnt_row['cnt']):0;
		$redis->ss_setex($cnt_key,2592000,$author_count);
	} else {
		$author_count=intval($cnt_val);
	}
}
else
{
	$sql_count='SELECT COUNT(*) AS cnt FROM '.$dbarr['pre'].'article_article WHERE display <> 1 AND '.$dbarr['words'].' >= 0 AND author = "'.$author_sql.'"';
	$cnt_row=$db->ss_getone($sql_count);
	$author_count=isset($cnt_row['cnt'])?intval($cnt_row['cnt']):0;
}

$sql=$rico_sql.'AND author = "'.$author_sql.'" ORDER BY lastupdate DESC LIMIT 50';
if(isset($redis))
{
	$res=$redis->ss_redis_getrows($sql,$cache_time);
}
else
{
	$res=$db->ss_getrows($sql);
}

if($author_count<=0) $author_count=is_array($res)?count($res):0;

if($is_ft)$author=Convert::jt2ft($author);
require_once __THEME_DIR__.'/tpl_author.php';
?>
