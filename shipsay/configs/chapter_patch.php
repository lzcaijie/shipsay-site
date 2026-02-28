<?php
/**
 * Chapter Patch config override (可选)
 *
 * 说明：
 * - 只在需要覆盖 shipsay/include/chapter_patch.php 默认参数时才修改
 * - 建议只改变量，不改逻辑
 *
 * MODLOG:
 * - 2026-02-12 by jie cai: 初版
 */

// $chapter_patch_enable = 1;
// $chapter_patch_min_len = 100;
// $chapter_patch_expire = 7 * 86400;
// $chapter_patch_source_limit = 3;
// $chapter_patch_http_timeout = 4;
// $chapter_patch_hub_url = 'https://zongkong.112book.com/panel/api/novel_hub.php';
// $chapter_patch_cache_ttl = 86400;
// $chapter_patch_fail_cooldown_base = 300;
// $chapter_patch_fail_cooldown_max = 3600;
// $chapter_patch_fail_ttl = 2 * 86400;
// $chapter_patch_insecure_ssl = 0;
// $chapter_patch_log = __ROOT_DIR__ . '/shipsay/configs/_bak/chapter_patch.log';
// 脏补丁坏词（命中则视为无效，不写库/不复用）
$chapter_patch_bad_phrases = [
  '章节内容正在处理中，后续会添加，感谢您的支持！',
];

