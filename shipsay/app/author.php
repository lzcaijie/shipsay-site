<?php

if(!file_exists(__THEME_DIR__.'/tpl_author.php')) Url::ss_errpage();

$author = isset($matches[1]) ? Text::ss_toutf8(urldecode($matches[1])) : '';
if($is_ft) $author = Convert::jt2ft($author,1);
$author_sql = addslashes($author);
$author_count = 0;
$res = [];
$rand_authors = [];
$sortcategory = [];

foreach($sortarr as $k=>$v)
{
    $tmpurl = $is_sortid ? Url::category_url($k) : Url::category_url($v['code']);
    $v['caption'] = Text::ss_toutf8($v['caption']);
    if($is_ft) $v['caption'] = Convert::jt2ft($v['caption']);
    $sortcategory[$k] = [
        'sorturl' => $tmpurl,
        'sortname' => $v['caption'],
        'sortname_2' => @mb_substr($v['caption'],0,2),
    ];
}

if($author_sql !== '')
{
    $sql_count = 'SELECT COUNT(*) AS cnt FROM '.$dbarr['pre'].'article_article WHERE display <> 1 AND '.$dbarr['words'].' >= 0 AND author = "'.$author_sql.'"';
    if(isset($redis))
    {
        $cnt_key = 'author_cnt_'.md5(strtolower($author_sql));
        $cnt_val = $redis->ss_get($cnt_key);
        if($cnt_val === false || $cnt_val === null || $cnt_val === '')
        {
            $cnt_row = $db->ss_getone($sql_count);
            $author_count = isset($cnt_row['cnt']) ? intval($cnt_row['cnt']) : 0;
            $redis->ss_setex($cnt_key,2592000,$author_count);
        }
        else
        {
            $author_count = intval($cnt_val);
        }
    }
    else
    {
        $cnt_row = $db->ss_getone($sql_count);
        $author_count = isset($cnt_row['cnt']) ? intval($cnt_row['cnt']) : 0;
    }

    $sql = $rico_sql.'AND author = "'.$author_sql.'" ORDER BY lastupdate DESC LIMIT 50';
    if(isset($redis))
    {
        $res = $redis->ss_redis_getrows($sql, isset($cache_time) ? $cache_time : 3600);
    }
    else
    {
        $res = $db->ss_getrows($sql);
    }
}

if(!is_array($res)) $res = [];
if($author_count <= 0) $author_count = count($res);

foreach($res as $k=>$v)
{
    if(!isset($res[$k]['author_url']) || $res[$k]['author_url'] === '')
    {
        $res[$k]['author_url'] = Url::author_url(isset($v['author']) ? $v['author'] : $author);
    }
}

$sql_rand = 'SELECT author, COUNT(*) AS bookcount FROM '.$dbarr['pre'].'article_article WHERE display <> 1 AND '.$dbarr['words'].' >= 0 AND author <> "" GROUP BY author ORDER BY RAND() LIMIT 15';
if(isset($redis))
{
    $rand_authors = $redis->ss_redis_getrows($sql_rand,86400);
}
else
{
    $rand_authors = $db->ss_getrows($sql_rand);
}
if(!is_array($rand_authors)) $rand_authors = [];

if($is_ft) $author = Convert::jt2ft($author);
require_once __THEME_DIR__.'/tpl_author.php';
?>