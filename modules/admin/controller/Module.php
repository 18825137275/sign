<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\admin\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Module extends AdminBase{
	
    public function index()
    {
    	
		$this->assign('list',Db::name('module')->where('iscore',0)->field('module,modulename,disabled,author')->select());
		
    	$this->assign('breadcrumb1','扩展');
		$this->assign('breadcrumb2','模块管理');
		    
		return $this->fetch();   
    }
	
	public function set_status(){
		$data=input('param.');
		
		Db::name('module')->where('module',$data['module'])->update(['disabled'=>$data['status']],false,true);		
		
		storage_user_action(UID,session('user_auth.username'),config('BACKEND_USER'),'修改模块状态');	
		
		cache('module',null);
		
		$this->redirect('Module/index');
	}
	
}
