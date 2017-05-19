<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\controller;
use osc\common\controller\ItemBase;
use think\Db;
class FrontCategory extends ItemBase{
	
    public function index()
    {
    	$data=input('param.');	
		
		$service=new \osc\item\service\Service();
		
		$this->assign('option_value',$service->get_option_value((int)$data['id']));
		
		$this->assign('item',$service->get_item_by_param($data,12));
		    
		return $this->fetch();   
    }

	
}
