<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\admin\controller;
use osc\common\controller\Base;
use think\Db;
class Login extends Base{
	
	public function login(){		
	
		$user=new \osc\admin\service\User();
		
		 if($this->request->isPost()){
			
			$data=safe_filter(input('post.'));
			
			if(empty($data['username'])){
				$this->error('用户名不能为空！');
			}elseif(empty($data['password'])){
				$this->error('密码不能为空！');
			}
			$user_info=Db::name('admin')->where('user_name',$data['username'])->find();
		
			//用户存在且可用
			if($user_info&&$user_info['status']==1){
				
				//验证密码
				if(think_ucenter_encrypt($data['password'],config('PWD_KEY'))==$user_info['passwd']){
					
					$group=Db::name('auth_group_access')->where('uid',$user_info['admin_id'])->find();
					
			        $auth = array(
			            'uid'             => $user_info['admin_id'],
			            'username'        => $user_info['user_name'],
			            'group_id'			  => $group['group_id']			          
					 );			
					
				    session('user_auth', $auth);
		    		session('user_auth_sign',data_auth_sign($auth));
				
			        $data = array();
			        $data['admin_id']	=	$user_info['admin_id'];
			        $data['last_login_time']	=	time();				
			        $data['login_count']		=	array('exp','login_count+1');
					$data['last_login_ip']	=	get_client_ip();
					
			        Db::name('admin')->update($data);
										
					storage_user_action($user_info['admin_id'],$user_info['user_name'],config('BACKEND_USER'),'登录了后台系统');
					
					return $this->success('登录成功！',url('Index/index'));
				}else{
					return  $this->error('密码错误！');
				}
			}else{
				return  $this->error('用户不存在或被禁用！');
			}				

        } else {
        	
            if($user->is_login()){
                $this->redirect('Index/index');
            }else{			
                return $this->fetch('public/login'); 
            }
        }
		
	}


	
}
