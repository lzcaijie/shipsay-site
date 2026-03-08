## 2026-03-08 | 标准 | Shipsay v5 红线重命名（v1 docs-only）
- 说明：基于上一轮 docs-only 审计包重新收口并重命名为 `v1` 起点包，本轮继续严格只动 `docs/*`，不触碰 `app / class / include / configs`。
- 收紧：将文档中的泛写法进一步明确为“当前只以 `themes/shipsay/` 作为母模板标准”；其它主题可参考同样边界，但不反向定义 Shipsay 标准。
- 固定：后续模板工作默认遵守“核心尽量不动，由模板去适配核心”；除非先完成全局核对并确认必须修改核心，否则不把核心程序改动混入标准审计包。

## 2026-03-08 | 标准 | Shipsay v5 文档审计（第五轮 / 程序与模板对照）
- 核对：按 `fz1.112book.com_20260308v2` 重新对照 `docs`、`shipsay/app/*` 与 `themes/shipsay/*`，本轮重点不改模板，只修正文档口径。
- 修正：`VARIABLE_MAP` 顶部基线版本更新为 `20260308v2`，避免后续继续按旧包口径判断当前模板。
- 修正：明确 `tpl_top.php` 当前模板局部实际使用的是 `$rank_sections / $rank_lists / $rank_limit`，它们对应 app 层 `$top_sections / $top_rank_lists / $top_rank_limit`，避免后续误把聚合页变量写错。
- 固定：分类页 `onclick / javascript: / href="#"` 仍记为模板层待整改项；但阅读页字号/夜间/极简按钮，以及 app 层分页输出中的 `javascript:void(0);` 禁用态，当前视为兼容交互，不与旧跳转写法混为同一级问题。
- 核对：本轮程序与 shipsay 模板复扫未发现需要立即写入标准的 PHP 7.4 语法级阻塞项；后续仍优先按“文档 → 变量链 → 结构/CSS → 程序链路”的顺序排查。

## 2026-03-08 | 标准 | Shipsay v5 标准收口（第四轮 / 交接版）
- 固定：当前 `themes/shipsay` 进入“可复用母模板”阶段，后续修改默认优先遵守：**先核文档 → 再看当前模板变量链 → 最后只借旧布局/旧 CSS 的正确控制块**。
- 固定：后续新模板或旧模板重整理时，默认采用同一执行顺序：`tpl_info.php` → `tpl_indexlist.php` → `tpl_home.php` → `tpl_category.php` → `tpl_reader.php` → 辅助页；禁止跳过详情/目录页直接大面积改首页或全局 CSS。
- 固定：文档交接时必须同时给出三类信息：1）当前标准页/待整改页分层；2）变量/链接禁改红线；3）整轮测试顺序与页面检查点。
- 固定：分类页 PC 分页问题已通过样式重置收口；本轮将“列表容器旧规则污染分页”的案例写入标准，后续遇到相似问题优先查容器级通用规则，不先怀疑数据链。
- 固定：当前标准输出以“准确”为第一优先级；缺失可后补，但不得把错误变量、错误链接、错误页面结构写入模板标准。

## 2026-03-08 | 标准 | Shipsay v5 标准收口（第三轮）
- 固定：辅助页后续默认分三层处理，不再混进主模板核心页一起改：
  - 主核心页：`tpl_home.php`、`tpl_category.php`、`tpl_info.php`、`tpl_indexlist.php`、`tpl_reader.php`
  - 次核心页：`tpl_recentread.php`、`tpl_rank.php`、`tpl_top.php`
  - 可用优先页：`tpl_error.php`
- 固定：后续批量整理其他模板时，默认沿用 **“旧正常布局做样式参考 + 当前正确变量链继续保留 + 目录页与详情页同体系”** 的三段式方法，不再尾部叠补丁。
- 明确：本轮把“辅助页分层、禁止事项、模板复用顺序、待整改清单拆细”写入标准文档，作为后续母模板整理与新模板复制的正式依据。
- 固定：标准文档优先保证“准确无误”，允许暂时不完整；缺失后补，错误不得进入标准。

