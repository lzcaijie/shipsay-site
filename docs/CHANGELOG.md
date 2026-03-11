- shuyue v3：继续按 v5 收口未触及页面，范围仅 `themes/shuyue/*` 与 `docs/CHANGELOG.md`；不动 `app / class / include / configs`，也不回带其他模板。
- shuyue v3：修正 `tpl_recentread.php` 的脚本输出顺序，阅读记录页改为通过 `page_end_scripts` 在 footer 关闭前输出 `tempbookcase.js / layer.js` 与 `nav_sel('nav_his')`，避免脚本落在 `</body></html>` 之后。
- shuyue v3：`tpl_home.php / tpl_category.php / tpl_author.php` 继续按真实站点链接收口 canonical 与公共入口，首页与列表页的 `More+` 链接只消费真实 `rank_entry_url / fake_top / allbooks_url`，分类页 canonical 不再临时拼接 `SERVER_NAME + REQUEST_URI`。

- shuyue v2：继续按 v5 收口模板层，仍只调整 `themes/shuyue/*` 与 `docs/CHANGELOG.md`；统一 `tpl_header.php / tpl_footer.php / tpl_error.php / tpl_search.php / tpl_author.php / tpl_recentread.php` 的站点首页、搜索、排行、阅读记录真实链接消费，不再在面包屑和错误页里继续写死首页旧入口。
- shuyue v2：`tpl_info.php / tpl_indexlist.php / tpl_reader.php` 收口详情页、目录页、阅读页的真实链接链路；阅读页蜘蛛分页改为消费 `Url::chapter_url()`，不再硬写 `/read/{aid}/{cid}/{pid}.html`；详情页与目录页补齐最新章节/目录/相关推荐的同体系展示。
- shuyue v2：`tpl_rank.php / tpl_top.php` 继续按 v5 统一为真实排行入口 + 聚合榜/单榜切换展示，并补齐头部导航高亮脚本，避免排行页进入后头部状态不一致。

- shuyue v1：以本次上传的 `tpl_shuyue5_20260302` 备份为基线，恢复 `themes/shuyue/*` 与 `www/static/shuyue/*` 的完整模板骨架；当前完整包里 `themes/shuyue` 仅剩 `tpl_home.php / tpl_category.php / tpl_recentread.php`，且 `www/static/shuyue` 为空，已先按最小差异补回可运行模板层。
- shuyue v1：不恢复会员系统相关文件，删除 `themes/shuyue/user/*`、`www/static/shuyue/js/user.js`，并同步去掉详情页/阅读页的加入书架与加入书签入口。
- shuyue v1：`tpl_header.php / tpl_error.php / tpl_rank.php / tpl_top.php` 改为优先消费程序真实搜索、排行、阅读记录链接；不再默认写死 `/search/`、`/rank/` 等旧链路；缺失时改为禁用展示。
- shuyue v1：`tpl_footer.php` 与 `www/static/shuyue/js/tempbookcase.js` 收口全站链接行为，移除非友情链接 `target="_blank"`；阅读记录清空只删除自身记录，不再 `localStorage.clear()` 全清。

- qula v5 r6：修正 `tpl_header.php` 头部搜索地址取值顺序；当 `ss_search_url()` 存在但返回空值时，自动回退到 `fake_search`，避免搜索框被渲染为禁用不可输入。
## 2026-03-10 qula v5 r5
- qula：头部移除书库榜单入口，保留首页/排行榜单/完本小说/阅读记录。
- qula：目录页“最新章节信息”增加章节名与链接兜底，移除说明性占位文案。
- qula：阅读记录页补充 scoped 样式，修复 PC 端边框溢出与条目排版错位。
- qula：顶部设首页/收藏入口改为简洁样式，PC 端更贴近其余头部视觉。

## 2026-03-10 qula v5 r4
- 修复 qula 单榜页 PC 与移动端榜单内容贴边的问题，补齐榜单切换区与榜单列表左右留白，分榜按钮与列表条目不再紧贴边框。
- 修复 qula 移动端底部继续显示独立 m-footer 的问题，统一改为直接显示与 PC 相同的 pc-footer 文案内容，仅保留一套底部口径。

