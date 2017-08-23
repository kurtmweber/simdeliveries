<?php
	require_once("Config.inc.php");
	require_once("Database.inc.php");
	
	class User{
		private $userName = false;
		private $email = false;
		private $admin = null;
		private $userId = false;
		private $dateOfBirth = false;
		private $timeZone = false;
		private $loginId = false;
		
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
					try {
						$this->userId = $this->GetUserId();
						} catch (Exception $e){
						$this->userId = null;
						}
					}
				if (is_int($arg)){
					$this->userId = $arg;
					}
				}
			}
			
		function Authenticate($password){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT passwordHash FROM users WHERE id = ?")){
				$stmt->bind_param("i", $this->userId);
				$stmt->execute();
				$stmt->bind_result($passwordHash);
				if (!$stmt->fetch()){
					throw new Exception("invalid user", E_USER_NO_EXIST);
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
			
			if (password_verify($password, $passwordHash)){
				return true;
				} else {
				return false;
				}
			}
			
		function IsAdmin(){
			if ($this->admin !== null){
				return $this->admin;
				}
				
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT admin FROM users WHERE id = ?")){
				$stmt->bind_param("i", $this->userId);
				$stmt->execute();
				$stmt->bind_result($adminVal);
				if(!$stmt->fetch()){
					throw new Exception("invalid user", E_USER_NO_EXIST);
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			if ($adminVal == "1"){
				$this->admin = true;
				} else {
				$this->admin = false;
				}
			
			return $this->admin;
			}
		
		function Login($ip){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("INSERT INTO logins VALUES(NULL, ?, ?, NULL)")){
				$stmt->bind_param("is", $this->userId, $ip);
				$stmt->execute();
				$insertId = $stmt->insert_id;
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("UPDATE users SET lastLogin = ? WHERE id = ?")){
				$stmt->bind_param("ii", $insertId, $this->userId);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			return $insertId;
			}
			
		function VerifySession($sessionCode){
			
			try {
				$sessionSecretTest = bin2hex(hash("md5", $sessionCode . $this->GetLoginId(). $this->GetUserName(), true));
				} catch (Exception $e){
				return false;
				}
			
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT sessionSecret FROM sessions WHERE associatedLogin = ? ORDER BY sessionId DESC LIMIT 1")){
				try {
					$stmt->bind_param("i", $this->GetLoginId());
					} catch (Exception $e){
					return false;
					}
				$stmt->execute();
				$stmt->bind_result($sessionSecret);
				$stmt->fetch();
				} else {
				throw new exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			if ($sessionSecretTest == $sessionSecret){
				return true;
				} else {
				return false;
				}
			}
			
		function GetLoginId(){
			if ($this->loginId){
				return $this->loginId;
				}
				
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT loginId FROM logins WHERE user = ? ORDER BY time DESC LIMIT 1")){
				try {
					$stmt->bind_param("i", $this->GetUserId());
					} catch (Exception $e){
					return null;
					}
					
				$stmt->execute();
				$stmt->bind_result($loginId);
				$stmt->fetch();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			return $loginId;
			}
			
		function NewSession($loginId){
			$conn = GetDatabaseConn();
			
			$sessionCode = bin2hex(hash("md5", openssl_random_pseudo_bytes(32), true));
			
			$sessionSecret = bin2hex(hash("md5", $sessionCode . $loginId . $this->GetUserName(), true));
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("DELETE FROM sessions WHERE user = ?")){
				$stmt->bind_param("i", $this->GetUserId());
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("INSERT INTO sessions VALUES(NULL, ?, ?, ?, ?)")){
				$stmt->bind_param("issi", $this->GetUserId(), $sessionSecret, $sessionCode, $loginId);
				$stmt->execute();
				if ($stmt->errno){
					printf("%s", $stmt->error);
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			return $sessionCode;
			}
			
		function GetUserName(){
			if ($this->userName){
				return $this->userName;
				}
				
			if (func_num_args() == 0){
				$searchUser = $this->userId;
				} else {
				$searchUser = func_get_arg(0);
				}
				
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT userName FROM users WHERE userName = ?")){
				$stmt->bind_param("s", $searchUser);
				$stmt->execute();
				$stmt->bind_result($resultName);
				if (!$stmt->fetch()){
					throw new Exception("invalid user", E_USER_NO_EXIST);
					}
				$this->userName = $resultName;
				return $resultName;
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
			}
			
		function GetUserId(){
			if ($this->userId){
				return $this->userId;
				}
				
			if (func_num_args() == 0){
				$searchUser = $this->userName;
				} else {
				$searchUser = func_get_arg(0);
				}
				
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("SELECT id FROM users WHERE userName = ?")){
				$stmt->bind_param("s", $searchUser);
				$stmt->execute();
				$stmt->bind_result($resultId);
				if (!$stmt->fetch()){
					throw new Exception("invalid user", E_USER_NO_EXIST);
					}
				$this->userId = $resultId;
				return $resultId;
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
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
				if ($stmt->errno){
					printf("%s\n", $stmt->error);
					}
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