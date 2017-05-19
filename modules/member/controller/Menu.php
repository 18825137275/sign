<?php
/**
 *
 * @author    李梓钿
 * 会员中心菜单管理,权限管理需要使用
 */
namespace osc\member\controller;
use osc\common\controller\AdminBase;
use think\Db;

class Menu extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','会员');
		$this->assign('breadcrumb2','会员菜单管理');
	}
	
    public function index(){
    	
		$cate=Db::name('MemberMenu')->field('id,pid,title AS name')->order('sort_order ASC')->select();
		
		$list =list_to_tree($cate);
		
		$this->assign('list',json_encode($list));
		
		return $this->fetch();   
    }
	
	public function add(){
		
		if($this->request->isPost()){
			
			$data=input('post.');		
			$data['pid']=$data['id'];
			unset($data['id']);			
			
			$result = $this->validate($data,'MemberMenu');
			
			if($result!==true){
				return ['error'=>$result];
			}
			$id=Db::name('MemberMenu')->insert($data,false,true);
			if($id){
				
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'添加了后台菜单，'.$data['title']);	
											
				return ['status'=>'success','id'=>$id,'name'=>$data['title']];
			}else{
				return ['error'=>'新增失败'];
			}
			
		}
	}
	
	function edit(){
		
		if($this->request->isPost()){
			
			$data=input('post.');	
			
			$result = $this->validate($data,'MemberMenu');
			
			if($result!==true){
				return ['error'=>$result];
			}
			
			$r=Db::name('MemberMenu')->update($data);
			
			if($r){
				
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改了后台菜单，'.$data['title']);
				
				return ['success'=>'修改成功','name'=>$data['title']];				
			
			}else{
								
				return ['error'=>'修改失败'];
			}
		}
	}
	function del(){
		
		if($this->request->isPost()){
			$id=input('post.id');
			
			if(Db::name('MemberMenu')->where('pid',$id)->find()){				
				return ['error'=>'请先删除子节点！！'];
			}

			if(Db::name('MemberMenu')->where('id',$id)->delete()){
				
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'删除了后台菜单，id='.$id);
								
				return ['success'=>'删除成功'];
			}
		}		
	}
	function get_info(){
		
		if($this->request->isPost()){
			$id=input('id');
			$d=Db::name('MemberMenu')->find($id);
			
			return ['title'=>$d['title'],'url'=>$d['url'],'type'=>$d['type'],'icon'=>$d['icon'],'module'=>$d['module'],'sort_order'=>$d['sort_order']] ;
		}
	}
	
	
}
