<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

return [
    'cat/:id'   	=> 'front_category/index',
    'info/:id'   	=> 'front_item/index',
    
	'reg$'   		=> 'member/login/reg',
	'login$'   		=> 'member/login/login',
	'logout$'   	=> 'member/login/logout',	
	'check_login$'  => 'member/login/check_login',
	
	'member$'   	=> 'member/account/profile',
	'apply/:id'   	=> 'member/apply/apply',
	
	'payment_list$' => 'payment/payment/payment_list',
	'pay_api$'   	=> 'payment/payment/pay_api',
	
	'wxpay$'		=> 'payment/weixin/code',
	'get_order_status$'=> 'payment/weixin/get_order_status',
	'pay_success$'	=> 'payment/alipay/pay_success',
];