## 2026-03-10 qula v5 r3
- 修复 qula 头部移动端缺少首页入口，m-nav 增加首页并移除重复搜索入口。
- 修复 qula 详情页、目录页手机端操作按钮绝对定位导致首章/最新信息被压住，改为流式按钮布局。
- 修复 qula 聚合排行榜、单榜、详情页、目录页、阅读页在 PC 端被 legacy 253px 单列宽度压缩的问题，改为 v5 单列全宽布局。
- 修复 qula 单榜 PC/移动端条目列宽，避免书名区域被过度压缩。

## 2026-03-10-02 | 模板 | qula 第二轮按 v5 收详情/目录/排行与阅读页手机翻页自适应（v2）
- 范围：仅调整 `themes/qula/*`、`www/static/qula/style.css` 与 `docs/CHANGELOG.md`，不动 `app / class / include / configs`。
- 修正：`tpl_reader.php` 对应手机端阅读翻页区改为 flex 自适应，`上一页 / 目录 / 下一页` 在 3 个或 4 个按钮场景下都不再固定占 25% 留白。
- 收口：`tpl_info.php` 与 `tpl_indexlist.php` 改为同体系输出，统一为书籍信息 / 最新章节信息 / 简介 / 顺序目录或预览 / 相关小说推荐 / 人气小说推荐，不再保留原先零散长尾链接与破碎闭合标签。
- 收口：`tpl_rank.php` 不再把同一份 `articlerows` 重复渲染成 4 列假榜单；当前单榜页统一消费 `page_title / articlerows / rank_detail_base / rank_entry_url`。
- 收口：`tpl_top.php` 改为正式消费 `top_sections / top_rank_lists / top_rank_limit`，不再继续写死 `fake_rankstr` 拼榜单入口。
- 微调：`www/static/qula/style.css` 新增 `qula-*` 页面作用域样式，只补当前详情/目录/排行与阅读翻页区，不扩散影响全站其他模板。
- 结论：qula 第二轮先把核心内容页与排行链路收成可集中测试状态；后续由你一次性实测再按页面补尾。

## 2026-03-10-01 | 模板 | qula 首轮按 v5 清会员残留与旧入口（v1）
- 范围：仅调整 `themes/qula/*`、`www/static/qula/*` 与 `docs/CHANGELOG.md`，不动 `app / class / include / configs`。
- 清理：删除 `themes/qula/user/*` 与 `www/static/qula/user.js`，模板层不再保留会员书架、登录/注册、加入书架/书签等入口。
- 收口：`tpl_header.php` 改为直接输出真实搜索表单与公共导航，去掉 `login()` / `MLogin()` 注入，排行与阅读记录入口优先消费真实变量，不再默认写死 `/rank/`；同步下发 `SS_SEARCH_URL` 给静态搜索脚本。
- 收口：`tpl_error.php` 不再写死 `/search/` fallback；搜索入口缺失时只做提示，不再反造旧搜索链路。
- 修正：`tpl_footer.php` 去掉非友情链接的 `target="_blank"`；移动端 footer 改为首页 / 阅读记录 / 排行 / 顶部。
- 修正：`www/static/qula/tempbookcase.js` 的 `removeAll()` 不再 `localStorage.clear()` 全清，同时移除阅读记录详情/继续阅读链接的 `target="_blank"`。
- 清理：`www/static/qula/common.js` 的搜索函数不再写死 `/search/` 与新开窗口；未再使用的 `www/static/qula/history.js`、`www/static/qula/motheme.js` 一并删除。
- 结论：qula 首轮先按 v5 把“多余会员系统 + 旧入口 + 全清本地存储”这批高风险问题清掉，后续再继续收详情页、目录页、排行页。

