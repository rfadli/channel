<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('DOCVIEW', DOCROOT."view".DIRECTORY_SEPARATOR);
define('BASE_URL', "https://".$_SERVER['HTTP_HOST']."/");
//require_once (DOCROOT."lib/db/MysqliDb.php");
//include_once(DOCROOT."lib/chilkat/chilkat_9_5_0.php");

function __autoload($class_name) {
	$s = explode("_", $class_name);
	if(count($s) == 1)
	{
		if(file_exists(DOCROOT."/classes/".$class_name . '.php'))
		{
	    	include DOCROOT."/classes/".$class_name . '.php';
		}
		else if(file_exists(DOCROOT."/lib/".$class_name . '.php'))
		{
			include DOCROOT."/lib/".$class_name . '.php';
		}
	}
	else {
		if(file_exists(DOCROOT."/classes/".$s[1]."/".$s[0] . '.php'))
		{
			include DOCROOT."/classes/".$s[1]."/".$s[0] . '.php';
		}
	}
	
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if($path == "/")
{
	$r = new welcome_controller();
	$r->index();
}
else {
	$adacontent = false;
	$pp = explode("/", $path);
	if(count($pp) > 2)
	{
		if (class_exists($pp[1].'_controller')) {
			$rr = $pp[1].'_controller';
			$r = new $rr();
			if(method_exists($r, $pp[2]))
			{
				$r->$pp[2]();
				$adacontent = true;
			}
		}
	}
	if(!$adacontent)
	{
		echo "not Found";
	}
}		