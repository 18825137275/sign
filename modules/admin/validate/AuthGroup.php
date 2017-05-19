<?php

namespace osc\admin\validate;
use think\Validate;
class AuthGroup extends Validate
{
    protected $rule = [
        'title'  =>  'require|min:2',     
    ];

    protected $message = [
        'title.require'  =>  '后台菜单名称必填',
        'title.min'  =>  '后台菜单名称不能小于两个字',     
    ];

	
}
?>