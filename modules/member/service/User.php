<?php
namespace osc\member\service;
use think\Db;
//用户数据
class User{
	
	function is_login(){
		$user = session('member_user_auth');
	    if (empty($user)) {
	        return 0;
	    } else {
	        return session('member_user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
	    }
	}
	
	function user_info($uid=UID){
		if($this->is_login()){
			return Db::name('member')->where('userid',$uid)->find();	
		}	
	}
	
	function user_group(){
		return Db::name('member_auth_group')->field('id,title')->where('status',1)->select();
	}
	
}
?>