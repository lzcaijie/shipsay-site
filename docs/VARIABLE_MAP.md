# VARIABLE_MAP（Shipsay 变量与占位符总表）

> 目的：把“后台设置变量、URL 占位符、SEO 占位符、模板运行时变量”分开写清楚，避免后续 AI 或人工把不同层级的变量混用。
>
> 说明：本表基于 `fz1.112book.com_20260306v2` 最新源码扫描整理。

---

## 1. 使用原则

### 1.1 变量分四层

1. **后台配置变量**：来源于 `www/caijie/*` 后台设置与 `shipsay/configs/config.ini.php`
2. **URL 占位符**：用于伪静态路由模板，不是模板运行时变量
3. **SEO 占位符**：只用于 `shipsay/configs/seo_tpl.php`
4. **模板运行时变量**：由 `shipsay/app/*.php` 准备后传给 `themes/*/tpl_*.php`

### 1.2 禁止混用

错误示例：
- 把 `{aid}` 当成模板里的 PHP 变量
- 把 `$seo_title` 当成后台设置项
- 把 `$fake_top` 写死成 `/top/`

### 1.3 不确定变量先看真实运行结果

像章节区、分页页码、混淆后的 `cid` 这类变量，不能只靠局部代码字面判断真实语义。
必须结合：
- 真实运行页面
- 路由映射
- 当前模板输出结果
- 对应 `app/*` 的数据准备方式

确认后再写进标准；不确定时宁可暂缺，也不能写错。

---

## 2. 后台配置变量（`www/caijie/base/*`）

## 2.1 基础设置 `cfg_main.php`

| 变量 | 作用 | 备注 |
|---|---|---|
| `sitename` | 站点名称 | 最终生成 `SITE_NAME` |
| `txt_url` | TXT 源地址/文本地址 | 读章链路相关 |
| `txt_get_mode` | TXT 获取方式 | 后台可选项 |
| `remote_img_url` | 远程图片地址 | 图片源配置 |
| `local_img` | 本地化封面/图片 | 后台多选项 |
| `is_attachment` | 附件模式 | 文件资源相关 |
| `att_url` | 附件地址 | 附件根地址 |
| `root_dir` | 站点根目录 | 程序目录相关 |
| `commend_ids` | 首页推荐书 ID 集合 | 首页推荐模块使用 |
| `theme_dir` | 当前主题目录 | 模板分发/调用关键值 |
| `is_3in1` | 目录页三合一/单独页模式 | 目录链路相关 |
| `readpage_split_mode` | 阅读分页模式 | 阅读页分页相关 |
| `readpage_split_lines` | 阅读分页行数 | 阅读页分页相关 |
| `category_per_page` | 栏目页每页数量 | 分类列表分页 |
| `home_lastupdate_num` | 首页最近更新数量 | 首页列表数量 |
| `home_postdate_num` | 首页最新入库数量 | 首页列表数量 |
| `vote_perday` | 每日推荐/投票限制 | 推荐逻辑 |
| `count_visit` | 是否统计访问 | 详情/阅读访问链路 |

## 2.2 伪静态设置 `cfg_fake.php`

| 变量 | 作用 | 备注 |
|---|---|---|
| `fake_info_url` | 详情页 URL 模板 | 如 `/book/{aid}/` |
| `fake_chapter_url` | 阅读页 URL 模板 | 如 `/read/{aid}/{cid}.html` |
| `use_orderid` | 章节是否用排序 ID | 影响 `cid` 逻辑 |
| `fake_sort_url` | 分类页 URL 模板 | 如 `/sort/{sortcode}/{pid}/` |
| `fake_top` | 聚合排行榜入口 | 当前已扩展为单榜前缀 |
| `fake_recentread` | 阅读记录页地址 | 如 `/history.html` |
| `fake_indexlist` | 目录页 URL 模板 | 如 `/indexlist/{aid}/{pid}/` |
| `per_indexlist` | 目录分页每页章节数 | 目录页分页 |

## 2.3 长尾设置 `cfg_langtail.php`

