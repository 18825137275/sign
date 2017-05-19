<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\admin\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Config extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','系统');
		$this->assign('breadcrumb2','配置管理');
	}
	
     public function index(){
     	
		$filter=input('param.');
		
		$filter=safe_filter($filter);	
		
		$map=[];
		
		$query=[];
		
		$map['id']=['GT','0'];
		
		if(isset($filter['name'])){		
			$map['name']=['like',"%".$filter['name']."%"];
			$query['name']=urlencode($filter['name']);	
		}
		if(isset($filter['module'])){	
			$map['module']=['eq',$filter['module']];
			$query['module']=urlencode($filter['module']);
		}		
		
		$list = Db::name('Config')->where($map)
		->paginate(config('page_num'),false,['query'=>$query]);
		
		$this->assign('list',$list);
		
		
		$data= new \oscshop\CacheData(); 
		
		$this->assign('module',$data->get_config_module());
		
		$this->assign('empty','<tr><td colspan="20">没有数据~</td></tr>');
    	return $this->fetch();
	 }
	
	function add(){
		
		if($this->request->isPost()){
			
			return $this->single_table_insert('Config','添加系统配置');
		}
		$data= new \oscshop\CacheData(); 
		
		$this->assign('module',$data->get_config_module());
		
		$this->assign('crumbs','新增');
		$this->assign('action',url('Config/add'));
		
		return $this->fetch('edit');

	}

	function edit(){
		
		if($this->request->isPost()){
			return $this->single_table_update('Config','修改了系统配置');
		}
		
		$this->assign('crumbs','编辑');
		$this->assign('action',url('Config/edit'));
		$this->assign('c',Db::name('Config')->where('id',input('id'))->find());
		
		return $this->fetch();	
	}
	public function del(){
		$r=Db::name('Config')->delete(input('id'));
		if($r){
			$this->redirect('Config/index');
		}
	}

	 
}
?>