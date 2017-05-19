<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\admin\controller;
use osc\common\controller\AdminBase;
class Index extends AdminBase{
	
    public function index()
    {
    	
		    
		return $this->fetch();   
    }
	
	public function logout(){
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'退出了系统');
		$this->user->logout();		
		$this->redirect('Login/login');
	}
	
	public function clear(){
        clear_cache();
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'清除了缓存');
        return $this->success('缓存清理完毕');
    }
	
}
