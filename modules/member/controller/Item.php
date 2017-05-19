<?php
/**
 * @author    李梓钿
 *会员中心报名项目相关
 */
namespace osc\member\controller;
use osc\common\controller\MemberBase;
use think\Db;

class Item extends MemberBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','活动报名');
		$this->assign('breadcrumb2','活动列表');
	}
	
    public function index(){	
		
		$filter=input('param.');
	
		$map=[];
		
		$query=[];
		
		$map['uid']=['EQ',UID];
		
		if(isset($filter['title'])){		
			$map['title']=['like',"%".$filter['title']."%"];
			$query['title']=urlencode($filter['title']);	
		}
		if(isset($filter['cat'])){	
			$map['cid']=['eq',$filter['cat']];
			$query['cat']=urlencode($filter['cat']);
		}		
		
		$list = Db::name('item')->where($map)->paginate(config('page_num'),false,['query'=>$query]);
		$this->assign('empty','<tr><td colspan="20">没有数据~</td></tr>');
		$this->assign('list', $list);
		
		$service=new \osc\item\service\Service();
		
		$this->assign('service',$service);  
		
		$this->assign('category',$service->get_category_tree());   //dump($service->get_category_tree());die;
		
		return $this->fetch();   
    }
	
	public function add(){				
		
		if($this->request->isPost()){
			
			$data=input('post.',null,'htmlspecialchars');			
		
			$model=new \osc\member\model\Item();  		
			 	
			$error=$model->validate($data);	
	
			if($error){			
				return $this->error($error);	
			}
		
			$return=$model->add_item($data);		
			
			if($return){
												
				storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'新增了报名项目 ');		
			
				return $this->success('新增成功！',url('Item/index'));			
			}else{
				return $this->error('新增失败！');			
			
			}
			
		}
		
		$service=new \osc\item\service\Service();
		
		$this->assign('category',$service->get_category_tree());  
		
		$this->assign('action',url('item/add'));
		$this->assign('crumbs', '新增');
		return $this->fetch('edit');   
    }
	
	public function edit(){				
		
		if($this->request->isPost()){
			
			$data=input('post.',null,'htmlspecialchars');			
		
			$model=new \osc\member\model\Item();  		
			 	
			$error=$model->validate($data);	
	
			if($error){			
				return $this->error($error);	
			}
		
			$return=$model->edit_item($data);		
			
			if($return){
												
				storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'修改了报名项目 ');		
			
				return $this->success('修改成功！',url('Item/index'));			
			}else{
				return $this->error('修改失败！');			
			
			}
			
		}		
		
		$id=(int)input('id');
		
		$service=new \osc\item\service\Service();
		
		$this->assign('category',$service->get_category_tree());  			
		
		$item=Db::name('item')->where(['uid'=>UID,'id'=>$id])->find();
		
		if(!$item){
			return $this->error('非法操作！！');
		}
		
		$map['uid']=['EQ',UID];
		$map['item_id']=['EQ',$id];	
		
		$this->assign('data',Db::name('item_data')->where($map)->find());
		
		$this->assign('item',$item);		
		
		$this->assign('item_option',DB::name('item_option')->where($map)->select());
		
		$this->assign('action',url('item/edit'));
		
		$this->assign('crumbs', '修改');
		return $this->fetch('edit');   
    }
	
	function copy_item(){
		$id =safe_filter(input('post.'));

		$model=new \osc\member\model\Item();  	
		if($id){		
			foreach ($id['id'] as $k => $v) {						
				$model->copy_item($v);
			}	
			storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'复制报名项目');
			
			$data['redirect']=url('Item/index');				
			return $data;
		}
	}
	function del(){
		
		$model=new \osc\member\model\Item();  
		
		$id=input('id');

		$r=$model->del_item((int)$id);	
		if($r){
			
			storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'删除报名项目'.input('get.id'));
			
			$this->redirect('Item/index');
		}else{
			return $this->error('删除失败！',url('Item/index'));
		}		
		
	}
	/*
	function edit_item(){
		if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));
			
			if(empty($data['title'])){
				return ['error'=>'标题必填'];
			}
			if(!empty($data['start_apply_time'])){
				$data['start_apply_time']=strtotime($data['start_apply_time']);
			}	
			if(!empty($data['end_apply_time'])){
				$data['end_apply_time']=strtotime($data['end_apply_time']);
			}
			if(!empty($data['start_time'])){
				$data['start_time']=strtotime($data['start_time']);
			}
			if(!empty($data['end_time'])){
				$data['end_time']=strtotime($data['end_time']);
			}
			
			$r=Db::name('item')->update($data,false,true);		
			if($r){				
				storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'更新基本信息');							
				return $this->success('更新成功！',url('item/index'));
			}else{			
				return $this->error('更新失败！');	
			}
		}
	
	 	$this->assign('item',Db::name('item')->find(input('id')));
		
	 	$this->assign('crumbs', '编辑基本信息');	
		
	 	return $this->fetch('item');
	}

	function edit_data(){
		if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));			
			
			$r=Db::name('item_data')->update($data,false,true);		
			if($r){				
				storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'更新详情');							
				return $this->success('更新成功！',url('item/index'));
			}else{			
				return $this->error('更新失败！');	
			}
		}
		$this->assign('item',Db::name('item_data')->where('item_id',input('id'))->find());
		$this->assign('crumbs', '编辑详情');	
		return $this->fetch('data');
	}
	function edit_option(){
		
		if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));	
			
			Db::name('item')->update(['id'=>(int)$data['item_id'],'cid'=>(int)$data['category']],false,true);	
			
			if(isset($data['option'])){
				Db::name('item_option')->where('item_id',(int)$data['item_id'])->delete();
				
				if(isset($data['option'])){
					foreach ($data['option'] as $key=>$option) {
						Db::execute("INSERT INTO " . config('database.prefix'). "item_option SET item_id =".(int)$data['item_id'].",cid = " . (int)$data['category']. ",option_id =".$key.",option_value_id =" . (int)$option);
					}
				}
			}
			storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'更新搜索选项');	
			
			return $this->success('更新成功！',url('item/index'));
		}
		
		$this->assign('item',DB::name('item')->find(input('id')));
		
		$this->assign('item_option',DB::name('item_option')->where('item_id',input('id'))->select());
	
		$service=new \osc\item\service\Service();
		
		$this->assign('category',$service->get_item_category());
		
		$this->assign('crumbs', '编辑搜索选项');	
		
	 	return $this->fetch('option');
	}
	*/
	
	public function get_option_value(){
		
		$cid=input('cid');		
		
		$this->assign('option', $this->option_values((int)$cid));
		
		exit($this->fetch('option_value'));
	}
	
	function option_values($cid) {
		
		$option=Db::name('option')->where('cid',(int)$cid)->select();
		
		$option_value = Db::query("SELECT ov.* FROM " 
		. config('database.prefix'). "option o LEFT JOIN " 
		. config('database.prefix'). "option_value  ov ON (ov.option_id = o.option_id) WHERE o.cid =" 
		. (int)$cid);
		
		$option_value_data=[];
		
		foreach ($option as $k=>$v) {
			$option_value_data[$k]['name']=$v['name'];
			$option_value_data[$k]['option_id']=$v['option_id'];
			foreach ($option_value as $k1 => $v1) {
				if($v['option_id']==$v1['option_id']){
					$option_value_data[$k]['value'][]=$v1;
				}
			}
			
		}

		return $option_value_data;
	}
	
}
