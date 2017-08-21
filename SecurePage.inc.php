<?php
	require_once("Config.inc.php");
	require_once("Modules.inc.php");
	require_once("UserClass.inc.php");
	
	class SecurePage extends Page{
		function __construct($pageTitle){
			parent::__construct($pageTitle);
			}
			
		function GetUser(){
			static $user;
			
			if (func_num_args() == 2){
				$user = new User(func_get_arg(0));
				$authenticated = $user->Authenticate(func_get_arg(1));
				if ($authenticated){
					return $user;
					}
				}
			return false;
			}
			
		function __destruct(){
			parent::__destruct();
			}
		}
?>