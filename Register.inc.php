<?php
	require_once("Config.inc.php");
	require_once("SecurePage.inc.php");
	require_once("UserClass.inc.php");
	require_once("Database.inc.php");
	
	class RegisterPage extends SecurePage{
		private $user;
		
		function __construct(){
			parent::__construct("Register");
			
			$this->user = $this->GetUser();
				
			$this->Begin();
			}
			
		function Begin(){			
			if ($this->user === false){
				$this->LoggedOutNavbar();
				if (isset($_POST['SubmitRegistration'])){
					$this->ProcessRegistration();
					} else {
					@$this->RegistrationForm();
					}
				} else {
				}
				
			return;
			}
			
		function ProcessRegistration(){
			$userName = $_POST['userName'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$birthMonth = $_POST['birthMonth'];
			$birthDate = $_POST['birthDate'];
			$birthYear = $_POST['birthYear'];
			
			if (preg_match("/[a-zA-Z0-9_-]/", $userName) === 0){
?>
		<P CLASS="invalid">User name must consist of letters, numbers, underscore, or hyphen.</P>
<?php
				$invalids['userName'] = true;
				}
				
			if (preg_match("/@/", $email) === 0){
?>
		<P CLASS="invalid">Invalid e-mail address format.</P>
<?php
				$invalids['email'] = true;
				}
				
			if ((strlen($password) < 8) || ($password == $userName) || ($password == $email)){
?>
		<P CLASS="invalid">Password must be at least eight characters and distinct from username or email address.</P>
<?php
				$invalids['password'] = true;
				}
				
			$birthYear = trim($birthYear);
			$birthMonth = trim($birthMonth);
			$birthDate = trim($birthDate);
			
			if (!$this->ValidateDate($birthYear, $birthMonth, $birthDate)){
?>
		<P CLASS="invalid">Invalid birth date.</P>
<?php
				$invalids['birthDay'] = true;
				}
				
			if (isset($invalids)){
				$this->RegistrationForm($invalids);
				return;
				}
				
			$dob = $birthYear . "-" . $birthMonth . "-" . $birthDate;
				
			try {
				$user = new User($userName, $password, $_SERVER['REMOTE_ADDR'], $email, $dob);
				} catch (Exception $e){
				if ($e->getCode() == E_PREPARED_STMT_UNRECOV){
					printf("Unrecoverable error, exiting.");
					exit();
					}
				if ($e->getCode() == E_USERNAME_EXISTS){
?>
		<P CLASS="invalid">Error: That username is already in use.</P>
<?php
					}
				if ($e->getCode() == E_EMAIL_EXISTS){
?>
		<P CLASS="invalid">Error: That e-mail address is already in use.</P>
<?php
					}
				@$this->RegistrationForm();
				return;
				}
?>
		<P>Registration succeeded.  You should receive an e-mail containing a verification code.  Follow the instructions contained in that e-mail, and then wait for an admin to approve your registration (usually no more than 24 hours); you will be notified when this is done.</P>
<?php
			}

		function RegistrationFormClass($value){
			if (isset($value)){
				printf("CLASS=\"invalid\" ");
				}
			}
			
		function ValidateDate($birthYear, $birthMonth, $birthDate){			
			if (!is_int($birthYear) && !ctype_digit($birthYear)){
				return false;
				}
				
			if (!is_int($birthMonth) && !ctype_digit($birthMonth)){
				return false;
				}
				
			if (!is_int($birthDate) && !ctype_digit($birthDate)){
				return false;
				}
				
			if ($birthYear < 1900){
				return false;
				}
			
			if ($birthYear > (date("Y") - 18)){
				return false;
				}
				
			if ($birthMonth < 1){
				return false;
				}
				
			if ($birthMonth > 12){
				return false;
				}
				
			if ($birthDate < 1){
				return false;
				}
				
			if ($birthDate > 31){
				return false;
				}
				
			return checkdate($birthMonth, $birthDate, $birthYear);
			}
		
		function RegistrationForm($invalids){
?>
		<H2>Registration</H2>
		<P>Fill out and submit to register.  All fields are required.  After registration, you will receive an e-mail with a verification code.  Follow the instructions in the e-mail, and then it will be up to another 24-48 hours before your registration is approved by an administrator.</P>
		<FORM ACTION="index.php?register" METHOD="POST">
			<INPUT TYPE="HIDDEN" NAME="SubmitRegistration" VALUE="TRUE">
			<LABEL <?php $this->RegistrationFormClass(@$invalids['userName']) ?>FOR="userName">Desired username:</LABEL>
			<INPUT <?php $this->RegistrationFormClass(@$invalids['userName']) ?>TYPE="TEXT" NAME="userName">
			<BR>
			<LABEL <?php $this->RegistrationFormClass(@$invalids['email']) ?>FOR="email">E-mail address:</LABEL>
			<INPUT <?php $this->RegistrationFormClass(@$invalids['email']) ?>TYPE="TEXT" NAME="email">
			<BR>
			<LABEL <?php $this->RegistrationFormClass(@$invalids['password']) ?>FOR="password">Password:</LABEL>
			<INPUT <?php $this->RegistrationFormClass(@$invalids['password']) ?>TYPE="PASSWORD" NAME="password">
			<BR>
			<LABEL <?php $this->RegistrationFormClass(@$invalids['birthDay']) ?>FOR="birthYear">Date of Birth:</LABEL>
			<SELECT <?php $this->RegistrationFormClass(@$invalids['birthDay']) ?>NAME="birthYear">
				<OPTION>Year
				<OPTION VALUE="1999">1999
				<OPTION VALUE="1998">1998
				<OPTION VALUE="1997">1997
				<OPTION VALUE="1996">1996
				<OPTION VALUE="1995">1995
				<OPTION VALUE="1994">1994
				<OPTION VALUE="1993">1993
				<OPTION VALUE="1992">1992
				<OPTION VALUE="1991">1991
				<OPTION VALUE="1990">1990
				<OPTION VALUE="1989">1989
				<OPTION VALUE="1988">1988
				<OPTION VALUE="1987">1987
				<OPTION VALUE="1986">1986
				<OPTION VALUE="1985">1985
				<OPTION VALUE="1984">1984
				<OPTION VALUE="1983">1983
				<OPTION VALUE="1982">1982
				<OPTION VALUE="1981">1981
				<OPTION VALUE="1980">1980
				<OPTION VALUE="1979">1979
				<OPTION VALUE="1978">1978
				<OPTION VALUE="1977">1977
				<OPTION VALUE="1976">1976
				<OPTION VALUE="1975">1975
				<OPTION VALUE="1974">1974
				<OPTION VALUE="1973">1973
				<OPTION VALUE="1972">1972
				<OPTION VALUE="1971">1971
				<OPTION VALUE="1970">1970
				<OPTION VALUE="1969">1969
				<OPTION VALUE="1968">1968
				<OPTION VALUE="1967">1967
				<OPTION VALUE="1966">1966
				<OPTION VALUE="1965">1965
				<OPTION VALUE="1964">1964
				<OPTION VALUE="1963">1963
				<OPTION VALUE="1962">1962
				<OPTION VALUE="1961">1961
				<OPTION VALUE="1960">1960
				<OPTION VALUE="1959">1959
				<OPTION VALUE="1958">1958
				<OPTION VALUE="1957">1957
				<OPTION VALUE="1956">1956
				<OPTION VALUE="1955">1955
				<OPTION VALUE="1954">1954
				<OPTION VALUE="1953">1953
				<OPTION VALUE="1952">1952
				<OPTION VALUE="1951">1951
				<OPTION VALUE="1950">1950
				<OPTION VALUE="1949">1949
				<OPTION VALUE="1948">1948
				<OPTION VALUE="1947">1947
				<OPTION VALUE="1946">1946
				<OPTION VALUE="1945">1945
				<OPTION VALUE="1944">1944
				<OPTION VALUE="1943">1943
				<OPTION VALUE="1942">1942
				<OPTION VALUE="1941">1941
				<OPTION VALUE="1940">1940
				<OPTION VALUE="1939">1939
				<OPTION VALUE="1938">1938
				<OPTION VALUE="1937">1937
				<OPTION VALUE="1936">1936
				<OPTION VALUE="1935">1935
				<OPTION VALUE="1934">1934
				<OPTION VALUE="1933">1933
				<OPTION VALUE="1932">1932
				<OPTION VALUE="1931">1931
				<OPTION VALUE="1930">1930
				<OPTION VALUE="1929">1929
				<OPTION VALUE="1928">1928
				<OPTION VALUE="1927">1927
				<OPTION VALUE="1926">1926
				<OPTION VALUE="1925">1925
				<OPTION VALUE="1924">1924
				<OPTION VALUE="1923">1923
				<OPTION VALUE="1922">1922
				<OPTION VALUE="1921">1921
				<OPTION VALUE="1920">1920
				<OPTION VALUE="1919">1919
				<OPTION VALUE="1918">1918
				<OPTION VALUE="1917">1917
				<OPTION VALUE="1916">1916
				<OPTION VALUE="1915">1915
				<OPTION VALUE="1914">1914
				<OPTION VALUE="1913">1913
				<OPTION VALUE="1912">1912
				<OPTION VALUE="1911">1911
				<OPTION VALUE="1910">1910
				<OPTION VALUE="1909">1909
				<OPTION VALUE="1908">1908
				<OPTION VALUE="1907">1907
				<OPTION VALUE="1906">1906
				<OPTION VALUE="1905">1905
				<OPTION VALUE="1904">1904
				<OPTION VALUE="1903">1903
				<OPTION VALUE="1902">1902
				<OPTION VALUE="1901">1901
				<OPTION VALUE="1900">1900
			</SELECT>
			<SELECT <?php $this->RegistrationFormClass(@$invalids['birthDay']) ?>NAME="birthMonth">
				<OPTION>Month
				<OPTION VALUE="01">January
				<OPTION VALUE="02">February
				<OPTION VALUE="03">March
				<OPTION VALUE="04">April
				<OPTION VALUE="05">May
				<OPTION VALUE="06">June
				<OPTION VALUE="07">July
				<OPTION VALUE="08">August
				<OPTION VALUE="09">September
				<OPTION VALUE="10">October
				<OPTION VALUE="11">November
				<OPTION VALUE="12">December
			</SELECT>
			<SELECT <?php $this->RegistrationFormClass(@$invalids['birthDay']) ?>NAME="birthDate">
				<OPTION>Day
				<OPTION VALUE="01">1
				<OPTION VALUE="02">2
				<OPTION VALUE="03">3
				<OPTION VALUE="04">4
				<OPTION VALUE="05">5
				<OPTION VALUE="06">6
				<OPTION VALUE="07">7
				<OPTION VALUE="08">8
				<OPTION VALUE="09">9
				<OPTION VALUE="10">10
				<OPTION VALUE="11">11
				<OPTION VALUE="12">12
				<OPTION VALUE="13">13
				<OPTION VALUE="14">14
				<OPTION VALUE="15">15
				<OPTION VALUE="16">16
				<OPTION VALUE="17">17
				<OPTION VALUE="18">18
				<OPTION VALUE="19">19
				<OPTION VALUE="20">20
				<OPTION VALUE="21">21
				<OPTION VALUE="22">22
				<OPTION VALUE="23">23
				<OPTION VALUE="24">24
				<OPTION VALUE="25">25
				<OPTION VALUE="26">26
				<OPTION VALUE="27">27
				<OPTION VALUE="28">28
				<OPTION VALUE="29">29
				<OPTION VALUE="30">30
				<OPTION VALUE="31">31
			</SELECT>
			<BR>
			<LABEL FOR="submitButton">By submitting, you agree to the <A HREF="index.php?tos">Terms of Service</A></LABEL>
			<INPUT TYPE="SUBMIT" NAME="submitButton" VALUE="Submit">
			<INPUT TYPE="RESET" VALUE="Reset">
		</FORM>
<?php
			return;
			}
		
		function __destruct(){
			parent::__destruct();
			}
		}
?>