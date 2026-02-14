/*
 * ShipSay CMS 4.2 - Chapter Patch Schema (兜底补章补丁表)
 *
 * 表名：{$dbarr['pre']}article_chapter_patch（默认 shipsay_article_chapter_patch）
 *
 * 设计：
 * - 主章节优先；仅缺章/短章触发读写
 * - 不覆盖主章节表（你后续采集更新主库时会自动回归主章节）
 * - 可按 expire_at/last_hit 定期清理
 *
 * MODLOG:
 * - 2026-02-12 by jie cai: 初版
 */

CREATE TABLE IF NOT EXISTS `shipsay_article_chapter_patch` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `articleid` INT UNSIGNED NOT NULL DEFAULT 0,
  `chapterorder` INT UNSIGNED NOT NULL DEFAULT 0,
  `fp` CHAR(32) NOT NULL DEFAULT '' COMMENT 'md5(name_norm|author_norm)',
  `chaptername` VARCHAR(100) NOT NULL DEFAULT '',
  `content` MEDIUMTEXT NOT NULL,
  `content_len` INT UNSIGNED NOT NULL DEFAULT 0,
  `content_hash` CHAR(40) NOT NULL DEFAULT '' COMMENT 'sha1(content)',
  `source_site_id` INT UNSIGNED NOT NULL DEFAULT 0,
  `source_base_url` VARCHAR(255) NOT NULL DEFAULT '',
  `source_articleid` INT UNSIGNED NOT NULL DEFAULT 0,
  `fetched_at` INT UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` INT UNSIGNED NOT NULL DEFAULT 0,
  `expire_at` INT UNSIGNED NOT NULL DEFAULT 0,
  `hit_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `last_hit` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_article_chapter` (`articleid`,`chapterorder`),
  KEY `idx_fp` (`fp`),
  KEY `idx_expire` (`expire_at`),
  KEY `idx_last_hit` (`last_hit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
