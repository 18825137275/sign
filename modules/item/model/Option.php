<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\item\model;
use think\Db;
class Option{
	
	public function validate($data) {

		$error=array();
		if ((utf8_strlen($data['name']) <1) || (utf8_strlen($data['name']) > 10)) {
			$error['error'] = '选项名称必须大于1小于10个字！！';
		}elseif (($data['type'] == 'select' || $data['type'] == 'radio' || $data['type'] == 'checkbox') && !isset($data['option_value'])) {
			$error['error'] ='选项值必填！！';
		}elseif (isset($data['option_value'])) {
			foreach ($data['option_value'] as $option_value_id => $option_value) {				
				if ((utf8_strlen($option_value['name']) < 1) || (utf8_strlen($option_value['name']) > 10)) {
					$error['error'] ='选项值必须大于0小于10个字！！';
				}				
			}
		}
		if($error){
			return $error;
			die;
		}
	
	}
	//可以显示系统选项和分类的组
	public function allow_group(){
		$group_id=session('user_auth.group_id');
		
		//可以显示系统选项和分类的组
		$system_option_group=[
			config('admin_group')
		];
		
		return in_array($group_id, $system_option_group);
	}
	
	
	public function add_option($data){			
		
			$option['name']=$data['name'];	
			$option['type']=$data['type'];		
			$option['update_time']=date('Y-m-d H:i:s',time());	
			$option['value']='';			
	
			$option['cid']=$data['cid'];
			$option['system']=1;				
		
			$option['uid']=session('user_auth.uid');
				
			if(isset($data['option_value'])){
				foreach ($data['option_value'] as $k=> $v) {
					if(!empty($v)){
						if($v!=end($data['option_value'])){
							$option['value'].=$v['name'].',';
						}else{
							$option['value'].=$v['name'];
						}					
					}				
				}	
			}
			$option_id=Db::name('Option')->insert($option,false,true);
			
			if($option_id){
				
				if(isset($data['option_value'])){				
					foreach ($data['option_value'] as $k => $v) {						
						if(!empty($v)){
							
							$value['option_id']=$option_id;
							$value['value_name']=$v['name'];						
							$value['value_sort_order']=$v['sort_order'];							
					
							$value['cid']=$data['cid'];
							$value['system']=1;
							
							Db::name('OptionValue')->insert($value);
						}
					}
				}
				return true;
			}else{
				return false;
			}		
	}
	public function edit_option($data){		
			
			$option['option_id']=$data['id'];
			$option['name']=$data['name'];	
			$option['type']=$data['type'];		
			$option['update_time']=date('Y-m-d H:i:s',time());		
			$option['value']='';				
		
			$option['cid']=$data['cid'];
			$option['system']=1;				
		
			$option['uid']=session('user_auth.uid');
			
			
			if(isset($data['option_value'])){
				foreach ($data['option_value'] as $k=> $v) {
					if(!empty($v)){
						if($v!=end($data['option_value'])){
							$option['value'].=$v['name'].',';
						}else{
							$option['value'].=$v['name'];
						}					
					}				
				}	
			}
			$r=Db::name('option')->update($option,false,true);	
			
			if($r){
				if(isset($data['option_value'])){	
					Db::name('option_value')->where('option_id',$data['id'])->delete();
					
					foreach ($data['option_value'] as $k => $v) {						
						if(!empty($v)){
							
							$value['option_id']=$data['id'];
							$value['value_name']=$v['name'];						
							$value['value_sort_order']=$v['sort_order'];
							
							
							$value['cid']=$data['cid'];
							$value['system']=1;				
							
							
							Db::name('OptionValue')->insert($value,false,true);
						}
					}
				}
				return true;
			}else{
				return false;
			}		
	}
	
	function get_options($filter_name) {
			
			$sql = "SELECT * FROM ".config('database.prefix'). "option";
			
			if (isset($filter_name) && !is_null($filter_name)) {
				$sql .= " WHERE name LIKE '" . $filter_name . "%'";
			}			
	
			$query = Db::query($sql);
	
			return $query;
	}	
	
	function get_option_values($option_id) {
		
		$option_value_data = array();
		
		$option_value_query = Db::query("SELECT * FROM " 
		. config('database.prefix'). "option_value ov LEFT JOIN " 
		. config('database.prefix'). "option o ON (ov.option_id = o.option_id) WHERE ov.option_id =" 
		. (int)$option_id);
				
		foreach ($option_value_query as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['option_value_id'],
				'name'            => $option_value['name'],
				'value'           => $option_value['value_name'],				
				'sort_order'      => $option_value['value_sort_order']
			);
		}
		
		return $option_value_data;
	}
	
	
}
?>