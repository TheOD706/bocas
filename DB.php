<?php
	$db_param = parse_ini_file("DB.ini");
	$servername = $db_param["servername"];
	$username = $db_param["username"];
	$password = $db_param["password"];
	$dbname = $db_param["dbname"];
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
	$result = $conn->query($sql);
	
	/*if ($result === TRUE) {
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}*/
	
	$conn->close();
 ?>