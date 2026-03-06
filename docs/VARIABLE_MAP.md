# VARIABLE_MAP（Shipsay 变量与占位符总表）

> 目的：把“后台设置变量、URL 占位符、SEO 占位符、模板运行时变量、模板局部派生变量”分开写清楚，避免后续 AI 或人工把不同层级的变量混用。
>
> 当前基线：`fz1.112book.com_20260307v1` 全目录扫描结果。
>
> 准确性原则：本表允许暂时不全，但不能写错；不确定的变量不写死进标准。

---

## 1. 使用原则

### 1.1 变量分五层

1. **后台配置变量**：来源于 `www/caijie/*` 后台设置与 `shipsay/configs/config.ini.php`
2. **URL 占位符**：用于伪静态路由模板，不是模板运行时变量
3. **SEO 占位符**：只用于 `shipsay/configs/seo_tpl.php`
4. **App 输出变量**：由 `shipsay/app/*.php`、`shipsay/class/router.php`、`shipsay/seo.php` 准备后传给 `themes/*/tpl_*.php`
5. **模板局部派生变量**：只在当前模板文件里临时兜底或二次整理，不能反向当成核心变量

### 1.2 禁止混用

错误示例：
- 把 `{aid}` 当成模板里的 PHP 变量
- 把 `$seo_title` 当成后台设置项
- 把模板局部派生变量当成全站公共变量
- 把 `$fake_top` / `$fake_rankstr` / `$rank_entry_url` 当成同一层概念

### 1.3 先看来源，再判断能不能改

处理任何模板变量前，必须先判断它属于哪一层：
- 配置层
- 路由层
- app 输出层
- SEO 渲染层
- 模板局部派生层

没核清来源，不准直接改模板引用方式。

---

## 2. 后台配置变量（`www/caijie/base/*`）

### 2.1 基础设置 `cfg_main.php`

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

### 2.2 伪静态设置 `cfg_fake.php`

| 变量 | 作用 | 备注 |
|---|---|---|
| `fake_info_url` | 详情页 URL 模板 | 如 `/book/{aid}/` |
| `fake_chapter_url` | 阅读页 URL 模板 | 如 `/read/{aid}/{cid}.html` |
| `use_orderid` | 章节是否用排序 ID | 影响 `cid` 逻辑 |
| `fake_sort_url` | 分类页 URL 模板 | 如 `/sort/{sortcode}/{pid}/` |
| `fake_top` | 排行聚合入口 | 与 `fake_rankstr` 配合使用 |
| `fake_recentread` | 阅读记录页地址 | 如 `/history.html` |
| `fake_indexlist` | 目录页 URL 模板 | 如 `/indexlist/{aid}/{pid}/` |
| `per_indexlist` | 目录分页每页章节数 | 目录页分页 |

### 2.3 长尾设置 `cfg_langtail.php`

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

### 2.4 高级设置 `cfg_adv.php`

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

### 2.5 Redis 设置 `cfg_redis.php`

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

### 2.6 数据库设置 `cfg_database.php`

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

### 当前源码可确认的默认模板

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

当前源码中已确认支持：

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
- `ss_seo_render($page)` 只负责轻量替换，不负责随机生成 SEO

---

## 5. App 输出变量（运行时变量）

### 5.1 路由层 / 全局公共变量（`shipsay/class/router.php`）

| 变量 | 含义 | 来源 |
|---|---|---|
| `$theme_dir` | 当前主题目录 | 配置层 |
| `$site_url` | 站点绝对地址 | router 自动补齐 |
| `$year` | 当前年份 | router |
| `$db` / `$redis` | 数据库 / Redis 实例 | router 初始化 |
| `$dbarr` | DB 配置数组 | router |
| `$rico_sql` | 文章基础查询 SQL 前缀 | router |
| `$allbooks_url` | 书库入口 | 从 `fake_sort_url` 派生 |
| `$full_allbooks_url` | 完本书库入口 | 由 `fake_fullstr + allbooks_url` 派生 |
| `$fake_fullstr` | 完本前缀 | router 默认 `quanben` |
| `$fake_rankstr` | 旧榜单前缀 | router 默认 `rank` |

