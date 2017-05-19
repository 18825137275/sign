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

	//'app_trace' =>  true,
	//'app_debug' => true,
	'app_namespace' =>  'osc',	
	'default_module'=> 'item',
	
    'url_route_on' => true,
	'url_route_must'=>  false,
	
	
    'view_replace_str'=>[
    '__PUBLIC__'=>'/static',
    '__RES__'=>'/static/view_res',
    '__ADMIN__' =>'/static/view_res/admin',
    'IMG_ROOT'=>'/'
	],
	
	'FRONTEND_USER'=>'网站会员',	
	'BACKEND_USER'=>'后台系统用户',
	
	'session'                => [
		'type'           => '',
		'auto_start'     => true,
	],
	
	'storage_user_action'=>true,
	
	'URL_HTML_SUFFIX'=>'',
	//默认错误跳转对应的模板文件
	'dispatch_error_tmpl' => APP_PATH.'common/view/public/error.tpl',
	//默认成功跳转对应的模板文件
	'dispatch_success_tmpl' => APP_PATH.'common/view/public/success.tpl'
];
