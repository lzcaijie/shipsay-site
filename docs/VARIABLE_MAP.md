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

### 1.4 先区分“变量问题”还是“CSS/结构问题”

像这轮手机端带图卡片、footer 居中、分类分页块这类问题，默认先归类为 **CSS/模板结构问题**，不要误判成变量链路问题。

判断原则：
- 程序输出的链接、页码、按钮文案已正确，只是显示错位 → 先查 CSS
- 模板结构存在，但按钮/分页/信息区排列异常 → 先查 CSS 与模板结构
- 只有在链接目标、页码数据、章节范围、SEO 文案来源本身错误时，才进入变量链路排查
- 像封面尺寸、卡片间距、作者/字数/更新时间是否同一行、详情页按钮区与书封区是否协调，这些都属于 CSS 节奏问题，不要误判成变量缺失

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
| `$fullflag / $full_url / $allbooks_url / $allbooks_url_safe` | 完本/书库链路（模板展示优先用 safe 变量） |
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
| `$author_safe / $author_count_safe` | 作者页本地安全显示值（作者名 / 作品数） |
| `$indexlist_breadcrumb_item` | 目录页 BreadcrumbList 使用的安全目录链接 |
| `$chapterwords_safe / $now_pid_safe / $max_pid_safe` | 阅读页字数 / 分页本地安全数值 |
| `$pre_url / $next_url` | 上一章 / 下一章 |
| `$prevpage_url / $nextpage_url` | 阅读分页链接 |
| `$now_pid / $max_pid` | 阅读分页当前页 / 总页数 |
| `$index_url / $index_url_raw / $index_url_attr` | 返回目录：app 原始值 / 模板本地 raw / 模板输出 attr |
| `$info_url` | 返回详情 |
| `$seo_title / $seo_keywords / $seo_description` | 页面 SEO |

## 5.7 搜索页 `tpl_search.php`

| 变量 | 含义 |
|---|---|
| `$searchkey` | 搜索词（原始值，不能直接裸输出） |
| `$searchkey_safe` | 搜索词安全转义后的显示值 |
| `$search_highlight()` | 搜索结果高亮 helper（模板局部闭包） |
| `$search_res` | 搜索结果列表 |
| `$search_count / $search_count_safe` | 结果数 / 安全展示值 |
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
| `$top_sections` | 排行聚合页榜单配置（由 `shipsay/app/top.php` 准备） |
| `$top_rank_lists` | 排行聚合页榜单数据（由 `shipsay/app/top.php` 准备） |
| `$top_rank_limit` | 排行聚合页单榜展示数量上限 |
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
| `$rank_base_raw / $rank_entry_url / $rank_detail_base` | 排行链接基础值（模板层不再补 `/rank/`） |
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
| `$full_allbooks_url_raw / $full_allbooks_url_attr` | 模板局部 | Header 完本入口 raw / attr |
| `$search_url_raw / $search_url_attr` | 模板局部 | 搜索入口 raw / attr |
| `$search_placeholder` | 模板局部 | 搜索框占位文案 |
| `$rank_entry_raw / $rank_entry_attr` | 模板局部 | Header 中排行入口 raw / attr |
| `$site_home_url_raw / $site_home_url_attr` | 模板局部 | 站点首页入口 raw / attr；Header、recentread、footer 等公共区优先复用 |
| `$category_url_safe` | 模板局部 | 分类页 canonical / OG / breadcrumb 使用 |
| `$author_url_safe` | 模板局部 | 作者页 canonical / OG / breadcrumb 使用 |
| `$rank_url_safe` | 模板局部 | 榜单详情页 canonical / OG / breadcrumb 使用 |
| `$top_url_safe` | 模板局部 | 榜单聚合页 canonical / OG / breadcrumb 使用 |

### 6.3 详情页/目录页局部变量补充

| 变量 | 层级 | 说明 |
|---|---|---|
| `$index_url_raw / $index_url_attr` | 模板局部 | 详情页/阅读页目录入口 raw / attr（不再回退详情页） |
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

