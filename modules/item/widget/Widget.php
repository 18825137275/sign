<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\widget;
use think\Controller;
class Widget extends Controller{
	
    public function category()
    {
    	$service=new \osc\item\service\Service();
		
		$this->assign('top_nav',$service->get_item_category());    
		
		return $this->fetch('widget:category'); 
    }

	
}