## 2026-03-08 | 标准 | Shipsay v5 标准收口（第二轮）
- 口径：不再以“最原始 css”或“当前乱版 css”任一单边为准，而是固定采用 **两版本对比**：
  - 旧正常模板/样式：只作为布局与样式参考
  - 当前最新模板：保留 v5 合规变量链、safe 链接、SEO、阅读双链路
- 固定：目录页不是独立风格页，必须与详情页保持同一结构体系；目录页新增功能只能在详情页同体系内补入，不再另起一套样式逻辑。
- 固定：后续处理 CSS 默认先找“旧的已验证正常控制块”，优先复用已有正确部分；当前站点若经过多轮微调，默认采用“调整和合并”，不再尾部叠补丁链。
- 固定：首页 / 分类页已验证正常部分优先保留；详情页 / 目录页为重建优先页；阅读页保持普通用户 JS 加载、蜘蛛直出正文。
- 收口：补充第二轮文档规则，明确：
  - 旧版只借布局，不借旧变量链
  - 分类页分页、目录页样式与详情页统一属于“结构同体系、样式同参考”问题
  - 后续制定标准时，缺失可以后补，错误不能进入标准

## 2026-03-08 | 标准 | Shipsay v5 核对与标准收口（第一轮）
- 核对：按当前已合并基线重新核对 `tpl_home.php`、`tpl_category.php`、`tpl_info.php`、`tpl_indexlist.php`、`tpl_reader.php`、`tpl_recentread.php`、`tpl_rank.php`、`tpl_top.php`、`tpl_error.php` 与 `style.css`。
- 结论：明确当前 Shipsay 标准口径为“**旧的、已验证正常的模板/CSS 只作为布局参考；当前主题中已经正确的变量链、safe 链接、SEO 链路、阅读双链路必须保留**”。
- 固定：目录页必须与详情页保持同一结构体系；阅读页继续保持“普通用户 JS 加载、蜘蛛直出正文”。
- 分层：将页面分为 A/B/C 三层：
  - A 级：`tpl_home.php`、`tpl_info.php`、`tpl_indexlist.php`、`tpl_reader.php`
  - B 级：`tpl_category.php`、`tpl_rank.php`、`tpl_top.php`、`tpl_recentread.php`
  - C 级：`tpl_error.php`
- 文档：补充 `V5_1_TEMPLATE_STANDARD.md` 与 `VARIABLE_MAP.md`，明确：
  - 布局可借旧版，变量链不能退回旧版
  - 分类页旧交互写法属于待整改，不是最终标准
  - safe 链接优先级与允许/禁止写死边界
  - 目录页按详情页同体系处理

## 2026-03-07-3 | 模板 | Shipsay 手机端图文邻接区继续适配
- 调整：继续只在 `www/static/shipsay/style.css` 微调，不回退到原始版，也不新增强压覆盖块。
- 细化：首页/分类页带图卡片改为更稳定的“封面列 + 文字列”节奏，标题、简介、作者、字数/时间继续按手机端视觉收口。
- 细化：首页分类首卡 `sortvisit` 的封面与右侧文案继续贴齐，标题、作者、简介分层更清晰。
- 细化：详情页/目录页顶部 `novel-basic-info` 的作者、分类、状态、字数改为更稳的折行策略，避免长作者名把两列挤坏。
- 同步：`docs/V5_1_TEMPLATE_STANDARD.md`、`docs/VARIABLE_MAP.md` 补充本轮“图文邻接区适配仍属于 CSS 层收口”的说明。