补充说明：
- `tpl_top.php` 当前基线不再直接查库，榜单数据应由 `shipsay/app/top.php` 预先准备。
- `tpl_search.php` 中的 `$searchkey` 仅视为原始输入，模板前台展示必须改用 `$searchkey_safe` 或局部高亮 helper；搜索结果主容器优先复用现有 `side_commend_width` 类，不再继续写模板内联宽度。
- `tpl_indexlist.php` 中的 BreadcrumbList 链接必须使用 `$indexlist_breadcrumb_item` 这类明确兜底值，不能回退引用未定义原始变量。
- `tpl_reader.php` 中的本地阅读记录写入应使用 `$reader_url_safe`，不要直接把原始 `$uri` 当成稳定链接。
- `tpl_author.php` 中的作者名与作品数展示建议先整理为 `$author_safe / $author_count_safe`，再输出到前台。

### Footer / recentread / error 模板本地变量（本轮补充）
- `$site_home_url_raw / $site_home_url_attr`：Footer、recentread、error 等公共区优先复用的站点首页入口 raw / attr。
- `$recentread_page_title / $recentread_page_title_html`：阅读记录页标题本地变量与安全输出值。
- `$recentread_page_description / $recentread_page_description_html`：阅读记录页描述本地变量与安全输出值。
- `$recent_info_url_attr / $recent_author_url_attr`：阅读记录页猜你喜欢列表链接 attr。
- `$recent_articlename_html / $recent_author_html`：阅读记录页猜你喜欢列表安全展示文案。
- `$footer_sitemap_sm_raw / $footer_sitemap_sm_attr`、`$footer_sitemap_xml_raw / $footer_sitemap_xml_attr`：Footer 当前模板本地站点地图资源链接；属于固定资源路径，不等同于业务入口变量。

### 本轮补充：手机端带图区细调说明（2026-03-07）
- 本轮首页 / 分类页 / 详情页 / 目录页的“图片周围文字适配”，本质属于 **CSS 排版层调整**。
- 本轮未新增新的 app 层核心变量。
- `novel-basic-info`、`side_commend`、`searchresult`、`sortvisit` 的这轮改动，应优先理解为“现有模板结构上的移动端排版标准收口”，而不是数据准备链路变化。


### 本轮补充：图文邻接区继续适配（2026-03-07）
- 本轮首页 / 分类页 / 首页分类首卡 / 详情页 / 目录页继续做的是 **图片周围文字适配**。
- 这轮问题继续归类为 **CSS 排版层收口**，不是 app 层变量链路变化。
- `side_commend`、`searchresult`、`sortvisit`、`novel-basic-info` 的本轮调整，重点是封面列宽、文字列节奏、作者/分类/状态/字数折行策略。
- 尤其是 `novel-meta p:first-of-type` 的收口，属于“现有模板结构上的手机端折行优化”，不是新增数据字段。


## 2026-03-07 cg_patch_007
- 本轮仍为 `www/static/shipsay/style.css` 的移动端布局收口。
- 未新增模板变量，未修改 PHP 数据变量映射。


## 2026-03-07 cg_patch_008
- 本轮继续只收 `side_commend` 手机端卡片节奏。
- 未新增模板变量，未修改 PHP 变量映射。
- 首页 / 分类列表摘要取消首行缩进，属于 CSS 展示层策略，不属于变量语义变化。

## 2026-03-07 cg_patch_009
- 本轮未新增 app 层数据变量。
- 本轮新增/显式使用的是模板展示层 class：
  - `meta-pairs`：详情页 / 目录页顶部元信息分组容器。
  - `meta-label`：作者 / 分类 / 状态 / 字数等标签文本。
  - `meta-value`：非链接型元信息值（如状态、字数）。
  - `sort-author`：首页分类首卡作者行。
  - `sort-desc`：首页分类首卡简介块。
- 这些都属于前端展示层结构标记，不代表新增 PHP 数据变量。


## 2026-03-07 cg_patch_010
- 本轮未新增 app 层数据变量。
- 本轮新增/显式使用的是模板展示层 class：
  - `meta-latest`：详情页 / 目录页顶部“最新章节”行容器。
  - `book-actions-wide`：详情页手机端整行铺开的主操作按钮容器。
- 本轮首页 / 分类列表 / `sortvisit` 的“摘要收口为 1 行”仍属于 CSS 展示层策略，不属于 PHP 变量语义变化。

- `tpl_info.php` / `tpl_indexlist.php` 顶部元信息默认仍保持原始 `p > span` 结构；手机端优先通过样式层控制两列、截断与按钮铺开，不新增会影响 PC 的全局元信息结构。


---

