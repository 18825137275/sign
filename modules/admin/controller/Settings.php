<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\admin\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Settings extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','系统');
				
	}

	
	function general(){			
		$this->assign('breadcrumb2','基本配置');
		$this->assign('common',$this->get_config_by_module('common'));
		return $this->fetch();
	}
	
	function get_config_by_module($module){
		
		$list=Db::name('config')->where('module',$module)->select();
		if(isset($list)){
			foreach ($list as $k => $v) {
				$config[$v['name']]=$v;
			}
		}
		return $config;
	}
	
	function save(){
		
		if($this->request->isPost()){
			
			$config=input('post.');			
			
			if($config && is_array($config)){
				$c=DB::name('Config');    
	            foreach ($config as $name => $value) {
	                $map = array('name' => $name);
					$c->where($map)->setField('value', $value);					
	            }
				
	        }
	        clear_cache();
			
	      return ['success'=>'更新成功'];
		  
		}
	}
	
	


}
?>