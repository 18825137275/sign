<?php

namespace osc\item\validate;
use think\Validate;
class ItemCategory extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:2',
        'sort_order'=>'number'    
    ];

    protected $message = [
        'name.require'  =>  '分类名称必填',
        'name.min'  =>  '分类名称不能小于两个字',     
      
        'sort_order.number'  =>  '排序必须是数字' 
    ];

	
}
?>