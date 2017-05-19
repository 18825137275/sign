<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\controller;
use osc\common\controller\AdminBase;
use think\Db;
class ItemCategory extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','报名');
		$this->assign('breadcrumb2','分类');
	}
	
        public function index(){
    	
				
		$cate =Db::name('item_category')->order('sort_order')->select();
		
		$list =list_to_tree($cate);
		
		$this->assign('list',json_encode($list));
		
		return $this->fetch();   
    }
	
	public function add(){
		
		if($this->request->isPost()){
			
			$data=input('post.');		
			$data['pid']=$data['id'];
			unset($data['id']);			
			
			$result = $this->validate($data,'ItemCategory');
			
			if($result!==true){
				return ['error'=>$result];
			}
			$id=Db::name('item_category')->insert($data,false,true);
			if($id){
				
				cache('item_category',null);
				cache('item_category_info',null);
				
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'添加了分类，'.$data['name']);	
											
				return ['status'=>'success','id'=>$id,'name'=>$data['name']];
			}else{
				return ['error'=>'新增失败'];
			}
			
		}
	}
	
	function edit(){
		
		if($this->request->isPost()){
			
			$data=input('post.');	
			
			$result = $this->validate($data,'ItemCategory');
			
			if($result!==true){
				return ['error'=>$result];
			}
			
			$r=Db::name('item_category')->update($data);
			
			if($r){
				
				cache('item_category',null);
				cache('item_category_info',null);
				
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改了分类，'.$data['name']);
				
				return ['success'=>'修改成功','name'=>$data['name']];				
			
			}else{
								
				return ['error'=>'修改失败'];
			}
		}
	}
	function del(){
		
		if($this->request->isPost()){
			$id=(int)input('post.id');
			
			if(Db::name('item')->where('cid',$id)->find()){				
				return ['error'=>'该分类下存在活动，不能删除！！'];
			}
			
			if(Db::name('item_category')->where('pid',$id)->find()){				
				return ['error'=>'请先删除子节点！！'];
			}
			
			if(Db::name('item_category')->where('id',$id)->delete()){
				
				/*
					Db::name('option')->where('cid',$id)->delete();
					Db::name('option_value')->where('cid',$id)->delete();
					Db::name('item_option')->where('cid',$id)->delete();
					Db::name('item')->where('cid',$id)->delete();
					Db::name('item_data')->where('cid',$id)->delete();
				*/
				
				cache('item_category',null);
				cache('item_category_info',null);
				
				storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'删除了分类，id='.$id);
								
				return ['success'=>'删除成功'];
			}
		}		
	}
	function get_info(){
		
		if($this->request->isPost()){
			$id=input('id');
			$d=Db::name('item_category')->find($id);
			
			return ['name'=>$d['name'],'meta_keyword'=>$d['meta_keyword'],'meta_description'=>$d['meta_description'],'sort_order'=>$d['sort_order']] ;
		}
	}
	


	
}
