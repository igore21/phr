<?php
define('DB_CONN_STRING', 'mysql:host=localhost;dbname=test;charset=utf8');
define('DB_USER',        'root');
define('DB_PASS',        '');


class DB {
	
	private static function getDB() {
		static $db = null;
		if($db == null) {
			$db = new PDO(DB_CONN_STRING, DB_USER, DB_PASS);
		}
		return $db;
	}
	
	public static function getRes() {
		$result = array();
		$db = self::getDB();
		$stm = $db->prepare('select * from proba2');
		if ($stm->execute()) {
			$result = $stm->fetchAll();
		}
		return $result;
	}
}