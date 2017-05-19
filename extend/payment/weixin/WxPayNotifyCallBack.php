<?php
namespace payment\weixin;

use payment\weixin\WxPayApi;
use payment\weixin\WxPayConfig;
use payment\weixin\WxPayException;
use payment\weixin\WxPayNotify;
use payment\weixin\WxPayOrderQuery;
use think\Db;

class WxPayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
	
		$input = new WxPayOrderQuery();
		
		$input->SetTransaction_id($transaction_id);
		
		$result = WxPayApi::orderQuery($input);		
		
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理方法，成功的时候返回true，失败返回false，处理商城订单
	public function NotifyProcess($data, &$msg)
	{
		$notfiyOutput = array();
				
		if(!array_key_exists("transaction_id", $data)){			
			$msg = "输入参数不正确";
			return false;
		}

		
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
	
			$msg = "订单查询失败";
			return false;
		}
		
		
		if($data['result_code']=='SUCCESS'){
	
			$order=Db::name('member_apply')->where('order_num',$data['out_trade_no'])->find();			
			
			if($order&&($order['pay_status']==0)){				
			
					$pay=new \osc\payment\service\Service();
					
					$pay->update_order_status($order['ma_id'],$order['item_id']);
					
					return true;	
									
			}
		}else{
			
			return false;
		}
	}
}