## 2026-03-09-13 | 模板 | 2025txt 头部搜索死链收口（v6）
- 范围：仅调整 `themes/2025txt/tpl_header.php`、`www/static/2025txt/css/2025.css` 与 `docs/CHANGELOG.md`，不动 `app / class / include / configs`。
- 修正：头部橙色导航中原“搜索”文案在 `search_url_raw` 缺失时会输出不可点击的禁用项；当前 2025txt 已有头部搜索框，因此直接移除重复的顶部“搜索”导航文案，不再保留死链入口。
- 微调：`header-common-nav` 按 5 个公共入口重新收口宽度，PC 改为 20% 均分，手机端改为 `calc(100%/5)`，避免移除“搜索”后导航留大块空白。
- 结论：继续遵守 v5“搜索入口必须走程序真实链接、按钮可点；已有搜索框时不再额外保留不可点击重复入口”的最小差异修法。

## 2026-03-09-13 | 模板 | 2025txt 排行聚合页按 v5 收口（v5）
- 范围：仅调整 `themes/2025txt/tpl_top.php` 与 `docs/CHANGELOG.md`，不动核心与其他页面主结构。
- 修正：`tpl_top.php` 不再继续使用 `allvisit{sortid}` / `Sort::ss_sorturl()` 这套分类榜数据；改为正式消费 `shipsay/app/top.php` 已提供的 `top_sections / top_rank_lists / top_rank_limit`。
- 修正：聚合榜标题、切换按钮与每个榜单卡片的“更多”统一消费 `rank_entry_url / rank_detail_base / top_sections[*].more`，不再把分类榜误当成聚合榜输出。
- 微调：补齐聚合榜移动端卡片样式与标题/更多对齐，避免榜单标题区重叠、挤压和错位。
- 结论：2025txt 的 `tpl_top.php` 继续按 v5 口径保持“app 提供榜单集合 → 模板只负责展示”，不在模板里自造分类榜或旧排行链路。

## 2026-03-09-12 | 模板 | 2025txt 继续清尾（v4）
- 范围：继续只动 `themes/2025txt/*` 与 `docs/CHANGELOG.md`，不动 `app / class / include / configs`。
- 收口：`tpl_header.php` 的阅读记录入口优先消费 `ss_recentread_url()`，仅在旧变量存在时兼容 `fake_recentread`。
- 收口：`tpl_info.php` 去掉模板层 `Url::index_url($articleid)` 目录链接兜底；详情页目录按钮与“查看完整目录”只消费 app 已传入的 `$index_url`，缺失时做禁用展示。
- 收口：`tpl_indexlist.php` 去掉写死 `/index/{articleid}/...` 分页回退；当前页 canonical/og 与分页跳转优先消费当前真实 `$uri / $index_url`，其他页只在 `Url::index_url()` 可用时输出链接，不再模板层自造旧路由。
- 结论：2025txt 继续按“核心给真实链接 → 模板只消费并安全输出 → 缺失时禁用展示”收尾，不主动改已经正常显示的手机端主结构。

## 2026-03-09 2025txt v3
- 继续按 v5 与 shipsay 母模板收口 2025txt，未动核心目录。
- tpl_header.php：补齐排行入口，公共导航改为优先消费 rank_entry_url / fake_top。
- tpl_rank.php：去掉写死 /rank/ 路径，canonical 与榜单切换统一消费 rank_detail_base。
- tpl_top.php：聚合榜入口改为优先消费 rank_entry_url / fake_top，不再以 fake_rankstr 作为默认导航来源。
- tpl_search.php、tpl_error.php：去掉写死 /search/ fallback，搜索入口缺失时改为禁用提交。
- www/static/2025txt/css/2025.css：修正 font-face 的旧 /public/font 路径。
- 清理未使用静态资源：chapter.css、detail.css、font/bootstrap.min.js、js/base.js、js/layer.js、js/protect-page.js、js/protect-ptcms.js。

