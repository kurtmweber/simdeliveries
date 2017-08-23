<?php
	require_once("Config.inc.php");
	require_once("SecurePage.inc.php");
	require_once("UserClass.inc.php");
	
	class Aircraft extends SecurePage{
		function __construct(){
			parent::__construct("Aircraft");
			
			$this->user = $this->GetUser();
			
			if ($this->user === false){
				$this->NotLoggedIn();
				} else {
				$this->Begin();
				}
			}
			
		function Begin(){
			$this->LoggedInNavbar();
			$this->AircraftNavbar();
			
			return;
			}
			
		function AircraftNavbar(){
?>
		<NAV CLASS="subnav">
			<A HREF="index.php?aircraft&my" CLASS="navbar-link">[my aircraft]</A> | <A HREF="index.php?aircraft&market" CLASS="navbar-link">[aircraft market]</A> | <A HREF="index.php?aircraft&stats" CLASS="navbar-link">[aircraft stats]</A> | <A HREF="index.php?aircraft&find" CLASS="navbar-link">[find aircraft]</A>
		</NAV>
<?php
			}
			
		function __destruct(){
			parent::__destruct();
			}
		}
?>