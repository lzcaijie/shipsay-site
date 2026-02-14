# CHANGELOG（分站）

## 2026-02-13

- 新增：site_sync 支持 `patch.site_sync.allow_ips` 下发并落盘到 `shipsay/configs/site_sync.php`。
- 优化：签名策略支持“只读接口可不验签”（默认仅 allow_ips；可用 `site_sync_sign_readonly=1` 强制只读也验签）。
- 新增：`chapter_get` 只读接口（供缺章/短章兜底跨库取章；返回 txt_url 内容）。

## 2026-02-13（v6）

- 新增：site_sync 模板分发（分站端）
  - 新增操作：`tpl_status` / `tpl_apply` / `tpl_rollback`
  - 覆盖目录：`themes/<theme>/` + `www/static/<theme>/`
  - 备份：`shipsay/configs/_bak/tpl_bundle_*`，当前状态：`shipsay/configs/_bak/tpl_current.json`
  - 写操作强制要求 `site_sync_secret`（否则拒绝执行）
- 增强：tpl_status / tpl_apply / tpl_rollback 响应增加 `site_sync` 摘要（ver/ip/allow_ips_count/trust_proxy_ip/sign_readonly），供总控模板状态可视化。
