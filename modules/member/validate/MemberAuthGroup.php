<?php

namespace osc\member\validate;
use think\Validate;
class MemberAuthGroup extends Validate
{
    protected $rule = [
        'title'  =>  'require|min:2',     
    ];

    protected $message = [
        'title.require'  =>  '菜单名称必填',
        'title.min'  =>  '菜单名称不能小于两个字',     
    ];

	
}
?>