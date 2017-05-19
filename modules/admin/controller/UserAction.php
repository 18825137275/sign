<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\admin\controller;
use osc\common\controller\AdminBase;
use think\Db;
class UserAction extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb1','系统');
		$this->assign('breadcrumb2','用户行为');
	}
	
    public function index()
    {
    	
    	$list = Db::name('user_action')->order('ua_id desc')->paginate(config('page_num'));
		
		$this->assign('empty','<tr><td colspan="20">没有数据~</td></tr>');
		$this->assign('list',$list);
		    
		return $this->fetch();   
    }

	
	public function del(){
		if(Db::name('user_action')->where('ua_id','>',0)->delete()){
			return $this->success('清空成功！',url('UserAction/index'));
		}else{
			return $this->error('清空失败！',url('UserAction/index'));
		}
		
	}
}
