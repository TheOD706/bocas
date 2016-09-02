<?php
	class Record{
		var $id;
		var $name;
		var $email;
		var $site;
		var $message;
		var $date;
		var $ip;
		var $browser;
		
		function __construct($_id, $_name, $_email, $_site, $_message, $_date, $_ip, $_browser){
			$this->id = $_id;
			$this->name = $_name;
			$this->email = $_email;
			$this->site = $_site;
			$this->message = $_message;
			$this->date = $_date;
			$this->ip = $_ip;
			$this->browser = $_browser;
		}
		
		function getId(){
			return $this->id;
		}
		function getName(){
			return $this->name;
		}
		function setName($_name){
			$this->name = $_name;
		}
		function getEmail(){
			return $this->email;
		}
		function setEmail($_email){
			$this->email = $_email;
		}
		function getSite(){
			return $this->site;
		}
		function setSite($_site){
			$this->site = $_site;
		}
		function getMessage(){
			return $this->message;
		}
		function setMessage($_message){
			$this->message = $_message;
		}
		function getDate(){
			return $this->date;
		}
		function setDate($_date){
			$this->date = $_date;
		}
		function getIP(){
			return $this->ip;
		}
		function setIP($_ip){
			$this->ip = $_ip;
		}
		function getBrowser(){
			return $this->browser;
		}
		function setBrowser($_browser){
			$this->browser = $_browser;
		}
		
	}
?>