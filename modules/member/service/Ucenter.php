<?php
namespace osc\member\service;
use think\Db;
//用户数据
class Ucenter{
	
	private $db;
	//前缀
	private $p='';
		
	public function __construct(){
		
		//数据库配置
		$db_config = [
		    // 数据库类型
		    'type'        => 'mysql',
		    // 服务器地址
		    'hostname'    => '',
		 
		    // 数据库名
		    'database'    => '',
		    // 数据库用户名
		    'username'    => '',
		    
		    'hostport'    => '3306',
		    // 数据库密码
		    'password'    => '',
		    // 数据库编码默认采用utf8
		    'charset'     => 'utf8',
		    // 数据库表前缀
		    'prefix'      => '',
		];
				
		$this->db=Db::connect($db_config);
	}	
	
	public function get_user_list(){
		return $this->db->query('select * from '.$this->p.'common_member');
	}
	
}
?>