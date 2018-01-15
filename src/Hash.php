<?php
//2012-2-10 by jay hash取值
//last change 2016-11-14 Jay

namespace Comn\Utils;
class Hash
{
	private $is_hash_num = false;
	private $_max;
	private $_min;
	private $ary_key_list;
	
	//按数字范围哈希
	public function get_hash_num($key,$min,$max){
		if(!is_numeric($min) || !is_numeric($max) || $max < $min){
			return false;
		}
		$this->set_hash_num($min,$max);
		return $this->get_hash($key);
	}
	
	//按数组哈希
	public function get_hash_ary($key,$ary){
		if(!is_array($ary) || !$ary){
			return false;
		}
		$this->set_hash_ary($min,$max);
		return $this->get_hash($key);
	}
	
	/****************
	 * 私有方法
	 ****************/
	
	//按照key获取一个哈希值
	private function get_hash($str){
		if(!$str){
			return false;
		}
		if(is_numeric($str)){
			$str = strval($str);
		}
		if(!is_string($str)){
			return false;
		}
		
		if(!$this->_max){
			return false;
		}

		$hash = $this->_time33Hash($str);
		//echo $hash;
		$count = $this->_max;
		if($this->is_hash_num){
			$count = $count - $this->_min;
		}
		$rt = abs(fmod($hash, $count));
		if($this->is_hash_num){
			return $rt + $this->_min;
		} else if($this->ary_key_list){
			return $this->ary_key_list[$rt];
		} else {
			return $rt;
		}
	}
	
	//time33核心算法
	private function _time33Hash($str) {
		$hash = 0;
		$n = strlen($str);
		for ($i = 0; $i < $n; $i++) {
			$hash += ($hash <<5 ) + ord($str[$i]);
		}
		return $hash;
	}
	
	//设置需要哈希的数组
	private function set_hash_ary($ary){
		$this->is_hash_num = false;
		$this->_max = count($ary);
		$this->ary_key_list = array_keys($ary);
	}

	//设置数字的最小与最大范围
	private function set_hash_num($min=0,$max=1000){
		$this->_min = $min;
		$this->_max = $max + 1;
		$this->is_hash_num = true;
	}
}//end class