| 变量 | 作用 | 备注 |
|---|---|---|
| `is_langtail` | 是否启用长尾 | 长尾详情/目录链路 |
| `langtail_catch_cycle` | 长尾采集周期 | 长尾采集策略 |
| `langtail_cache_time` | 长尾缓存时间 | 缓存配置 |
| `fake_langtail_info` | 长尾详情页 URL 模板 | 如 `/books/{aid}/` |
| `fake_langtail_indexlist` | 长尾目录页 URL 模板 | 如 `/indexs/{aid}/{pid}/` |
| `is_keywords` | 是否启用关键词 | 长尾关键词 |
| `keywords_num` | 关键词数量 | 长尾关键词数量 |
| `fake_tag` | tag 页 URL 模板 | 当前后台只读展示 |

## 2.4 高级设置 `cfg_adv.php`

| 变量 | 作用 | 备注 |
|---|---|---|
| `cache_homepage` | 首页缓存开关 | 首页缓存 |
| `cache_homepage_period` | 首页缓存周期 | 首页缓存 |
| `use_js` | 是否启用 JS 链路 | 阅读/前端相关 |
| `use_gzip` | gzip 开关 | 输出压缩 |
| `enable_down` | 是否允许下载 | 下载功能 |
| `is_ft` | 繁体模式 | 模板显示相关 |
| `site_url` | 站点主域名 | 站点地址 |
| `is_multiple` | 多站映射模式 | articleid/sourceid 相关 |
| `ss_newid` | 新 ID 规则 | 多站/新旧 ID 映射 |
| `ss_sourceid` | 源站 ID 规则 | 多站映射 |

## 2.5 Redis 设置 `cfg_redis.php`

| 变量 | 作用 | 备注 |
|---|---|---|
| `use_redis` | 是否启用 Redis | 缓存总开关 |
| `redishost` | Redis 主机 | 连接参数 |
| `redisport` | Redis 端口 | 连接参数 |
| `redispass` | Redis 密码 | 连接参数 |
| `redisdb` | Redis DB | 连接参数 |
| `redis_scope` | Redis 作用域/前缀 | 避免串缓存 |
| `home_cache_time` | 首页缓存时间 | 首页数据 |
| `info_cache_time` | 详情缓存时间 | 详情/目录/阅读相关 |
| `category_cache_time` | 分类缓存时间 | 栏目页 |
| `cache_time` | 通用缓存时间 | 其它列表 |

## 2.6 数据库设置 `cfg_database.php`

| 变量 | 作用 | 备注 |
|---|---|---|
| `dbhost` | DB 主机 | 数据库配置 |
| `dbport` | DB 端口 | 数据库配置 |
| `dbname` | DB 名称 | 数据库配置 |
| `dbuser` | DB 用户 | 数据库配置 |
| `dbpass` | DB 密码 | 数据库配置 |
| `db_pconnect` | 持久连接 | 数据库配置 |
| `authcode` | 授权码/系统校验 | 程序内部使用 |

---

## 3. URL 占位符（伪静态模板专用）

这些不是 PHP 变量，而是 URL 模板里的占位符。

| 占位符 | 含义 | 常见位置 |
|---|---|---|
| `{aid}` | 小说 ID | 详情/阅读/目录 |
| `{acode}` | 小说拼音或代码 | 详情页可选 |
| `{cid}` | 章节 ID | 阅读页 |
| `{subaid}` | 小说子序号 | 某些链路可选 |
| `{sortid}` | 分类 ID | 分类页 |
| `{sortcode}` | 分类拼音/code | 分类页 |
| `{pid}` | 页码 | 分类页/目录页/tag 页 |
| `{tag}` | tag 名称 | tag 页 |

### 当前源码中可确认的默认模板

```php
$fake_info_url = '/book/{aid}/';
$fake_chapter_url = '/read/{aid}/{cid}.html';
$fake_sort_url = '/sort/{sortcode}/{pid}/';
$fake_top = '/top/';
$fake_recentread = '/history.html';
$fake_indexlist = '/indexlist/{aid}/{pid}/';
$fake_langtail_info = '/books/{aid}/';
$fake_langtail_indexlist = '/indexs/{aid}/{pid}/';
```

---

## 4. SEO 占位符（`shipsay/configs/seo_tpl.php` 专用）

