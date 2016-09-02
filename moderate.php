<?php 
	session_start();
	echo "<p style='text-align:center;'><a href='index.php' >Back to main page</a></p>";
	echo "<p style='text-align:center;'><a href='moderate.php?log=out'>LogOut</a></p>";
	echo "<style>div{margin:3px 0px;} h2{text-align:center;} table th,td{border:1px solid black;}</style>";
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		if($_GET["log"] == "out"){
			session_unset();
			session_destroy();
		}
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if($_POST["action"] == "Create"){
			require_once 'create_DB_Tables.php';
			$db = new DBTableCreator();
			echo "Tables created = ".$db->create();
		}
		if($_POST["action"] == "Remove"){
			require_once 'create_DB_Tables.php';
			$db = new DBTableCreator();
			echo "Tables removed = ".$db->remove();
		}
		$moder = parse_ini_file("moderator.ini");
		if($_POST["login"] == $moder["login"])
			if($_POST["password"] == $moder["password"]){
				$_SESSION["log"] = "log";
			}
	} 
	if($_SESSION["log"] == "log"){
		echo "<div style='border:3px solid black;'><h2>Create DataBase</h2><form action='";
		echo $_SERVER["PHP_SELF"];
		echo "' method='post'><input type='submit' value='Create' name='action'>";
		echo "<input type='submit' value='Remove' name='action'></form></div>";
		echo "<div style='border:3px solid black;'><h2>Data Base Content</h2>";
		echo "<div id='result' style='border:3px solid black;'><h2>Results</h2></div>";
		echo "<div id='list' style='border:3px solid black;'><h2>Book List</h2></div>";
		
	} else {
		echo "<form method='post' action='";
		echo $_SERVER["PHP_SELF"];
		echo "' style='text-align:center; border:1px solid black; margin: 50px 15%; ";
		echo "border-radius: 50px;'>Login<input name='login'><br>Password";
		echo "<input type='password' name='password'><br>";
		echo "<input type='submit' value='Log In'></form>";
		
	}
	echo "<script type='text/javascript' src='scripts/moderator.js'></script>";
?>
	