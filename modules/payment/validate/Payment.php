<?php
/**
 *
 * @author    李梓钿
 *
 */
namespace osc\payment\validate;
use think\Validate;
class Payment extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:2',
        'payment_code'=>'require', 
        'value'=>	'require'
           
    ];

    protected $message = [
        'name.require'  =>  '名称必填',
        'name.min'  =>  '名称不能小于两个字',   
        'payment_code.require'  =>  '支付方式必填',        
        'value.require'  =>  '值必填'
        
    ];

	
}
?>