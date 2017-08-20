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
			
		function TestUsernameExists($userName){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT * FROM users WHERE userName = ?")){
				$stmt->bind_param("s", $userName);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows > 0){
					return true;
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
			}
			
		function TestEmailExists($email){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT * FROM users WHERE eMail = ?")){
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows > 0){
					return true;
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
			}
			
		function CreateNewUser($userName, $password, $ip, $email, $dateOfBirth){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("INSERT INTO users VALUES(NULL, ?, ?, FALSE, NULL, NULL, NULL, ?, ?, FALSE, FALSE)")){
				$stmt->bind_param("ssss", $userName, password_hash($password, PASSWORD_DEFAULT), $email, $dateOfBirth);
				$stmt->execute();
				if ($stmt->errno == SQL_ERROR_DUP_ENTRY){
					if ($this->TestUsernameExists($userName)){
						throw new exception("username exists", E_USERNAME_EXISTS);
						}
					if ($this->TestEmailExists($email)){
						throw new exception("email exists", E_EMAIL_EXISTS);
						}
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			$this->userId = $stmt->insert_id;
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("INSERT INTO logins VALUES(NULL, ?, ?, NULL)")){
				$stmt->bind_param("is", $this->userId, $ip);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			$loginId = $stmt->insert_id;
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("UPDATE users SET registration=?, lastLogin=?")){
				$stmt->bind_param("ii", $loginId, $loginId);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("INSERT INTO emailVerification VALUES(NULL, ?, ?)")){
				$random = openssl_random_pseudo_bytes(16);
				$verify = hash("md5", $random, true);
				$verify = bin2hex($verify);
				$stmt->bind_param("is", $this->userId, $verify);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			mail($email, "SimDeliveries Email Verification", $verify, "From: kmw@outwardhosting.com");
				
			return;
			}
			
		function __destruct(){
			}
		}
?>