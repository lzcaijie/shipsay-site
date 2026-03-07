<?php if (!defined('__ROOT_DIR__')) exit;

// shipsay/configs/seo_tpl.php
// Fixed SEO templates for subsite (recommended).
// Placeholders supported: {SITE_NAME} {articlename} {author} {chaptername} {sortname} {page} {searchkey} {ranktitle} {intro_p}
// NOTE: We only set defaults if the variable is empty, so you can override elsewhere if needed.

if (!isset($seo_home_title_tpl) || $seo_home_title_tpl==='') $seo_home_title_tpl = '{SITE_NAME} - 免费小说在线阅读';
if (!isset($seo_home_keywords_tpl) || $seo_home_keywords_tpl==='') $seo_home_keywords_tpl = '{SITE_NAME},小说,小说网,最新章节,免费阅读';
if (!isset($seo_home_desc_tpl) || $seo_home_desc_tpl==='') $seo_home_desc_tpl = '{SITE_NAME}为您提供热门小说最新章节免费阅读。';

if (!isset($seo_info_title_tpl) || $seo_info_title_tpl==='') $seo_info_title_tpl = '{articlename}最新章节目录_{author}著_{SITE_NAME}';
if (!isset($seo_info_keywords_tpl) || $seo_info_keywords_tpl==='') $seo_info_keywords_tpl = '{articlename},{author},{SITE_NAME},最新章节,全文阅读';
if (!isset($seo_info_desc_tpl) || $seo_info_desc_tpl==='') $seo_info_desc_tpl = '《{articlename}》作者：{author}，简介：{intro_p}';

if (!isset($seo_indexlist_title_tpl) || $seo_indexlist_title_tpl==='') $seo_indexlist_title_tpl = '《{articlename}》章节目录_第{page}页_{SITE_NAME}';
if (!isset($seo_indexlist_keywords_tpl) || $seo_indexlist_keywords_tpl==='') $seo_indexlist_keywords_tpl = '{articlename}目录,{SITE_NAME},章节列表,第{page}页';
if (!isset($seo_indexlist_desc_tpl) || $seo_indexlist_desc_tpl==='') $seo_indexlist_desc_tpl = '《{articlename}》章节目录第{page}页，尽在{SITE_NAME}。';

if (!isset($seo_reader_title_tpl) || $seo_reader_title_tpl==='') $seo_reader_title_tpl = '{chaptername}_{articlename}_{SITE_NAME}';
if (!isset($seo_reader_keywords_tpl) || $seo_reader_keywords_tpl==='') $seo_reader_keywords_tpl = '{articlename},{chaptername},{SITE_NAME},在线阅读';
if (!isset($seo_reader_desc_tpl) || $seo_reader_desc_tpl==='') $seo_reader_desc_tpl = '《{articlename}》最新章节：{chaptername}，作者：{author}。';

if (!isset($seo_category_title_tpl) || $seo_category_title_tpl==='') $seo_category_title_tpl = '{sortname}小说_第{page}页_{SITE_NAME}';
if (!isset($seo_category_keywords_tpl) || $seo_category_keywords_tpl==='') $seo_category_keywords_tpl = '{sortname}小说,{SITE_NAME},排行榜,第{page}页';
if (!isset($seo_category_desc_tpl) || $seo_category_desc_tpl==='') $seo_category_desc_tpl = '{sortname}小说列表第{page}页，热门推荐尽在{SITE_NAME}。';

if (!isset($seo_author_title_tpl) || $seo_author_title_tpl==='') $seo_author_title_tpl = '{author}作品大全_{SITE_NAME}';
if (!isset($seo_author_keywords_tpl) || $seo_author_keywords_tpl==='') $seo_author_keywords_tpl = '{author},{SITE_NAME},作品集,小说';
if (!isset($seo_author_desc_tpl) || $seo_author_desc_tpl==='') $seo_author_desc_tpl = '作者{author}作品列表与最新章节，尽在{SITE_NAME}。';

if (!isset($seo_search_title_tpl) || $seo_search_title_tpl==='') $seo_search_title_tpl = '{searchkey}搜索结果_{SITE_NAME}';
if (!isset($seo_search_keywords_tpl) || $seo_search_keywords_tpl==='') $seo_search_keywords_tpl = '{searchkey},{SITE_NAME},搜索,小说';
if (!isset($seo_search_desc_tpl) || $seo_search_desc_tpl==='') $seo_search_desc_tpl = '{searchkey}相关小说搜索结果，尽在{SITE_NAME}。';

if (!isset($seo_rank_title_tpl) || $seo_rank_title_tpl==='') $seo_rank_title_tpl = '{ranktitle}_{SITE_NAME}';
if (!isset($seo_rank_keywords_tpl) || $seo_rank_keywords_tpl==='') $seo_rank_keywords_tpl = '{ranktitle},{SITE_NAME},排行榜,热门小说';
if (!isset($seo_rank_desc_tpl) || $seo_rank_desc_tpl==='') $seo_rank_desc_tpl = '{ranktitle}榜单，尽在{SITE_NAME}。';

?>