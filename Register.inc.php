<?php
	require_once("Config.inc.php");
	require_once("SecurePage.inc.php");
	require_once("UserClass.inc.php");
	
	class RegisterPage extends SecurePage{
		private $user;
		
		function __construct(){
			parent::__construct("Register");
			
			$this->user = parent::GetUser();
				
			$this->Begin();
			}
			
		function Begin(){
			$userName = $_POST['userName'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$birthMonth = $_POST['birthMonth'];
			$birthDate = $_POST['birthDate'];
			$birthYear = $_POST['birthYear'];
			
			if ($this->user === false){
				LoggedOutNavbar();
				if (isset($_POST['SubmitRegistration'])){
					} else {
					$this->RegistrationForm();
					}
				} else {
				}
			}
			
		function RegistrationForm(){
?>
		<H2>Registration</H2>
		<P>Fill out and submit to register.  All fields are required.  After registration, you will receive an e-mail with a verification code.  Follow the instructions in the e-mail, and then it will be up to another 24-48 hours before your registration is approved by an administrator.</P>
<?php
			}
		
		function __destruct(){
			parent::__destruct();
			}
		}
?>