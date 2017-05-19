<?php
namespace osc\item\service;
use think\Db;
//Item模块数据服务接口
class Service{
	
	//取得分类信息
	public function get_item_category_info($id,$key){
	 	
		if (!$item_category = cache('item_category_info')) {
		
			$list=Db::name('item_category')->select();
			
			$cat=[];
			
			foreach ($list as $k => $v) {
				$cat[$v['id']]=$v;
			}
			
			cache('item_category_info', $cat);	
			
			$item_category=$cat;
		}
		return $item_category[$id][$key];		
	}
	
	//取得分类
	public function get_item_category(){
	 	
		if (!$item_category = cache('item_category')) {
		
			$list=Db::name('item_category')->select();
			
			cache('item_category', $list);	
			
			$item_category=$list;
		}
		return $item_category;		
	}
	//取得分类树形结构
	public function get_category_tree(){
		$category=Db::name('item_category')->field('id,pid,name')->select();		
		$tree=new \oscshop\Tree();	
		return $tree->toFormatTree($category,'name');
	}
	
	//取得搜索项
	public function get_option_value($cid){
		
		$option=Db::name('option')->where('cid',$cid)->select();
		
		$option_value=Db::name('option_value')->where('cid',$cid)->select();
		
		$list=[];
		if($option){		
			foreach ($option as $k => $v) {
				$list[$k]['name']=$v['name'];
				$list[$k]['type']=$v['type'];
				$list[$k]['option_id']=$v['option_id'];
				$list[$k]['cid']=$v['cid'];
				foreach ($option_value as $k1 => $v1) {
					if($v['option_id']==$v1['option_id']){
						$list[$k]['value'][]=$v1;
					}
				}
			}
		}
		
		
		return $list;
	}
	//通过参数取得item列表
	public function get_item_by_param($param,$page_num=10){
		
		$param=safe_filter($param);
		
		$map=[];
		$query=[];
		
		if(isset($param['type'])){
			$query['type']=urlencode($param['type']);	
		}
		
		if(isset($param['title'])){
			$map['title']=['like',"%".$param['title']."%"];	
			$query['title']=urlencode($param['title']);	
		}
		if(isset($param['id'])){
			$map['cid']=['eq',(int)$param['id']];	
			$query['cid']=urlencode((int)$param['id']);		
		}
		
		$map['id']=['GT','0'];
		$map['status']=['EQ','1'];
		
		if(isset($param['o'])&&!empty($param['o'])){			
			
			$item_option=Db::name('item_option')->where('option_value_id','in',$param['o'])->paginate($page_num);
			
			$item_id=null;
						
			foreach ($item_option as $k => $v) {
				if($v!=end($item_option)){
					$item_id.=$v['item_id'].',';
				}else{
					$item_id.=$v['item_id'];
				}
			}
			
			$map['id']=['IN',$item_id];	
			$query['o']=urlencode($param['o']);		
		
		}

		return Db::name('item')
		->where($map)
		->paginate($page_num,false,['query'=>$query]);
		
	}
	//取得item详情数据
	public function get_item_info($item_id){
		
		$map['i.id']=['EQ',(int)$item_id];
		$map['i.status']=['EQ','1'];
		
		return Db::name('item')->alias('i')
		->join('item_data id','i.id=id.item_id')
		->where($map)
		->find();
	}
}
?>