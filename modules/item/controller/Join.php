<?php
/**
 * @author    李梓钿
 *会员资料相关
 */
namespace osc\item\controller;
use osc\common\controller\AdminBase;
use think\Db;
class Join extends AdminBase{
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign('breadcrumb2','报名列表');
		$this->assign('breadcrumb1','报名');
	}
	
	public function search_param(){
		
		$filter=safe_filter(input('param.'));
	
		$map=[];
		
		$query=[];
		
		//标题
		if(isset($filter['title'])){		
			$map['item_title']=['like',"%".$filter['title']."%"];
			$query['title']=urlencode($filter['title']);	
		}
		//分类
		if(isset($filter['cat'])){	
			$map['cid']=['eq',$filter['cat']];
			$query['cat']=urlencode($filter['cat']);
		}
		//付款状态
		if(isset($filter['pay_status'])){	
			$map['pay_status']=['eq',$filter['pay_status']];
			$query['pay_status']=urlencode($filter['pay_status']);
		}
		
		return [
			'map'=>$map,
			'query'=>$query
		];
	}
	
	public function get_excel_data($list){
		
		$service=new \osc\item\service\Service();
		
		$excel_obj = new \oscshop\Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'活动标题');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'分类');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'姓名');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'联系电话');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'所需金额(元)');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'是否付款');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'付款时间');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'报名时间');	
		//data
		foreach ((array)$list as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['item_title']);
			$tmp[] = array('data'=>$service->get_item_category_info($v['cid'],'name'));
			$tmp[] = array('data'=>$v['name']);
			$tmp[] = array('data'=>$v['tel']);
			
			$tmp[] = array('data'=>$v['money']);
			
			switch ($v['pay_status']) {
				case '0':
					$tmp[] = array('data'=>'未付款');
				break;
				case '1':
					$tmp[] = array('data'=>'已付款');
				break;
				case '2':
					$tmp[] = array('data'=>'已退款');
				break;
			
			}
			
			if($v['pay_time'] == 0){
				$tmp[] = array('data'=>'无');
			}else{
				$tmp[] = array('data'=>date('Y-m-d',$v['pay_time']));
			}
			
			if($v['create_time'] == 0){
				$tmp[] = array('data'=>'无');
			}else{
				$tmp[] = array('data'=>date('Y-m-d',$v['create_time']));
			}
	
			
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,'UTF8');
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset('活动报名信息','UTF8'));
		$excel_obj->generateXML($excel_obj->charset('活动报名信息','UTF8').time().'-'.date('Y-m-d-H',time()));
	}
	
	//报名情况
	public function index(){
				
		$param=$this->search_param();		
		
		$list = Db::name('member_apply')->where($param['map'])->paginate(config('page_num'),false,['query'=>$param['query']]);
		$this->assign('empty','<tr><td colspan="20">没有数据~</td></tr>');
		$this->assign('list', $list);		
	
		
		$service=new \osc\item\service\Service();
		
		$this->assign('service',$service);  
		
		$this->assign('category',$service->get_category_tree());  //dump($service->get_category_tree());die;

		
		return $this->fetch();  
	}
	
	public function export_excel(){
		
		$param=$this->search_param();			
		
		$list=Db::name('member_apply')->where($param['map'])->select();
		
		$this->get_excel_data($list);
	}
	
}
