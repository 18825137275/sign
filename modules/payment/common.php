<?php
use think\Db;
/**
 * 读取支付配置
 * @param string $module module
 * @return array 
 */
function payment_config($code){
	$list=Db::name('payment')->where('payment_code',$code)->select();
	$config=[];
	foreach ($list as $k => $v) {
		$config[$v['name']]=$v['value'];
	}
	return $config;
}

?>