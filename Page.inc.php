<?php
	require_once("Config.inc.php");
	require_once("Top.inc.php");
	require_once("Bottom.inc.php");
	
	class Page{
		private $PageTitle;
		
		function __construct($PageTitle){
			$this->PageTitle = $PageTitle;
			
			PageTop($this->PageTitle);
			}
			
		function SanitizeInputForDisplay($input){
			$input = trim($input);
			$input = stripslashes($input);
			$input = htmlspecialchars($input);
			
			return $input;
			}
			
		function LoggedOutNavbar(){
?>
		<NAV>
			<A HREF="index.php" CLASS="navbar-link">[home]</A> | <A HREF="index.php?news" CLASS="navbar-link">[news]</A> | <A HREF="index.php?register" CLASS="navbar-link">[register]</A> | <A HREF="index.php?login" CLASS="navbar-link">[log in]</A>
		</NAV>
<?php
		}
			
		function __destruct(){
			PageBottom();
			}
		}
?>