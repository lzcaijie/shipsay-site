# OPS（site）日常操作手册

> 这是“分站 shipsay-site 仓库”的操作定稿说明。目标：改动快速生效，且 GitHub/工作区/运行目录保持一致。

## 1）单一真源
- 以 GitHub 为准：`lzcaijie/shipsay-site`
- 线上任何改动最终都要回到 GitHub（commit/push），避免“线上漂移”。

## 2）目录分层（固定）
- 工作区（与 GitHub 同步，唯一编辑入口）：`/root/gitwork/shipsay-site`
- 运行目录（网站实际跑的，只通过脚本同步）：`/www/wwwroot/fz1.112book.com`

## 3）交付与更新方式（默认：增量包 + A/B）
1. 上传增量包到服务器 `/root/tmp/`
2. 在工作区执行 A 段：切到 `main`、拉最新、建分支、把增量包覆盖到工作区
3. 先做 `git status / git diff` 与范围检查，再提交推送
4. PR 合并后执行 B 段：同步到运行目录 `/www/wwwroot/fz1.112book.com` 并校验

## 4）排除项（保护线上真实配置/数据）
- 部署排除：`.git/`、`*.tar.gz`
- 说明：`shipsay/config.php`、`shipsay/config.local.php` 当前基线中不存在，不再写入排除清单，避免误导后续模板协作。

## 5）一致性验证（最准）
```bash
rsync -ani --delete --no-owner --no-group   --exclude='.git/' --exclude='*.tar.gz'   /root/gitwork/shipsay-site/   /www/wwwroot/fz1.112book.com/ | head -n 200
```
输出为空≈一致。

## 6）宝塔【常用命令】建议（site 三条）
- 提交推送：把改动写进 GitHub（形成进度点）
- 正式部署：同步到运行目录生效
- 查看差异（最准）：确认工作区与运行目录一致

## 7）最短反馈（用于对接，减少对话）
- 测试：✅/❌（一句话）
- commit：`git log -1 --oneline`
