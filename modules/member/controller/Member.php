<?php
/**
 * @author    李梓钿
 * 会员权限管理
 */
namespace osc\member\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Member extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','会员');
		$this->assign('breadcrumb2','会员列表');
	}
	
     public function index(){
     	
     	$list = Db::name('member')
     	->alias('m')
		->join('member_auth_group mag','m.groupid = mag.id')
		->field('m.*,mag.title')
     	->paginate(config('page_num'));
		
		$service=new \osc\member\service\User();
				
		$this->assign('list',$list);
		$this->assign('group',$service->user_group());
		$this->assign('empty','<tr><td colspan="20">没有数据~</td></tr>');
    	return $this->fetch();
	 }
	public function set_status(){
		
		$data=safe_filter(input('param.'));
		
		Db::name('member')->where('userid',$data['id'])->update(['checked'=>(int)$data['status']],false,true);		
		
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改了会员状态');	
		
		$this->redirect('Member/index');
	}
	public function del(){
		
		$uid=safe_filter(input('param.id'));
		
		Db::name('member')->where('userid',(int)$uid)->delete();
		Db::name('member_auth_group_access')->where('uid',(int)$uid)->delete();
		
		Db::name('item')->where('uid',(int)$uid)->delete();
		Db::name('item_data')->where('uid',(int)$uid)->delete();
		Db::name('item_option')->where('uid',(int)$uid)->delete();
		
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'删除了会员');	
		
		$this->redirect('Member/index');
	}
	public function edit(){
		
	}
}
?>