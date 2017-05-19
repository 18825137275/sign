<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\payment\controller;
use osc\common\controller\Base;

class Payment extends Base{
	//支付方式列表
	function payment_list(){
		
		$data= new \osc\payment\service\Service(); 
		
		$this->assign('list',$data->get_available_payment_list());
		
		return $this->fetch(); 
	}
	
	function pay_api(){
		if($this->request->isPost()){
			
			$type=safe_filter(input('post.type'));
			
			$class = '\\osc\\payment\\controller\\' . ucwords($type);
			
			$payment= new $class();
			
			return $payment->process(session('item'));
			
		}
	}
	
}
