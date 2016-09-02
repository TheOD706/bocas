<?php
	class DBManager{
		
		function execute($sql, $class){
			include 'DB.php';
			$resarray["count"] = $result->num_rows;
			require_once 'model_'.$class.'.php';
			for($i = 0; $i < $result->num_rows; ++$i){
				if($row = $result->fetch_assoc()){
					switch ($class){
						case "Record":
							$resarray[$i] = new Record($row["id"], $row["name"], $row["email"], 
									$row["site"], $row["message"], $row["posttime"], $row["ip"], 
									$row["browser"]);
							break;						
					}					
				} 
			}
			return $resarray;
		}
		
	}
?>