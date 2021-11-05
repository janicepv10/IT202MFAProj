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
$cell =$_GET["cell"];
$cell = mysqli_real_escape_string($db, $cell);
$name =$_GET["name"];
$name = mysqli_real_escape_string($db, $name);

$email = "$ucid@njit.edu";
$hash = password_hash($pass, PASSWORD_DEFAULT);

$s = "INSERT INTO users (ucid, cell, email, pass, name, hash) VALUES ('$ucid', '$cell', '$email', '$pass', '$name', '$hash')";
($t = mysqli_query($db, $s)) or die(mysqli_error($db));

$pet =$_GET["pet"];
$pet = mysqli_real_escape_string($db, $pet);
$born =$_GET["born"];
$born = mysqli_real_escape_string($db, $born);
$tree =$_GET["tree"];
$tree = mysqli_real_escape_string($db, $tree);

$s = "INSERT INTO `security-questions` (ucid, question, answer) VALUES ('$ucid','Name of first pet?','$pet')";
($t = mysqli_query($db, $s)) or die(mysqli_error($db));

$s = "INSERT INTO `security-questions` (ucid, question, answer) VALUES ('$ucid','Name of town born in?','$born')";
($t = mysqli_query($db, $s)) or die(mysqli_error($db));

$s = "INSERT INTO `security-questions` (ucid, question, answer) VALUES ('$ucid','Favorite tree?','$tree')";
($t = mysqli_query($db, $s)) or die(mysqli_error($db));

?>

<br><a href="https://web.njit.edu/~jpv24/Assignment2/authenticate.html">Click here to login to your account!</a><br><br>