### 5.2 Header / 公共入口相关变量

| 变量 | 含义 | 备注 |
|---|---|---|
| `$fake_recentread` | 阅读记录入口 | 配置或路由输出 |
| `$fake_top` | 排行聚合入口 | 配置输出 |
| `$fake_search` | 搜索入口 | 当前源码中未见统一核心定义，模板必须兜底 |
| `$search_url_safe` | 搜索提交地址 | 模板局部兜底，不能误写成核心变量 |
| `$full_allbooks_url_safe` | 完本入口安全值 | 模板局部兜底 |
| `$rank_entry_safe` | 排行入口安全值 | 模板局部兜底 |
| `$search_placeholder` | 搜索框占位 | 模板局部展示变量 |

### 5.3 首页 `shipsay/app/home.php`

| 变量 | 含义 |
|---|---|
| `$commend` | 推荐书列表 |
| `$popular` | 热门书列表 |
| `$sort1...$sortN` | 各分类热门列表（动态变量） |
| `$lastupdate` | 最近更新列表 |
| `$postdate` | 最新入库列表 |
| `$link_html` | 友情链接 HTML |
| `$home_lastupdate_num` | 最近更新条数 |
| `$home_postdate_num` | 最新入库条数 |

### 5.4 排行聚合 / 榜单详情（`shipsay/app/top.php` / `shipsay/app/rank.php`）

| 变量 | 含义 | 备注 |
|---|---|---|
| `$rank_meta` | 由 `ss_get_fake_top_meta()` 生成的排行榜入口元信息 | 结构化路由元数据 |
| `$rank_entry_url` | 排行聚合入口 URL | 来自 `$rank_meta['entry_url']` |
| `$rank_detail_base` | 榜单详情前缀 | 来自 `$rank_meta['detail_base']` |
| `$rank_legacy_base` | 旧 rank 前缀 | 用于兼容旧 `/rank/` |
| `$query` | 当前榜单 key | 例如 `allvisit` / `monthvisit` |
| `$page_title` | 当前榜单标题 | 由 `title_arr` 派生 |
| `$articlerows` | 榜单详情列表 | 详情页模板使用 |

### 5.5 详情页 `shipsay/app/info.php` / `shipsay/app/info_langtail.php`

| 变量 | 含义 |
|---|---|
| `$articleid` | 小说 ID |
| `$articlename` | 书名 |
| `$author` / `$author_url` | 作者与作者页 |
| `$img_url` | 封面 |
| `$sortid` / `$sortname` | 分类 |
| `$isfull` | 完结状态 |
| `$words_w` | 万字数 |
| `$intro_p` / `$intro_des` | 简介摘要 / 简介纯文本 |
| `$first_url` | 第一章链接 |
| `$last_url` | 最新章节链接 |
| `$lastchapter` | 最新章节名 |
| `$lastchapter_arr` | 最新章节列表源 |
| `$preview_chapters` | 第二章节区数据源 | 语义需结合真实运行结果判断，不能只靠数组切片字面猜 |
| `$chapterrows` | 全章节数据 |
| `$chapters` | 章节总数 |
| `$index_url` | 目录页链接 |
| `$langtailrows` | 长尾推荐列表 |

### 5.6 目录页 `shipsay/app/indexlist.php` / `shipsay/app/indexlist_langtail.php`

| 变量 | 含义 |
|---|---|
| `$list_arr` | 当前页章节列表 |
| `$pid` | 当前目录页码 |
| `$per_page` | 每页章节数 |
| `$chapters` | 总章节数 |
| `$htmltitle` | 目录页分页 HTML / 片段 |
| `$langtailrows` | 长尾推荐列表 |

### 5.7 阅读页 `shipsay/app/reader.php`

