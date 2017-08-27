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
?>