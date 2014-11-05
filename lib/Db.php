t
<?php

class Db{
	private static $dbs;
	
	public static function init() {
        if (self::$dbs == null)
		{
			$filename = DOCROOT."digibeat.json";
			$handle = fopen($filename, "r");
			$contents = fread($handle, filesize($filename));
			fclose($handle);
			$dt = json_decode($contents, true);
			
			$server = $dt['mongodb']['host'].": ".$dt['mongodb']['port'];
			$m = new MongoClient($server);		
			self::$dbs = $m->streaming;
		}
        return self::$dbs;
    }
}