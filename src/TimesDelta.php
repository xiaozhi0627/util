<?php

namespace Gwantsi\Utils;

class TimesDelta
{
	static private $instance = NULL;
	public static function getInstance(){
		if (self::$instance === NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function getDeltaNow($time) {
		$ary = $this->getDeltaTime($time,time());
		if($ary['hour'] > 24){
			$day = (int)($ary['hour']/ 24);
			if($day > 365){
				$year = (int)($day / 24);
				return $year . '年';
			}
			return $day . '天';
		}
		
		if($ary['hour'] > 0){
			return $ary['hour'] . '小时';
		}
		if($ary['min'] > 0){
			return $ary['min'] . '分钟';
		}
		if($ary['sec'] > 0){
			return $ary['sec'] . '秒';
		}
		return '0秒';
	}
	
	/**
     * 获取两时间点之间的间隔
     * @param $startTime
     * @param $endTime
     * @return mixed
     */
    public function getDeltaTime($startTime,$endTime) {
        $deltaTime = $endTime - $startTime;
		if($deltaTime <= 0){
			$deltaTime = 0;
		}
        $time['hour']=(int)($deltaTime/3600);
        $time['min']=(int)(($deltaTime%3600)/60);
        $time['sec']=(int)($deltaTime%60);
        return $time;
    }
}//end class
?>