| 变量 | 含义 |
|---|---|
| `$chaptername` | 章节名 |
| `$rico_content` | 正文 HTML |
| `$pre_url` / `$next_url` | 上一章 / 下一章 |
| `$page` / `$now_pid` | 阅读分页页码 |
| `$reader_des` | 阅读页 description 摘要 |

---

## 6. 模板局部派生变量（只能在当前模板内使用）

### 6.1 `themes/shipsay/tpl_header.php`

| 变量 | 含义 |
|---|---|
| `$full_allbooks_url_safe` | 完本入口兜底值 |
| `$search_url_safe` | 搜索提交地址兜底值 |
| `$search_placeholder` | 搜索框占位文案 |
| `$rank_entry_safe` | 排行入口兜底值 |

> 说明：当前 Shipsay 仓库中**没有统一核心函数 `ss_search_url()` 定义**，所以该模板采用 `function_exists(...) ? ... : fallback` 形式兜底。后续标准里不能把 `ss_search_url()` 当成 Shipsay 核心已存在函数写死。

### 6.2 `themes/shipsay/tpl_info.php`

| 变量 | 含义 |
|---|---|
| `$index_url_safe` | 目录页链接兜底值 |
| `$latest12` | `lastchapter_arr` 截取后的前 12 项 |
| `$latest50` | `preview_chapters` 截取后的前 50 项 |

### 6.3 `themes/shipsay/tpl_indexlist.php`

| 变量 | 含义 |
|---|---|
| `$total_pages_safe` | 目录总页数兜底值 |
| `$langtail_list` | 当前文件里定义但未实际使用的局部变量 |

> 说明：`$langtail_list` 当前属于死变量，不应写进“公共变量定义”，只能记在扫描结果里。

### 6.4 `themes/shipsay/tpl_reader.php`

| 变量 | 含义 |
|---|---|
| `$pageTitle` | 阅读页 `<title>` 使用值 |
| `$index_url_safe` | 目录页链接兜底值 |

### 6.5 `themes/shipsay/tpl_rank.php`

| 变量 | 含义 |
|---|---|
| `$current_query` | 当前榜单 key |
| `$current_title` | 当前榜单标题 |

### 6.6 `themes/shipsay/tpl_top.php`

| 变量 | 含义 |
|---|---|
| `$top_title` / `$top_keywords` / `$top_description` | 聚合排行页局部 SEO |
| `$rank_sections` | 榜单区块定义 |
| `$rank_lists` | 模板内查询出的榜单数据 |
| `$rank_limit` | 模板内榜单数量限制 |

> 注意：`tpl_top.php` 当前直接查库 / 读缓存，这属于 Shipsay 现状，不属于后续模板标准。该处应记录为**现存例外**，不能反向写成规范。

---

## 7. 已确认的“不要写错”的定义

1. **`$fake_top` 不是榜单详情前缀本身**，实际详情前缀要通过 `ss_get_fake_top_meta()` 派生。
2. **`$rank_entry_url` / `$rank_detail_base` 属于 app/top 路由派生变量**，不是后台直接配置项。
3. **`$search_url_safe` 是模板兜底变量，不是核心统一 API。**
4. **`$latest12` / `$latest50` 是模板内二次整理变量，不是 app 原始变量。**
5. **`$preview_chapters` 的实际语义不能只靠 `array_slice/array_reverse` 字面判断，必须结合真实运行页验证。**
6. **`$langtail_list` 当前未实际使用，不能写成有效公共变量。**

---

## 8. 当前扫描结论（变量层）

本轮全目录扫描后，变量文档当前最需要避免的错误是：

- 把模板局部变量写成全局标准
- 把历史兼容变量写成唯一标准
- 把“当前 Shipsay 的例外写法”写成后续模板必须遵守的规范
- 把尚未核实的运行时语义写死进文档

后续补文档时，优先保证：**定义准确 > 覆盖完整**。
