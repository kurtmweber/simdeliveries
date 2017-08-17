<?php
	require_once("Config.inc.php");
	require_once("Page.inc.php");
	
	class HomePage extends Page{
		function __construct(){
			parent::__construct("Home");
			return;
			}
			
		function __destruct(){
			parent::__destruct();
			return;
			}
		}
?>