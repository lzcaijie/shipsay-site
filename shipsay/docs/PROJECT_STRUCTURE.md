# PROJECT_STRUCTURE（分站）

> 该文件记录关键目录与入口，便于后续升级/交接。

## 目录结构

- `www/`：站点运行目录
  - `www/api/site_sync.php`：分站同步接口（pull/apply/rollback/check_only + 只读 novel_search/chapter_get）
- `shipsay/`：核心目录
  - `shipsay/app/reader.php`：蜘蛛直出阅读链路入口（正文输出 `$rico_content`）
  - `shipsay/include/reader_js.php`：普通用户 JS 正文链路入口（由 `/api/reader_js.php` 路由）
  - `shipsay/configs/`：最终落盘配置目录（总控下发最终写这里）
    - `config.ini.php` / `filter.ini.php` / `link.ini.php` / `count.ini.php` / `search.ini.php`
    - `site_sync.php`：分站同步安全配置（allow_ips/secret/签名策略）
  - `shipsay/docs/`：交接文档
    - `CHANGELOG.md`
    - `PROJECT_STRUCTURE.md`

## site_sync 说明

- 入口：`https://分站域名/api/site_sync.php`
- 只读接口：
  - `novel_search`：按书名/作者搜索；返回匹配书的 `articleid`
  - `chapter_get`：按（书名/作者/章序）取章节正文（从 txt_url 读取）
- 写接口：`apply` / `rollback` / `check_only`
- 安全策略：
  - allow_ips：必检（建议必填）
  - secret：写接口必验签；只读接口默认不验签（可设置 `site_sync_sign_readonly=1` 强制验签）

## v6：模板分发（分站端）

- 入口：`/www/api/site_sync.php`
  - 响应会额外包含 `site_sync` 摘要字段：`ver / ip / allow_ips_count / trust_proxy_ip / sign_readonly`（用于总控状态可视化）
  - `tpl_status`：查看当前模板状态与备份数量（只读）
  - `tpl_apply`：下载并应用模板包（支持 `check_only` 仅检查）
  - `tpl_rollback`：回滚到最近一次模板备份
- 覆盖目录：
  - `themes/<theme>/`
  - `www/static/<theme>/`
- 备份与状态：
  - `shipsay/configs/_bak/tpl_bundle_*`：每次下发前的备份
  - `shipsay/configs/_bak/tpl_current.json`：当前模板信息
