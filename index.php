<?php
	require_once("Config.inc.php");
	require_once("Page.inc.php");
	require_once("Modules.inc.php");
	
	date_default_timezone_set("Etc/UTC");
	
	if (isset($_GET['register'])){
		$page = new RegisterPage;
		} elseif (isset($_GET['verify'])) {
		$page = new VerifyPage;
		} elseif (isset($_GET['login'])){
		$page = new LoginPage;
		} elseif (isset($_GET['user'])){
		$page = new UserPage;
		} elseif (isset($_GET['aircraft'])){
		$page = new Aircraft;
		} else {
		$page = new HomePage;
		}
?>