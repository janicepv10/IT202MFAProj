<?php
session_start();

include("myfunctions.php"  );

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);

include("account.php"  );
$db = mysqli_connect($hostname,$username,$password,$project);
if(mysqli_connect_errno())
{ echo "Failed to connect to MySQL: " .mysqli_connect_error();
exit();
}
mysqli_select_db($db, $project);

$ucid =$_GET["ucid"];
$ucid = mysqli_real_escape_string($db, $ucid);
$pass =$_GET["pass"];
$pass = mysqli_real_escape_string($db, $pass);
$hash = password_hash($pass, PASSWORD_DEFAULT);
echo "<br>hash is: $hash <br><br>";
$gooddata = true;

$origUCID = $ucid;
$origPass = $pass;

$ucid = safe($db, "ucid");
$pass = safe($db, "pass");

if(!$gooddata){
	echo "<br> **** Unsafe Input. Please re-enter. <br>";	
}	
else{
	if( !authenticate($db, $ucid,$pass)){ 
		echo "<br> **** Invalid credentials. Please re-enter. <br>";
		header( "refresh: 4 , url=authenticate.html "); 
		exit ("");
	}
	else{	
		$_SESSION["authenticated"]=true;
		$_SESSION["ucid"]=$ucid;
	
		echo " Authenticated **** Redirecting to KB1.php";
		header( "refresh: 4 , url=KB1.php "); 
		exit ("<br>");
	}
}

?>

<style>
.formContainer {
  height:   100%   ;
  position: relative;
}
.center {
  margin:     0                       ;
  position:   absolute                ;
  top:        50%                     ;
  left:       50%                     ;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%)    ;
  }
form {  margin:   auto		   ;
		width:    600px        ;
		border:   1px solid red;
		padding:  20px         ;
	 } 
</style>	 

<div class="formContainer">	
<div class="center">
<form action = "authenticate.php" >

  <br><br>Sticky Form<br><br>
  <input type = text name= "ucid" value=<?php echo $origUCID; ?>>ucid<br><br>
  <input type = text id="pass" name="pass" value=<?php echo $origPass; ?>>pass
  <input type="checkbox" id="show" name="showPass">Click to hide password/unclick to see<br><br>
  <input type =submit><br>
  
 

</form>
</div>
</div>

<script>
	var ptrCheck = document.getElementById("show")
	var ptrPass = document.getElementById("pass")
	
	ptrCheck.addEventListener("click", F)
	function F() {
	if(ptrCheck.checked){
		ptrPass.type = "password"
	}
	else
		ptrPass.type = "text"
	}
</script>
