<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\payment\service;
use think\Db;
//支付模块数据获取
class Service{
	
	//取得所有支付分组列表
	public function get_payment_code_list(){
	 	
		$payment_code=Db::query('select DISTINCT payment_code as code, payment_name as name,status from '.config('database.prefix')."payment");
		
		return $payment_code;		
	}
	//取得激活的支付分组列表
	public function get_available_payment_list(){
	 	
		$payment_code=Db::query('select DISTINCT payment_code as code, payment_name as name,status from '.config('database.prefix')."payment where status=1");
		
		return $payment_code;		
	}
	
	
	//写人订单
	public function add_order($item,$code){
		
		$apply['item_id']=$item['id'];
		$apply['item_title']=$item['title'];
		$apply['member_id']=session('member_user_auth.uid');		
		$apply['name']=$item['name'];
		$apply['tel']=$item['tel'];		
		$apply['cid']=$item['cid'];
		$apply['uid']=$item['uid'];		
		$apply['payment_code']=$code;	
		$apply['money']=$item['price'];		
		$apply['order_num']=build_order_no();		
		$apply['create_time']=time();		
		$apply['is_pay']=1;
		
		return [
			'id'=>Db::name('member_apply')->insert($apply,false,true),
			'order_num'=>$apply['order_num']
		];
	}
	
	public function alipay_url($item,$order){		
		
		if($order['id']){
			
			$payment['notify_url']=request()->domain().url('payment/alipay/alipay_notify');					
					
			$payment['return_url']=request()->domain().url('payment/alipay/alipay_return');//同步通知
			$payment['order_type']='goods_buy';
			$payment['subject']='活动费用';
			$payment['name']=$item['title'];
			$payment['pay_order_no']=$order['order_num'];
			$payment['pay_total']=$item['price'];					
			
			$alipay= new \payment\alipay\Alipay(payment_config('alipay'),$payment);
			
			$url= $alipay->get_payurl();
		
			return $url;
		}
		
		
	}
	
	public function insert_weixin_order($item){
		
		return $this->add_order($item,'weixin');
		
	}
	
	public function update_order_status($id,$item_id){
		
		$update['update_time']=time();
		$update['pay_time']=time();
		$update['pay_status']=1;
		
		Db::name('member_apply')->where('ma_id',(int)$id)->update($update);
		
		Db::name('item')->where('id',(int)$item_id)->setInc('join_num', 1);
	} 
	
}
?>