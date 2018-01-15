<?php
//2012-2-10 by jay hash取值
//last change 2016-11-14 Jay

namespace Gwantsi\Utils;

class ResponseCode
{
	private $lang;
	
	static private $instance = NULL;
	public static function getInstance($lang = 'cn') {
		if (self::$instance === NULL) {
			self::$instance = new self($lang);
		}
		return self::$instance;
	}
	
	public function __construct($lang = 'cn'){
		$this->lang = $lang;
	}

	public function build($code,$data='',$msg = ''){
		$codeList = $this->codeCn();
		if($this->lang == 'en'){
			$codeList = $this->codeEn();
		}
		return $this->create($codeList,$code,$data,$msg);
	}
	
	private function codeEn(){
		$codeList = [
			'100'=>'Unknow error',//成功
			'200'=>'Success',//成功
			'2006'=>'Send vcode error',//发送验证码错误，多半是服务器端出了问题
			'2007'=>'Token must need',//用户认证的Token必须存在，说明该URL必须要登录才能访问
			'2008'=>'Token error',//Token验证错误
			'2009'=>'Send vcode too much',//发送验证码触发业务流控限制
			'2010'=>'Old token error',//旧的Token验证错误
			'2011'=>'Get ali oss stsToken error',//获取ali oss token错误
			'2012'=>'Token 超时',//Token超时
			'2021'=>'Error money',//金额错误
			'2022'=>'No money',//余额不足
			'2023'=>'Too much money',//金额到达上限
			'2024'=>'Change money fail',//修改金额失败
			'2025'=>'The funds are frozen',//资金被冻结
			'2030'=>'Invalid symbol',//包含非法字符
			
			'3000'=>'Wrong parament',//参数错误
			'3001'=>'Wrong mobile number',//手机号码不能为空
			'3002'=>'Password is not be empty',//密码不能为空
			'3003'=>'Third index must need',//第三方唯一标识必须存在
			'3004'=>'Platform error',//平台标识错误，只能是weixin weibo qq 三种
			'3005'=>'The phone number is incorrect',//手机号码格式错误
			'3006'=>'Vcode error',//验证码错误
			'3011'=>'Not bind mobile',//用户没有绑定手机
			'3012'=>'Not find user',//没有找到这个用户
			'3013'=>'User name or password error',//用户名或密码错误
			'3014'=>'User is block',//用户被锁定
			'3015'=>'The phone is already in use',//这个手机号码已经被使用了
			'3016'=>'Nickname must only',//昵称必须唯一
			'3017'=>'Not find design order',//没有找到设计订单
			'3018'=>'No need to change',//
			'3019'=>'Please set your password',//需要重新设置密码
			'3020'=>'This mobile is bind a third platform',//该手机号码已经绑定了一个第三方平台了
			'3101'=>'Not find bank card',//没有找到银行卡
			'3102'=>'Bank card error',//银行卡号错误,有问题的银行卡号
			'3103'=>'Id Card error',//身份证号码错误
			'3104'=>'Bank card max',//银行卡达到上限
			'3200'=>'Not find address',//没有找到地址信息
			'3300'=>'No data',//没有数据
			'3400'=>'Too much works',//设计师个人作品达到最大数量
			'3500'=>'Server error',//服务器错误
			
			'4000'=>'Wrong parament',//参数错误
			'4001'=>'ProductId is not be empty',//商品ID不能为空
			'4002'=>'PostId is not be empty',//作品ID不能为空
			'4003'=>'Comment is not be empty',//评论内容不能为空
			'4004'=>'UserId is not be empty',//用户ID不能为空
			'4005'=>'Product type already exists',//商品已经加入分类
			'4006'=>'Product tag already exists',//商品标签已经存在
			'4007'=>'Product not exist',//商品不存在
			'4008'=>'Type not exist',//分类不存在
			'4009'=>'designerId is not be empty',//设计师ID不能为空
			'4020'=>'Resource is empty',//分类不存在
			'4100'=>'MyShow is lock',//成品秀被锁
			'4101'=>'MyShow get failed',//成品秀获取失败
			'4102'=>'MyShow photo get failed',//成品秀图片获取失败
			'4103'=>'UserMyShow get failed',//用户成品秀获取失败
			'4200'=>'Resource get failed',//资源获取失败
			'4300'=>'Resource create failed',//资源创建失败
			'4400'=>'Resource update failed',//资源更新失败
			'4500'=>'Delete failed',//删除失败
			'4600'=>'Have been over praise',//已点过赞
			'4700'=>'Commodity parameters are not complete, can not be shelves',//商品参数未填写完整，不能上架


			'5001'=>'param userId invalid',
			'5002'=>'no origin designed file',
			'5003'=>'param productIds invalid',
			'5004'=>'param title invalid',
			'5005'=>'param intro invalid',
			'5006'=>'param totalFees invalid',
			'5007'=>'origin designed file not be uploaded',
			'5008'=>'path param id is illegal',
			'5009'=>'path param action is illegal',
			'5010'=>'path param orderId is invalid',
			'5011'=>'param designerId is required',
			'5012'=>'order created failed',
			'5013'=>'order modified failed',
			'5014'=>'choose designer failed',
			'5015'=>'param content is invalid',
			'5016'=>'no design style and option range',
			'5017'=>'no races in this order',
			'5018'=>'can not have more races',
			'5019'=>'post design failed',
			
			'6001' => 'process order prepay failed',
		];
		return $codeList;
	}
	
