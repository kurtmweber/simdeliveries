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
				try {
					$this->ProcessVerification();
					} catch (Exception $e){
					if ($e->getCode() == E_NO_VER_CODE){
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">No code exists for that user.</P>");
						$this->VerificationForm();
						} else {
						$this->UnrecoverableError();
						}
					}
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
					$this->TabbedHtmlOut("<P CLASS=\"invalid\">No such user exists.</P>");
					$this->VerificationForm();
					return;
					} else {
					$this->UnrecoverableError();
					}
				}
			$id = $user->GetUserId();
			
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			
			if ($stmt->prepare("SELECT code FROM emailVerification WHERE user = ?")){
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$stmt->bind_result($resultCode);
				$stmt->store_result();
				if (!$stmt->fetch()){
					throw new Exception("no verification code", E_NO_VER_CODE);
					}
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}
				
			if ($resultCode == $_POST['verificationCode']){
				try {
					$this->UpdateVerification($id);
					} catch (Exception $e){
					$this->UnrecoverableError();
					}
				$this->TabbedHtmlOut("<P>Verification succeeded</P>");
				} else {
				$this->TabbedHtmlOut("<P CLASS=\"invalid\">Invalid code.</P>");
				$this->VerificationForm();
				}
				
			return;
			}
			
		function UpdateVerification($userId){
			$conn = GetDatabaseConn();
			
			$stmt = $conn->stmt_init();
			if ($stmt->prepare("DELETE FROM emailVerification WHERE user = ?")){
				$stmt->bind_param("i", $userId);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
				}

			$stmt = $conn->stmt_init();
			if ($stmt->prepare("UPDATE users SET verified=true WHERE id = ?")){
				$stmt->bind_param("i", $userId);
				$stmt->execute();
				} else {
				throw new Exception("prepared statement failed", E_PREPARED_STMT_UNRECOV);
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