## 2026-03-09-11 | 模板 | 2025txt 去掉 tag/user 并合并双头部（v2）
- 范围：仅新增/调整 `themes/2025txt/*`、`www/static/2025txt/*` 与 `docs/CHANGELOG.md`，不动 `app / class / include / configs`。
- 对齐：按 `V5_1_TEMPLATE_STANDARD.md` 与 `themes/shipsay/*` 母模板集合收口；`tpl_tag.php`、`user/*`、`tpl_headerr.php` 不再保留在 2025txt 母模板中。
- 收口：`tpl_header.php` 改为与母模板同口径的可变链接消费方式，去掉 `/search/`、`/history.html` 等硬编码 fallback；链接缺失时仅做禁用展示，不再反向造业务入口。
- 清理：删除 `themes/2025txt/tpl_tag.php`、`themes/2025txt/tpl_headerr.php`、`themes/2025txt/user/*` 与 `www/static/2025txt/js/user.js`；`tpl_info.php` / `tpl_reader.php` 同步移除加入书架/加书签入口。
- 修正：`www/static/2025txt/js/2025.js` 去掉登录/注册/书架自动注入；`tpl_recentread.php` 页面文案收口为“阅读记录”。
- 结论：2025txt 本轮继续按“保留正常手机端结构、先清多余会员系统与非标准文件”的方式收口，为后续子模板直接复用母模板做准备。

## 2026-03-09-08 | 模板 | 2025 母模板复制为 2025txt（首轮收口）
- 范围：新增 `themes/2025txt/*`、`www/static/2025txt/*`，仅做 2025 → 2025txt 母模板复制与首轮标准收口；不动 `app / class / include / configs`。
- 处理：复制 `themes/2025` 与 `www/static/2025` 形成 `2025txt` 基线，后续子模板从 `2025txt` 派生，不再直接改原 `2025`。
- 修正：收掉会影响模板改名的硬编码路径，`tpl_tag.php` 不再写死 `/static/2025/css/2025.css`；`css/2025.css` 的字体资源改成相对路径；`js/tempbookcase.js` 改为消费 footer 下发的 `SS_THEME_DIR / SS_STATIC_BASE`，不再写死 `/static/2025/nocover.jpg`。
- 修正：`tpl_header.php` 统一阅读记录入口兜底变量；`tpl_top.php` 优先消费 `rank_entry_url / rank_detail_base`；`tpl_error.php` / `tpl_top.php` 的头部引入位置改回 `body` 内，避免把头部 HTML 输出到 `head` 区。
- 说明：当前首轮只处理“改名后会直接出问题”的硬编码与公共入口口径，不主动改已经正常显示的手机端主结构；会员链路与更多页面标准化留待后续轮次继续收口。

## 2026-03-09-07 | 文档 | Shipsay v14 标准文档最终收束（只动 docs）
- 修正：`VARIABLE_MAP.md` 将排行聚合页输入正式收口为 `top_sections / top_rank_lists / top_rank_limit`，不再把 `allvisit{sortid}` / `monthvisit{sortid}` / `weekvisit{sortid}` 继续写成母模板常用标准输入。
- 修正：`VARIABLE_MAP.md` 删除 2026-03-07 历史扫描补充大段，避免把阶段性备忘误当成现行标准；历史过程说明统一留在 `CHANGELOG.md`。
- 补充：`V5_1_TEMPLATE_STANDARD.md` 明确排行页属于高风险页面，要求 `tpl_top.php / tpl_rank.php` 默认先尊重当前正常 DOM 与现有 CSS，不因命名更规整就顺手改作者节点、图片块或列表层级。

