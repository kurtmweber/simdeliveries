<?php
	require_once("Config.inc.php");
	
	function GetDatabaseConn(){
		static $conn = false;
		
		if ($conn === false){
			$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
			if ($conn->connect_errno){
				printf("mySQL error: %s\n", $conn->connect_error);
				exit();
				}
			}
			
		return $conn;
		}
?>