<?php
	$dbHost = trim(`grep -w "DB_HOST" ../.htaccess | cut -d " " -f 3 -`, "\"\n");
	$dbName = trim(`grep -w "DB_NAME" ../.htaccess | cut -d " " -f 3 -`, "\"\n");
	$dbUser = trim(`grep -w "DB_USER" ../.htaccess | cut -d " " -f 3 -`, "\"\n");
	$dbPass = trim(`grep -w "DB_USER_PASS" ../.htaccess | cut -d " " -f 3 -`, "\"\n");
	
	$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
	if ($conn->connect_errno){
		printf("%s\n", $conn->connect_error);
		exit();
		}
		
	$stmt = $conn->stmt_init();
	$stmt->prepare("SELECT id FROM users WHERE verified=false");
	if ($stmt->errno){
		printf("%s\n", $stmt->error);
		}
	$stmt->execute();
	$stmt->bind_result($id);
	$stmt->store_result();
	while ($stmt->fetch()){
		$loginStmt = $conn->stmt_init();
		$loginStmt->prepare("SELECT time FROM logins WHERE time < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 day)");
		if ($loginStmt->errno){
			printf("%s\n", $loginStmt->error);
			}
		$loginStmt->execute();
		$loginStmt->store_result();
		if ($loginStmt->num_rows != 0){
			$delStmt = $conn->stmt_init();
			$delStmt->prepare("DELETE FROM users WHERE id = ? AND verified=false");
			$delStmt->bind_param("i", $id);
			$delStmt->execute();
			
			$delStmt->prepare("DELETE FROM logins WHERE user = ?");
			$delStmt->bind_param("i", $id);
			$delStmt->execute();
			
			$delStmt->prepare("DELETE FROM emailVerification WHERE user = ?");
			$delStmt->bind_param("i", $id);
			$delStmt->execute();
			}
		}
?>