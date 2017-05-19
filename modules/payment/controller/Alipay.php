<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\payment\controller;
use osc\common\controller\Base;
use think\Db;
class Alipay extends Base{
	//下单处理
	public function process($item){
		
		$pay= new \osc\payment\service\Service();
		
		$order=$pay->add_order($item,'alipay');
					
		$url=$pay->alipay_url($item,$order);
		
		session('item',null);
		
		return ['type'=>'alipay','pay_url'=>$url];
	}
	
	public function re_pay($order_id){
		
		$pay= new \osc\payment\service\Service();
		
		$order=Db::name('member_apply')->where('ma_id',$order_id)->find();
					
		if($order['payment_code']!='alipay'){
			Db::name('member_apply')->where('ma_id',$order['ma_id'])->update(array('payment_code'=>'alipay'));	
		}
							
		$url=$pay->alipay_url(['title'=>$order['item_title'],'price'=>$order['money']],['id'=>$order['ma_id'],'order_num'=>$order['order_num']]);
							
		return ['type'=>'alipay','pay_url'=>$url];
	}
	
	//异步通知
	public function alipay_notify(){
	
		
		$alipay= new \payment\alipay\Alipay(payment_config('alipay'));	
		
		$verify_result = $alipay->verifyNotify();
		
		if($verify_result) {		
			
			$post=input('post.');
			
			$order=Db::name('member_apply')->where('order_num',$post['out_trade_no'])->find();
			
			if($post['trade_status'] == 'TRADE_FINISHED') {				
				
		    }
		    elseif($post['trade_status'] == 'TRADE_SUCCESS') {		
				
				if($order&&($order['pay_status']==0)){
					
					$pay=new \osc\payment\service\Service();
					
					$pay->update_order_status($order['ma_id'],$order['item_id']);
					
					echo "success";		
									
				}else{
					echo "fail";
				}		        
				
		    }			
			
		}else{
			
			
			echo "fail";
		}
	}
	//同步通知
	public function alipay_return(){
		
		$alipay= new \payment\alipay\Alipay(payment_config('alipay'));		
		//对进入的参数进行远程数据判断
		$verify = $alipay->return_verify();
	
		if($verify){
		
			$get=input('param.');
			
			$order=Db::name('member_apply')->where('order_num',$get['out_trade_no'])->find();
			
			if($order['pay_status']==1){
				@header("Location: ".url('/pay_success'));	
				die;
			}
			
			if($order&&($order['pay_status']==0)){
				//支付完成
				if($get['trade_status']=='TRADE_SUCCESS'){					
					
					$pay=new \osc\payment\service\Service();
					
					$pay->update_order_status($order['ma_id'],$order['item_id']);
					
					@header("Location: ".url('/pay_success'));	
				}						
			}else{
				die('订单不存在');
			}
			
		}else{
			die('支付失败');
		}	
	}
	public function pay_success(){
		
		return $this->fetch('public:pay_success'); 
	}
}
