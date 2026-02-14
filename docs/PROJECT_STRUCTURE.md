# 船说CMS 4.2 分站（fz1）项目结构说明（可修改）

> 本文件用于：记录分站侧目录结构、关键入口、阅读链路、同步接口与兜底补章逻辑，便于后续维护与交接。
>
> **修改规则（必须遵守）：**
> 1) 修改本文件必须在最下方「变更注释」追加一条记录（写清日期、修改人、改动点）。
   - 日期建议：`YYYY-MM-DD-N`（如 `2026-02-12-1`），同一天多次改动用 N 递增。
> 2) 不要删除旧记录；如需纠错请追加“更正”记录。
> 3) 结构说明以“路径 + 职责 + 注意事项”为准。

---

## 0. 顶层目录

- `www/`：站点运行目录（Web Root，入口与路由）
- `shipsay/`：船说CMS核心（app/include/class/configs/tools）
- `themes/`：模板目录（每套模板一个子目录）

> 静态资源约定：`/www/static/<theme>/...`（总控分发模板时需同时下发模板文件 + 对应静态资源）

---

## 1. Web 入口与路由

- 入口：`www/index.php`
  - 定义 `__ROOT_DIR__`，加载 `shipsay/configs/config.ini.php`
  - 通过 `shipsay/class/router.php` 根据 `REQUEST_URI` 路由到对应 app/include

---

## 2. 阅读链路（非常关键）

### 2.1 蜘蛛直出（PHP 直出正文）

- 入口：`shipsay/app/reader.php`
- 正文来源：优先读 TXT（章节文件）
- 模板输出：`themes/*/tpl_reader.php` 使用 `$rico_content` 输出正文
- 兜底补章：当缺章/短章时，会调用 `shipsay/include/chapter_patch.php` 进行补丁表兜底

### 2.2 普通用户（JS 拉取正文）

- 前端：`themes/*/tpl_reader.php` 通过 AJAX 请求 `/api/reader_js.php`
- 路由：由 `router.php` 路由到 `shipsay/include/reader_js.php`
- 兜底补章：当缺章/短章时，同样调用 `shipsay/include/chapter_patch.php`

---

## 3. 缺章/短章兜底补全（方案B：补丁表，不动主章节表）

### 3.1 触发与顺序

- 触发条件：主 TXT 缺章 / 内容去空白后长度 < 100 字（阈值可配）
- 兜底顺序：
  1) 主 TXT（本地）优先
  2) 本库补丁表：`shipsay_article_chapter_patch`（实际表名前缀以 `$dbarr['pre']` 为准）
  3) Hub sources：`https://zongkong.112book.com/panel/api/novel_hub.php`（`mode=sources`）
  4) 远端分站接口：`https://{分站域名}/api/site_sync.php`（`chapter_get`）
  5) 成功写回补丁表（不覆盖主章节表）

### 3.2 关键文件

- 兜底核心：`shipsay/include/chapter_patch.php`
- 可选配置覆盖：`shipsay/configs/chapter_patch.php`
- 建表 SQL：`shipsay/tools/chapter_patch_schema.sql`

### 3.3 稳定性/节流

- Hub sources：本地文件缓存（TTL 可配）
- 远端拉取失败：失败冷却（指数退避，避免反复请求打满来源站点）

---

## 4. site_sync（分站同步 & 只读接口）

- URL 入口（固定）：`https://{分站域名}/api/site_sync.php`
- 实际脚本：`www/api/site_sync.php`
- 配置：`shipsay/configs/site_sync.php`
  - `$site_sync_allow_ips`：白名单（**必须维护**）
  - `$site_sync_secret`：核心同步签名密钥（建议启用）
  - `$site_sync_sign_readonly`：可选（只读接口是否也强制签名）

- 动作（act）：
  - 只读：`tpl_status`、`core_status`、`core_check_only`
  - 写操作：模板 `tpl_apply/tpl_rollback`，核心 `core_apply/core_rollback`（v6.2 已实现）

---

## 变更注释（修改本文件必须追加）

- 2026-02-13-6 | 补充 | by jie cai | v6.2.2：core_apply 的 skipped_samples 采样修复；site_sync meta.ver=6.2.2-impl（便于总控识别）。

- 2026-02-13-3 | 补充 | by jie cai | v6.2.0：core_apply/core_rollback 已实现（核心下发/回滚落盘与备份策略）。

- 2026-02-13-1 | 补充 | by jie cai | v6.1：补充 core_check_only 核心预演动作说明。
- 2026-02-13-2 | 补充 | by jie cai | v6.1.1：site_sync meta ver 更新为 6.1.1-impl（便于识别分站版本）。

- 2026-02-12 | 初始化 | by jie cai | 创建分站 PROJECT_STRUCTURE.md，补齐阅读链路、兜底补章与 site_sync 入口说明。
