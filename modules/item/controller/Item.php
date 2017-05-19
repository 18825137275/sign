<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Item extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','报名');
		$this->assign('breadcrumb2','活动列表');
	}
	
    public function index(){
    	
		$filter=input('param.');
	
		$map=[];
		
		$query=[];
		
		if(isset($filter['title'])){		
			$map['title']=['like',"%".$filter['title']."%"];
			$query['title']=urlencode($filter['title']);	
		}
		if(isset($filter['cat'])){	
			$map['cid']=['eq',$filter['cat']];
			$query['cat']=urlencode($filter['cat']);
		}		
		if(isset($filter['username'])){	
			$map['username']=['like',"%".$filter['username']."%"];
			$query['username']=urlencode($filter['username']);
		}
		
		$list = Db::name('item')->where($map)->paginate(config('page_num'),false,['query'=>$query]);
		$this->assign('empty','<tr><td colspan="20">没有数据~</td></tr>');
		$this->assign('list', $list);
		
		$service=new \osc\item\service\Service();
		
		$this->assign('service',$service);  
		
		$this->assign('category',$service->get_category_tree());  
			
		
		return $this->fetch();  
	 }
	
	
	 public function set_status(){
		
		$data=safe_filter(input('param.'));
		
		Db::name('item')->where('id',$data['id'])->update(['status'=>(int)$data['status']],false,true);		
		
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改了活动状态');	
		
		$this->redirect('Item/index');
	}
	 
	 
	public function del(){
		
		Db::name('item')->delete(input('id'));
		Db::name('item_data')->where('item_id',input('id'))->delete();
		Db::name('item_option')->where('item_id',input('id'))->delete();		
		
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'删除了活动');
		
		$this->redirect('Item/index');	
	}
	

}
?>