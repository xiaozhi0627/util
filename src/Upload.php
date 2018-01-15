<?php

namespace Gwantsi\Utils;
    
Class Upload{
	private $dir;
	private $set_filename;
	private $thumb_width;
	private $thumb_height;
	private $thumb_ext;
	private $watermark_file;
	private $watermark_pos;
	private $watermark_alpha;
	private $time;
	private $is_copy = false;
	
	private $file_type_list = array();
	private $filetypedata = array();
	private $filetypeids = array();
	private $filetypes = array();

	public $error_msg = '';
	
	//得到一个单例
	static private $instance = NULL;
	public static function getInstance($type_constraint = array(),$time = 0) 
	{
		if (self::$instance === NULL) {
			self::$instance = new self($type_constraint = array(),$time = 0);
		}
		return self::$instance;
	}
	
	function __construct($type_constraint = array(),$time = 0) {
		
		//文件类型范围数组
		$this->file_type_list = array(
			'av' => array('av', 'wmv', 'wav'),
			'real' => array('rm', 'rmvb'),
			'binary' => array('dat'),
			'flash' => array('swf'),
			'html' => array('html', 'htm'),
			'image' => array('gif', 'jpg', 'jpeg','pjpeg', 'png'),
			'jpg' => array('jpg', 'jpeg'),
			'office' => array('doc', 'xls', 'ppt'),
			'pdf' => array('pdf'),
			'rar' => array('rar', 'zip'),
			'text' => array('txt'),
			'bt' => array('bt'),
			'video'=> array('mp4','m4v','f4v','webm','flv','quicktime'),
			'zip' => array('tar', 'rar', 'zip', 'gz')
		);
		if($type_constraint){
			$this->set_file_type($type_constraint,$time);
		}
	}
    
	function setFileType($filetype = array(),$time = 0) {
		$this->time = $time ? $time : time();
		$file_type_data = array(
				'av' => array('av', 'wmv', 'wav'),
				'real' => array('rm', 'rmvb'),
				'binary' => array('dat'),
				'flash' => array('swf'),
				'html' => array('html', 'htm'),
				'image' => array('gif', 'jpg', 'jpeg','pjpeg', 'png'),
				'jpg' => array('jpg', 'jpeg'),
				'office' => array('doc', 'xls', 'ppt'),
				'pdf' => array('pdf'),
				'rar' => array('rar', 'zip'),
				'text' => array('txt'),
				'bt' => array('bt'),
				'video'=> array('mp4','m4v','f4v','webm','flv','quicktime'),
				'zip' => array('tar', 'rar', 'zip', 'gz')
			);
		if(empty($filetype)){
			$this->filetypedata = $file_type_data;
		}else{
			if(is_array($filetype)){
				foreach($filetype as $type){
					$this->filetypedata[$type] = $file_type_data[$type];
				}
			}else{
				$this->filetypedata[$filetype] = $file_type_data[$filetype];
			}
		}
		//print_r($this->filetypedata);
		$this->filetypeids = array_keys($this->filetypedata);
		foreach($this->filetypedata as $data) {
			$this->filetypes = array_merge($this->filetypes, $data);
		}
	}
	
	/*********************
	 * 新建文件保存目录
	 *********************/

	//按照日期建立目录
	public function mkdir_by_date($date, $dir = '.') {
		list($y, $m, $d) = explode('-', date('Y-m-d', $date));
		!is_dir("$dir/$y") && mkdir("$dir/$y", 0755);
		!is_dir("$dir/$y/$m$d") && mkdir("$dir/$y/$m$d", 0755);
		return "/$y/$m$d";
	} 

	public function mkdir_by_hash($s, $dir = '.') {
		$s = md5($s);
		!is_dir($dir.'/'.$s[0]) && mkdir($dir.'/'.$s[0], 0755); 
		!is_dir($dir.'/'.$s[0].'/'.$s[1]) && mkdir($dir.'/'.$s[0].'/'.$s[1], 0755);
		!is_dir($dir.'/'.$s[0].'/'.$s[1].'/'.$s[2]) && mkdir($dir.'/'.$s[0].'/'.$s[1].'/'.$s[2], 0755); 
		return '/'.$s[0].'/'.$s[1].'/'.$s[2];
	}

	public function mkdir_by_key($key, $dir = '.') {
		$key = sprintf("%09d", $key);
		$dir1 = substr($key, 0, 3);
		$dir2 = substr($key, 3, 2);
		$dir3 = substr($key, 5, 2);
		!is_dir($dir.'/'.$dir1) && mkdir($dir.'/'.$dir1, 0755);
		!is_dir($dir.'/'.$dir1.'/'.$dir2) && mkdir($dir.'/'.$dir1.'/'.$dir2, 0755);
		!is_dir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3) && mkdir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3, 0755);
		return '/'.$dir1.'/'.$dir2.'/'.$dir3;
	}
	
	/*********************
	 * 常用
	 *********************/
	
	/*
	 * 保存文件
	 * @param $input_name String 标签input的name
	 * @param $type_constraint Array 所支持的文件类型数组
	 * @param $filename String 保存的文件名称
	 * @param $save_path String 保存的文件目录路径
	 * @param $iscopy Bool 是否为复制
	 */
	public function save_file($input_name,$type_constraint,$filename,$save_path,$iscopy = false){
		if($_FILES[$input_name]['error']) {
			$this->error_msg = 'error:'.$_FILES[$input_name]['error'];
			return false;
		}

		if(!$_FILES[$input_name]['name']) {
			$this->error_msg = '文件不存在';
			return false;
		}
		
		//设置常用属性
		$this->set_file_type($type_constraint);
		$this->set_dir($save_path);
		$this->set_filename($filename);
		$this->set_copy($iscopy);
		
		//执行上传
		return $this->execute($input_name);
	}
	
	/*
	 * 保存图片
	 * @param $input_name String 标签input的name
	 * @param $type_constraint Array 所支持的文件类型数组
	 * @param $filename String 保存的文件名称
	 * @param $save_path String 保存的文件目录路径
	 * @param $width String 保存的文件目录路径
	 * @param $height String 保存的文件目录路径
	 * @param $watermark_ary Array 水印数组信息 array('file'=>'PATH','pos'=>'9','alpha'=>'100');
	 * @param $iscopy Bool 是否为复制
	 */
	public function save_img($input_name,$type_constraint,$filename,$save_path,$width = 800,$height = 800,$watermark_ary = array(),$iscopy = false){
		if($_FILES[$input_name]['error']) {
			$this->error_msg = 'error:'.$_FILES[$input_name]['error'];
			return false;
		}
		if(!$_FILES[$input_name]['name']) {
			$this->error_msg = '文件不存在';
			return false;
		}
		
		//设置常用属性
		$this->set_file_type($type_constraint);
		$this->set_dir($save_path);
		$this->set_filename($filename);
		$this->set_copy($iscopy);
		$this->set_thumb($width,$height);
		
		//设置水印
		if($watermark_ary && $watermark_ary['file']){
			$watermark_file = $watermark_ary;
			$watermark_pos = 9;
			$watermark_alpha = 100;
			
			if($watermark_ary['pos'] > 0){
				$watermark_pos = $watermark_ary['pos'];
			}
			if(is_numeric($watermark_ary['alpha'])){
				$watermark_alpha = $watermark_ary['alpha'];
			}
			$this->set_watermark($watermark_file, $watermark_pos,$watermark_alpha);
		}

		//执行上传
		return $this->execute($input_name);
	}
	
	/*********************
	 * 设置基本信息
	 *********************/
	
	//设置文件类型
	public function set_file_type($type_constraint = array(),$time = 0){
		$this->time = $time ? $time : time();
		if($type_constraint){
			if(is_array($type_constraint)){
				foreach($type_constraint as $type){
					$this->filetypedata[$type] = $this->file_type_list[$type];
				}
			}else{
				$this->filetypedata[$type_constraint] = $this->file_type_list[$type_constraint];
			}
		} else {
			$this->filetypedata = $this->file_type_list;
		}
		
		if($this->filetypedata){
			$this->filetypeids = array_keys($this->filetypedata);
			foreach($this->filetypedata as $data) {
				$this->filetypes = array_merge($this->filetypes, $data);
			}
		}
	}
	
	//设置目录
	public function set_dir($dir) {
		$this->dir = $dir;
	}
	
	//设置文件名称
	public function set_filename($filename) {
		$this->filename = $filename;
	}
	
	//设置是否复制 $val bool
	public function set_copy($val = true) {
		$this->is_copy = $val;
	}
	
	//设置压缩的宽与高(图片专用)
	public function set_thumb($width, $height, $ext = '') {
		$this->thumb_width = $width;
		$this->thumb_height = $height;
		$this->thumb_ext = $ext;
	}
	
	//设置水印(图片专用)
	public function set_watermark($file, $pos = 9, $alpha = 100) {
		$this->watermark_file = $file;
		$this->watermark_pos = $pos;
		$this->watermark_alpha = $alpha;
	}
	
	/*********************
	 * 执行上传逻辑
	 *********************/

	//执行上传
	public function execute($input_name) {
		$arr = array();

		if($_FILES[$input_name]['error']) {
			$this->error_msg = 'error:'.$_FILES[$input_name]['error'];
			return false;
		}

		if(!$_FILES[$input_name]['name']) {
			$this->error_msg = '文件不存在';
			return false;
		}

		$file = array(
			'name' => $_FILES[$input_name]['name'],
			'tmp_name' => $_FILES[$input_name]['tmp_name']
		);
		
		//判断文件类型
		$fileext = strtolower($this->fileext($file['name']));
		
		if(!in_array($fileext, $this->filetypes)) {
			$fileext = '_'.$fileext;
			$this->error_msg = 'wrong file type';
			return false;
		}


		if(isset($this->filename)){
			$tfilename = $this->filename;
			$filename = $tfilename.'.'.$fileext;
		}else{
			$tfilename = md5($this->time.rand(100, 999).$file['name']);
			$filename = '1'.$tfilename.'.'.$fileext;
		}
		$filethumb = '0'.$tfilename.'.'.($this->thumb_ext ? $this->thumb_ext : $fileext);

		$rs = $this->copy($file['tmp_name'], $this->dir.'/'.$filename);
		if(!$rs){
			$this->error_msg = 'file move error';
			return false;
		}

		$arr['file'] = $filename;
		if(in_array($fileext, array('jpg', 'gif', 'png','jpeg','pjpeg'))) {
			if($this->thumb_width) {
				if($this->thumb($this->thumb_width, $this->thumb_height, $this->dir.'/'.$filename, $this->dir.'/'.$filethumb, ($this->thumb_ext ? $this->thumb_ext : $fileext))) {
					@unlink($this->dir.'/'.$filename);
					if(isset($this->filename)){
						$arr['file'] = $filename;
						@rename($this->dir.'/'.$filethumb,$this->dir.'/'.$arr['file']);
					}else{
						$arr['file'] = $filethumb;
					}
				}
			}
			if($this->watermark_file) {
				$this->watermark($this->dir.'/'.$filename, $this->watermark_file, $fileext, $this->watermark_pos, $this->watermark_alpha);
			}
		}
		return $arr;
	}
	
	//从二进制流执行上传
	public function execute_bybinary($file_binary,$key) {
		$arr = array();
		if(!$file_binary) {
			$this->error_msg = '文件不存在';
			return false;
		}

		//判断文件类型
		$fileext = $this->get_file_type_forbinary($file_binary);
		if(!in_array($fileext, $this->filetypes)) {
			$fileext = '_'.$fileext;
			$this->error_msg = '错误的文件类型';
			return false;
		}

		$tfilename = md5($this->time.rand(100, 999).$key);
		$filename = '1'.$tfilename.'.'.$fileext;
		$filethumb = '0'.$tfilename.'.'.($this->thumb_ext ? $this->thumb_ext : $fileext);

		//header( "Content-type: image/jpeg");
		$file_dir = $this->dir.'/'.$filename;
		if($fp = fopen($file_dir,'w')){
			if(fwrite($fp,$file_binary)){
				fclose($fp);
			}
		}
		$arr['file'] = $filename;
		if(in_array($fileext, array('jpg', 'gif', 'png','jpeg','pjpeg'))) {
			if($this->thumb_width) {
				if($this->thumb($this->thumb_width, $this->thumb_height, $this->dir.'/'.$filename, $this->dir.'/'.$filethumb, ($this->thumb_ext ? $this->thumb_ext : $fileext))) {
					$arr['file'] = $filethumb;
					@unlink($this->dir.'/'.$filename);
				}
			}
			if($this->watermark_file) {
				$this->watermark($this->dir.'/'.$filename, $this->watermark_file, $fileext, $this->watermark_pos, $this->watermark_alpha);
			}
		}
		return $arr;
	}
    //从$_FILES执行上传
    function executeByFile($ofile)
    {
        $arr = array();

		if($error = $ofile->getError()){
		   return false;
		}
        
		$file = array(
			'name' => $ofile->getClientFilename(),
			'tmp_name' => $ofile->file
		);
		
		//判断文件类型
		$fileext = strtolower($this->fileext($ofile->getClientFilename()));


		if(!in_array($fileext, $this->filetypes)) {
			$fileext = '_'.$fileext;
			self::$error_msg = 'wrong file type';
			return false;
		}


		if(isset($this->filename)){
			$tfilename = $this->filename;
			$filename = $tfilename.'.'.$fileext;
		}else{
			$tfilename = md5($this->time.rand(100, 999).$file['name']);
			$filename = '1'.$tfilename.'.'.$fileext;
		}
		$filethumb = '0'.$tfilename.'.'.($this->thumb_ext ? $this->thumb_ext : $fileext);
		$rs = $this->copy($file['tmp_name'], $this->dir.'/'.$filename);
        
		if(!$rs){
			self::$error_msg = 'file move error';
			return false;
		}

		$arr['file'] = $filename;
		if(in_array($fileext, array('jpg', 'gif', 'png','jpeg','pjpeg'))) {
			if($this->thumb_width) {
				if($this->thumb($this->thumb_width, $this->thumb_height, $this->dir.'/'.$filename, $this->dir.'/'.$filethumb, ($this->thumb_ext ? $this->thumb_ext : $fileext))) {
					@unlink($this->dir.'/'.$filename);
					if(isset($this->filename)){
						$arr['file'] = $filename;
						@rename($this->dir.'/'.$filethumb,$this->dir.'/'.$arr['file']);
					}else{
						$arr['file'] = $filethumb;
					}
				}
			}
			if($this->watermark_file) {
				$this->watermark($this->dir.'/'.$filename, $this->watermark_file, $fileext, $this->watermark_pos, $this->watermark_alpha);
			}
		}
		return $arr['file'];
    }
	
	//添加水印
	public function watermark($target,$watermark_file,$ext,$watermarkstatus = 9,$watermarktrans=50) {
		$gdsurporttype = array();
		if(function_exists('imageAlphaBlending') && function_exists('getimagesize')) {
			if(function_exists('imageGIF')) $gdsurporttype[]='gif';
			if(function_exists('imagePNG')) $gdsurporttype[]='png';
			if(function_exists('imageJPEG')) {
				$gdsurporttype[]='jpg';
				$gdsurporttype[]='jpeg';
			}
		}
		if($gdsurporttype && in_array($ext, $gdsurporttype) ) {
			$attachinfo	= getimagesize($target);
			$watermark_logo = imageCreateFromGIF($watermark_file);

			$logo_w		= imageSX($watermark_logo);
			$logo_h		= imageSY($watermark_logo);
			$img_w		= $attachinfo[0];
			$img_h		= $attachinfo[1];
			$wmwidth	= $img_w - $logo_w;
			$wmheight	= $img_h - $logo_h;

			$animatedgif = 0;
			if($attachinfo['mime'] == 'image/gif') {
				$fp = fopen($target, 'rb');
				$targetcontent = fread($fp, 9999999);
				fclose($fp);
				$animatedgif = strpos($targetcontent, 'NETSCAPE2.0') === FALSE ? 0 : 1;
			}

			if($watermark_logo && $wmwidth > 10 && $wmheight > 10 && !$animatedgif) {
				switch ($attachinfo['mime']) {
					case 'image/jpeg':
						$dst_photo = imageCreateFromJPEG($target);
						break;
					case 'image/gif':
						$dst_photo = imageCreateFromGIF($target);
						break;
					case 'image/png':
						$dst_photo = imageCreateFromPNG($target);
						break;
				}

				switch($watermarkstatus) {
					case 1:
						$x = +5;
						$y = +5;
						break;
					case 2:
						$x = ($logo_w +	$img_w)	/ 2;
						$y = +5;
						break;
					case 3:
						$x = $img_w - $logo_w-5;
						$y = +5;
						break;
					case 4:
						$x = +5;
						$y = ($logo_h +	$img_h)	/ 2;
						break;
					case 5:
						$x = ($logo_w +	$img_w)	/ 2;
						$y = ($logo_h +	$img_h)	/ 2;
						break;
					case 6:
						$x = $img_w - $logo_w;
						$y = ($logo_h +	$img_h)	/ 2;
						break;
					case 7:
						$x = +5;
						$y = $img_h - $logo_h-5;
						break;
					case 8:
						$x = ($logo_w +	$img_w)	/ 2;
						$y = $img_h - $logo_h;
						break;
					case 9:
						$x = $img_w - $logo_w-5;
						$y = $img_h - $logo_h-5;
						break;
				}

				imageAlphaBlending($watermark_logo, FALSE);
				imagesavealpha($watermark_logo,TRUE);
				imageCopyMerge($dst_photo, $watermark_logo, $x,	$y, 0, 0, $logo_w, $logo_h, $watermarktrans);

				switch($attachinfo['mime']) {
					case 'image/jpeg':
						imageJPEG($dst_photo, $target);
						break;
					case 'image/gif':
						imageGIF($dst_photo, $target);
						break;
					case 'image/png':
						imagePNG($dst_photo, $target);
						break;
				}
			}
		}
	}
	
	//裁剪图片
	public function thumb($forcedwidth, $forcedheight, $sourcefile, $destfile, $destext, $imgcomp = 0) {
        
		$g_imgcomp=100-$imgcomp;
		$g_srcfile=$sourcefile;
		$g_dstfile=$destfile;
		$g_fw=$forcedwidth;
		$g_fh=$forcedheight;
		$ext = strtolower(substr(strrchr($sourcefile, '.'), 1, 10));
        
		//if($ext == 'bmp'){
			//$g_srcfile = $this->ImageCreateFromBMP( $sourcefile);
			//$ext = strtolower(substr(strrchr($g_srcfile, '.'), 1, 10));
		//}
		//var_dump($g_srcfile);exit;

		if(file_exists($g_srcfile)) {
			$g_is = getimagesize($g_srcfile);
			if($g_is[0] < $forcedwidth && $g_is[1] < $forcedheight) {
				copy($sourcefile, $destfile);
				return filesize($destfile);
			}
			if (($g_is[0] - $g_fw) >= ($g_is[1] - $g_fh)){
				$g_iw=$g_fw;
				$g_ih=($g_fw/$g_is[0])*$g_is[1];
			} else {
				$g_ih=$g_fh;
				$g_iw=($g_ih/$g_is[1])*$g_is[0];
			}
             
			switch ($ext) {
				case 'jpg':
				case 'jpeg':
				case 'pjpeg':
					$img_src = imagecreatefromjpeg($g_srcfile);
					!$img_src && $img_src = imagecreatefromgif($g_srcfile);
					break;
				case 'gif':
					$img_src = imagecreatefromgif($g_srcfile);
					break;
				case 'png':
					$img_src = imagecreatefrompng($g_srcfile);
					break;
			}
			$img_dst = imagecreatetruecolor($g_iw, $g_ih);
			imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $g_iw, $g_ih, $g_is[0], $g_is[1]);
			switch($destext) {
				case 'jpg':
				case 'jpeg':
				case 'pjpeg':
					imagejpeg($img_dst, $g_dstfile, $g_imgcomp);
					break;
				case 'gif':
					imagegif($img_dst, $g_dstfile, $g_imgcomp);
					break;
				case 'png':
					imagepng($img_dst, $g_dstfile);
					break;
				//case 'bmp':
				//	imagejpeg( $mi , $dst_img ,$g_imgcomp);
				//	imagedestroy($mi);//释放内存
			}
			imagedestroy($img_dst);
			return filesize($destfile);
		} else {
			return false;
		}
	}
	
	private function copy($sourcefile, $destfile) {
		if($this->is_copy){
			$rs = copy($sourcefile, $destfile);
		} else {
			$rs = move_uploaded_file($sourcefile, $destfile);
		}
		//$this->is_copy = false;
		//@unlink($sourcefile);
		return $rs;
	}
	
	private function fileext($filename) {
		return substr(strrchr($filename, '.'), 1, 10);
	}
	
	private function get_filetype($ext) {
		foreach($this->filetypedata as $k => $v) {
			if(in_array($ext, $v)) {
				return $k;
			}
		}
		return 'common';
	}
	
	public function check_filetype($file_name) {
		//判断文件类型
		$fileext = strtolower($this->fileext($file_name));
		if(!in_array($fileext, $this->filetypes)) {
			$fileext = '_'.$fileext;
			$this->error_msg = 'wrong file type';
			return false;
		}
		return true;
	}
	
	private function ImageCreateFromBMP($filename){
		// Ouverture du fichier en mode binaire
		if ( ! $f1 = fopen ( $filename , "rb" )) return FALSE ;
		
		// 1 : Chargement des ent�tes FICHIER
		$FILE = unpack ( "vfile_type/Vfile_size/Vreserved/Vbitmap_offset" , fread ( $f1 , 14 ));
		if ( $FILE [ 'file_type' ] != 19778 ) return FALSE ;
		
		// 2 : Chargement des ent�tes BMP
		$BMP = unpack ( 'Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' . '/Vcompression/Vsize_bitmap/Vhoriz_resolution' .
		'/Vvert_resolution/Vcolors_used/Vcolors_important' , fread ( $f1 , 40 ));
		$BMP [ 'colors' ] = pow ( 2 , $BMP [ 'bits_per_pixel' ]);
		if ( $BMP [ 'size_bitmap' ] == 0 ) $BMP [ 'size_bitmap' ] = $FILE [ 'file_size' ] - $FILE [ 'bitmap_offset' ];
		$BMP [ 'bytes_per_pixel' ] = $BMP [ 'bits_per_pixel' ] / 8 ;
		$BMP [ 'bytes_per_pixel2' ] = ceil ( $BMP [ 'bytes_per_pixel' ]);
		$BMP [ 'decal' ] = ( $BMP [ 'width' ] * $BMP [ 'bytes_per_pixel' ] / 4 );
		$BMP [ 'decal' ] -= floor ( $BMP [ 'width' ] * $BMP [ 'bytes_per_pixel' ] / 4 );
		$BMP [ 'decal' ] = 4 - ( 4 * $BMP [ 'decal' ]);
		if ( $BMP [ 'decal' ] == 4 ) $BMP [ 'decal' ] = 0 ;
		
		// 3 : Chargement des couleurs de la palette
		$PALETTE = array ();
		if ( $BMP [ 'colors' ] < 16777216 ){
			$PALETTE = unpack ( 'V' . $BMP [ 'colors' ] , fread ( $f1 , $BMP [ 'colors' ] * 4 ));
		}
		// 4 : Cr�ation de l'image
		$IMG = fread ( $f1 , $BMP [ 'size_bitmap' ]);
		$VIDE = chr ( 0 );
		$res = imagecreatetruecolor( $BMP [ 'width' ] , $BMP [ 'height' ]);
		$P = 0 ;
		$Y = $BMP [ 'height' ] - 1 ;

		while ( $Y >= 0 ){
			$X = 0 ;
			while ( $X < $BMP [ 'width' ]){
				if ( $BMP [ 'bits_per_pixel' ] == 24 ){
					$COLOR = unpack ( "V" , substr ( $IMG , $P , 3 ) . $VIDE );
				}
				elseif ( $BMP [ 'bits_per_pixel' ] == 16 ){
					$COLOR = unpack ( "n" , substr ( $IMG , $P , 2 ));
					$COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
				}
				elseif ( $BMP [ 'bits_per_pixel' ] == 8 ){
					$COLOR = unpack ( "n" , $VIDE . substr ( $IMG , $P , 1 ));
					$COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
				}
				elseif ( $BMP [ 'bits_per_pixel' ] == 4 ){
					$COLOR = unpack ( "n" , $VIDE . substr ( $IMG , floor ( $P ) , 1 ));
					if (( $P * 2 ) % 2 == 0 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] >> 4 ) ; else $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x0F );
					$COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
				}
				elseif ( $BMP [ 'bits_per_pixel' ] == 1 ){
					$COLOR = unpack ( "n" , $VIDE . substr ( $IMG , floor ( $P ) , 1 ));
					if (( $P * 8 ) % 8 == 0 ) $COLOR [ 1 ] = $COLOR [ 1 ] >> 7 ;
					elseif (( $P * 8 ) % 8 == 1 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x40 ) >> 6 ;
					elseif (( $P * 8 ) % 8 == 2 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x20 ) >> 5 ;
					elseif (( $P * 8 ) % 8 == 3 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x10 ) >> 4 ;
					elseif (( $P * 8 ) % 8 == 4 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x8 ) >> 3 ;
					elseif (( $P * 8 ) % 8 == 5 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x4 ) >> 2 ;
					elseif (( $P * 8 ) % 8 == 6 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x2 ) >> 1 ;
					elseif (( $P * 8 ) % 8 == 7 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x1 );
					$COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
				}
				else{
					return FALSE ;
				}
				imagesetpixel( $res , $X , $Y , $COLOR [ 1 ]);
				$X ++ ;
				$P += $BMP [ 'bytes_per_pixel' ];
			}
			$Y -- ;
			$P += $BMP [ 'decal' ];
		}
		// Fermeture du fichier
		fclose ( $f1 );
		return $res ;
	}

	/*
	 * 注：文件类型的编码目前不全，期待逐步完善
	 */
	private function get_file_type_forbinary($file_binary){
		if(!$file_binary) {
			return 'unknown';
		}
		$str_info  = @unpack("C2chars", $file_binary);
		$type_code = intval($str_info['chars1'].$str_info['chars2']);
		$file_type = '';
		switch ($type_code) {
			case '7790':
				$file_type = 'exe';
				break;
			case '7784':
				$file_type = 'midi';
				break;
			case '8075':
				$file_type = 'zip';
				break;
			case '8297':
				$file_type = 'rar';
				break;
			case '255216':
				$file_type = 'jpg';
				break;
			case '7173':
				$file_type = 'gif';
				break;
			case '6677':
				$file_type = 'bmp';
				break;
			case '13780':
				$file_type = 'png';
				break;
			default:
				$file_type = 'unknown';
				break;
		}
		return $file_type;
	}
}
