<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Option extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','报名');
		$this->assign('breadcrumb2','选项');
	}
	
	//可以显示系统选项和分类的组
	public function allow_group(){
		$group_id=session('user_auth.group_id');
		
		//可以显示系统选项和分类的组
		$system_option_group=[
			config('admin_group')
		];
		
		return in_array($group_id, $system_option_group);
	}
	
    public function index(){
    	
		$list = Db::name('Option')->paginate(config('page_num'));
		
			
		$this->assign('list', $list);
		
		$cache_data= new \osc\item\service\Service();
		
		$this->assign('category', $cache_data->get_item_category());
		
		$this->assign('empty', '<tr><td colspan="20">~~暂无数据</td></tr>');
			
		
		return $this->fetch();  
	 }
	
	 public	function add(){
	 	
		if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));	
			
			$model=new \osc\item\model\Option();  		
			
			$error=$model->validate($data);	
			if($error){
				return $error;
			}
					
			$return=$model->add_option($data);		
			
			if($return){								
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'新增了选项');						
				return ['success'=>'新增成功','action'=>'add'];				
			}else{			
				return ['error'=>'新增失败'];
			}
			
		}
		
		$service= new \osc\item\service\Service();
		
		$this->assign('category', $service->get_item_category());
		
		$this->assign('crumbs', '新增');
		$this->assign('action', url('Option/add'));
		return $this->fetch('edit');
		
	}
	 
	 public	function edit(){
	 	if($this->request->isPost()){
	 		$data=safe_filter(input('post.'));	
			
			$model=new \osc\item\model\Option();  		
			
			$error=$model->validate($data);	
			if($error){
				return $error;
			}
					
			$return=$model->edit_option($data);		
			
			if($return){								
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改了选项');						
				return ['success'=>'修改成功','action'=>'edit'];				
			}else{			
				return ['error'=>'修改失败'];
			}
	 	}
		$service= new \osc\item\service\Service();
		
		$this->assign('category', $service->get_item_category());
		
		$this->assign('option',Db::name('Option')->find(input('id')));
		$this->assign('option_values',Db::name('OptionValue')->where('option_id',input('id'))->select());
		$this->assign('crumbs', '编辑');
		$this->assign('action', url('Option/edit'));
		return $this->fetch('edit');
	}
	 
	public function del(){
		Db::name('option')->delete(input('id'));
		Db::name('option_value')->where('option_id',input('id'))->delete();		
		
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'删除了选项');
		
		$this->redirect('Option/index');	
	}
	

}
?>