## 2026-03-09-06 | 文档 | Shipsay v13 docs 全量收口（只动 docs）
- 范围：仅调整 `docs/*`，不动模板与核心。
- 修正：`OPS.md` 同步当前真实运行目录 `/www/wwwroot/fz1.112book.com`，并把交付流程收口为“增量包 + A/B”；去掉当前基线中不存在的 `shipsay/config.php`、`shipsay/config.local.php` 旧排除项。
- 修正：`PROJECT_STRUCTURE.md` 明确当前母模板标准路径为 `themes/shipsay/*`，阅读页链路说明不再沿用过泛的 `themes/*/tpl_reader.php` 口径。
- 修正：`V5_1_TEMPLATE_STANDARD.md` 新增“模板修改注意事项”：现有模板修复同样遵守母模板标准，只是结构尽量少动；URL 标准化、去掉多余会员系统、统一当前核心支持的变量/SEO/链接链仍属于应做项；子模板基于母模板微调生成。
- 修正：`VARIABLE_MAP.md` 基线说明切换到 `fz1.112book.com_20260309v1`，并明确当前母模板标准路径为 `themes/shipsay/tpl_*.php`。
- 结论：当前 docs 收口重点从“变量/链路定义”扩展到“模板修改方法标准”，为后续现有模板修复与母模板/子模板派生提供统一规则。

## 2026-03-09-05 | 模板 | Shipsay 排行模板回归现有 CSS（v12）
- 范围：仅调整 `themes/shipsay/tpl_top.php` 与 `tpl_rank.php`，不动核心。
- 修正：`tpl_top.php` 将作者节点恢复为与现有 CSS 匹配的旧结构，避免 `.top-card li span` 的固定宽度规则把作者压成竖排。
- 修正：`tpl_rank.php` 恢复为与当前 `style.css` 匹配的结构，不再沿用一套与现有样式类名不兼容的新结构；`/top/weekvisit/` 等单榜页继续按当前 CSS 输出。
- 结论：排行问题最终定性为“模板结构与现有 CSS 不匹配”，不是核心回退问题。

## 2026-03-09-05 | 回退 | Shipsay 排行 fallback 误改回退（v10 已撤回）
- 说明：曾尝试修改 `shipsay/include/tpl_top_default.php` 以统一排行 fallback，但该改动改变了核心 fallback 页面原有展示模型，不适合作为当前阶段的核心标准。
- 处理：相关改动已通过 `revert: rollback shipsay rank fallback v10` 正式回退；当前 `tpl_top_default.php` 继续保持 `fz1.112book.com_20260309v1` 基线原样。
- 结论：从此处开始再次确认：核心默认冻结，后续模板必须适配核心，不再反过来改核心去贴模板标准。

## 2026-03-09-05 | 文档 | Shipsay 最终验收式 docs 收尾（只动 docs）
- 范围：仅调整 `docs/*`，不动 `themes/shipsay/*` 与核心目录。
- 修正：`VARIABLE_MAP.md` 将 `tpl_header.php` 头部变量表改为当前真实运行口径：统一记录 `*_raw / *_attr / *_html`，不再把旧的 `*_safe` 头部链接变量写成现行标准。
- 修正：`VARIABLE_MAP.md` / `V5_1_TEMPLATE_STANDARD.md` 同步把分类页口径改成“真实跳转入口已收口，`store_menu()` 等局部功能交互保留为前端交互例外”，不再继续把它归类成旧导航待整改项。
- 修正：历史记录中 `tpl_rank.php` 的排行入口说明同步到当前最终口径：模板正式只消费 `rank_entry_url / rank_detail_base / fake_top`，旧 `fake_rankstr` 仅保留给路由兼容。
- 复扫：`root/docs` 全量复核完成；`CHANGELOG.md / V5_1_TEMPLATE_STANDARD.md / VARIABLE_MAP.md / OPS.md / PROJECT_STRUCTURE.md` 当前未发现新的阻塞性口径冲突。
- 结论：当前 docs 与模板、核心现状已基本一致，可作为 Shipsay 阶段性收口版文档基线继续使用。


