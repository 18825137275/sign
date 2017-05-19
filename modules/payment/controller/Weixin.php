<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\payment\controller;
use osc\common\controller\Base;

use payment\weixin\WxPayApi;
use payment\weixin\WxPayConfig;
use payment\weixin\WxPayUnifiedOrder;
use payment\weixin\WxPayNotifyCallBack;
use think\Db;

class Weixin extends Base{
	
	public function process($item){
		return ['type'=>'wx_pay','pay_url'=>url('/wxpay')];
	}
	public function re_pay($order_id){
		return ['type'=>'wx_pay','pay_url'=>url('payment/weixin/re_pay_code',array('ma_id'=>$order_id))];
	}
	function code(){
		
		$pay= new \osc\payment\service\Service(); 
		
		$r=$pay->insert_weixin_order(session('item'));
		
		if($r['id']){
			$order=session('item');
		
			$config=payment_config('weixin');
	
			$cfg = array(
			    'APPID'     => $config['appid'],
			    'MCHID'     => $config['weixin_partner'],
			    'KEY'       => $config['partnerkey'],
			    'APPSECRET' => $config['appsecret'],
			    'NOTIFY_URL' =>request()->domain().url('payment/weixin/weixin_notify')
		    );
		    WxPayConfig::setConfig($cfg);     
	        //②、统一下单
	        $input = new WxPayUnifiedOrder();           
	  
	        $input->SetBody('活动费用');
	        $input->SetAttach('附加数据');
	        $input->SetOut_trade_no($r['order_num']);
			
	        $input->SetTotal_fee((float)$order['price']*100);
			
	        $input->SetTime_start(date("YmdHis"));
	        $input->SetTime_expire(date("YmdHis", time() + 600));
			$input->SetTrade_type('NATIVE');
	
			$input->SetProduct_id(time());
			
			$wxapi=new WxPayApi();
			
		    $url= $wxapi->unifiedOrder($input);	
			
			session('item',null);
			
			$this->assign('url',$url['code_url']);
			
			$this->assign('trade_no',$r['order_num']);
			return $this->fetch('code'); 
		}
		
		
	}
	//会员中心去支付
	public function re_pay_code(){
		
		$ma_id=(int)input('ma_id');
		
		$order=Db::name('member_apply')->where('ma_id',$ma_id)->find();
		
		if($order['ma_id']){
		
			$config=payment_config('weixin');
	
			$cfg = array(
			    'APPID'     => $config['appid'],
			    'MCHID'     => $config['weixin_partner'],
			    'KEY'       => $config['partnerkey'],
			    'APPSECRET' => $config['appsecret'],
			    'NOTIFY_URL' =>request()->domain().url('payment/weixin/weixin_notify')
		    );
			//重新生成trade_no
			$trade_no=build_order_no();
			
			Db::name('member_apply')->where('ma_id',$order['ma_id'])->update(array('order_num'=>$trade_no,'payment_code'=>'weixin'));	
			
		    WxPayConfig::setConfig($cfg);     
	        //②、统一下单
	        $input = new WxPayUnifiedOrder();           
	  
	        $input->SetBody('活动费用');
	        $input->SetAttach('附加数据');
	        $input->SetOut_trade_no($trade_no);
			
	        $input->SetTotal_fee((float)$order['money']*100);
			
	        $input->SetTime_start(date("YmdHis"));
	        $input->SetTime_expire(date("YmdHis", time() + 600));
			$input->SetTrade_type('NATIVE');
	
			$input->SetProduct_id(time());
			
			$wxapi=new WxPayApi();
			
		    $url= $wxapi->unifiedOrder($input);				
			
			$this->assign('url',$url['code_url']);
			
			$this->assign('trade_no',$trade_no);
			
			$this->assign('ma_id',$ma_id);
			
			return $this->fetch('recode'); 
		}
	}
	
	public function get_order_status(){
		
		$data=input('post.');
		
		$order=Db::name('member_apply')->where('order_num',$data['out_trade_no'])->find();	
		
		if($order['pay_status']==1){
			die('pay_suc');
		}else{
			die('no_pay');
		}
	}
	//异步通知
	public function weixin_notify(){	
				

		$config=payment_config('weixin');
		
		$notify_url=request()->domain().url('payment/weixin/weixin_notify');
		
		$cfg = array(
			'APPID'     => $config['appid'],
			'MCHID'     => $config['weixin_partner'],
			'KEY'       => $config['partnerkey'],
			'APPSECRET' => $config['appsecret'],
			'NOTIFY_URL' => $notify_url,
		);
		WxPayConfig::setConfig($cfg); 	
		
		$call_back=new WxPayNotifyCallBack();
		
		$call_back->Handle(false);
		
	}
}