## 10. 2026-03-08 | v5 核对补充（页面分层与 safe 优先级）

### 10.1 页面分层结论

#### A 级：当前可直接作为标准输入页
- `tpl_home.php`
- `tpl_info.php`
- `tpl_indexlist.php`
- `tpl_reader.php`

#### B 级：变量链基本正确，但模板交互/样式还需继续收口
- `tpl_category.php`
- `tpl_rank.php`
- `tpl_top.php`
- `tpl_recentread.php`

#### C 级：当前先保可用
- `tpl_error.php`

### 10.2 safe 链接优先级（本轮正式补充）

后续模板中，凡是存在 `*_safe` 兜底变量时，前台展示优先级统一为：

1. `*_safe`
2. 当前 app 层直接准备好的真实链接变量
3. 首页链接等极少数展示入口，最后才允许非常轻的模板兜底值

#### 当前应优先使用 `*_safe` 的常见入口
- `$home_url_safe`
- `$allbooks_url_raw / $allbooks_url_attr`
- `$full_allbooks_url_raw / $full_allbooks_url_attr`
- `$recentread_url_raw / $recentread_url_attr`
- `$search_url_raw / $search_url_attr`
- `$rank_entry_raw / $rank_entry_attr`
- `$info_url_raw / $info_url_attr`
- `$index_url_raw / $index_url_attr`
- `$reader_url_raw / $reader_url_attr`
- `$top_url_raw / $top_url_attr`
- `$rank_url_raw / $rank_url_attr`

规则：
- 能走 `*_safe` 的，不要直接退回原始变量
- fallback 只作为最终兜底，不作为模板默认真实值

### 10.3 详情页 / 目录页变量层规则（正式固定）

#### 详情页 `tpl_info.php`
后续必须继续保留当前这组变量链：
- `$articlename`
- `$author / $author_url`
- `$sortid / $sortname`
- `$isfull`
- `$words_w`
- `$lastchapter / $last_url`
- `$first_url`
- `$index_url / $index_url_safe`
- `$info_url / $info_url_safe`
- `$intro / $intro_p / $intro_plain`
- `$seo_title / $seo_keywords / $seo_description`

#### 目录页 `tpl_indexlist.php`
后续必须继续保留当前这组变量链：
- `$articlename`
- `$author / $author_url`
- `$sortid / $sortname`
- `$isfull`
- `$words_w`
- `$lastchapter / $last_url`
- `$first_url`
- `$info_url`
- `$index_url / $indexlist_url_safe`
- `$list_arr`
- `$pid / $total_pages_safe`
- `$seo_title / $seo_keywords / $seo_description`

说明：
- 目录页虽然是后期新增页，但变量链已经走到正确方向
- 后续可以借旧详情页布局，不允许把变量链退回旧模板

### 10.4 阅读页双链路属于正式变量规则，不是临时兼容

阅读页 `tpl_reader.php` 当前正式规则：

- 普通用户：正文通过 `/api/reader_js.php` 拉取
- 蜘蛛或关闭 JS：直出 `<?=$rico_content?>`

因此：
- `$rico_content` 仍是核心正文变量
- 但普通用户 HTML 源码正文为空是**正确行为**
- 不允许后续再把普通用户链路改回模板直出正文

### 10.5 分类页属于“旧交互待整改页”

`tpl_category.php` 当前需要继续保留的真实变量有：
- `$retarr`
- `$sortcategory`
- `$sortid / $sortname`
- `$fullflag / $full_url`
- `$allbooks_url / $allbooks_url_safe`
- `$seo_title / $seo_keywords / $seo_description`

但下面这些写法只视为当前兼容实现，不应继续当标准扩散：
- `onclick="javascript:..."`
- `href="#"`
- `href="javascript:"`
- 过重的模板内 fallback 导航写法

### 10.6 当前确认允许写死与禁止写死的边界

#### 允许写死的界面文案
- `作者：`
- `分类：`
- `状态：`
- `字数：`
- `最新章节：`
- `开始阅读`
- `查看目录`
- `返回详情`
- `相关推荐`

#### 禁止写死的真实业务值
- 分类名
- 作者名
- 书名
- 详情链接
- 目录链接
- 阅读链接
- 排行入口
- 搜索入口
- 阅读记录入口
- 页面真实 SEO 数据来源

### 10.7 本轮最终原则

