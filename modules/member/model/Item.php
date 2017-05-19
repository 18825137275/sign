<?php
/**
 * @author    李梓钿
 *
 */
namespace osc\member\model;
use think\Db;
class Item{
	
	public function validate($data) {

		if(empty($data['title'])){
			return ['标题必填'];
		}elseif(empty($data['category'])){
			return ['搜索选项必填'];
		}
	
	}
	
	public function add_item($data){		
		
		$item['image']=$data['image'];
		$item['title']=$data['title'];
		$item['contact']=$data['contact'];
		$item['contact_tel']=$data['contact_tel'];
		$item['location']=$data['location'];
		
		$item['uid']=session('member_user_auth.uid');
		$item['username']=session('member_user_auth.username');
		
		$item['total_num']=$data['total_num'];
	
		$item['price']=$data['price'];
		
		if((float)$data['price']>0){
			$item['is_pay']=1;
		}
		
		$item['cid']=$data['category'];		
		
		$item['create_time']=time();
		
		if(1==config('item_check')){//需要审核
			$item['status']=0;
		}else{
			$item['status']=1;
		}
		
		if(!empty($data['start_apply_time'])){
			$item['start_apply_time']=strtotime($data['start_apply_time']);
		}	
		if(!empty($data['end_apply_time'])){
			$item['end_apply_time']=strtotime($data['end_apply_time']);
		}
		if(!empty($data['start_time'])){
			$item['start_time']=strtotime($data['start_time']);
		}
		if(!empty($data['end_time'])){
			$item['end_time']=strtotime($data['end_time']);
		}
		
		
		$item_id=Db::name('item')->insert($item,false,true);
		
		if($item_id){
			$item_data['item_id']=$item_id;				
			$item_data['summary']=$data['data']['summary'];
			$item_data['description']=$data['data']['description'];		
			$item_data['uid']=UID;	
			$item_data['cid']=$data['category'];	
				
			Db::name('item_data')->insert($item_data);
			
			if(isset($data['option'])){
				foreach ($data['option'] as $key=> $option) {
					Db::execute("INSERT INTO " . config('database.prefix'). "item_option SET item_id =" . (int)$item_id. ",uid =".UID . ",cid =" . (int)$item['cid']. ",option_id =".$key.", option_value_id =" . (int)$option);
				}
			}
			return true;
		}else{
			return false;
		}
		
	}
	
	public function edit_item($data){
		
		$item['image']=$data['image'];
		$item['title']=$data['title'];
		$item['contact']=$data['contact'];
		$item['contact_tel']=$data['contact_tel'];
		$item['location']=$data['location'];
		
		$item['uid']=session('member_user_auth.uid');
		$item['username']=session('member_user_auth.username');
		
		$item['total_num']=$data['total_num'];
		
		$item['price']=$data['price'];
		$item['cid']=$data['category'];		
		
		if((float)$data['price']>0){
			$item['is_pay']=1;
		}
		
		$item['update_time']=time();
		
		if(1==config('item_check')){//需要审核
			$item['status']=0;
		}else{
			$item['status']=1;
		}
		
		if(!empty($data['start_apply_time'])){
			$item['start_apply_time']=strtotime($data['start_apply_time']);
		}else{
			$item['start_apply_time']=0;
		}			
		
		if(!empty($data['end_apply_time'])){
			$item['end_apply_time']=strtotime($data['end_apply_time']);
		}else{
			$item['end_apply_time']=0;
		}	
		
		if(!empty($data['start_time'])){
			$item['start_time']=strtotime($data['start_time']);
		}else{
			$item['start_time']=0;
		}	

		if(!empty($data['end_time'])){
			$item['end_time']=strtotime($data['end_time']);
		}else{
			$item['end_time']=0;
		}	
		
		$item_id=(int)$data['id'];
		
		$r=Db::name('item')->where('id',$item_id)->update($item,false,true);
		
		if($r){
						
			$item_data['summary']=htmlspecialchars($data['data']['summary']);
			$item_data['description']=htmlspecialchars($data['data']['description']);		
			$item_data['cid']=$data['category'];	
			$item_data['update_time']=time();	
				
			Db::name('item_data')->where('item_id',$item_id)->update($item_data);
			
			if(isset($data['option'])){
				
				Db::name('item_option')->where('item_id',$item_id)->delete();
				
				foreach ($data['option'] as $key=> $option) {
					Db::execute("INSERT INTO " . config('database.prefix'). "item_option SET item_id =" . (int)$item_id. ",uid =".UID . ",cid =" . (int)$item['cid']. ",option_id =".$key.", option_value_id =" . (int)$option);
				}
			}
			return true;
		}else{
			return false;
		}
		
	}
	
	function copy_item($item_id){
		
			$item=Db::name('item')->find($item_id);	
			
			if ($item) {
				
				$data = $item;
				
				$data['category'] = $item['cid'];		
				
					
				if($data['start_apply_time']!=0)
				$data['start_apply_time']= date('Y-m-d',$data['start_apply_time']);		
				
				if($data['end_apply_time']!=0)
				$data['end_apply_time']=date('Y-m-d',$data['end_apply_time']);		
				
				if($data['start_time']!=0)
				$data['start_time']=date('Y-m-d',$data['start_time']);		
				
				if($data['end_time']!=0)
				$data['end_time']=date('Y-m-d',$data['end_time']);				
				
				unset($data['id']);
								
				$data['data'] =Db::name('item_data')->where('item_id',$item_id)->find();			
				
				$option =Db::name('item_option')->where('item_id',$item_id)->field('option_value_id,option_id')->select();	
				
				foreach ($option as $key => $v) {
				
					$data['option'][$v['option_id']] =$v['option_value_id'];
				}				
				
				$this->add_item($data);
			}
	}
	
	public function del_item($id){
			try{
									
				Db::name('item')->where(['id'=>$id,'uid'=>UID])->delete();
				Db::name('item_data')->where(['item_id'=>$id,'uid'=>UID])->delete();
				Db::name('item_option')->where(['item_id'=>$id,'uid'=>UID])->delete();				
				
				return true;
			}catch(Exception $e){
				return false;
			}
	}
	
	
	
	
}
?>