当前源码中已明确支持：

| 占位符 | 含义 |
|---|---|
| `{SITE_NAME}` | 站点名 |
| `{articlename}` | 书名 |
| `{author}` | 作者 |
| `{chaptername}` | 章节名 |
| `{sortname}` | 分类名 |
| `{page}` | 页码 |
| `{searchkey}` | 搜索词 |
| `{ranktitle}` | 排行榜标题 |
| `{intro_p}` | 简介纯文本/摘要 |

### 规则
- 这些占位符只用于 SEO 模板字符串
- 模板页本身不要再手写一套不一致的 title/meta 逻辑

---

## 5. 模板运行时变量（按页面分）

## 5.1 公共头部 `tpl_header.php`

| 变量 | 含义 |
|---|---|
| `$theme_dir` | 当前主题目录 |
| `$allbooks_url` | 书库入口 |
| `$allbooks_url_safe` | 书库入口安全兜底 |
| `$full_allbooks_url` | 完本入口基础值 |
| `$full_allbooks_url_safe` | 完本入口安全兜底 |
| `$fake_recentread` | 足迹/阅读记录入口 |
| `$recentread_url_safe` | 足迹入口安全兜底 |
| `$fake_search` | 搜索入口（若存在） |
| `$search_url_safe` | 搜索提交地址（安全兜底） |
| `$search_placeholder` | 搜索框占位文案 |
| `$rank_entry_safe` | 排行入口安全兜底 |

## 5.2 首页 `tpl_home.php`

| 变量 | 含义 |
|---|---|
| `$commend` | 首页推荐书列表 |
| `$popular` | 热门/排行榜入口数据 |
| `$lastupdate` | 最近更新列表 |
| `$postdate` | 最新入库列表 |
| `$link_html` | 友情链接 HTML |
| `$fake_top` | 排行入口前缀 |
| `$fake_rankstr` | 旧 rank 前缀（兼容） |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.3 分类页 `tpl_category.php`

| 变量 | 含义 |
|---|---|
| `$retarr` | 当前分类书籍列表 |
| `$sortcategory` | 分类导航集合 |
| `$sortid / $sortname` | 当前分类 |
| `$fullflag / $full_url / $allbooks_url` | 完本/书库链路 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.4 详情页 `tpl_info.php`

| 变量 | 含义 |
|---|---|
| `$articleid` | 小说 ID |
| `$articlename` | 书名 |
| `$author / $author_url` | 作者与作者页链接 |
| `$img_url` | 封面地址 |
| `$sortid / $sortname` | 分类信息 |
| `$isfull` | 完结状态 |
| `$words_w` | 字数（万字） |
| `$intro / $intro_p` | 简介原文 / 简介摘要 |
| `$lastchapter / $last_url` | 最新章节标题 / 链接 |
| `$lastchapter_arr` 或 `$lastarr` | 最新章节列表（模板实际用前需核对） |
| `$first_url` | 开始阅读链接 |
| `$index_url / $index_url_safe` | 目录页链接 |
| `$info_url / $info_url_safe` | 详情页当前链接（安全兜底） |
| `$intro_plain` | 详情页用于 SEO/结构化数据的简介纯文本 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.5 目录页 `tpl_indexlist.php`

| 变量 | 含义 |
|---|---|
| `$articlename` | 书名 |
| `$author / $author_url` | 作者与作者页 |
| `$img_url` | 封面 |
| `$sortid / $sortname` | 分类 |
| `$isfull` | 完结状态 |
| `$words_w` | 字数 |
| `$chapters` | 总章节数 |
| `$list_arr` | 当前页章节列表 |
| `$pid` | 当前目录分页页码 |
| `$first_url` | 开始阅读链接 |
| `$info_url` | 返回详情链接 |
| `$index_url / $indexlist_url_safe` | 当前目录基础链接 / 当前目录安全链接 |
| `$lastchapter / $last_url` | 最新章节信息 |
| `$lastupdate_cn` | 最新更新时间中文文案 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.6 阅读页 `tpl_reader.php`

