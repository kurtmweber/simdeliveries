<?php
	require_once("Config.inc.php");
	require_once("Page.inc.php");
	require_once("Database.inc.php");
	require_once("UserClass.inc.php");
	
	class VerifyPage extends Page{
		function __construct(){
			parent::__construct("Verify");
			$this->LoggedOutNavbar();
			
			$this->Begin();
			}
			
		function Begin(){
			if (isset($_POST['SubmitVerification'])){
				$this->ProcessVerification();
				} else {
				$this->VerificationForm();
				}
			
			return;
			}
			
		function ProcessVerification(){
			try {
				$user = new User($_POST['userName']);
				} catch (Exception $e){
				if ($e->getCode() == E_USER_NO_EXIST){
					printf("No such user");
					}
				}
			}
			
		function VerificationForm(){
?>
		<FORM ACTION="index.php?verify" METHOD="POST">
			<LABEL FOR="userName">Username:</LABEL>
			<INPUT NAME="userName">
			<LABEL FOR="verificationCode">Verification code:</LABEL>
			<INPUT NAME="verificationCode">
			<INPUT TYPE="SUBMIT" NAME="SubmitVerification" VALUE="Submit">
			<INPUT TYPE="RESET">
		</FORM>
<?php
			}
			
		function __destruct(){
			parent::__destruct();
			}
		}
?>