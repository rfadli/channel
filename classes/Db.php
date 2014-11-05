<?php

class Db{
	private static $dbs;
	
	public static function init() {
        if (self::$dbs == null)
		{
			$db = new Mysqlidb('127.0.0.1', 'root', 'c1mah1', 'pureftpd');
			if(!$db) die("Database error");
				
			self::$dbs = $db;
		}
        return self::$dbs;
    }
}