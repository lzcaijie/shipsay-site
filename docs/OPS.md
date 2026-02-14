# OPS（site）日常操作手册

> 这是“分站 shipsay-site 仓库”的操作定稿说明。目标：改动快速生效，且 GitHub/工作区/运行目录保持一致。

## 1）单一真源
- 以 GitHub 为准：`lzcaijie/shipsay-site`
- 线上任何改动最终都要回到 GitHub（commit/push），避免“线上漂移”。

## 2）目录分层（固定）
- 工作区（与 GitHub 同步，唯一编辑入口）：`/root/gitwork/shipsay-site`
- 运行目录（网站实际跑的，只通过脚本同步）：`/www/wwwroot/www/`

## 3）交付与更新方式（默认：仅变更文件压缩包）
1. 上传 zip 到宝塔
2. 解压到工作区根目录覆盖（不要解压到运行目录）
3. 点【提交推送】→ 点【正式部署】→ 点【查看差异（最准）】→ 测试

## 4）排除项（保护线上真实配置/数据）
- 部署排除：`.git/`、`*.tar.gz`、`shipsay/config.php`、`shipsay/config.local.php`

## 5）一致性验证（最准）
```bash
rsync -ani --delete --no-owner --no-group   --exclude='.git/' --exclude='*.tar.gz'   --exclude='shipsay/config.php' --exclude='shipsay/config.local.php'   /root/gitwork/shipsay-site/   /www/wwwroot/www/ | head -n 200
```
输出为空≈一致。

## 6）宝塔【常用命令】建议（site 三条）
- 提交推送：把改动写进 GitHub（形成进度点）
- 正式部署：同步到运行目录生效
- 查看差异（最准）：确认工作区与运行目录一致

## 7）最短反馈（用于对接，减少对话）
- 测试：✅/❌（一句话）
- commit：`git log -1 --oneline`