	private function codeCn(){
		$codeList = [
			'100'=>'未知错误',//成功
			'200'=>'Success',//成功
			'2006'=>'发送验证码错误',//发送验证码错误，多半是服务器端出了问题
			'2007'=>'Token必须存在',//用户认证的Token必须存在，说明该URL必须要登录才能访问
			'2008'=>'Token验证错误',//Token验证错误
			'2009'=>'验证码发送太频繁',//发送验证码触发业务流控限制
			'2010'=>'原Token验证错误',//旧的Token验证错误
			'2011'=>'获取阿里oss token失败',//获取ali oss token错误
			'2012'=>'Token 超时',//Token超时
			'2021'=>'金额错误',//金额错误
			'2022'=>'余额不足',//余额不足
			'2023'=>'金额到达上限',//金额到达上限
			'2024'=>'修改金额失败',//修改金额失败
			'2025'=>'资金被冻结',//资金被冻结
			'2030'=>'输入的信息中包含非法字符',//包含非法字符
			
			'3000'=>'参数错误',//参数错误
			'3001'=>'错误的手机号码',//手机号码不能为空
			'3002'=>'密码不能为空',//密码不能为空
			'3003'=>'第三方唯一标识必须存在',//第三方唯一标识必须存在
			'3004'=>'平台错误',//平台标识错误，只能是weixin weibo qq 三种
			'3005'=>'手机号码格式错误',//手机号码格式错误
			'3006'=>'验证码错误',//验证码错误
			'3011'=>'没有绑定手机',//用户没有绑定手机
			'3012'=>'没有找到用户',//没有找到这个用户
			'3013'=>'用户名或密码错误',//用户名或密码错误
			'3014'=>'用户被锁定',//用户被锁定
			'3015'=>'手机号码已经被使用',//这个手机号码已经被使用了
			'3016'=>'昵称已经存在',//昵称必须唯一
			'3017'=>'没有找到设计订单',//没有找到设计订单
			'3018'=>'没有需要更新的内容',//没有需要更新的内容
			'3019'=>'请重新设置密码',//需要重新设置密码
			'3020'=>'该手机号码已经绑定了一个第三方平台了',//该手机号码已经绑定了一个第三方平台了
			'3101'=>'没有找到银行卡',//没有找到银行卡信息
			'3102'=>'错误的银行卡',//银行卡号错误,有问题的银行卡号
			'3103'=>'身份证号码错误',//身份证号码错误
			'3104'=>'银行卡数量达到上限',//银行卡达到上限
			'3200'=>'没有找到地址信息',//没有找到地址信息
			'3300'=>'没有获取到数据',//没有数据
			'3400'=>'作品数量达到上限',//设计师个人作品达到最大数量
			'3500'=>'系统错误',//服务器错误

			'4000'=>'参数错误',
			'4001'=>'商品ID不能为空',
			'4002'=>'作品ID不能为空',
			'4003'=>'评论内容不能为空',
			'4004'=>'用户ID不能为空',
			'4005'=>'商品已经加入分类',
			'4006'=>'商品标签已经存在',
			'4007'=>'商品不存在',
			'4008'=>'分类不存在',
			'4020'=>'分类不存在',
			'4100'=>'成品秀被锁',
			'4101'=>'没有成品秀',
			'4102'=>'成品秀图片获取失败',
			'4103'=>'用户成品秀获取失败',
			'4200'=>'资源获取失败',
			'4300'=>'资源创建失败',
			'4400'=>'资源更新失败',
			'4500'=>'删除失败',
			'4600'=>'已点过赞',
			'4700'=>'商品参数未填写完整，不能上架',

			'5001'=>'param userId invalid',
			'5002'=>'no origin designed file',
			'5003'=>'param productIds invalid',
			'5004'=>'param title invalid',
			'5005'=>'param intro invalid',
			'5006'=>'param totalFees invalid',
			'5007'=>'origin designed file not be uploaded',
			'5008'=>'path param id is illegal',
			'5009'=>'path param action is illegal',
			'5010'=>'path param orderId is invalid',
			'5011'=>'param designerId is required',
			'5012'=>'order created failed',
			'5013'=>'order modified failed',
			'5014'=>'choose designer failed',
			'5015'=>'param content is invalid',
			'5016'=>'no design style and option range',
			'5017'=>'no races in this order',
			'5018'=>'can not have more races',
			'5019'=>'post design failed',
			
			'6001' => 'process order prepay failed',
		];
		return $codeList;
	}
	
	private function create($codeList,$code,$data = '',$msg = ''){
		//返回数组
		$backAry = [
			'code'=>'100',
			'message'=>'Unknow error',
			'data'=>''
		];

		if(isset($codeList[$code])){
			$backAry['code'] = $code;
			$backAry['message'] = $codeList[$code];
			if($data){
				$backAry['data'] = $data;
			}
		}
		if($msg){
			$backAry['message'] = $msg;
		}
		return $backAry;
	}
}