## 2026-03-07-2 | 模板 | Shipsay 手机端带图区文字节奏细调
- 调整：继续只在 `www/static/shipsay/style.css` 收口手机端带图区域，不回退原始版，也不使用强压覆盖式写法。
- 细化：首页/分类页带图卡片的封面宽高、标题与简介节奏、作者与字数/更新时间同排对齐。
- 细化：首页分类首卡 `sortvisit` 的封面与右侧文案改为更紧凑的上下节奏，作者单独成行，不再依赖 `<br>` 撑开视觉。
- 细化：详情页/目录页顶部 `novel-basic-info` 在手机端改为稳定的图文双列节奏，作者/分类/状态/字数按两列收口。
- 同步：`docs/V5_1_TEMPLATE_STANDARD.md`、`docs/VARIABLE_MAP.md` 补充本轮可复用标准说明。

# CHANGELOG（分站 shipsay-site，最新在最前）

> 说明：
> - 本文件只记录“分站侧功能/接口/安全策略”变更（新增写在最前）。
> - 日常操作流程/部署/一致性验证：见 `docs/OPS.md`。
>
> 记录规则（建议）：
> - 写清：日期、类型、版本号（可自定义）、涉及路径、回滚方式/要点。

---


## 2026-03-07-02 | 模板 | Shipsay 手机端带图卡片与详情/目录书封区继续细调
- 目标：在上一轮已收口的基础上，继续微调手机端带图卡片、首页分类首卡、详情页/目录页书封信息区，让整体节奏更接近可复用标准模板，而不是靠强覆盖硬压。
- 更新：`www/static/shipsay/style.css`
  - 继续细调首页推荐卡、分类页列表卡与搜索类带图卡片的间距、封面尺寸、标题/简介/底部信息区节奏。
  - 调整首页分类首卡（`sortvisit` 第一张带图卡）的图片与文字对齐方式，减少图片周围空白感。
  - 细调详情页与目录页顶部书封信息区的封面尺寸、标题行距、元信息与按钮区间距。
  - 本轮仍坚持顺着现有结构微调，不新增强压 footer 覆盖块。
- 更新：`docs/V5_1_TEMPLATE_STANDARD.md`
  - 补充“带图卡片细调优先做微调，不轻易重写结构”的标准说明。
- 更新：`docs/VARIABLE_MAP.md`
  - 补充封面尺寸、卡片间距、作者/字数/更新时间同行节奏等问题的归类说明，明确仍属于 CSS/结构问题。
- 回滚：回退上述 3 个文件到本次修改前版本即可。

## 2026-03-07-01 | 模板 | Shipsay 手机端卡片/分页/footer 收口（标准继续沉淀）
- 目标：继续以 `themes/shipsay` 作为标准模板基线，优先收口手机端带图卡片、分类分页块、详情/目录顶部信息区、全站 footer。
- 更新：`www/static/shipsay/style.css`
  - 优化带图列表卡片的移动端节奏，统一图片宽高、文本区收缩、标题/简介/底部信息区的间距与对齐。
  - 优化详情页与目录页顶部信息区，统一手机端书封区、元信息区、按钮区与目录头部的排布。
  - 优化分类页手机端分页块，改为更稳定的纵向节奏，避免上一页 / 页码选择 / 下一页之间出现大块空白。
  - 修正全站 footer 手机端居中逻辑，沿现有结构轻量收口，不再采用强压覆盖式写法。
- 更新：`docs/V5_1_TEMPLATE_STANDARD.md`
  - 明确 `shipsay/docs/` 视为废弃目录，正式文档真源仅为 `root/docs/`。
  - 补充手机端 footer 标准、分类分页块标准，以及“顺着现有规则收口、不依赖强制覆盖”的执行原则。
- 更新：`docs/VARIABLE_MAP.md`
  - 补充“先区分变量问题还是 CSS/结构问题”的判断规则，避免把手机端样式问题误判为变量链路错误。
- 回滚：回退上述 3 个文件到本次修改前版本即可。


