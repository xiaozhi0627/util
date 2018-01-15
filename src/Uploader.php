<?php

namespace Gwantsi\Utils;

use Gwantsi\Utils\Upload;
    
class Uploader extends Upload
{
    protected $path;
    protected $url;
    protected $small;
    protected $medium;
    protected $large;
    protected $fileDomain;
    protected $maxWidth = 1920;
    protected $maxHeight = 1080;

    public function __construct($fileDomain)
    {
        $this->fileDomain = $fileDomain;
    }
    
    public function setFileDomain($fileDomain)
    {
        $this->fileDomain = $fileDomain;
    }

    public function setMax($width,$height)
    {
        $this->maxWidth = $width;
        $this->maxHeight = $height;
    }
    
    /**
     * 检测目录是否存在,不存在则创建,无法创建则抛出异常,检测结果是布尔型
     * @param  string  $path 路径
     * @return boolean true|false
     * @exception \Exception
     */
    protected function parseDir($path)
    {
        $this->url = $path;
        $path = $this->fileDomain.'/'.$path;
        if(!is_writable($this->fileDomain)){
            return false;
        }elseif(!is_dir($path)){
            $ok = @mkdir($path,0755,1); 
        }
        return $path;
    }
    /**
     * 设置上传路径
     * @param  string $path 上传路径
     * @return \Comn\Utils\Uploader $this
     */
    public function setPath($path)
    {
        if(!($path = $this->parseDir($path))) {
            throw new \Exception('Invaulid directory',2101);
        }
        $this->path = $path; 
        return $this;
    }
    /**
     * 设置裁剪小图尺寸
     * @param  integer $width  小图宽
     * @param integer $height   小图高
     * @return \Comn\Utils\Uploader $this
     */
    public function setSmall($width,$height)
    {
        $this->small['width'] = $width;
        $this->small['height'] = $height;
        return $this;
    }
     /**
     * 设置裁剪中图尺寸
     * @param  integer $width  中图宽
     * @param integer $height   中图高
     * @return \Comn\Utils\Uploader $this
     */
    public function setMedium($width,$height)
    {
        $this->medium['width'] = $width;
        $this->medium['height'] = $height;
        return $this;
    }
     /**
     * 设置裁剪大图尺寸
     * @param  integer $width  大图宽
     * @param integer $height   大图高
     * @return \Comn\Utils\Uploader $this
     */
    public function setLarge($width,$height)
    {
        $this->large['width'] = $width;
        $this->large['height'] = $height;
        return $this;
    }
    /**
     * 上传图片,当没设置任何裁剪尺寸时将上传原图
     * @param  \Slim\Http\UploadedFile $image 上传文件对象
     * @return array [
     *                   url_origin=>string,//原图上传后的File URL
     *                   url_small=>string,//小图上传后的File URL
     *                   url_medium=>string,//中图上传后的File URL
     *                   url_large=>string//大图上传后的File URL
     *               ]
     */
    public function uploadImage($image)
    {
        $path = $this->path;
        $this->setFileType('image');
        if(!$this->check_filetype($image->getClientFilename())) return false;
        if(!$this->checkSize($this->large) && !$this->checkSize($this->small) && !$this->checkSize($this->medium)){
            $this->set_copy(false);
            $this->set_dir($path);
            $this->set_filename(md5(uniqid($image->getClientFilename().microtime())));
            $this->set_thumb($this->maxWidth,$this->maxHeight);
            $origin = $this->executeByFile($image);
            $url_origin = $this->url.'/'.$origin;
        }else{
            $this->set_copy(true);
            $this->set_dir($path);
            if($this->checkSize($this->small)) {
                $this->set_thumb($this->small['width'],$this->small['height']);
                $this->set_filename(md5(uniqid($image->getClientFilename().microtime())));
                $small =$this->executeByFile($image);
                $url_small = $this->url.'/'.$small;
            }
            if($this->checkSize($this->medium)) {
                $this->set_thumb($this->medium['width'],$this->medium['height']);
                $this->set_filename(md5(uniqid($image->getClientFilename().microtime())));
                $medium =$this->executeByFile($image);
                $url_medium = $this->url.'/'.$medium;
            }
            if($this->checkSize($this->large)) {
                $this->set_thumb($this->large['width'],$this->large['height']);
                $this->set_filename(md5(uniqid($image->getClientFilename().microtime())));
                $large =$this->executeByFile($image); 
                $url_large = $this->url.'/'.$large;
            }
        }
        $url = array(
            'url_origin' => $url_origin?$url_origin:'',
            'url_small' => $url_small?$url_small:'',
            'url_medium' => $url_medium?$url_medium:'',
            'url_large' => $url_large?$url_large:''
        );
        return $url;
    }

    protected function checkSize($size)
    {
        return (@$size['width'] & @$size['height'])?true:false;
    }
}