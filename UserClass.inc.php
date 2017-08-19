<?php
	require_once("Config.inc.php");
	require_once("Database.inc.php");
	
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
				$userName = func_get_arg(0);
				$password = func_get_arg(1);
				$ip = func_get_arg(2);
				$email = func_get_arg(3);
				$dateOfBirth = func_get_arg(4);
				$this->CreateNewUser($userName, $password, $ip, $email, $dateOfBirth);
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
			if ($stmt->prepare("INSERT INTO users VALUES(NULL, ?, ?, FALSE, NULL, NULL, NULL, ?, ?, FALSE)")){
				$stmt->bind_param("ssss", $userName, password_hash($password, PASSWORD_DEFAULT), $email, $dateOfBirth);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", EXCEPTION_PREPARED_STMT_FAILED);
				}
				
			$this->userId = $stmt->insert_id;
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("INSERT INTO logins VALUES(NULL, ?, ?, NULL)")){
				$stmt->bind_param("is", $this->userId, $ip);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", EXCEPTION_PREPARED_STMT_FAILED);
				}
				
			$loginId = $stmt->insert_id;
			
			$stmt = $conn->stmt-insert_id;
			if ($stmt->prepare("UPDATE users SET registration=?, lastLogin=?")){
				$stmt->bind_param("ii", $loginId, $loginId);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", EXCEPTION_PREPARED_STMT_FAILED);
				}
				
			return;
			}
			
		function __destruct(){
			}
		}
?>