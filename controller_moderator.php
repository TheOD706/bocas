<?php
	class Moderator{
		
		function __construct(){
			require_once 'controller_DB.php';
		}
		
		function showAll(){
			$dbm = new DBManager();
			$result = $dbm->execute("SELECT * FROM Book", "Record");
			return  $result;
		}
		
		function showOne($id){
			$dbm = new DBManager();
			$sql = "SELECT * FROM Book WHERE id=".$id;
			$result = $dbm->execute($sql, "Record");
			return  $result;
		}
		
		function edit($id, $name, $email, $site, $message, $date, $ip, $browser){
			$dbm = new DBManager();
			$sql = "UPDATE Book SET name='".$name."', email='".$email."', site='".$site.
				"', message='".$message."', posttime='".$date."', ip='".$ip."', browser='".
				$browser."' WHERE id=".$id;
			$result = $dbm->execute($sql, "Record");
		}
		
		function remove($id){
			$dbm = new DBManager();
			$sql = "DELETE FROM Book WHERE id=".$id;
			$result = $dbm->execute($sql, "Record");
		}
		
	}
?>