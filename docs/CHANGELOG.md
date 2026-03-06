# CHANGELOG（分站 shipsay-site，最新在最前）

- 修复：`themes/shipsay/tpl_footer.php` 统一底部首页入口为安全链接，并给统计代码 include 增加文件存在/数组判断，避免模板层直接依赖未兜底变量。
- 修复：`themes/shipsay/tpl_recentread.php` 的首页面包屑与猜你喜欢列表统一改用模板本地 safe 值输出，不再直接裸用原始链接与文案。
- 修复：`themes/shipsay/tpl_error.php` 的返回首页和搜索表单 action 改走安全链接输出，保持错误页模板边界一致。
- 任务：新增“手机页面显示问题”到后续模板验收范围，后续单独按移动端布局、错位、空白、按钮可点性继续收口。

- 修复：`themes/shipsay/tpl_author.php` 的作者名/作品数改走本地安全显示值，并统一作者页 canonical / OG URL 的转义输出。
- 修复：`themes/shipsay/tpl_indexlist.php` 的目录页 BreadcrumbList 不再回退引用未定义原始变量，并把分页/总章节展示统一为本地安全数值。
- 修复：`themes/shipsay/tpl_reader.php` 的阅读页本地记录脚本改用 `$reader_url_safe`，并统一阅读页 novel OG 属性与分页数字的安全输出。
- 修复：`shipsay/app/home.php` 的热门小说数据改为按实际展示数量取 `12` 条，去掉首页无意义的奇数超取。
- 修复：`themes/shipsay/tpl_home.php` 移除未使用的 `$rank_base` 历史变量，并统一首页 canonical / `mobile-agent` / `og:url` 的安全输出。
- 修复：`themes/shipsay/tpl_header.php` 顶部导航过滤排行入口时改用 `$rank_entry_safe`，不再依赖原始 `fake_top` 判断。
- 修复：`themes/shipsay/tpl_rank.php` 榜单详情页优先复用程序已准备的 `$rank_entry_url`，并统一 `canonical / mobile-agent / og:url` 的安全输出。
- 修复：`shipsay/app/top.php` 接管排行聚合页榜单数据准备，`themes/shipsay/tpl_top.php` 不再直接拼 SQL / 读 Redis / 查库。
- 修复：`themes/shipsay/tpl_category.php` 的书库入口统一改走 `$allbooks_url_safe`，避免模板直接吃未兜底链路。
- 修复：`themes/shipsay/tpl_search.php` 的搜索词输出改为安全高亮，避免前台直接裸输出搜索词。
> 说明：
> - 本文件只记录“分站侧功能/接口/安全策略”变更（新增写在最前）。
> - 日常操作流程/部署/一致性验证：见 `docs/OPS.md`。
>
> 记录规则（建议）：
> - 写清：日期、类型、版本号（可自定义）、涉及路径、回滚方式/要点。

---

## 2026-03-07-2 | 模板/文档 | Shipsay SEO 收尾第二轮 + 变量边界校准
- 修复：`themes/shipsay/tpl_header.php` 增加书库/完本/足迹入口 safe 兜底，避免头部直接依赖未兜底变量。
- 修复：`themes/shipsay/tpl_info.php` 详情页 SEO 输出与页面 TDK 对齐，`canonical / og / JSON-LD` 改为走安全链接和纯文本简介。
- 修复：`themes/shipsay/tpl_indexlist.php` 目录页补齐 TDK 兜底、OG 基础项与 BreadcrumbList 结构化数据，并去掉未使用的局部变量。
- 修复：`themes/shipsay/tpl_reader.php` 阅读页补齐 `canonical` 与 BreadcrumbList，并让 `og:title / og:description` 与页面 SEO 输出保持一致。
- 文档：继续补强 `docs/V5_1_TEMPLATE_STANDARD.md` 与 `docs/VARIABLE_MAP.md`，记录 safe 变量、目录页/阅读页 SEO 最低标准与变量判定红线。

## 2026-03-07-1 | 模板/文档 | Shipsay SEO 首轮收口 + v5.1 文档补充
- 修复：`themes/shipsay/tpl_info.php` 前台不再展示内部实现说明文案，并将章节块标题统一为“前 50 章”。
- 完善：补强首页、分类页、作者页、排行聚合页、榜单详情页的基础 SEO 输出（canonical / device / OG / 结构化数据）。
- 完善：新增 `docs/VARIABLE_MAP.md` 与 `docs/V5_1_TEMPLATE_STANDARD.md`，把本轮扫描确认的变量分层、结构红线、SEO 规则补入真源文档。
- 迁移：为 `shipsay/docs/` 增补迁移占位文件，继续固定根目录 `docs/` 为唯一真源。
- 备注：`themes/shipsay/tpl_top.php` 仍保留历史数据层例外，仅记录，不作为后续模板标准。


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
