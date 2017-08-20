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
			
		function __destruct(){
			PageBottom();
			}
		}
?>