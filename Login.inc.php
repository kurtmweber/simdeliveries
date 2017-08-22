<?php
	require_once("Config.inc.php");
	require_once("SecurePage.inc.php");
	require_once("Database.inc.php");
	require_once("UserClass.inc.php");
	
	class LoginPage extends SecurePage{
		function __construct(){
			ob_start();
			parent::__construct("Login");
			
			$this->user = $this->GetUser();
			$this->Begin();
			ob_end_flush();
			
			return;
			}
			
		function Begin(){
			if (isset($_POST['SubmitLogin'])){
				$this->processLogin();
				}
				
			if (!$this->user){
				$this->LoggedOutNavbar();
				if (isset($_POST['SubmitLogin'])){
					$this->TabbedHtmlOut("<P CLASS=\"invalid\">Login failed.</P>");
					}
				$this->LoginForm();
				} else {
				$this->LoggedInNavbar();
				$this->TabbedHtmlOut("<P>Login succeeded.</P>");
				}
				
			return;
			}
			
		function ProcessLogin(){
			try {
				$this->user = $this->GetUser($_POST['userName'], $_POST['password']);
				} catch (Exception $e){
				}
				
			if (!$this->user){
				return;
				}
			
			$loginId = $this->user->Login($_SERVER['REMOTE_ADDR']);
			$sessionCode = $this->user->NewSession($loginId);
			
			$this->SendSessionCookie($sessionCode);
			return;
			}
			
		function SendSessionCookie($sessionCode){
			setcookie(SITENAME . "Session", $sessionCode, time() + (365*24*60*60));
			setcookie(SITENAME . "User", $this->user->GetUserName(), time() + (365*24*60*60));
			
			return;
			}
			
		function LoginForm(){
?>
		<H2>Login</H2>
		<FORM ACTION="index.php?login" METHOD="POST">
			<INPUT TYPE="HIDDEN" NAME="SubmitLogin" VALUE="TRUE">
			<LABEL FOR="userName" CLASS="login">Username:</LABEL>
			<INPUT TYPE="TEXT" NAME="userName">
			<BR>
			<LABEL FOR="password" CLASS="login">Password:</LABEL>
			<INPUT TYPE="PASSWORD" NAME="password">
			<BR>
			<INPUT TYPE="SUBMIT" NAME="loginSubmit" VALUE="Log in">
			<INPUT TYPE="RESET" VALUE="Clear">
		</FORM>
<?php
		}
			
		function __destruct(){
			parent::__destruct();
			
			return;
			}
		}
?>