## 2026-02-28-01 | 修复 | v6 模板下发：解压不再依赖 shell_exec（支持 zip/tar.gz）
- 修复：部分分站禁用 `shell_exec` 导致模板下发报错 `tpl_extract_failed - shell_exec_disabled`。
- 更新：`shipsay/include/site_sync_impl.php` 的模板包解压逻辑改为优先使用 `ZipArchive`（zip）与 `zlib+PharData`（tar.gz→tar）完成解压，不再强依赖系统 `tar` 命令；仅在环境允许时保留 `tar` 作为兜底。
- 兼容：模板包即使文件名为 `.tar.gz`，也会按 magic bytes 自动识别 zip/gzip。
- 回滚：回退本次改动文件即可（`shipsay/include/site_sync_impl.php`）。

## 2026-02-27-11 | 修复 | v6 模板下发：下载强校验 HTTP 状态码 + 更明确的 sha1 错误
- 修复：`shipsay/include/site_sync_impl.php` 的 `ss_http_download_to_file()` 在 `allow_url_fopen` 分支未校验 HTTP 状态码，可能把 403/404 的 JSON 错误页当作文件写入，导致 `tpl_sha1_mismatch` 误报。
- 增强：下载请求增加 `Accept-Encoding: identity` / UA，减少中间层压缩/变换导致的字节流不一致风险。
- 增强：模板包应用前增加 gzip magic 校验；若下载内容疑似 JSON/HTML，会在错误返回中附带简短 `head` 预览，方便定位（如 ip_not_allowed/bad_sig/expired 等）。
- 回滚：回退本次改动文件即可（`shipsay/include/site_sync_impl.php`）。

## 2026-02-14-4 | 补丁 | v6.3.3-fz1（core_policy 写入加固 + 回包补充 + 摘要范围校验）
- 更新：`site_sync meta.ver` 从 `6.3.2-impl` → `6.3.3-impl`。
- 加固：`core_policy` 旧策略备份流程增加失败拦截（备份目录创建失败/复制失败返回 `backup_failed`，中止写入）。
- 加固：`core_policy.json` 原子写增强为 `fopen/fwrite/fflush/(可选fsync)/rename`；重命名失败返回 `rename_failed` 并清理临时文件。
- 增强：`core_check_only` / `core_apply` 回包新增 `policy_load_err` 与 `policy_fallback` 字段，便于总控识别降级执行。
- 增强：`core_status.policy` 摘要中 `policy_ver` / `updated_at` 增加范围校验（`policy_ver<1 => 1`，`updated_at<0 => 0`）。
- 涉及：`shipsay/include/site_sync_impl.php`
- 回滚：恢复上述实现与版本号改动即可。

## 2026-02-14-3 | 补丁 | v6.3.2-fz1（core_policy 降级兜底 + 摘要增强 + 原子写 + 回包补充）
- 更新：`site_sync meta.ver` 从 `6.3.1-impl` → `6.3.2-impl`。
- 修复：`core_policy.json` 解析失败/策略结构异常时，不再中断 `core_check_only` / `core_apply`，改为自动降级使用默认策略继续执行（并保留错误标记）。
- 增强：`core_status.policy` 摘要新增 `err` / `policy_ver` / `updated_at`，用于识别策略文件健康状态与版本。
- 加固：`core_policy_apply` 写入 `core_policy.json` 改为同目录临时文件 + `rename` 覆盖的原子写流程。
- 增强：`core_check_only` / `core_apply` 回包新增 `policy_used` 字段（策略摘要）。
- 涉及：`shipsay/include/site_sync_impl.php`
- 回滚：恢复上述实现与版本号改动即可。

## 2026-02-14-2 | 补丁 | v6.3.1-fz1（core_apply/core_rollback 返回版本号修复 + impl ver 统一）
- 修复：`core_apply` / `core_rollback` 响应字段 `v` 错误（`62` → `63`，避免总控误判协议代际）。
- 更新：`site_sync meta.ver` 从 `6.3.0-impl` → `6.3.1-impl`（用于总控识别分站补丁升级进度）。
- 涉及：`shipsay/include/site_sync_impl.php`
- 回滚：恢复上述两处改动即可。

