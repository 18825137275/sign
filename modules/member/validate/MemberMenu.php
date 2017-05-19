<?php

namespace osc\member\validate;
use think\Validate;
class MemberMenu extends Validate
{
    protected $rule = [
        'title'  =>  'require|min:2',
        'sort_order'=>'number'    
    ];

    protected $message = [
        'title.require'  =>  '菜单名称必填',
        'title.min'  =>  '菜单名称不能小于两个字',     
      
        'sort_order.number'  =>  '排序必须是数字' 
    ];

	
}
?>