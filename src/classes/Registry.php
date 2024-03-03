<?php
namespace Fileupload\Classes;

class Registry
{ 
	public static $_storage = array(); 
    
    public static function set($value) {
		self::$_storage[] = $value;
	}
	public static function getAll()
	{
		return self::$_storage;
	}
 
	public static function clean()
	{
		self::$_storage = array(); 
		return true;
	}
}
