/**
 * 
 */
var color = "#";
for(var i = 0; i<3; ++i){
	if(Math.random() > 0.5) color += "ff";
	else color += "80";
}
document.body.style.background = color;
			
showAll();

function showAll(){
	sendRequest("view_moderator.php", "action=showAll", "list");
}


function sendRequest(target, data, result){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById(result).innerHTML = xhttp.responseText;
			if(xhttp.responseText.substring(17, 30) == "data has been"){//refresh data table
				showAll();
			}
		}
	};
	xhttp.open("POST", target, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(data);
}

function itemEdit(item){
	sendRequest("view_moderator.php", "action=showOne&id=" + item, "result");
}

function change(id){
	var name = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	var site = document.getElementById("site").value;
	var message = document.getElementById("message").value;
	var date = document.getElementById("date").value;
	var ip = document.getElementById("ip").value;
	var browser = document.getElementById("browser").value;
	var data = "action=edit&id="+id+"&name="+name+"&email="+email+"&site="+site+"&message="+
		message+"&date="+date+"&ip="+ip+"&browser="+browser;
	sendRequest("view_moderator.php", data, "result");
}

function itemRemove(item){
	sendRequest("view_moderator.php", "action=remove&id=" + item, "result");
}