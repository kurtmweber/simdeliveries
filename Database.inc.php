<?php
	require_once("Config.inc.php");
	
	function GetDatabaseConn(){
		static $conn = false;
		
		if ($conn === false){
			$conn = new mysqli($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_USER_PASS'], $_SERVER['DB_NAME']);
			if ($conn->connect_errno){
				printf("mySQL error: %s\n", $conn->connect_error);
				exit();
				}
			}
			
		return $conn;
		}
?>