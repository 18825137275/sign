<?php
//判断php版本 
if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');
//设置网站字符集
header("Content-Type:text/html; charset=utf-8");
//根目录，物理路径
define('ROOT_PATH',str_replace('\\','/',dirname(__FILE__)) . '/'); 
//类库包
define('EXTEND_PATH',__DIR__ . '/../extend/');
//图片上传目录
define('DIR_IMAGE',ROOT_PATH.'uploads/');
// 定义应用目录
define('APP_PATH', __DIR__ . '/../modules/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