| 变量 | 含义 |
|---|---|
| `$articlename` | 书名 |
| `$chaptername` | 当前章节名 |
| `$author / $author_url` | 作者与作者页 |
| `$sortid / $sortname` | 分类信息 |
| `$chapterwords` | 当前章字数 |
| `$rico_content` | 正文 HTML（核心变量） |
| `$reader_url_safe` | 当前阅读页安全链接 |
| `$pre_url / $next_url` | 上一章 / 下一章 |
| `$prevpage_url / $nextpage_url` | 阅读分页链接 |
| `$now_pid / $max_pid` | 阅读分页当前页 / 总页数 |
| `$index_url / $index_url_safe` | 返回目录 |
| `$info_url` | 返回详情 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.7 搜索页 `tpl_search.php`

| 变量 | 含义 |
|---|---|
| `$searchkey` | 搜索词 |
| `$search_res` | 搜索结果列表 |
| `$search_count` | 结果数 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.8 作者页 `tpl_author.php`

| 变量 | 含义 |
|---|---|
| `$author` | 作者名 |
| `$author_count` | 作品数量 |
| `$res` | 作者作品列表 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.9 排行榜 `tpl_rank.php / tpl_top.php / tpl_rank_list.php`

### 聚合页常用变量
| 变量 | 含义 |
|---|---|
| `$sortarr` | 全部分类 |
| `allvisit{sortid}` | 某分类总榜列表（由 `top.php` 动态变量准备） |
| `monthvisit{sortid}` | 某分类月榜 |
| `weekvisit{sortid}` | 某分类周榜 |

### 单榜页常用变量
| 变量 | 含义 |
|---|---|
| `$query` | 榜单 key，如 `monthvisit` |
| `$page_title` / `$current_title` | 当前榜单标题 |
| `$articlerows` | 榜单书籍列表 |
| `$fake_top` | 排行入口前缀 |
| `$fake_rankstr` | 旧 rank 前缀（兼容） |
| `$rank_base` / `$rank_entry_url` / `$rank_detail_base` | 排行链接基础值 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.10 阅读记录 `tpl_recentread.php`

| 变量 | 含义 |
|---|---|
| `$popular` | 猜你喜欢/热门数据 |
| 最近阅读主体 | 当前主要由前端 `showtempbooks()` 生成 |

---

## 6. 运行时公共常量/函数（模板编写必须知道）

| 名称 | 类型 | 说明 |
|---|---|---|
| `SITE_NAME` | 常量 | 站点名称 |
| `SITE_URL` | 常量 | 站点地址 |
| `__ROOT_DIR__` | 常量 | 项目根目录 |
| `__THEME_DIR__` | 常量 | 当前主题目录 |
| `Sort::ss_sorthead()` | 方法 | 头部分类导航 |
| `Sort::ss_sorturl()` | 方法 | 分类 URL |
| `Url::info_url()` | 方法 | 详情页 URL |
| `Url::index_url()` | 方法 | 目录页 URL |
| `Url::chapter_url()` | 方法 | 阅读页 URL |
| `Text::ss_lastupdate()` | 方法 | 时间文案转换 |
| `ss_search_url()` | 函数 | 搜索地址兜底函数 |
| `ss_get_fake_top_meta()` | 函数 | 排行前缀元数据 |

---

## 7. 模板编写时不能写死的内容

以下内容后续模板中默认都不能写死：

- `/top/`
- `/rank/`
- `/history.html`
- `/search/`
- `/book/{id}/` 的具体路径
- 首页标题、keywords、description 的固定字符串
- 分类固定名称

应优先使用：
- 后台变量
- `Url::*` 方法
- 程序准备好的链接变量
- SEO 运行时变量

---

## 8. 当前可以直接作为“模板标准输入”的页面链路

| 页面 | 主入口 | 模板 |
|---|---|---|
| 首页 | `shipsay/app/home.php` | `tpl_home.php` |
| 分类页 | `shipsay/app/category.php` | `tpl_category.php` |
| 详情页 | `shipsay/app/info.php` / `info_langtail.php` | `tpl_info.php` |
| 目录页 | `shipsay/app/indexlist.php` / `indexlist_langtail.php` | `tpl_indexlist.php` |
| 阅读页 | `shipsay/app/reader.php` | `tpl_reader.php` |
| 搜索页 | `shipsay/app/search.php` | `tpl_search.php` |
| 作者页 | `shipsay/app/author.php` | `tpl_author.php` |
| 阅读记录 | `shipsay/app/recentread.php` | `tpl_recentread.php` |
| 排行页 | `shipsay/app/top.php` | `tpl_top.php / tpl_rank.php / tpl_rank_list.php` |

