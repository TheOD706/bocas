<?php
	class Book{
		
		var $dbm;
		var $sql;
		
		function __construct(){
			require_once 'controller_DB.php';
			$dbm = new DBManager();			
		}
		
		function showBook($field, $direct){
			$dbm = new DBManager();			
			$sql = "SELECT * FROM Book ORDER BY ".$field." ".$direct;
			$result = $dbm->execute($sql, "Record");
			return $result;
		}
		
		function addRecord($record){
			$dbm = new DBManager();			
			$sql = "INSERT INTO Book (name, email, site, message, posttime, ip, browser) 
				VALUES ('".$record->getName()."', '".$record->getEmail()."', '".
				$record->getSite()."', '".$record->getMessage()."', '".$record->getDate().
				"', '".$record->getIp()."', '".$record->getBrowser()."');";
			$result = $dbm->execute($sql, "Record");
			return $result;
		}
		
	}
?>