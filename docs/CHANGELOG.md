# 船说CMS 4.2 分站（fz1）- 版本与优化记录（可修改）

> 本文件用于：记录分站侧每一次改动（接口/阅读链路/兜底策略/安全策略），方便后续更新与交接。
>
> **修改规则（必须遵守）：**
> 1) 每次上线/覆盖文件后，必须新增一条记录（不要改旧记录）。
> 2) 写清楚：日期、版本号（或内部编号）、改动点、影响范围、涉及文件路径、回滚方式。
   - **日期格式建议：`YYYY-MM-DD-N`（同一天多次改动用 N 递增，如 `2026-02-12-1`）**；也可加 `HH:mm`。
> 3) 与安全相关（鉴权/白名单/secret）必须单独标注。

---

## 版本记录

### v5.2-fz1-patch（缺章/短章兜底补丁表 + 冷却策略）— 2026-02-12

- 类型：稳定性/内容兜底
- 目标：主章节缺章或内容不足阈值（默认 <100 字）时，跨站取章兜底并写入补丁表；主库采集补全后自动回归主章节（主章节优先）。
- 改动点：
  - 新增：`shipsay/include/chapter_patch.php`（补丁表读取 + Hub sources + 远端 chapter_get 拉取 + 写入补丁表）
  - 新增：`shipsay/configs/chapter_patch.php`（可选参数覆盖）
  - 接入：`shipsay/app/reader.php`（蜘蛛直出正文链路）
  - 接入：`shipsay/include/reader_js.php`（普通用户 JS 正文链路）
  - 稳定性：失败冷却（指数退避）+ Hub sources 文件缓存（TTL 可配）
- 依赖：
  - 资源站库已建表：`shipsay_article_chapter_patch`（`shipsay/tools/chapter_patch_schema.sql`）
  - Hub 可用：`https://zongkong.112book.com/panel/api/novel_hub.php`（`mode=sources`）
- 回滚方式：
  - 恢复 `reader.php/reader_js.php` 旧版；
  - 删除/禁用 `chapter_patch.php`（或在 `chapter_patch.php` 设置 `$chapter_patch_enable=0`）。

---

### v5.2-fz1-patch（site_sync 只读接口默认不验签 + allow_ips 维护口径）— 2026-02-12

- 类型：接口鉴权策略（安全/可用性）
- 目标：`novel_search / chapter_get` 只读接口默认只依赖 allow_ips 放行，避免只读跨站调用受 secret 不一致影响；核心同步仍强制签名。
- 改动点：
  - `www/api/site_sync.php`：只读接口默认不强制签名；核心同步（pull/apply/rollback/check_only）在配置 secret 时强制签名。
  - `shipsay/configs/site_sync.php`：补充 allow_ips 维护说明，并填入当前全量 IP 白名单（156 条）。
  - 可选开关：如需“只读接口也强制签名”，在 `shipsay/configs/site_sync.php` 设置 `$site_sync_sign_readonly = 1;`
- 回滚方式：恢复旧版 `www/api/site_sync.php` 与 `shipsay/configs/site_sync.php`。

---



---

### v6.1-fz2-patch（core_check_only 核心预演）— 2026-02-13-1

- 类型：接口增强（只读预演/安全预推）
- 改动点：
  - 分站 `site_sync` 新增只读动作：`core_check_only`
    - 下载 core bundle → 解包到临时目录 → 统计将新增/覆盖/黑名单跳过文件数
    - 默认跳过覆盖 `www/api/site_sync.php`（除非 `overwrite_site_sync=1`）并在结果中标记 `site_sync_files`
  - 结果返回字段：`core_check.total_files/add_files/overwrite_files/skipped_files/site_sync_files` 等（供总控落库展示）
- 注意：本阶段仅预演，不覆盖线上核心文件、不写 core_current.json。

---

### v6.2.0-fz2（core_apply / core_rollback 核心下发与回滚）— 2026-02-13-3

- 类型：接口增强（写操作/可回滚）
- 改动点：
  - 分站 `site_sync` 新增写操作：
    - `core_apply`：下载 core bundle → 校验 sha1 → 解包 → 备份将被覆盖的文件 → 覆盖写入
    - `core_rollback`：回滚到最近一次 `core_bundle_*` 备份（恢复被覆盖文件 + 删除新增文件）
  - 默认安全策略：
    - 永远不覆盖：`shipsay/configs/`、`themes/`、`www/static/`、`www/caijie/`
    - 默认不覆盖：`www/api/site_sync.php`（除非 `overwrite_site_sync=1`）
    - 跳过运行时目录：`runtime/cache/logs/uploads` 等（命中路径片段即跳过）
  - 备份/状态落盘：
    - 备份：`shipsay/configs/_bak/core_bundle_*`（仅备份会被覆盖的文件 + meta.json）
    - 状态：`shipsay/configs/_bak/core_current.json`（apply/rollback 后正式写入）
  - 控量清理：保留最近 `keep` 份备份（默认 3，最多 60）。
- 涉及路径：`shipsay/include/site_sync_impl.php`
- 回滚方式：覆盖回旧版 `site_sync_impl.php`（或仅移除 core_apply/core_rollback 段）。

---

### v6.2.2-fz2（core_apply skipped_samples 修复 + meta ver 更新）— 2026-02-13-6

- 类型：完善（展示/可识别性，不影响写盘结果）
- 改动点：
  - 修复：`core_apply` 统计跳过文件样例 `skipped_samples` 时，采样代码放在 `continue` 之后导致永远为空；现在会正常返回（用于总控“详情”展示）。
  - `site_sync meta.ver` 从 `6.2.1-impl` 更新为 `6.2.2-impl`，便于总控识别分站升级进度。
- 涉及路径：`shipsay/include/site_sync_impl.php`
- 回滚方式：覆盖回 v6.2.1 对应 impl（或把上述两处改动恢复即可）。

## 变更注释（修改本文件必须追加）

- 2026-02-13-6 | 完善 | by jie cai | v6.2.2：修复 core_apply 的 skipped_samples 采样；meta.ver=6.2.2-impl。

- 2026-02-13-3 | 功能 | by jie cai | v6.2.0：新增 core_apply/core_rollback（核心下发与回滚，默认不覆盖 site_sync）。


- 2026-02-13-1 | 功能 | by jie cai | v6.1：新增 core_check_only 核心预演（只读预推）。

- 2026-02-13-2 | 维护 | by jie cai | v6.1.1：site_sync meta ver 调整为 6.1.1-impl（便于识别版本）。

- 2026-02-12 | 初始化 | by jie cai | 创建分站 CHANGELOG.md，补齐兜底补章与 site_sync 鉴权策略记录。


### v6.1.1-fz2（版本标识调整）— 2026-02-13-2

- 类型：维护/可识别性
- 改动点：site_sync meta 的 ver 字段从 `6.1-impl` 调整为 `6.1.1-impl`，方便总控识别分站升级进度。
- 涉及路径：`shipsay/include/site_sync_impl.php`
- 回滚方式：恢复 ver 字符串即可（不影响功能）。
