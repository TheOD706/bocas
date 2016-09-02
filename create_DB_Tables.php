<?php

class DBTableCreator{
	
	function create(){
		$sql = "CREATE TABLE IF NOT EXISTS Book (id int PRIMARY KEY AUTO_INCREMENT,
			name varchar(75) NOT NULL, email varchar(50) NOT NULL,
			site varchar(50), message varchar(1000), posttime datetime,
			ip varchar(25), browser varchar(50));";
		include 'DB.php';
		return  $result;
	}
	
	function remove(){
		$sql = "DROP TABLE Book";
		include 'DB.php';
		return  $result;
	}	
	
}

	
?>