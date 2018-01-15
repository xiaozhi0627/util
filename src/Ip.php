<?php
/*
各种ip处理类
by Jay 2016-11-15
*/
namespace Gwantsi\Utils;

class Ip
{
	private static $instance = null;
	public static function getInstance()
	{
		if(!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	//获取客户端ip
	public function getIp(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), '')){
			$ip = getenv("HTTP_CLIENT_IP");
		} else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), '')){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), '')){
			   $ip = getenv("REMOTE_ADDR");
		} else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], '')){
			   $ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = '';
		}
		return ($ip);
	}
	
	//判断是否是有效ip地址
	public function verifyIp($ipaddres){
		$preg="/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
		if(preg_match($preg,$ipaddres))return true;
		return false;
	}
	
	//根据IP获取City
	public function getCity($ip){
		if(!$this->verifyIp($ip)){
			return false;
		}
		$r = file_get_contents('http://www.ip138.com/ips.asp?ip='.$ip);
		$t = '本站主数据：';
		$t = $this->convertEncodingDeep($t,'gbk');
		preg_match("/".$t."(.*) /iU",$r, $matches);
		$r = $matches[1]; 
		$r = $this->convertEncodingDeep($r,'utf-8');
		return $r;
	}
	
	//按区号获取城市
	public function getCityNum($city){
		$city_list = array();
		$city_list['北京'] = '10';
		$city_list['上海'] = '21';
		$city_list['广东'] = '20';
		if($city){
			return $city_list[$city];
		} else {
			return false;
		}
	}
	
	//按城市获取区号
	public function getCityByNum($no){
		$city_list = array();
		$city_list[10] = '北京';
		$city_list[21] = '上海';
		$city_list[20] = '广东';
		if($no){
			return $city_list[$no];
		} else {
			return 0;
		}
	}

	//检查IP是否可访问
	public function checkBySock($ip,$time=1){
		$errno = '';
		$errstr = '';
		$fp = @fsockopen($ip,80,$errno,$errstr,$time);
		if($fp) {
			return 1;
		}else{
			return 0;
		}
	}
	
	private function convertEncodingDeep($value,$code_to = 'utf-8'){
		if(is_array($value)){
			$value = array_map(array('string', 'convert_encoding_deep'),$value);
		} else {
			$codeing = mb_detect_encoding($value, array('ASCII','UTF-8','GB2312','GBK','BIG5')); 
			$value = mb_convert_encoding($value,$code_to,$codeing);
		}
		return $value; 
	}
}//end class
?>