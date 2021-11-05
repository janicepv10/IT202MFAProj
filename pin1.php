<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);

if (!(isset($_SESSION["KBpassed"]))){
	echo "<br> **** Redirecting to KB1.php <br>";
	header( "refresh: 4 , url=KB1.php "); 
	exit ("");
}
include("account.php"  );
$db = mysqli_connect($hostname,$username,$password,$project);
if(mysqli_connect_errno())
{ echo "Failed to connect to MySQL: " .mysqli_connect_error();
exit();
}

$pin = mt_rand(1001,9999);
$_SESSION["pin"] = $pin;
mail("jpv24@njit.edu","PIN",$pin);

echo "<br>Instructor Use - pin: $pin ";
?>
<br><br><br>

<form action = "pin2.php" >

  <input type = text name= "pin">pin<br>
  <input type =submit><br>

</form>
