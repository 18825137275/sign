<?php
/**
 * @author    李梓钿
 *会员账户资料相关
 */
namespace osc\member\controller;
use osc\common\controller\MemberBase;
use think\Db;

class Account extends MemberBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','个人资料');
		
	}
	//我的资料
    public function profile(){	
		
		if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));			
			
			$member['userpic']=$data['userpic'];
			$member['nickname']=$data['nickname'];			
			$member['email']=$data['email'];
							
			if(Db::name('member')->where('userid',UID)->update($member,false,true)){
				
				storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'修改了系统个人资料');	
				
				return ['success'=>'修改成功','action'=>'edit'];
			}else{
				return ['error'=>'修改失败'];
			}
		}
		
		$user=new \osc\member\service\User();
		
		$this->assign('user',$user->user_info());
		
		$this->assign('breadcrumb2','我的资料');
		
		return $this->fetch();   
    }
	//修改密码
	public function password(){
		if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));
			
			if(empty($data['old_pwd'])){
				return ['error'=>'请输入旧密码'];
			}elseif(empty($data['new_pwd'])){
				return ['error'=>'请输入新密码'];
			}elseif(empty($data['new_pwd2'])){
				return ['error'=>'请输入新密码确认'];
			}elseif($data['new_pwd2']!=$data['new_pwd']){
				return ['error'=>'两次密码输入不一致'];
			}
			
			$user=new \osc\member\service\User();
		
			$user_info=$user->user_info();
			
			if(think_ucenter_encrypt($data['old_pwd'],config('PWD_KEY'))!=$user_info['password']){
				return ['error'=>'旧密码错误'];
			}
			
			$member['password']=think_ucenter_encrypt($data['new_pwd'],config('PWD_KEY'));	
							
			if(Db::name('member')->where('userid',UID)->update($member,false,true)){
				
				storage_user_action(UID,session('member_user_auth.username'),config('FRONTEND_USER'),'修改了登录密码');	
				
				return ['success'=>'修改成功','action'=>'edit'];
			}else{
				return ['error'=>'修改失败'];
			}
		}
		$this->assign('breadcrumb2','修改密码');
		return $this->fetch(); 
	}

	
	
	
}
