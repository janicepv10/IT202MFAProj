<?php
session_start();

setcookie("doneBy", "jpv24", time() + (86400*30), "/");
setcookie("doneAt", date('l jS \of F Y h:i:s A'), time() + (86400*30), "/");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);

if(!(isset($_SESSION["authenticated"])))
{ 
	echo "<br>Access restricted.";
	echo "<br>Redirecting to authenticate.html";
	header("refresh: 3, url=authenticate.html");
	exit("");
}
$ucid = $_SESSION["ucid"];
include("myfunctions.php"  );

$hostNm = gethostname();
$reqMed = $_SERVER['REQUEST_METHOD'];
$reqTime = $_SERVER['REQUEST_TIME'];
$absPath = realpath($_SERVER["DOCUMENT_ROOT"]);
$ip = $_SERVER['REMOTE_ADDR']; 
echo "<br> Host server: $hostNm || HTTP Method: $reqMed || Time request started: $reqTime ||
 Absolute Path: $absPath || Remote IP Address: $ip <br>";

echo "<br>Admitted to KB1.php <br>";

include("account.php"  );
$db = mysqli_connect($hostname,$username,$password,$project);
if(mysqli_connect_errno())
{ echo "Failed to connect to MySQL: " .mysqli_connect_error();
exit();
}
mysqli_select_db($db, $project);

$s = "select * from `security-questions` where ucid='$ucid' order by Rand()";
($t = mysqli_query($db,$s)) or die(mysqli_error($db));

$r=mysqli_fetch_array($t, MYSQLI_ASSOC);
$question =$r[ "question" ]; 
$correctAnswer=$r[ "answer" ];
$randomAI = $r["AI"]; 

$_SESSION["answer"]=$correctAnswer;
$_SESSION["AI"]=$randomAI;

echo "Answer security question: $question   ";
echo "<br> For Instructor Use: Correct Answer: $correctAnswer "; 

?>
<br><br><br>

<form action = "KB2.php" >

  <input type = text name= "answer">answer<br>
  <input type =submit><br>

</form>
