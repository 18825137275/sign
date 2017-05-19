<?php
/**
 * @author    李梓钿
 * 会员报名操作相关
 */
namespace osc\member\controller;
use osc\common\controller\Base;
use think\Db;
class Apply extends Base{
	
	protected function _initialize() {
		parent::_initialize();
		
		$user=new \osc\member\service\User(); 
		
		define('UID',$user->is_login());
		
		if(!UID){
			return $this->error('请先登录','/');
		}
	
	}
	
	//报名申请
	public function apply(){		
		
		$item_id=input('param.id');
		
		$map['id']=['EQ',(int)$item_id];
		
		$map['status']=['EQ','1'];
		
		$item=Db::name('item')->where($map)->find();
		
		if($item['uid']==UID){
			$this->assign('error','报名失败,不能报名自己的活动');
			return $this->fetch(); 
		}
		//有限制名额
		if($item['total_num']!=0&&($item['join_num']>=$item['total_num'])){
			$this->assign('error','报名失败,活动已经报满！！');
			return $this->fetch(); 
		}
		//开始报名时间有限制
		if($item['start_apply_time']!=0){			
			if(time()<$item['start_apply_time']){
				$this->assign('error','报名失败,未到报名时间！！');
				return $this->fetch(); 
			}			
		}
		//结束报名时间有限制
		if($item['end_apply_time']!=0){			
			if(time()>$item['end_apply_time']){
				$this->assign('error','报名失败,报名结束了！！');
				return $this->fetch(); 
			}			
		}
		
		
		if($this->request->isPost()){
			
			session('item',null);			
			
			if($item){
								
				//需要支付的，保存入session,支付模块中写入订单
				if($item['is_pay']==1){					
					session('item',$item);
					
					session('item.name',input('post.name'));
					session('item.tel',input('post.tel'));
					
					return ['success'=>'1','location'=>url('/payment_list')];
					
				//不需要支付的，直接写入数据库	
				}elseif($item['is_pay']==0){
					
					$apply['item_id']=$item['id'];
					$apply['item_title']=$item['title'];
					$apply['member_id']=session('member_user_auth.uid');
					
					$apply['cid']=$item['cid'];
					$apply['uid']=$item['uid'];
					
					$apply['name']=input('post.name');
					$apply['tel']=input('post.tel');
					
					$apply['create_time']=time();
					
					$id=Db::name('member_apply')->insert($apply,false,true);
					
					Db::name('item')->where('id',(int)$item_id)->setInc('join_num', 1);
					
					if($id){
						return ['success'=>'报名成功'];
					}else{
						return ['error'=>'报名失败'];
					}
				}
				
			}else{
				return ['error'=>'该项目不存在！！'];
			}
			
		}
		
		
		
		if(Db::name('member_apply')->where(['member_id'=>session('member_user_auth.uid'),'item_id'=>(int)$item_id])->find()){
			$this->assign('error','您已经报过名了！！');
		}
		
		return $this->fetch();  
	}

	
}
