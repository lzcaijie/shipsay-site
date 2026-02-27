<?php
class SsRedis extends Redis
{
	private $ss_db = 0;

	public function __construct($redisarr)
	{
		try
		{
			$this->connect($redisarr['host'],$redisarr['port']);
		}
		catch(\Throwable $th)
		{
			die('连接服务器Redis出错: '.$th);
		}
		$this->auth($redisarr['pass']);
		$this->ss_db = empty($redisarr['db']) ? 0 : intval($redisarr['db']);
		$this->select($this->ss_db);
	}

	private function ss_hash_key($key)
	{
		// 默认：按站点隔离（旧逻辑：md5($site_url.$key)）
		// 可选：按“数据库池”隔离（同库多站共享缓存，避免重复预热）
		// 说明：dbpool 模式下，优先使用 redisdb 作为 pool（你现在的用法：1-7 固定编号）；
		//      若想同一个 redisdb 里再细分，可设置 $redis_pool 作为覆盖。
		global $site_url,$redis_scope,$redis_pool,$dbarr;
		if(isset($redis_scope) && $redis_scope==='dbpool')
		{
			if(isset($redis_pool) && $redis_pool!=='')
			{
				$pool=(string)$redis_pool;
			}
			else
			{
				$pool='rdb:'.$this->ss_db;
				// 如果你仍在用 redisdb=0，又希望不同源库不要共享，可自动退化到 dbarr 维度
				if($this->ss_db===0)
				{
					$h=isset($dbarr['host'])?(string)$dbarr['host']:'';
					$p=isset($dbarr['port'])?(string)$dbarr['port']:'';
					$n=isset($dbarr['name'])?(string)$dbarr['name']:'';
					if(($h.$p.$n)!=='') $pool='db:'.$h.'|'.$p.'|'.$n;
				}
			}
			return md5($pool.'|'.$key);
		}
		return md5($site_url.$key);
	}

	// 供业务侧使用：拿到“最终 redis key”（避免外部手写 md5 导致维度不一致）
	public function ss_key($key)
	{
		return $this->ss_hash_key($key);
	}
	public function ss_ttl($key)
	{
		return $this->ttl($this->ss_hash_key($key));
	}
	public function ss_setnxex($key,$value,$ttl=0)
	{
		$k=$this->ss_hash_key($key);
		$ok=$this->setnx($k,$value);
		if($ok)
		{
			$ttl=intval($ttl);
			if($ttl>0)$this->expire($k,$ttl);
		}
		return $ok;
	}

	public function ss_get($key)
	{
		return json_decode($this->get($this->ss_hash_key($key)),true);
	}
	public function ss_setex($key,$cache_time,$value)
	{
		return $this->setex($this->ss_hash_key($key),$cache_time,json_encode($value,JSON_UNESCAPED_UNICODE));
	}
	private function ss_ctx_key($key)
	{
		// NOTE: ss_getrows 输出会受站点配置影响（use_orderid/is_multiple/is_acode/fake_* 等）。
		// 以前用原始 $sql 作为缓存 key，会导致“切换配置后仍命中旧缓存”，表现为链接/ID 未变化。
		global $use_orderid,$is_multiple,$is_acode,$is_ft;
		global $fake_info_url,$fake_indexlist,$fake_chapter_url,$fake_sort_url,$fake_top,$fake_recentread;
		$ckey=$key.'|v=2';
		$ckey.='|uo='.(int)$use_orderid.'|mul='.(int)$is_multiple.'|ac='.(int)$is_acode.'|ft='.(int)$is_ft;
		if(isset($fake_info_url))$ckey.='|fi='.md5((string)$fake_info_url);
		if(isset($fake_indexlist))$ckey.='|ix='.md5((string)$fake_indexlist);
		if(isset($fake_chapter_url))$ckey.='|ch='.md5((string)$fake_chapter_url);
		if(isset($fake_sort_url))$ckey.='|so='.md5((string)$fake_sort_url);
		if(isset($fake_top))$ckey.='|tp='.md5((string)$fake_top);
		if(isset($fake_recentread))$ckey.='|rr='.md5((string)$fake_recentread);
		return $ckey;
	}
	public function ss_redis_getrows($sql,$cache_time,$shuffle=false)
	{
		$ckey=$this->ss_ctx_key($sql);
		$hit=$this->ss_get($ckey);
		// ss_get: key 不存在时 json_decode(false) => null
		if($hit!==null)
		{
			return $hit;
		}
		else
		{
			global $dbarr;
			$db=new Db($dbarr);
			$ret=$db->ss_getrows($sql);
			if($shuffle&&is_array($ret))shuffle($ret);
			$this->ss_setex($ckey,$cache_time,$ret);
			return $ret;
		}
	}
	public function ss_flushDb()
	{
		global $use_redis;
		if($use_redis)
		{
			if($this->flushDb())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		return false;
	}
}
?>