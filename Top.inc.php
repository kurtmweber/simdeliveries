<?php
	require_once("Config.inc.php");
	
	function PageTop($siteTitle){
?>
<HTML>
	<HEAD>
		<TITLE><?php echo SITENAME . ": " . $siteTitle; ?></TITLE>
		<LINK rel="stylesheet" type="text/css" href="simdeliveries.css">
	</HEAD>
	<BODY>
		<HEADER>
			<H1>Welcome to SimDeliveries!</H1>
		</HEADER>
<?php
		return;
		}
?>
  