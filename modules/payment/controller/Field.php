<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\payment\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Field extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','支付');
		$this->assign('breadcrumb2','字段管理');
	}
	
     public function index(){
     	
		$filter=input('param.');
		
		$map=[];
		
		$query=[];
		
		$map['id']=['GT','0'];
		
		if(isset($filter['name'])){		
			$map['name']=['like',"%".$filter['name']."%"];
			$query['name']=urlencode($filter['name']);	
		}
		if(isset($filter['code'])){	
			$map['payment_code']=['eq',$filter['code']];
			$query['code']=urlencode($filter['code']);
		}		
		
		$list = Db::name('payment')->where($map)->order('sort_order asc')
		->paginate(config('page_num'),false,['query'=>$query]);
		
		$this->assign('list',$list);
		
		
		$data= new \osc\payment\service\Service(); 
		
		$this->assign('payment_code',$data->get_payment_code_list());
		
		$this->assign('empty','<tr><td colspan="20">没有数据~</td></tr>');
    	return $this->fetch();
	 }
	
	function add(){
		
		if($this->request->isPost()){
			
			return $this->single_table_insert('Payment','添加支付字段');
		}
		$data= new \osc\payment\service\Service();
		
		$this->assign('payment_code',$data->get_payment_code_list());
		
		$this->assign('crumbs','新增');
		$this->assign('action',url('Field/add'));
		
		return $this->fetch('edit');

	}

	function edit(){
		
		if($this->request->isPost()){
			return $this->single_table_update('Payment','修改了支付字段');
		}
		
		$this->assign('crumbs','编辑');
		$this->assign('action',url('Field/edit'));
		$this->assign('c',Db::name('Payment')->where('id',input('id'))->find());
		
		return $this->fetch();	
	}
	public function del(){
		$r=Db::name('payment')->delete(input('id'));
		if($r){
			
			storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'删除支付接口字段');	
			
			$this->redirect('Field/index');
		}
	}

	 
}
?>