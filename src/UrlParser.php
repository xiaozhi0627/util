<?php
/**
 * User: hidehalo
 * Date: 2016/12/2
 * Time: 17:40
 */

namespace Gwantsi\Utils;

class UrlParser
{
    protected static $host;
    protected static $path;
    protected static $query;
    protected static $scheme;

    public static function parse($url)
    {
        $result = parse_url($url);
        if(!$result){
            return false;
        }
        self::$host = $result['host'];
        self::$path = $result['path'];
        self::$scheme = $result['scheme'];
        parse_str($result['query'],self::$query);
        return true;
    }

    public static function getPath()
    {
        return self::$path;
    }

    public static function getHost()
    {
        return self::$host;
    }

    public  static  function  getScheme()
    {
        return self::$scheme;
    }

    public static function getParam($name,$default=null)
    {
        return @self::$query[$name]?self::$query[$name]:$default;
    }
}