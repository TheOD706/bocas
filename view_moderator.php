<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		require_once 'controller_moderator.php';
		switch ($_POST["action"]){
			case "showAll":
				$m = new Moderator();
				$result = $m->showAll();
				echo "<h2>Book List</h2><table style='border:1px solid black; width:100%;'>";
				echo "<tr><th>ID</th><th>Name</th><th>E-mail</th><th>Site</th><th>Message</th>";
				echo "<th>Date</th><th>IP</th><th>Browser</th><th>Edit</th><th>Remove</th></tr>";
				for($i = 0; $i < $result["count"]; ++$i){
					echo "<tr><td>";
					echo $result[$i]->getId();
					echo "</td><td>";
					echo $result[$i]->getName();
					echo "</td><td>";
					echo $result[$i]->getEmail();
					echo "</td><td>";
					echo $result[$i]->getSite();
					echo "</td><td>";
					echo $result[$i]->getMessage();
					echo "</td><td>";
					echo $result[$i]->getDate();
					echo "</td><td>";
					echo $result[$i]->getIP();
					echo "</td><td>";
					echo $result[$i]->getBrowser();
					echo "</td><td><button onclick='itemEdit(";
					echo $result[$i]->getId();
					echo ");'>Edit</button></td><td><button onclick='itemRemove(";
					echo $result[$i]->getId();
					echo ");'>Remove</button></td></tr>";
				}
				echo "</table>";
				break;
			case "showOne":
				$m = new Moderator();
				$id = $_POST["id"];
				$result = $m->showOne($id);
				if($result["count"] == 1){//print edit item form
					$r = $result[0];
					echo "<h2>Results</h2><div>ID: ";
					echo $r->getId();
					echo "<br>Name:<input id='name' value='";
					echo $r->getName();
					echo "'><br>E-mail:<input id='email' value='";
					echo $r->getEmail();
					echo "'><br>Site:<input id='site' value='";
					echo $r->getSite();
					echo "'><br>Message:<input id='message' value='";
					echo $r->getMessage();
					echo "'><br>Date:<input id='date' value='";
					echo $r->getDate();
					echo "'><br>IP:<input id='ip' value='";
					echo $r->getIP();
					echo "'><br>Browser:<input id='browser' value='";
					echo $r->getBrowser();
					echo "'><br><button onclick='change(";
					echo $r->getId();
					echo ")'>Accept change</button></div>";
				}
				break;
			case "edit":
				$m = new Moderator();
				$id = $_POST["id"];
				$name = $_POST["name"];
				$email = $_POST["email"];
				$site = $_POST["site"];
				$message = $_POST["message"];
				$date = $_POST["date"];
				$ip = $_POST["ip"];
				$browser = $_POST["browser"];
				$result = $m->edit($id, $name, $email, $site, $message, $date, $ip, $browser);
				echo "<h2>Results</h2> data has been changed";
				echo $result;
				break;
			case "remove":
				$m = new Moderator();
				$id = $_POST["id"];
				$m->remove($id);
				echo "<h2>Results</h2> data has been removed";
				echo $result;
				break;
		}
	}
?>