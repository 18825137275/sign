<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\controller;
use osc\common\controller\ItemBase;
use think\Db;
class FrontItem extends ItemBase{
	
    public function index()
    {
    	$data=input('param.');	
		
		$service=new \osc\item\service\Service();
		
		$this->assign('info',$service->get_item_info($data['id']));		
		  
		return $this->fetch();   
    }

	
}
