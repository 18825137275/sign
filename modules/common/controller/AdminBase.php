<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\common\controller;
use think\Db;
class AdminBase extends Base{	
	
	protected $user;
	
	protected function _initialize() {
		parent::_initialize();
		
		$this->user=new \osc\admin\service\User();

		define('UID',$this->user->is_login());

        if(!UID){  
			$this->redirect('admin/Login/login');
        }		
		
       
		$this->get_menu();
		
        //权限判断  
			
        if(session('user_auth.username')!=config('administrator')){//超级管理员不需要验证        
	        
			$auth = new \auth\Auth();
			
			$url=$this->request->module().'/'.$this->request->controller().'/'.$this->request->action();
			
			if (!$auth->check($url,UID)) {
				$this->error('没有权限！');
			}
		}
	
	
	}
	
	public function get_menu(){
		
		if(session('user_auth.username')!=config('administrator')){
			$this->assign('admin_menu',$this->get_auth_menu());
		}else{			
			$this->assign('admin_menu',$this->get_admin_menu());
		}		
		
		$this->assign('root',$this->request->domain());
	}
	
	public function get_admin_menu(){		
		
		$menu=Db::name('menu')->where('type','eq','nav')->order('sort_order ASC')->select();
		
		$parent_menu=list_to_tree($menu,'id','pid','children',0);
		
		return $parent_menu;
	}
	
	public function get_auth_menu(){		
		
		$map['Menu.type']=['eq','nav'];
		$map['AuthRule.group_id']=['eq',session('user_auth.group_id')];
		
		$menu = Db::view('AuthRule','menu_id')
		->view('Menu','*','AuthRule.menu_id=Menu.id')		
		->where($map)	
		->order('Menu.sort_order asc')
		->select();	

		$parent_menu=list_to_tree($menu,'id','pid','children',0);
		
		return $parent_menu;
	}
	
	//用于单表插入操作
	public function single_table_insert($table_name,$user_action){
				
			$data=input('post.');	
				
			$data=safe_filter($data);	
			
			$result = $this->validate($data,$table_name);			
			if($result!==true){
				return ['error'=>$result];
			}			
			$id=Db::name($table_name)->insert($data,false,true);			
			if($id){								
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),$user_action);						
				return ['success'=>'新增成功','action'=>'add'];				
			}else{			
				return ['error'=>'新增失败'];
			}
		
	}
	//用于单表更新操作
	public function single_table_update($table_name,$user_action){
				
			$data=input('post.');		
			
			$data=safe_filter($data);	
				
			$result = $this->validate($data,$table_name);			
			if($result!==true){
				return ['error'=>$result];
			}			
			$r=Db::name($table_name)->update($data,false,true);			
			if($r){				
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),$user_action);							
				return ['success'=>'更新成功','action'=>'edit'];
			}else{			
				return ['error'=>'更新失败'];
			}
		
	}
	//用于单表删除操作
	public function single_table_delete($table_name,$user_action){
		
		$r=Db::name($table_name)->delete(input('id'));	
		
		if($r){				
			storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),$user_action);							
			return ['success'=>'删除成功','action'=>'delete'];
		}
		
	}
	
}