后续遇到旧模板与当前模板并存时，默认按这条规则判断：

- **旧模板**：只借布局与节奏
- **当前模板**：保变量链、safe 链接、SEO 链路、阅读双链路
- **目录页**：按详情页同体系处理
- **缺失项**：允许后补
- **错误变量定义**：不允许进入标准


### 10.8 第二轮重建时的变量保留/借用原则

当前 Shipsay 进入“旧正常布局参考 + 当前变量链保留”的阶段后，后续默认按下面这条判断：

#### 变量层必须保留当前版
以下内容默认保留当前版，不因借旧布局而回退：
- `*_safe` 链接变量
- `seo_title / seo_keywords / seo_description`
- 阅读页普通用户 JS / 蜘蛛直出双链路
- 详情页 / 目录页作者、分类、状态、字数、最新章节等真实变量

#### 布局层允许借旧版
以下内容允许参考旧版布局或块顺序：
- 详情页 / 目录页顶部信息区节奏
- 首页 / 分类页图文卡片节奏
- 最近阅读页旧稳定布局

说明：
- 旧版只是样式参考，不是变量参考。
- 当前版如果变量链正确，但视觉混乱，默认先查 CSS / 结构，不先改变量定义。

### 10.9 目录页与详情页的变量体系必须一致

`tpl_indexlist.php` 后续必须与 `tpl_info.php` 共用同一套核心书籍变量语义。至少要保持一致的包括：

- `$articlename`
- `$author / $author_url`
- `$sortid / $sortname`
- `$isfull`
- `$words_w`
- `$lastchapter / $last_url`
- `$first_url`
- `$info_url / $info_url_safe`
- `$index_url / $indexlist_url_safe`
- `$seo_title / $seo_keywords / $seo_description`

允许目录页额外新增但不改变详情页语义的变量：
- `$list_arr`
- `$pid`
- `$total_pages_safe`
- 目录页分页相关渲染变量

原则：
- 目录页可以增加目录列表变量。
- 目录页不能发明一套与详情页不同的“书籍基础信息变量语义”。

### 10.10 当前模板层允许写死与禁止写死的第二轮补充

#### 允许写死的结构标签
以下标签在后续模板整理时可以作为固定 UI 文案继续存在：
- `作品信息`
- `目录`
- `最新章节`
- `相关推荐`
- `返回详情`
- `开始阅读`
- `查看目录`

#### 禁止写死的链路和数据
以下内容无论旧模板还是新模板，都不能写死替代真实变量：
- 书籍主链接
- 目录页主链接
- 阅读页主链接
- 作者页链接
- 分类页链接
- 排行入口链接
- 搜索提交地址
- 最近阅读入口
- JSON-LD 中的 URL / 标题真实值

### 10.11 第二轮页面变量分层结论

#### 首页 / 分类页
- 优先保持当前已跑通变量链
- 若页面视觉异常，默认先查 CSS，不先改变量
- 分类页旧交互属于模板写法问题，不属于变量语义错误

#### 详情页 / 目录页
- 当前变量链已走到正确方向
- 后续允许借旧详情页布局，但不允许把顶层变量结构退回旧版混写

#### 阅读页
- 双链路是正式规则，不是兼容方案
- 普通用户 HTML 正文为空，不视为变量错误

#### 辅助页
- `tpl_recentread.php`、`tpl_rank.php`、`tpl_top.php` 默认先保可用
- 变量链不清楚时，宁可暂缺，不写错



### 10.12 第三轮辅助页变量与复用规则（2026-03-08）

#### `tpl_recentread.php`
- 允许继续复用旧稳定布局容器。
- 但首页链接、面包屑、推荐书输出仍应优先使用当前版的 safe 链接与转义写法。
- 不允许把旧模板里的本地假链接或无 safe 兜底写法直接带回。

#### `tpl_rank.php` / `tpl_top.php`
- 榜单入口、榜单 slug、分页、榜单标题必须继续来自当前版数据准备结果。
- 允许借旧版列表/卡片/标题条布局，但不允许把榜单真实链接写死。
- 若旧版没有对应变量，宁可补说明，不可臆造变量名写进标准。

#### `tpl_error.php`
- 当前阶段只要求：
  - 首页返回入口真实可用
  - 搜索入口真实可用
  - 页面文案不误导用户
- 该页不承担业务数据输出，不应额外引入虚假推荐、虚假榜单、虚假链接。