## 2026-03-09-04 | 模板 | Shipsay 全模板复扫收尾（只动 themes/shipsay + docs）
- 范围：仅调整 `themes/shipsay/*` 与 `docs/*`，不动 `app / class / include / configs`。
- 修正：`tpl_recentread.php` 将页面标题与描述变量前置定义，避免 `<title>` / `<meta description>` 在变量尚未赋值时提前输出空值。
- 修正：`tpl_header.php` 中搜索表单与公共入口在链接缺失时改为禁用展示，不再输出空 `action` 或空 `href`；继续保持“不写死旧路径、模板不反向造业务链接”。
- 修正：`tpl_error.php` 搜索表单同步采用同一口径：搜索入口缺失时禁用提交，不再让错误页表单默默回投当前地址。
- 文档：`V5_1_TEMPLATE_STANDARD.md` 与 `VARIABLE_MAP.md` 同步改成“当前链接标准以 `*_raw / *_attr / *_html` 为准”，保留 `*_safe` 仅作旧链路对照，不再作为新标准继续扩散。
- 结论：当前 Shipsay 模板层继续按“核心给真实链接 → 模板局部整理 raw/attr/html → 缺失时禁用展示”执行，减少空链接与职责边界混乱。


## 2026-03-09-02 | 模板 | Shipsay 首页 / 作者页 / 分类页继续收口（只动 themes/shipsay + docs）
- 范围：仅调整 `themes/shipsay/*` 与 `docs/*`，不动 `app / class / include / configs`。
- 核对：继续针对 `tpl_home.php`、`tpl_author.php`、`tpl_category.php` 做模板层扫描，确认剩余问题仍属于命名口径、局部内联样式、展示层转义与模板职责边界，不需要先改核心。
- 处理：
  - `tpl_home.php` 将首页主链接从 `*_safe` 混名继续收口为 `home_url_raw / home_url_attr`，并统一首页 SEO/OG/canonical 输出口径。
  - `tpl_home.php` 保留友情链接 `link_html` 直出，但在文档中明确其来源于后台友情链接配置缓存，属于模板可接受的受控 HTML 例外。
  - `tpl_author.php` 去掉 `style="width:100%;"`，改为复用 `side_commend side_commend_width`；补页面包屑；封面默认图与最后更新时间统一做安全输出。
  - `tpl_category.php` 将分类页主链接与分类名变量继续收口为 `*_raw / *_attr / *_html`，并补齐列表更新时间的安全输出。
- 结论：当前 `tpl_home.php / tpl_author.php / tpl_category.php` 可以继续维持“模板只消费上游变量、仅负责展示层安全输出”的方向；分类页剩余 `store_menu()` 这类局部功能型交互保留，不视为旧导航链路问题。


## 2026-03-09-01 | 模板 | Shipsay 链接链与 safe 口径收口（只动 themes/shipsay + docs）
- 范围：仅调整 `themes/shipsay/*` 与 `docs/*`，不动 `app / class / include / configs`。
- 目标：围绕已确认的 5 个模板问题收口：
  - 可变链接仍有硬编码兜底
  - 排行入口仍回退 `/rank/`
  - Header 对 `*_safe` 变量使用口径不一致
  - 搜索表单 `action` 未转义输出
  - 模板层兜底过多导致职责边界不清
- 处理：
  - `tpl_header.php` 改为统一 `*_raw / *_attr / *_html` 命名，不再写死 `/sort/`、`/search/`、`/history.html`、`/rank/`。
  - `tpl_top.php` 不再在模板内补默认榜单链接或 `/rank/` 入口，聚合页链接完全跟随 app 已准备好的 `rank_entry_url / rank_detail_base / top_sections`。
  - `tpl_rank.php` 去掉 `/rank/` 明文回退；当前模板正式只消费 `rank_entry_url / rank_detail_base / fake_top`，旧 `fake_rankstr` 仅保留给路由兼容。
  - `tpl_info.php` 去掉模板层 `Url::index_url($articleid)` 目录链接兜底，目录入口只消费 app 已传入的 `$index_url`。
  - `tpl_reader.php` 去掉“目录缺失时回退详情页”的写法；目录链接缺失时仅做禁用展示，不再模板层改写业务入口。
  - `tpl_category.php` 去掉旧的 `href="javascript:"` / `onclick=document.location` 全本筛选跳转。
  - `tpl_author.php` 同步收口 canonical / og / breadcrumb 的 raw/attr 口径，避免把已转义 attr 值反向当原始 URL 使用。
