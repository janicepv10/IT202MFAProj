<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);

include("myfunctions.php"  );

if (!(isset($_SESSION["pinpassed"]))){
	echo "<br> **** Redirecting to services1.php <br>";
	header( "refresh: 4 , url=services1.php "); 
	exit ("");
}

include("account.php"  );
$db = mysqli_connect($hostname,$username,$password,$project);
if(mysqli_connect_errno())
{ echo "Failed to connect to MySQL: " .mysqli_connect_error();
exit();
}
print "Successfully connected to MySQL database.<br>";
mysqli_select_db($db, $project);

$ucid = $_SESSION["ucid"];

$accountNum = $_GET["account"];
$accountNum = mysqli_real_escape_string($db, $accountNum);
$amountG = $_GET["amount"];
$amountG = mysqli_real_escape_string($db, $amountG);
$numTrans = $_GET["numTra"];
$numTrans = mysqli_real_escape_string($db, $numTrans);

$typeChosen = $_GET["menu1"];

if($typeChosen == "L"){
	list_transactions_wrapper($db, $ucid);
}
else if($typeChosen == "P"){
	perform_transaction($db, $ucid, $accountNum, $amountG);
}
else if($typeChosen == "R"){
	reset_account($db, $ucid, $accountNum);
}
else if($typeChosen == "LT"){
	list_Number_transactions($db, $ucid, $accountNum, $numTrans);
}
else if($typeChosen == "LA"){
	list_accounts($db, $ucid);
}
?>
<br><a href="https://web.njit.edu/~jpv24/Assignment1/logout.php/">Logout Link</a><br><br>