# PROJECT_STRUCTURE（分站 shipsay-site）

> 用途：记录分站侧目录结构、关键入口、阅读链路、同步接口与兜底补章逻辑，便于维护与交接。
>
> 约定：
> - 日常操作流程/部署/一致性验证：见 `docs/OPS.md`
> - 本文件如有改动，请在 `docs/CHANGELOG.md` 新增一条记录（新增写最前）

---

## 0）顶层目录
- `www/`：站点运行目录（Web Root，入口与路由）
- `shipsay/`：船说CMS核心（app/include/class/configs/tools）
- `themes/`：模板目录（每套模板一个子目录）
- `www/static/<theme>/...`：静态资源（模板分发时需同时下发模板文件 + 对应静态资源）

---

## 1）Web 入口与路由
- 入口：`www/index.php`
  - 定义 `__ROOT_DIR__`，加载 `shipsay/configs/config.ini.php`
  - 通过 `shipsay/class/router.php` 根据 `REQUEST_URI` 路由到对应 app/include

---

## 2）阅读链路（非常关键）

### 2.1 蜘蛛直出（PHP 直出正文）
- 入口：`shipsay/app/reader.php`
- 模板输出：`themes/*/tpl_reader.php` 使用 `$rico_content` 输出正文
- 兜底补章：缺章/短章时调用 `shipsay/include/chapter_patch.php`

### 2.2 普通用户（JS 拉取正文）
- 前端：`themes/*/tpl_reader.php` AJAX 请求 `/api/reader_js.php`
- 路由：`router.php` → `shipsay/include/reader_js.php`
- 兜底补章：缺章/短章时同样调用 `shipsay/include/chapter_patch.php`

---

## 3）缺章/短章兜底补全（补丁表方案）
- 触发：主 TXT 缺章 / 内容去空白后长度 < 100 字（阈值可配）
- 兜底顺序：
  1) 主 TXT（本地）优先
  2) 本库补丁表：`shipsay_article_chapter_patch`
  3) Hub sources：`https://zongkong.112book.com/panel/api/novel_hub.php?mode=sources`
  4) 远端分站接口：`https://{分站域名}/api/site_sync.php`（`chapter_get`）
  5) 成功写回补丁表（不覆盖主章节表）
- 关键文件：
  - `shipsay/include/chapter_patch.php`
  - `shipsay/configs/chapter_patch.php`（可选覆盖）
  - `shipsay/tools/chapter_patch_schema.sql`（建表）

---

## 4）site_sync（分站同步 & 只读接口）
- URL 入口（固定）：`https://{分站域名}/api/site_sync.php`
- 实际脚本：`www/api/site_sync.php`
- 配置：`shipsay/configs/site_sync.php`
  - allow_ips：白名单（建议必填）
  - secret：写接口建议启用验签
  - sign_readonly：可选（只读接口是否也强制签名）

- 动作（act）常用：
  - 只读：`tpl_status`、`core_status`、`core_check_only`
  - 写操作：模板 `tpl_apply/tpl_rollback`，核心 `core_apply/core_rollback`