- 结论：当前 Shipsay 模板继续按“模板适配核心”执行；核心链路已存在时，模板只负责消费和安全输出，不再自造业务 URL。

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

## 2026-03-09 | 标准 | Shipsay 核心页模板红线收口（第六轮 / info-indexlist-reader）
- 范围：仅调整 `themes/shipsay/tpl_info.php`、`tpl_indexlist.php`、`tpl_reader.php` 与 `root/docs`，继续遵守“模板适配核心、不动 app/class/include/configs”。
- 收口：详情页 `tpl_info.php` 的目录按钮不再输出空 `href`；当上游未提供 `$index_url` 时，模板只做禁用展示，不再靠空链接冒充真实目录入口。
- 收口：目录页 `tpl_indexlist.php` 统一补齐 `site_home_url_raw / site_home_url_attr`、`sort_url_raw / sort_url_attr`、`info_url_raw / info_url_attr`，BreadcrumbList 与面包屑统一消费当前页真实 raw/attr 链路。
- 收口：阅读页 `tpl_reader.php` 统一补齐 `site_home_url_raw / site_home_url_attr`、`sort_url_raw / sort_url_attr`、`info_url_raw / info_url_attr`；`og:novel:index_url` 改为只在目录链接存在时输出，并改用目录入口 `index_url_attr`，不再误填详情页链接。
- 收口：阅读页 `Text::ss_lastupdate()` 的结果先转义再输出；本地阅读记录写入继续使用 `info_url_raw / reader_url_raw`，不再混用原始变量与局部变量。
- 结论：当前三大核心页继续维持“模板只消费核心已提供链接，缺失时允许禁用展示，不允许模板层改写业务语义”。


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


## 2026-03-09 | redline v4 | 辅助页模板与文档继续收口
- 范围继续锁定在 `themes/shipsay/*` 与 `docs/*`，未改动 `app / class / include / configs`。
- `tpl_search.php`：搜索结果主容器改回现有样式体系内的 `side_commend_width` 类，不再保留 `style="width:100%;"` 这类模板内联宽度；同时补上搜索结果页面包屑，并把结果字段读取改成更稳的局部空值兼容写法。
- `tpl_recentread.php`：统一复用 `site_home_url_raw / site_home_url_attr` 口径，不再单独保留 `home_url_safe` 旧命名；阅读记录页标题与描述改成本地明确变量后再输出。
- `tpl_footer.php`：统一改为 `site_home_url_raw / site_home_url_attr` 与 `footer_sitemap_*_raw / _attr` 命名，避免把原始 URL 继续写成 `*_safe`；站点地图链接当前仍属于模板本地固定资源路径，由站点首页链接推导，不上升为核心业务入口变量。
- docs：同步修正文档中 footer / recentread / search 的变量命名与职责边界说明。


## 2026-03-09 | redline v8 | 文档变量修正与排行/SEO/分类约束收尾
- 范围继续锁定在 `themes/shipsay/*` 与 `docs/*`，未改动 `app / class / include / configs`。
- `tpl_top.php`：改为通过模板局部 `page_title=排行榜` 接入 `ss_seo_render('rank')`，闭合当前 `shipsay/configs/seo_tpl.php` 主链路，不再继续走缺失的 `seo_top_*` 分支。
- `tpl_header.php` / `tpl_top.php` / `tpl_rank.php`：统一去掉以 `fake_rankstr` 作为母模板默认排行入口的回退；当前模板正式只消费 `rank_entry_url / rank_detail_base / fake_top`，旧 `fake_rankstr` 仅保留给路由兼容。
- `tpl_rank.php`：单榜页切换链接统一使用 `rank_detail_base`，避免当 `fake_top` 入口与详情根路径不完全一致时模板自行拼错榜单链接。
- docs：修正 `VARIABLE_MAP` 中阅读页混入作者页变量、未落地变量名、`tpl_rank_list.php` 残留引用等问题；同步补充“排行 SEO 主链路当前闭环规则”与“分类分页 10 页上限属于核心约束”两项正式说明。
