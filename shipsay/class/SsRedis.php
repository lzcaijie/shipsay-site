<?php class SsRedis extends Redis
{
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
		$this->select(empty($redisarr['db'])?0:intval($redisarr['db']));
	}
	public function ss_get($key)
	{
		global $site_url;
		return json_decode($this->get(md5($site_url.$key)),true);
	}
	public function ss_setex($key,$cache_time,$value)
	{
		global $site_url;
		return $this->setex(md5($site_url.$key),$cache_time,json_encode($value,JSON_UNESCAPED_UNICODE));
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