### 10.13 第三轮“旧布局可借 / 旧变量不可借”补充

后续整理模板时，凡是来自旧模板的参考内容，都必须先分层：
- 可借：容器层级、标题条、按钮排列、卡片节奏、列表块顺序
- 不可直接借：旧模板中的真实链接拼接、旧 SEO 值、旧本地伪链接、未加 safe 的地址输出

判断原则：
- 只要涉及真实链接、后台变量、SEO 变量、阅读正文链路，就优先保当前版。
- 只要涉及视觉节奏、布局层次、卡片顺序，就允许参考旧版。


## 6. 允许写死 / 禁止写死（交接版）

### 6.1 允许写死（固定 UI 文案）
允许作为模板固定文案直接写入：
- 首页
- 分类
- 目录
- 作者：
- 状态：
- 分类：
- 字数：
- 最新章节：
- 开始阅读
- 查看目录
- 返回详情
- 相关推荐
- 热门小说
- 最近阅读

### 6.2 禁止写死（业务数据 / 业务链接）
以下内容必须来自程序变量、safe 链接或后台配置，不得模板层写死：
- 书名、作者名、分类名
- 详情页链接、目录页链接、阅读页链接
- 排行页入口、搜索入口、阅读记录入口
- 分类导航真实链接
- SEO 的标题、关键词、描述真实数据
- 阅读页正文输出方式

## 7. 变量复用边界（交接版）

### 7.1 详情页 / 目录页
详情页与目录页后续默认共用同一套基础书籍语义：
- 书名：`$articlename`
- 作者：`$author` / `$author_url`
- 分类：`$sortname` / `$sortid`
- 状态：`$isfull`
- 字数：`$words_w`
- 最新章节：`$lastchapter` / `$last_url`
- 首章入口：`$first_url`

目录页仅在以下部分做扩展：
- 当前目录页链接
- 章节列表与目录分页

### 7.2 阅读页
阅读页变量链后续固定为：
- 普通用户：模板留容器，由 JS 请求正文
- 蜘蛛 / 关闭 JS：输出 `$rico_content`
- 阅读页链接、目录链接、上一章/下一章都必须来自当前程序变量

## 8. 页面问题归类方法（交接版）

后续遇到问题时，先判断属于哪一类：
- **变量链问题**：链接错、SEO 错、章节数据错、排序错
- **模板结构问题**：模块顺序错、页面体系不一致、目录页/详情页结构脱节
- **CSS 控制块问题**：分页被容器规则污染、图片列和文字列错位、按钮/元信息间距异常

默认先排除 CSS 控制块污染，再决定是否进入模板或变量链层修改。


## 10.4 2026-03-09 | Header / rank / reader 模板变量收口

### 10.4.1 当前正式命名口径
- `*_raw`：原始 URL / 原始业务值，供 JSON-LD、逻辑判断、变量拼装使用。
- `*_attr`：对 `*_raw` 做过 `htmlspecialchars()` 的属性输出值，只用于 `href`、`content`、`canonical`、`og:url` 等属性位。
- `*_html`：展示文字专用安全值。

### 10.4.2 本轮重点收口文件
- `tpl_header.php`
- `tpl_top.php`
- `tpl_rank.php`
- `tpl_info.php`
- `tpl_indexlist.php`
- `tpl_reader.php`
- `tpl_category.php`
- `tpl_author.php`

### 10.4.3 这轮已经明确不再允许的模板写法
- 在 Header / 排行 / 搜索 / 足迹 / 书库 / 完本入口直接写死 `/rank/`、`/search/`、`/sort/`、`/history.html`。
- 在详情页模板里直接调用 `Url::index_url()` 补目录链接。
- 在阅读页里把目录入口缺失时自动改成详情页。
- 在分类页里继续使用 `href="javascript:"` 或 `onclick=document.location=...` 承担真实跳转。

### 10.4.4 当前仍保留的边界
- `tpl_footer.php` 的 `javascript:zh_tran(...)` 属于前端功能型交互，不归类为旧导航链路问题。
- `tpl_reader.php` 的字号/夜间/极简按钮，仍归类为阅读交互，不归类为旧导航链路问题。
- `tpl_search.php` / `tpl_author.php` 仍有局部行内样式问题，但当前先归为模板样式收口项，不上升到核心链路问题。
