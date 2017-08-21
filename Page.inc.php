<?php
	require_once("Config.inc.php");
	require_once("Top.inc.php");
	require_once("Bottom.inc.php");
	
	class Page{
		private $PageTitle;
		private $TabLevel;
		
		function __construct($PageTitle){
			$this->PageTitle = $PageTitle;
			
			PageTop($this->PageTitle);
			
			$this->TabLevel = 2;
			}
			
		function TabbedHtmlOut($html){
			for ($i = 0; $i < $this->TabLevel; $i++){
				printf("\t");
				}
				
			printf("%s\n", $html);
			
			return;
			}
			
		function UnrecoverableError(){
			$this->TabbedHtmlOut("<P CLASS=\"invalid\">Unrecoverable error, exiting</P>");
			exit();
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
		
		function LoggedInNavbar(){
?>
		<NAV>
			<A HREF="index.php?user" CLASS="navbar-link">[home]</A> | <A HREF="index.php?news" CLASS="navbar-link">[news] | <A HREF="index.php?aircraft" CLASS="navbar-link">[aircraft]</A> | <A HREF="index.php?airports" CLASS="navbar-link">[airports]</A> | <A HREF="index.php?finance" CLASS="navbar-link">[finance]</A> | <A HREF="index.php?communications" CLASS="navbar-link">[comms]</A> | <A HREF="index.php?profile" CLASS="navbar-link">[profile]</A> | <A HREF="index.php?logout" CLASS="navbar-link">[log out]</A>
		</NAV>
<?php
			}
			
		function __destruct(){
			PageBottom();
			}
		}
?>