# CHANGELOG（分站 shipsay-site，最新在最前）

> 说明：
> - 本文件只记录“分站侧功能/接口/安全策略”变更（新增写在最前）。
> - 日常操作流程/部署/一致性验证：见 `docs/OPS.md`。
>
> 记录规则（建议）：
> - 写清：日期、类型、版本号（可自定义）、涉及路径、回滚方式/要点。

---

## 2026-03-06-v5.2-1 | 模板 | shipsay 母模板第二轮纠偏 + docs 修订
- 目标：修正 v5.1 第一轮里“加了但不该加、该保留却没保留、模板显示与程序真实变量不一致”的问题。
- 模板调整：
  - `tpl_footer.php`：移除前端可见 HTML 注释，母模板不再输出用户可见注释。
  - `tpl_home.php`：移除页面正文里的“更多排行”入口，排行仅保留全站顶部入口。
  - `tpl_top.php / tpl_rank.php`：移除解释性说明文案，只保留页面标题与真实榜单内容。
  - `tpl_info.php`：简介改为优先读实际存在变量；恢复详情页前 50 章预览，PC 双列 / 手机单列；保留最近 12 章与相关推荐。
  - `tpl_category.php`：移除正文区域多余排行入口；恢复真实分页输出（桌面页码 + 手机上一页/下一页/跳页）。
  - `tpl_reader.php`：调整面包屑、分页信息、标题与正文的左右对齐，优先修正阅读流。
- 程序调整：
  - `shipsay/app/category.php`：取消“分类页最多只展示 10 页”的硬限制，恢复按真实总页数分页。
- 样式调整：
  - `www/static/shipsay/style.css`：补 `v5.2` 覆盖样式，修正分类分页、阅读页对齐、详情页简介与预览区节奏。
- 文档调整：
  - 更新 `docs/V5_1_TEMPLATE_STANDARD.md`
  - 更新 `docs/VARIABLE_MAP.md`
- 原则：模板纠偏优先于“为了统一继续加模块”；用户能看到的注释与说明文案一律去掉。

## 2026-03-06-v5.1-1 | 模板 | shipsay 母模板第一轮收口 + docs 更新
- 目标：继续以 `themes/shipsay/` 作为母模板基线，先修正 v5.0 中“改动过重、影响页面协调性”的部分，再沉淀到 v5.1 / v5.2 文档。
- 模板调整：
  - `tpl_header.php`：顶部入口新增“排行”，保留后台可变 `fake_top`，不写死路由。
  - `tpl_home.php`：移除首页强插的完整排行榜块，仅保留顶部/头部排行榜入口；热门模块增加“更多排行”入口。
  - `tpl_info.php`：恢复详情页最新章节区；修正章节列表变量兼容（优先 `lastarr`）；补回长尾相关推荐入口。
  - `tpl_indexlist.php`：目录页改为 PC 双列/手机单列；分页改回复用 app 已生成的 `$htmltitle`；补充长尾目录入口。
  - `tpl_category.php`：栏目页增加顶部扩展入口；PC 双列卡片；标题与简介长度收口；保持手机端单列。
  - `tpl_recentread.php`：阅读记录页改为主内容 + 侧栏结构，统一头部与面包屑。
  - `tpl_top.php`：改为复用 SEO 渲染链路。
- 静态样式：`www/static/shipsay/style.css` 同步补齐首页、栏目页、详情页、目录页、阅读记录页的收口样式与移动端规则。
- 文档调整：
  - 更新 `docs/V5_1_TEMPLATE_STANDARD.md`
  - 更新 `docs/VARIABLE_MAP.md`
  - 本条写入 `docs/CHANGELOG.md`
- 原则：不为了“更像标准”而破坏原本正确逻辑；SEO 继续服从程序链路。

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
