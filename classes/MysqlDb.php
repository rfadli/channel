<?php

class MysqlDb{
	private static $dbs;
	
	public static function init() {
        if (self::$dbs == null)
		{
			$db = new Mysqlidb('192.168.89.2', 'root', 'c1mah1', 'pureftpd');
			if(!$db) die("Database error");
				
			self::$dbs = $db;
		}
        return self::$dbs;
    }
}