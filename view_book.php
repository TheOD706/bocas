<?php
session_start();
    if(isset($_POST['captcha']))
    {
        $cap = (strtolower(urldecode($_POST['captcha'])) == strtolower($_SESSION['captcha']));
    }
    else
    {
        $cap = false; // no code
    }
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$field = $_POST["field"]; 
	$page = urldecode($_POST["page"]);
	$direction = $_POST["direction"];
	$record = null;
	echo "<table class='result'><tr><th id='namecell' onclick='sort(this)'";
	if($field == "name") echo " class='sort'";
	if($field == "name_reverse") echo " class='sort_reverse'";
	echo ">Name";
	if($field == "name") echo " &#x25BC;";
	if($field == "name_reverse") echo " &#x25B2;";
	echo "</th><th id='emailcell' onclick='sort(this)'";
	if($field == "email") echo " class='sort'";
	if($field == "email_reverse") echo " class='sort_reverse'";
	echo ">E-mail";
	if($field == "email") echo " &#x25BC;";
	if($field == "email_reverse") echo " &#x25B2;";
	echo "</th><th>Site</th><th id='datecell' onclick='sort(this)'";
	if($field == "date") echo " class='sort'";
	if($field == "date_reverse") echo " class='sort_reverse'";
	echo ">Post date";
	if($field == "date") echo " &#x25BC;";
	if($field == "date_reverse") echo " &#x25B2;";
	echo "</th><th>Message</th></tr>";
	
	if($field == "current"){
		if($cap == true) {
			$name = urldecode($_POST["name"]);
			$email = urldecode($_POST["email"]);
			$site = urldecode($_POST["site"]);
			$message = urldecode($_POST["message"]);
			//$ip = $_SERVER["REMOTE_ADDR"]; it don't work - show server ip
			$ip = urldecode($_POST["ip"]);
			$browser = $_SERVER["HTTP_USER_AGENT"];
			$date = urldecode(date("Y-m-d H:i:s"));
			require_once 'model_Record.php';
			$record = new Record(0, $name, $email, $site, $message, $date, $ip, $browser);
			require_once 'controller_book.php';
			$book = new Book();
			$result = $book->addRecord($record);
		}
	}
	
	$pagenumber = print_book_list($field, $page, $direction, $record);
	
	//finish table
	echo "</table><div id='page_controller'><button class='page' onclick='gopage(\"first\")'>";
	echo "&#10074;&#9668;</button><button class='page' onclick='gopage(\"prew\")'>&#9668;</button>";
	echo "<button class='page' onclick='gopage(\"current\")'>&#9673;</button>";
	echo "<input type='text' id='page_current' value='";
	echo $pagenumber["cur"];
	echo "' onkeyup=\"this.style.width =(Math.min(300,(this.value.length)*8+34))+'px';\" style='width: ";
	echo strlen($pagenumber["cur"]) * 8 + 34;
	echo "px'>/<span id='maxpage'>";
	echo $pagenumber["max"];
	echo "</span><button class='page' onclick='gopage(\"next\")'>&#9658;</button>";
	echo "<button class='page' onclick='gopage(\"last\")'>&#9658;&#10074;</button></div>";
}

function print_req($field, $direct, $page, $pagedirection){
	require_once 'controller_book.php';
	$book = new Book();
	$result = $book->showBook($field, $direct);

	$maxpage = ceil($result["count"] / 5);
	$page = 0 + $page;
	switch ($pagedirection){
		case "first": $page = 1; break;
		case "last": $page = $maxpage; break;
		case "prew": $page -= 1; break;
		case "next": $page += 1; break;
	}
	if($page < 1) $page = 1;
	if($page > $maxpage) $page = $maxpage;

	$startfrom = ($page - 1) * 5;

	//print table content
	for ($i = $startfrom; $i < $startfrom + 5; ++$i){
		$rec = $result[$i];
		if($rec == null) continue;
		echo "<tr><td>";
		echo $rec->getName();
		echo "</td><td>";
		echo $rec->getEmail();
		echo "</td><td>";
		echo $rec->getSite();
		echo "</td><td>";
		echo $rec->getDate();
		echo "</td><td>";
		echo $rec->getMessage();
		echo "</td></tr>";
	}
	$pagenumber["cur"] = $page;
	$pagenumber["max"] = $maxpage;
	return $pagenumber;
}

function print_book_list($field, $page, $direction, $record){
	$pagenumber = array("cur"=>"1", "max"=>"1");
	switch ($field){
		case "current"://show current added row
			if($record == null) return array("cur"=>"0", "max"=>"0");
			echo "<tr><td>";
			echo $record->getName();
			echo "</td><td>";
			echo $record->getEmail();
			echo "</td><td>";
			echo $record->getSite();
			echo "</td><td>";
			echo $record->getDate();
			echo "</td><td>";
			echo $record->getMessage();
			echo "</td></tr>";
			break;
		case "name":
			$pagenumber = print_req("name", "ASC", $page, $direction);
			break;
		case "name_reverse":
			$pagenumber = print_req("name", "DESC", $page, $direction);
			break;
		case "email":
			$pagenumber = print_req("email", "ASC", $page, $direction);
			break;
		case "email_reverse":
			$pagenumber = print_req("email", "DESC", $page, $direction);
			break;
		case "date":
			$pagenumber = print_req("posttime", "ASC", $page, $direction);
			break;
		case "":
			$pagenumber = print_req("posttime", "ASC", $page, $direction);
			break;
		case "date_reverse":
			$pagenumber = print_req("posttime", "DESC", $page, $direction);
			break;
	}
	return $pagenumber;
}
?>