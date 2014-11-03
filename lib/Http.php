<?php

class Http
{
	private static $http;
	
	public static function init() {
        if (self::$http == null)
		{
			self::$http = new CkHttp();

			$success = self::$http->UnlockComponent('WILLAWHttp_QxVksXRMURBF');
			if ($success != true) {
		    	print $http->lastErrorText() . "\n";
		    	exit;
			}
		}
        return self::$http;
    }
	
	public static function kirimJson($url, $jsonText)
	{
		$req = new CkHttpRequest();
		$http = Http::init();
		$http->AddQuickHeader("Content-Type", "application/json");
		$http->put_AcceptCharset('');
		$http->put_UserAgent('');
		$http->put_AcceptLanguage('');
		$http->put_AllowGzip(false);

		$resp = $http->PostJson($url, $jsonText);
		if (is_null($resp)) {
		    //print $http->lastErrorText() . "\n";
            return "";
		}
		else {
		    //  Display the JSON response.
		    //$str = new CkString;
		    //$resp->get_Header($str);
			//echo $str->getString();
		    return $resp->bodyStr();
		}
	}
	
	public static function getStr($url)
	{
		$http = Http::init();
		$hasil = $http->quickGetStr($url);
		if (is_null($hasil)) {
		    //print $http->lastErrorText() . "\n";
            return "";
		}
		else {
		    //  Display the JSON response.
		    //$str = new CkString;
		    //$resp->get_Header($str);
			//echo $str->getString();
		    return $hasil;
		}
	}        
}