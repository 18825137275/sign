<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\common\controller;
use think\Db;
class ItemBase extends Base{
			
	protected function _initialize() {
		parent::_initialize();	       
		
		$this->assign('root',$this->request->domain());
	}
	

	
}
