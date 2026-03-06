<?php

$rank_meta=ss_get_fake_top_meta(isset($fake_top)?$fake_top:'',isset($fake_rankstr)?$fake_rankstr:'rank');
$legacy_base='/'.$rank_meta['rank_prefix'];
$new_base=rtrim($rank_meta['detail_root'],'/');
$query=isset($matches[1])?trim((string)$matches[1]):'';

if($new_base!==$legacy_base)
{
	$target=$query!==''?$rank_meta['detail_base'].strtolower($query).'/':$rank_meta['entry_url'];
	header('Location: '.$target,true,302);
	exit;
}

require_once __ROOT_DIR__.'/shipsay/app/top.php';
?>
