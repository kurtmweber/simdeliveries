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
			
		function __destruct(){
			PageBottom();
			}
		}
?>