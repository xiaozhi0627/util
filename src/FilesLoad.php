<?php

namespace Gwantsi\Utils;

class FilesLoad{
	
	function __construct(){
		//构造函数
	}
	
	//单例
	static private $instance = NULL;
	public static function getInstance() 
	{
		if (self::$instance === NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/* 读取指定路径下所有的文件
	 * @Param $base_path 基础路径
	 * @Param $dir_path  要读取的目录相对路径
	 * @Param $host  域名，如不为空，则组成可访问的URL路径，否则返回相对路径
	 * Return Array 文件相对路径列表
	 */
	public function loadPath($base_path,$dir_path,$host = ''){
		$dirPath = $base_path.$dir_path;
		if(!is_dir($dirPath)){
			return false;
		}
		if(!$host){
			$host = '';
		}
		
		$arr = array();
		$res = array();
		$arr = $this->getFiles($dirPath);
		foreach($arr as $k=>$v){
			$temp[$k] = explode($base_path,$v);
			$res[$k] = $host . $temp[$k][1];
		}
		return $res;
	}
	
	//获取文件
	private function getFiles($path){
		if(!is_dir($path)){
			return false;
		}
		
		$handle  = opendir($path);
		$files = array();
		while(false !== ($file = readdir($handle))){
			if($file != '.' && $file!='..' && $file!='.svn'){
				$path2 = $path.'/'.$file;
				if(is_dir($path2)){
					$this->getFiles($path2);
				}else{
					if(preg_match("/\.(gif|jpeg|jpg|png|bmp)$/i", $file)){
						$files[$file] = $path.'/'.$file;
					}
				}
			}
		}
		return $files;
	}
	
	//获取目录
	public function getDir($dirPath){
		if(!is_dir($dirPath)){
			return false;
		}
		$ary = array();
		if ($dh = opendir($dirPath)){
			while (($file = readdir($dh))!= false){
				$filePath = $dirPath.'/'.$file;
				if(is_dir($filePath) && $file != '.' && $file != '..' && strtolower($file) != '.svn'){
					$ary[] = $file;
				}
			}
			closedir($dh);
		}
		return $ary;
	}
}