---

## 9. 一句话结论

后续所有模板改动，先查这份表：

- 先确认这是哪一层变量
- 再确认变量是谁提供的
- 再决定模板能不能直接用

这样才能减少“变量写对了但层级写错了”的问题。


---

## 6. 本轮全目录扫描补充（2026-03-07）

### 6.1 路由/入口层真实变量补充

| 变量 | 层级 | 说明 |
|---|---|---|
| `$site_url` | 路由/公共 | 站点根地址，多个模板会用于 canonical / breadcrumb / OG 链路 |
| `$allbooks_url` | 路由派生 | 书库入口，由分类伪静态模板派生 |
| `$full_allbooks_url` | 路由派生 | 完本入口，由 `fake_fullstr + allbooks_url` 组合 |
| `$fake_recentread` | 配置 | 阅读记录入口 |
| `$fake_top` | 配置 | 排行聚合入口 |
| `$fake_rankstr` | 路由兼容 | 旧排行明细前缀兼容值 |
| `$rico_sql` | app 数据准备 | 列表查询公共 SQL 前缀，不是模板变量标准 |

### 6.2 Header/模板局部派生变量补充

| 变量 | 层级 | 说明 |
|---|---|---|
| `$full_allbooks_url_safe` | 模板局部 | Header 对完本入口的兜底值 |
| `$search_url_safe` | 模板局部 | 搜索入口安全兜底值 |
| `$search_placeholder` | 模板局部 | 搜索框占位文案 |
| `$rank_entry_safe` | 模板局部 | Header 中排行入口兜底值 |
| `$home_url_safe` | 模板局部 | 首页 canonical / OG / 结构化数据使用 |
| `$category_url_safe` | 模板局部 | 分类页 canonical / OG / breadcrumb 使用 |
| `$author_url_safe` | 模板局部 | 作者页 canonical / OG / breadcrumb 使用 |
| `$rank_url_safe` | 模板局部 | 榜单详情页 canonical / OG / breadcrumb 使用 |
| `$top_url_safe` | 模板局部 | 榜单聚合页 canonical / OG / breadcrumb 使用 |

### 6.3 详情页/目录页局部变量补充

| 变量 | 层级 | 说明 |
|---|---|---|
| `$index_url_safe` | 模板局部 | 详情页/阅读页目录入口兜底 |
| `$latest12` | 模板局部 | 详情页展示用“最新 12 章”数组 |
| `$latest50` | 模板局部 | 详情页展示用“前 50 章”数组 |
| `$intro_html` | 模板局部 | 简介输出优先级合并值 |
| `$total_pages_safe` | 模板局部 | 目录页总页数安全值 |

### 6.4 排行链路变量补充

| 变量 | 层级 | 说明 |
|---|---|---|
| `$rank_meta` | app 输出 | `fake_top` / `fake_rankstr` 解析后的排行元数据 |
| `$rank_entry_url` | app 输出 | 排行聚合入口 |
| `$rank_detail_base` | app 输出 | 排行明细页基础前缀 |
| `$rank_legacy_base` | app 输出 | 旧排行前缀兼容值 |
| `$query` | app 输出 | 当前榜单 key |
| `$page_title` | app 输出 | 榜单标题，用于 SEO 占位符 `{ranktitle}` |

### 6.5 本轮纠错：不能只按数组切片字面解释章节语义

Shipsay 当前章节链路存在“章节 ID / 顺序混淆映射”的实际运行规则。

因此：
- 不能只看 `array_slice()` / `array_reverse()` 的字面写法
- 不能只看 `chapterorder ASC` 就直接断言“前 50 章 / 最新 50 章”
- 必须结合 **真实运行页、章节 URL 映射、最终页面输出结果** 一起判断

这条属于变量/数据语义判断红线，后续写标准时必须保留。
