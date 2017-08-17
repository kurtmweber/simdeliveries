<?php
	require_once("Config.inc.php");
	require_once("Page.inc.php");
	require_once("Modules.inc.php");
	
	if (isset($_COOKIE['LoginSession'])){
		} else {
		$page = new HomePage;
		}
?>