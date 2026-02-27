<?php

$langtailrows = array();
$langtail_show_num = 10;
$langsql = 'SELECT langid,langname,uptime FROM shipsay_article_langtail WHERE sourceid=' . intval($sourceid) . ' ORDER BY uptime DESC LIMIT ' . $langtail_show_num;

$need_update = false;
$cache_hit = false;

if (isset($redis)) {
    $cached = $redis->ss_get($langsql);
    if (is_array($cached)) {
        $langtailrows = $cached;
        $cache_hit = true;
    }
}

if (empty($langtailrows) && !$cache_hit) {
    $langres = $db->ss_query($langsql);
    if ($langres && $langres->num_rows) {
        $k = 0;
        while ($row = mysqli_fetch_assoc($langres)) {
            $langtailrows[$k]['langname'] = $row['langname'];
            $langtailrows[$k]['uptime'] = $row['uptime'];
            $langid = $row['langid'];
            if ($is_multiple) {
                $langid = ss_newid($langid);
            }
            $langtailrows[$k]['info_url'] = Url::info_url($langid, true);
            $langtailrows[$k]['index_url'] = Url::index_url($langid, 1, true);
            $k++;
        }
    }
}

// 是否需要刷新（没有数据或最新一条超过周期）
if (!empty($langtailrows)) {
    $need_update = (time() - intval($langtailrows[0]['uptime']) >= intval($langtail_catch_cycle) * 24 * 3600);
} else {
    $need_update = true;
}

if (!function_exists('ss_langtail_enqueue')) {
    function ss_langtail_enqueue($sourceid, $sourcename)
    {
        global $db, $redis;
        $sourceid = intval($sourceid);
        if ($sourceid <= 0) return;

        $now = time();
        $next_try = $now + rand(5, 600);

        // redis 轻锁：防止同一本书被并发疯狂 enqueue
        if (isset($redis)) {
            // 用 SsRedis 的 hash 规则（站点隔离 / dbpool 共享），避免外部手写 md5 导致维度不一致
            if (method_exists($redis, 'ss_setnxex')) {
                if (!$redis->ss_setnxex('langtail_task_' . $sourceid, 1, 30)) return;
            } else {
                // 兼容：极老版本 SsRedis
                $lockKey = md5('langtail_task_' . $sourceid);
                if (!$redis->setnx($lockKey, 1)) return;
                $redis->expire($lockKey, 30);
            }
        }

        $sourcename = addslashes($sourcename);

        // status: 0=待跑 1=成功 2=处理中 9=失败
        // attempts/last_try/next_try 由 cron 控制
        $sql = "INSERT INTO shipsay_article_langtail_task (sourceid,sourcename,status,attempts,last_try,next_try,created_at,updated_at)
                VALUES ({$sourceid},'{$sourcename}',0,0,0,{$next_try},{$now},{$now})
                ON DUPLICATE KEY UPDATE
                    sourcename='{$sourcename}',
                    status=IF(status IN (1,2), status, 0),
                    updated_at={$now},
                    next_try=IF(next_try=0 OR next_try>{$next_try},{$next_try},next_try)";
        $db->ss_query($sql);
    }
}

if ($need_update) {
    ss_langtail_enqueue($sourceid, $sourcename);
}

// 写缓存：没命中才写，避免一直刷新 TTL
if (isset($redis)) {
    if (!$cache_hit) {
        if (empty($langtailrows)) {
            $redis->ss_setex($langsql, 300, $langtailrows);
        } elseif ($need_update) {
            $redis->ss_setex($langsql, 600, $langtailrows);
        } else {
            $redis->ss_setex($langsql, $langtail_cache_time, $langtailrows);
        }
    } else {
        // 命中缓存但 TTL 异常时矫正
        $ttl = method_exists($redis, 'ss_ttl') ? $redis->ss_ttl($langsql) : $redis->ttl(md5($langsql));
        if (empty($langtailrows)) {
            if ($ttl < 0 || $ttl > 300) {
                $redis->ss_setex($langsql, 300, $langtailrows);
            }
        } elseif ($need_update) {
            if ($ttl < 0 || $ttl > 600) {
                $redis->ss_setex($langsql, 600, $langtailrows);
            }
        }
    }
}

?>
