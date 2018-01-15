<?php
/*
各种常用验证类
by Jay 2016-11-15
*/
namespace Gwantsi\Utils;

class UsuallyCheck
{
	/* 手机号码验证
	 * 13,14,15,17,18开头必须11位数
	 * */
	static public function moblie($mobile) {
		if (strlen($mobile) == "11") {
			$pattern = "/^1[34578]{1}\d{9}$/i";
			$n = preg_match($pattern,$mobile);
			if($n){
				return true;
			}
		}
		return false;
	}
	
	/* 电话号码验证
	 * 验证规则：区号+号码，区号以0开头，3位或4位
	 * 号码由7位或8位数字组成
	 * 区号与号码之间可以无连接符，也可以“-”连接
	 * 如01088888888,010-88888888,0955-7777777 
	 */
	static public function phone($phoneNum){
		$pattern = "/^0\d{2,3}-?\d{7,8}$/i";
		$n = preg_match($pattern,$phoneNum);
		if($n){
			return true;
		}
		return false;
	}
	
	//email验证
	static public function email($email){
		if($email){
			$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z\\-]+\\.[a-z]{2,4}(\\.[a-z]{2})?)$/i";
			if(preg_match($pattern,$email)) {
				return true;
			}
		}
		return false;
	}
	
	/* 验证身份证号码正确性
	 * @param 身份证号码，仅支持 18位新身份证
	 * Return Bool
	 */
	static public function idCard($idCard){
		$ary = str_split($idCard);
		$leath = count($ary);
		if($leath != 18){
			return false;
		}
		
		//获取最后一位校验码
		$lastNum = strtoupper($idCard[17]);
		
		//加权因子
		$wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
		
		//校验码对应值
		$ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
		
		//计算校验码
		$sigma = 0;
		for ($i = 0;$i < 17;$i++) {
			$sigma += $ary[$i] * $wi[$i];
		}
		$checkNum = $ai[($sigma % 11)];
		
		//比对校验码
		if($lastNum == $checkNum){
			return true;
		} else {
			return false;
		}
	}
	
}//end class
?>