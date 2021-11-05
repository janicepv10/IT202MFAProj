<?php
session_start();
unset ($_SESSION["pinpassed"]);
 
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);

if (!(isset($_SESSION["pin"]))){
	echo "<br> **** Redirecting to KB1.php <br>";
	header( "refresh: 4 , url=KB1.php "); 
	exit ("");
}
$userPin = $_GET["pin"];
$correctPin = $_SESSION["pin"];

if( $userPin == $correctPin ){
	echo "<br>Pin Correctly Entered! Directing to services1.php <br>";
	$_SESSION["pinpassed"] = true;
	header( "refresh: 4 , url=services1.php "); 
	exit ("");
}
else{
	echo "<br> Wrong Pin ****Redirecting to pin1.php <br>";
	header( "refresh: 4 , url=pin1.php "); 
	exit ("");
}

?>
