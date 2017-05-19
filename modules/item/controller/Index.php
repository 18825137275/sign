<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\controller;
use osc\common\controller\ItemBase;
use think\Db;
class Index extends ItemBase{
	
    public function index()
    {
		
    	$this->assign('title',config('SITE_TITLE'));
	
		$this->assign('item',Db::name('item')->where('status',1)->order('id desc')->paginate(16));	
		
		return $this->fetch();   
    }

	
}
