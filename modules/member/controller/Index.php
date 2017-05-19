<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\member\controller;
use osc\common\controller\MemberBase;
class Index extends MemberBase{
	
    public function index()
    {
    	
		    
		return $this->fetch();   
    }

	
}
