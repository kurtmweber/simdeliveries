<?php
	require_once("Config.inc.php");
	require_once("Page.inc.php");
	require_once("Modules.inc.php");
	
	if (isset($_GET['register'])){
		$page = new RegisterPage;
		} elseif (isset($_GET['verify'])) {
		$page = new VerifyPage;
		} else {
		$page = new HomePage;
		}
?>