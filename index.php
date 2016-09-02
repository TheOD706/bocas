<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1251">
<title>Book of complaints and suggestions</title>
<link rel="stylesheet" type="text/css" href="./styles/main_style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
		<tr><td>Name:</td><td><input id="name" type="text" onkeyup="checkLength(this)">
		<span id = "fillname">*</span></td></tr>
		<tr><td>E-mail:</td><td><input id="email" type="text" onkeyup="checkLength(this)">
		<span id = "fillemail">*</span></td></tr>
		<tr><td>Site:</td><td><input id="site" type="text" onkeyup="checkLength(this)">
		<span id = "fillsite"></span></td></tr>
		<tr><td>Message:</td><td><textarea rows="5" cols="30" id="message" 
		 onkeyup="checkLength(this)"></textarea><span id = "fillmessage"></span></td></tr>
		<tr><td>Captcha:<button onclick='refreshCaptcha()'>Refresh captcha</button></td>
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
		var ip = "";
		var req_param = [];

		$(document).ready(function () {
		    $.getJSON("http://jsonip.com/?callback=?", function (data) {
		        ip = data.ip;
		    });
		});
	
		function addRecord(){
			document.getElementById("fillcaptcha").innerHTML = "*";
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
			if(!validateEmail(document.getElementById("email").value)){
				fill = false;
				document.getElementById("fillemail").innerHTML = "Incorect email";
			} else {document.getElementById("fillemail").innerHTML = "*";}
			if(fill){
				var site = encodeURIComponent(document.getElementById("site").value);
				var message = encodeURIComponent(document.getElementById("message").value);
				var captcha = encodeURIComponent(document.getElementById("captcha_value").value);
				var data = "field=current&name="+name+"&email="+email+"&site="+site+
					"&message=" +message+"&captcha="+captcha+"&ip="+ip;				
				sendRequest("view_book.php", data)
				req_param["name"] = document.getElementById("name").value;
				req_param["email"] = document.getElementById("email").value;
				req_param["site"] = document.getElementById("site").value;
				req_param["message"] = document.getElementById("message").value;
				document.getElementById("name").value = "";
				document.getElementById("email").value = "";
				document.getElementById("site").value = "";
				document.getElementById("message").value = "";
				document.getElementById("captcha_value").value = "";
			}
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
					if(document.getElementById("maxpage").innerHTML == "0"){
						document.getElementById("fillcaptcha").innerHTML = "invalid captcha";
						document.getElementById("name").value = req_param["name"];
						document.getElementById("email").value = req_param["email"];
						document.getElementById("site").value = req_param["site"];
						document.getElementById("message").value = req_param["message"];
					}
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

		function validateEmail(email) {
		    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		    return re.test(email);
		}

		function checkLength(item){
			var id = item.id;
			var maxl = 0;
			switch(id){
			case "name": maxl = 75; break;
			case "email": maxl = 50; break;
			case "site": maxl = 50; break;
			case "message": maxl = 1000; break;
			}
			if(item.value.length > maxl){
				document.getElementById("fill"+id).innerHTML="Value is to long. Max length is " 
					+ maxl + ". Overwrited part will be ignored";
				 ;
			} else {
				if(id=="name" || id=="email") document.getElementById("fill"+id).innerHTML="*";
				else document.getElementById("fill"+id).innerHTML="";
			}			
		}
	</script>
</body>
</html>