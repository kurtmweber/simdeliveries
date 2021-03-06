<?php
	require_once("Config.inc.php");
	require_once("Modules.inc.php");
	require_once("UserClass.inc.php");
	
	class SecurePage extends Page{
		protected $user;
		
		function __construct($pageTitle){
			parent::__construct($pageTitle);
			}
			
		function NotLoggedIn(){
			$this->LoggedOutNavbar();
			$this->TabbedHtmlOut("<P CLASS=\"invalid\">You must be logged in to access this function.</P>");
			
			return;
			}
			
		function GetUser(){
			static $user;
			
			if (func_num_args() == 2){
				$user = new User(func_get_arg(0));
				$authenticated = $user->Authenticate(func_get_arg(1));
				if ($authenticated){
					return $user;
					}
				} else {
				if (!isset($_COOKIE[SITENAME . "User"])){
					return false;
					}
					
				if (!isset($_COOKIE[SITENAME . "Session"])){
					return false;
					}
				$userName = $_COOKIE[SITENAME . "User"];
				$sessionCode = $_COOKIE[SITENAME . "Session"];
				
				$user = new User($userName);
				
				$session = $user->VerifySession($sessionCode);
				
				if ($session){
					return $user;
					}
				}
			return false;
			}

		function LoggedInNavbar(){
?>
		<NAV>
			<A HREF="index.php?user" CLASS="navbar-link">[home]</A> | <A HREF="index.php?news" CLASS="navbar-link">[news]</A> | <A HREF="index.php?aircraft" CLASS="navbar-link">[aircraft]</A> | <A HREF="index.php?airports" CLASS="navbar-link">[airports]</A> | <A HREF="index.php?finance" CLASS="navbar-link">[finance]</A> | <A HREF="index.php?communications" CLASS="navbar-link">[comms]</A> | <A HREF="index.php?profile" CLASS="navbar-link">[profile]</A> | <A HREF="index.php?logout" CLASS="navbar-link">[log out]</A><?php
			if ($this->user->IsAdmin()){
				printf(" | <A HREF=\"index.php?admin\" CLASS=\"navbar-link\">[admin]</A>");
				}
?>

		</NAV>
<?php
			}
			
		function Footer(){
			$this->TabbedHtmlOut("");
			}

		function __destruct(){
			$this->Footer();
			parent::__destruct();
			}
		}
?>