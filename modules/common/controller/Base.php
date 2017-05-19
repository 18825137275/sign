<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\common\controller;
use think\Controller;
class Base extends controller{
	
	protected function _initialize() {
				
		$module=$this->request->module();
		
		if(!is_module_install($module)){
			die('该模块未安装');
		}
		
		$cache_key=$module.'_config_data';
		
		$config =   cache($cache_key);
		
        if(!$config){        	
            $common =   module_config('common');
			$cur =      module_config($module);			
			$config=array_merge($common,$cur);			
            cache($cache_key,$config);
        }
		
        config($config); 
	}
	
}
