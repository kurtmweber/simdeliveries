<?php
	require_once("Config.inc.php");
	require_once("Modules.inc.php");
	
	class SecurePage extends Page{
		function __construct($pageTitle){
			parent::__construct($pageTitle);
			}
			
		function GetUser(){
			return false;
			}
			
		function __destruct(){
			parent::__destruct();
			}
		}
?>