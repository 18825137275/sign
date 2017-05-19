<?php
/**
 * @author    李梓钿
 *会员登录注册相关
 */
namespace osc\member\controller;
use osc\common\controller\Base;
use think\Db;

class Login extends Base{

	
	//检测是否登录
	public function check_login(){
		$user=new \osc\member\service\User(); 
		
		if(!$user->is_login()){
			return ['error'=>'请先登录！！'];
		}
		
	}
	
	public function reg()
    {
    	if($this->request->isPost()){
    		
    		$data=safe_filter(input('post.'));					
			 	
			$error=$this->validate($data,'User');	
	
			if($error!==true){			
				return ['error'=>$error];	
			}
			
			$member['username']=$data['username'];
			$member['password']=think_ucenter_encrypt($data['password'],config('PWD_KEY'));
			$member['email']=$data['email'];
			
			if(empty($data['nickname'])){
				$member['nickname']=$data['username'];
			}else{
				$member['nickname']=$data['nickname'];
			}
			
			
			$member['regdate']=time();
			$member['lastdate']=time();
			
			$member['groupid']=config('default_group');
			
			if(1==config('reg_check')){//需要审核
				$member['checked']=0;
			}else{
				$member['checked']=1;
			}
			
			$uid=Db::name('member')->insert($member,false,true);
			
			if($uid){
				
				//写入用户权限表
				Db::name('member_auth_group_access')->insert(['uid'=>$uid,'group_id'=>$member['groupid']],false,true);				 		
				
				if(1==config('reg_check')){//需要审核
					return ['success'=>'注册成功，请等待管理员审核','check'=>1];
				}else{//不需要审核
					$auth = array(
		            'uid'             => $uid,
		            'username'        => $member['username'],
		            'nickname'        => $member['nickname'],
		            'group_id'		  => $member['groupid']			            
					 );	
					session('member_user_auth', $auth);
		    		session('member_user_auth_sign',data_auth_sign($auth));
					
					storage_user_action($uid,$member['username'],config('FRONTEND_USER'),'注册成为会员');
					
					return ['success'=>'注册成功','check'=>0];
				}
				
			    
			}else{
				return ['error'=>'注册失败'];
			}
			
    	}
		
		$user=new \osc\member\service\User(); 
		
		if($user->is_login()){
			die('您已经登录了账号！！');
		}
		  
		return $this->fetch();   
    }
	
	
	public function validate_login($data){
		
			if(empty($data['username'])){
				return ['error'=>'用户名必填'];
			}elseif(empty($data['password'])){
				return ['error'=>'密码必填'];
			}
			
			$user=Db::name('member')->where(['username'=>$data['username']])->find();
			
			if(!$user){
				return ['error'=>'账号不存在！！'];
			}elseif($user['checked']!=1){
				return ['error'=>'该账号未审核通过！！'];
			}
			
			if(think_ucenter_encrypt($data['password'],config('PWD_KEY'))==$user['password']){
			
				$auth = array(
		            'uid'             => $user['userid'],
		            'username'        => $user['username'],
		            'nickname'        => $user['nickname'],
		            'group_id'		  => $user['groupid']			            
				 );			
				
			    session('member_user_auth', $auth);
	    		session('member_user_auth_sign',data_auth_sign($auth));
				
				storage_user_action($user['userid'],$user['username'],config('FRONTEND_USER'),'登录了网站');
				
				return true;
			}else{
				return ['error'=>'密码错误'];
			}
	}
	
	//登录
	public function login(){
		
		if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));	
			
			$r=$this->validate_login($data);
			
			if(isset($r['error'])){
				return $r;
			}elseif($r==true){
				return ['success'=>true];
			}
			
		}
		
		$user=new \osc\member\service\User(); 
		
		if($user->is_login()){
			die('您已经登录了账号！！');
		}
		  
		return $this->fetch();  
	}
	function logout(){
		session('member_user_auth',null);
		$this->redirect('item/Index/index');
	}
}
