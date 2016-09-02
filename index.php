<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1251">
<title>Book of complaints and suggestions</title>
<link rel="stylesheet" type="text/css" href="./styles/main_style.css">
</head>
<body>
	<div id="main_content">
	<!-- header -->
	<div class="header">
		<h1>Book of complaints and suggestions</h1>
		<a href="moderate.php">moderator page</a>
	</div>
	<!-- form add -->
	<div class="add_form"><table>
		<tr><td>Name:</td><td><input id="name" type="text"><span id = "fillname">*</span></td></tr>
		<tr><td>E-mail:</td><td><input id="email" type="text"><span id = "fillemail">*</span></td></tr>
		<tr><td>Site:</td><td><input id="site" type="text"></td></tr>
		<tr><td>Message:</td><td><textarea rows="5" cols="30" id="message"></textarea></td></tr>
		<tr><td>Capcha:<button onclick='refreshCaptcha()'>Refresh captcha</button></td>
		<td><img id="captcha" alt="" src="/captcha/newCaptcha.php">
		<input id="captcha_value" type="text"><span id = "fillcaptcha">*</span></td></tr>
		<tr><td></td><td><button onclick="addRecord()">Add</button></td></tr>
	</table></div>
	<!-- table -->
	<div id="result_table">
		<button onclick="showRecords()">Show book records</button>
	</div>
	<!-- footer -->
	<div class="footer">
		<h3>Created by Oleh Dzianyi</h3>
	</div>
	</div>
	<script type="text/javascript">
		var field_sort = "";
	
		function addRecord(){
			var fill = true;
			var name = encodeURIComponent(document.getElementById("name").value);
			var email = encodeURIComponent(document.getElementById("email").value);
			if(name == ""){
				fill = false;
				document.getElementById("fillname").innerHTML = "Required to fill";
			} else {document.getElementById("fillname").innerHTML = "*";}
			if(email == ""){
				fill = false;
				document.getElementById("fillemail").innerHTML = "Required to fill";
			} else {document.getElementById("fillemail").innerHTML = "*";}
			if(fill){
				var site = encodeURIComponent(document.getElementById("site").value);
				var message = encodeURIComponent(document.getElementById("message").value);
				var captcha = encodeURIComponent(document.getElementById("captcha_value").value);
				var data = "field=current&name="+name+"&email="+email+"&site="+site+
					"&message=" +message+"&captcha="+captcha;				
				sendRequest("view_book.php", data)
			}
			document.getElementById("name").value = "";
			document.getElementById("email").value = "";
			document.getElementById("site").value = "";
			document.getElementById("message").value = "";
			document.getElementById("captcha_value").value = "";
		}

		function showRecords(){
			sendRequest("view_book.php", "field=&page=1");//default sort parameter
		}
		showRecords();//run on first page load

		function sendRequest(target, data){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					document.getElementById("result_table").innerHTML = xhttp.responseText;
					if(document.getElementById("maxpage").innerHTML == "0")
						document.getElementById("fillcaptcha").innerHTML = "invalid capcha";
					refreshCaptcha();
				}
			};
			xhttp.open("POST", target, true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(data);
		}

		function sort(cell) {
			field_sort = sortdirection(cell.id);
			var vpage = document.getElementById("page_current").value;
			sendRequest("view_book.php", "field=" + field_sort + "&page=" + vpage + "&direction=current");
		}

		function sortdirection(dir){
			dir = dir.replace("cell","");
			if(field_sort == dir){
				 dir = dir + "_reverse";
			}
			return dir;
		}

		function gopage(direction){
			var vpage = encodeURIComponent(document.getElementById("page_current").value);
			var data = "field=" + field_sort + "&page=" + vpage + "&direction=" + direction;
			sendRequest("view_book.php", data);
		}

		function refreshCaptcha(){
			document.getElementById("captcha").src = "/captcha/newCaptcha.php?rnd=" + Math.random();
		}

		function checkCaptcha(){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					alert(xhttp.responseText);
					//return xhttp.responseText;
				}
			};
			xhttp.open("GET", "captcha/checkCaptcha.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send();
		}
	</script>
</body>
</html>