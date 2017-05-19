<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\payment\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Index extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','支付');
		$this->assign('breadcrumb2','支付接口');
	}
	
    public function index()
    {
    	
		$data= new \osc\payment\service\Service(); 
		
		$this->assign('list',$data->get_payment_code_list());	
			    
		return $this->fetch();   
    }
	
	public function edit()
    {
    	
		if($this->request->isPost()){	
			$payment=input('post.');			
			
			if($payment && is_array($payment)){
				$c=DB::name('payment');    
	            foreach ($payment as $name => $value) {
	                $map = array('name' => $name);
					$c->where($map)->setField('value', $value);					
	            }
				
	        }
			
			storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改了支付接口配置');	
			
			return $this->success('编辑成功！',url('Index/index'));	
		}
			
    	$list=Db::name('payment')->where('payment_code',input('param.code'))->select();
		
		$this->assign('list',$list);	
		$this->assign('crumbs',input('param.code'));		    
		return $this->fetch();   
    }
	
	public function set_status(){
		
		$data=input('param.');
		
		Db::name('payment')->where('payment_code',$data['code'])->update(['status'=>$data['status']],false,true);		
		
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改了支付接口状态');	
		
		$this->redirect('Index/index');
	}
	
	
}
