<?php
	include_once("Config.inc.php"):
	include_once("Database.inc.php");
	
	class User{
		private $userName = false;
		private $email = false;
		private $admin = false;
		private $userId = false;
		private $dateOfBirth = false;
		private $timeZone = false;
		
		private $modified = false;
		
		function __construct(){
			if (func_num_args() == 5){
				$this->CreateNewUser();
				}
				
			if (func_num_args() == 1){
				$arg = func_get_arg(0);
				if (is_string($arg)){
					$this->userName = $arg;
					}
				if (is_int($arg)){
					$this->userId = $arg;
					}
				}
			}
			
		function CreateNewUser($userName, $password, $ip, $email, $dateOfBirth){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("INSERT INTO users VALUES()");
			}
			
		function __destruct(){
			}
		}
?>