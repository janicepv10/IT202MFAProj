<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);
unset($_SESSION["KBpassed"]);

if (!(isset($_SESSION["AI"]))){
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



$userAnswer = $_GET["answer"];
$correctAnswer = $_SESSION["answer"];

if( $userAnswer == $correctAnswer ){
	echo "<br>Correct Answer! Directing to pin1.php <br>";
	$_SESSION["KBpassed"] = true;
	header( "refresh: 4 , url=pin1.php "); 
	exit ("");
}
else{
	echo "<br> Wrong Answer ****Redirecting to KB1.php <br>";
	header( "refresh: 4 , url=KB1.php "); 
	exit ("");
}
?>
