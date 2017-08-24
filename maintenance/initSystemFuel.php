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
	$stmt->prepare("SELECT id, type, totalRunway FROM airports");
	if ($stmt->errno){
		printf("%s\n", $stmt->error);
		}
	$stmt->execute();
	$stmt->bind_result($id, $airportType, $runway);
	$stmt->store_result();
	while ($stmt->fetch()){
		$hasFuel = false;
		if (($airportType == "s") || ($airportType  == "m") || ($airportType == "l")){
			if ($runway >= 10560){
				$hasFuel = true;
				} else {
				$pct = floor(($runway / 10560) * 100);
				if (mt_rand(0, 100) <= $pct){
					$hasFuel = true;
					}
				}
			}
			
		if ($airportType == "h"){
			if ($runway >= 150){
				$hasFuel = true;
				} else {
				$pct = floor(($runway / 150) * 100);
				if (mt_rand(0, 100) <= $pct){
					$hasFuel = true;
					}
				}
			}
			
		if ($airportType = "w"){
			if ($runway >= 5000){
				$hasFuel = true;
				}
			}
			
		if ($hasFuel){
			$fuelStmt = $conn->stmt_init();
			$fuelStmt->prepare("UPDATE airports SET hasFuel = true WHERE id = ?");
			$fuelStmt->bind_param("i", $id);
			$fuelStmt->execute();
			}
		}
?>