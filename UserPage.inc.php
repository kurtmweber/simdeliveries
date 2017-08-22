<?php
	require_once("Config.inc.php");
	require_once("SecurePage.inc.php");
	require_once("UserClass.inc.php");
	
	class UserPage extends SecurePage{
		function __construct(){
			parent::__construct("Home");
			
			$this->user = $this->GetUser();
			
			if ($this->user === false){
				$this->NotLoggedIn();
				} else {
				$this->Begin();
				}
			}
			
		function Begin(){
			$this->LoggedInNavbar();
			$userName = $this->user->GetUserName();
			
			$this->TabbedHtmlOut("<P>Welcome, " . $userName . "</P>");
			
			return;
			}
			
		function __destruct(){
			parent::__destruct();
			}
		}
?>