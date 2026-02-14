<?php
/**
 * ShipSay CMS - site_sync stable shell (v6.1)
 * Path: /www/api/site_sync.php
 *
 * 说明：
 * - 本文件尽量保持稳定，只负责定义站点根目录并加载实现文件。
 * - 真实逻辑位于：/shipsay/include/site_sync_impl.php
 */
header('Content-Type: application/json; charset=utf-8');

function ss_shell_resp($arr){
  echo json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
  exit;
}

$root = realpath(__DIR__ . '/../..');
if (!$root) ss_shell_resp(['ok'=>0,'error'=>'bad_root']);

if (!defined('__ROOT_DIR__')) define('__ROOT_DIR__', $root);
if (!defined('SS_SITE_SYNC_SHELL_VER')) define('SS_SITE_SYNC_SHELL_VER', '6.1');

$impl = __ROOT_DIR__ . '/shipsay/include/site_sync_impl.php';
if (!is_file($impl)) ss_shell_resp(['ok'=>0,'error'=>'missing_impl']);
require $impl;
