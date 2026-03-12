<?php

if(!file_exists(__THEME_DIR__.'/tpl_author.php')) Url::ss_errpage();

if(!function_exists('ss_author_short_text'))
{
    function ss_author_short_text($text,$length=2)
    {
        $text=(string)$text;
        if($text==='') return '';
        if(function_exists('mb_substr')) return mb_substr($text,0,$length,'UTF-8');
        return substr($text,0,$length);
    }
}

$author = isset($matches[1]) ? Text::ss_toutf8(urldecode($matches[1])) : '';
if($is_ft) $author = Convert::jt2ft($author,1);
$author_sql = addslashes($author);
$author_count = 0;
$res = [];
$sortcategory = [];

if(!empty($sortarr) && is_array($sortarr))
{
    foreach($sortarr as $k=>$v)
    {
        $tmpurl = $is_sortid ? Url::category_url($k) : Url::category_url($v['code']);
        $caption = isset($v['caption']) ? Text::ss_toutf8($v['caption']) : '';
        if($is_ft) $caption = Convert::jt2ft($caption);
        $sortcategory[$k] = [
            'sorturl' => $tmpurl,
            'sortname' => $caption,
            'sortname_2' => ss_author_short_text($caption,2),
        ];
    }
}

if($author_sql !== '')
{
    $sql_count = 'SELECT COUNT(*) AS cnt FROM '.$dbarr['pre'].'article_article WHERE display <> 1 AND '.$dbarr['words'].' >= 0 AND author = "'.$author_sql.'"';
    if(isset($redis))
    {
        $cnt_key = 'author_cnt_'.md5(strtolower($author_sql));
        $cnt_val = $redis->ss_get($cnt_key);
        if($cnt_val===false || $cnt_val===null || $cnt_val==='')
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
if($author_count<=0) $author_count = count($res);

if($is_ft) $author = Convert::jt2ft($author);
require_once __THEME_DIR__.'/tpl_author.php';
?>
