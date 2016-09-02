<?php
	$db_param = parse_ini_file("DB.ini", true);
	$host = $_SERVER["HTTP_HOST"];
	$servername = $db_param[$host]["servername"];
	$username = $db_param[$host]["username"];
	$password = $db_param[$host]["password"];
	$dbname = $db_param[$host]["dbname"];
	
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