## 2026-02-14-1 | 功能 | v6.3-fz1（core_policy.json 核心策略：集中维护/下发/落盘/备份/摘要）
- 新增：核心策略文件 `core_policy.json`（分站落盘：`shipsay/configs/_bak/core_policy.json`，并自动保留备份目录）。
- 新增：写接口 `core_policy_apply`（总控批量下发策略到分站，分站落盘并控量清理旧备份）。
- 更新：`core_status` 回传策略摘要 `policy`（sha1/size/applied_at/backup_count/latest_backup/exists）。
- 更新：`core_check_only` / `core_apply` 读取策略并按策略控制跳过规则（`protect_site_sync` / `ban_prefix` / `ban_seg` / `allow_root`）。
- 涉及：`shipsay/include/site_sync_impl.php`
- 回滚：删除 `shipsay/configs/_bak/core_policy.json` 及其备份目录，并回退实现文件到 v6.2.x。

## 2026-02-13-6 | 完善 | v6.2.2-fz2（core_apply 统计修复）
- 修复：`core_apply` 统计跳过文件样例 `skipped_samples` 采样位置错误（之前永远为空，用于总控“详情”展示）。
- 更新：`site_sync meta.ver` 从 `6.2.1-impl` → `6.2.2-impl`（便于总控识别分站升级进度）。
- 涉及：`shipsay/include/site_sync_impl.php`
- 回滚：恢复上述两处改动即可（不影响写盘结构）。

## 2026-02-13-3 | 功能 | v6.2.0-fz2（core_apply / core_rollback 核心下发与回滚）
- 新增写操作：
  - `core_apply`：下载 core bundle → 校验 sha1 → 解包 → 备份将被覆盖文件 → 覆盖写入
  - `core_rollback`：回滚到最近一次 core bundle 备份（恢复被覆盖文件 + 删除新增文件）
- 默认安全策略：
  - 永远不覆盖：`shipsay/configs/`、`themes/`、`www/static/`、`www/caijie/`
  - 默认不覆盖：`www/api/site_sync.php`（除非 `overwrite_site_sync=1`）
  - 跳过运行时目录：`runtime/cache/logs/uploads` 等（命中路径片段即跳过）
- 备份/状态落盘：
  - 备份：`shipsay/configs/_bak/core_bundle_*`（仅备份会被覆盖的文件 + meta.json）
  - 状态：`shipsay/configs/_bak/core_current.json`（apply/rollback 后写入）
  - 清理：保留最近 `keep` 份备份（默认 3，最多 60）
- 涉及：`shipsay/include/site_sync_impl.php`

## 2026-02-13-2 | 维护 | v6.1.1-fz2（版本标识调整）
- 调整：`site_sync meta.ver` 从 `6.1-impl` → `6.1.1-impl`（便于总控识别版本）。
- 涉及：`shipsay/include/site_sync_impl.php`

## 2026-02-13-1 | 功能 | v6.1-fz2（core_check_only 核心预演）
- 新增只读动作：`core_check_only`
  - 下载 core bundle → 解包到临时目录 → 统计将新增/覆盖/黑名单跳过文件数
  - 默认跳过覆盖 `www/api/site_sync.php`（除非 `overwrite_site_sync=1`，并在结果中标记 `site_sync_files`）
  - 返回字段：`core_check.total_files/add_files/overwrite_files/skipped_files/site_sync_files` 等（供总控落库展示）
- 注意：仅预演，不覆盖线上核心文件、不写 `core_current.json`。

