<?php
/**
 * @author    李梓钿
 *
 * 公共缓存数据获取类
 */
namespace oscshop;
use think\Db;

class CacheData{	

	//取得系统配置分组列表
	public function get_config_module(){
	 	
		if (!$config_module = cache('config_module')) {
		
			$list=Db::name('config')->field('module,module_name')->group('module')->select();
			
			cache('config_module', $list);	
			
			$config_module=$list;
		}
		return $config_module;		
	}	

	
}