## 2026-02-12-2 | 安全/可用性 | site_sync 只读接口默认不验签
- 目标：`novel_search / chapter_get` 只读接口默认只依赖 allow_ips 放行，避免只读跨站调用受 secret 不一致影响。
- 规则：核心同步仍强制签名（pull/apply/rollback/check_only/core_* 等）。
- 可选：如需“只读接口也验签”，在 `shipsay/configs/site_sync.php` 设置 `$site_sync_sign_readonly = 1;`
- 涉及：`www/api/site_sync.php`、`shipsay/configs/site_sync.php`

## 2026-02-12-1 | 稳定性 | 缺章/短章兜底补丁表 + 冷却策略
- 目标：缺章或内容不足阈值（默认 <100 字）时，跨站取章兜底并写入补丁表；主库补全后自动回归主章节（主章节优先）。
- 新增：
  - `shipsay/include/chapter_patch.php`（补丁表读取 + Hub sources + 远端 `chapter_get` 拉取 + 写入补丁表）
  - `shipsay/configs/chapter_patch.php`（可选参数覆盖）
- 接入：
  - `shipsay/app/reader.php`（蜘蛛直出正文链路）
  - `shipsay/include/reader_js.php`（普通用户 JS 正文链路）
- 依赖：
  - 建表：`shipsay/tools/chapter_patch_schema.sql`
  - Hub：`https://zongkong.112book.com/panel/api/novel_hub.php?mode=sources`
- 稳定性：
  - Hub sources：本地文件缓存（TTL 可配）
  - 远端拉取失败：失败冷却（指数退避）
- 回滚：恢复 reader.php/reader_js.php 旧版，或在 `chapter_patch.php` 关闭开关。


## 2026-03-07 cg_patch_007
- mobile: 首页/分类列表带图卡片继续收口为更稳定的“封面列 + 文字列”布局。
- mobile: 首页分类首卡 sortvisit 首图卡片增大封面并收紧标题/作者/简介节奏。
- mobile: 详情页、目录页顶部图文区继续优化封面尺寸、元信息折行与按钮区节奏。


## 2026-03-07 cg_patch_008
- mobile: 首页/分类列表带图卡片继续只收“右侧文字节奏”，不再扩大封面和不再动详情/目录页顶部图区。
- mobile: 首页/分类列表卡片简介摘要改为更适合窄屏的两行预览，并取消列表摘要首行缩进，减少图片邻接区的断裂感。
- mobile: 作者行与字数/更新时间继续统一为同一底部节奏，降低首页与分类页卡片的上下留白发散。
- pc: 本轮仅追加 `max-width:768px` 收口，不改 PC 端结构与样式。

## 2026-03-07 cg_patch_009
- mobile: 首页分类首卡 `sortvisit` 首图条目把作者与简介拆成独立层，简介按两行摘要收口，解决手机端简介溢出与节奏发散。
- mobile: 详情页、目录页顶部元信息中的“作者 / 分类 / 状态 / 字数”改成更稳定的标签+内容结构，避免手机端把“作者”拆成两行。
- pc: 本轮同步兼顾 PC，模板结构只做小幅语义包装，不改页面主布局。


## 2026-03-07 cg_patch_010
- mobile: 首页 / 分类列表带图卡片摘要继续收口为 1 行预览，优先保证标题、作者、字数/时间基线更整齐。
- mobile: 首页分类首卡 `sortvisit` 的简介继续改成 1 行摘要，解决首图条目与下方列表衔接不够紧凑的问题。
- mobile: 详情页顶部元信息区继续收紧到更贴近书封高度，`开始阅读 / 查看目录` 按整行双按钮铺开；目录页最新章节改为单独可控的长链接行，避免长章节名溢出。
- pc: 本轮仍只针对手机端追加覆盖，不改 PC 端布局。
- 2026-03-07：恢复详情页/目录页 PC 顶部信息区与按钮节奏；手机端仅继续收口首页/分类带图卡片封面列、详情/目录元信息间距与详情按钮整行铺开。
