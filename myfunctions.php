<?php
//Authenticate Function
function authenticate($db, $ucid,$pass)
{
	global $t;
	
	$s = "select * from users where ucid='$ucid' " ;
	($t = mysqli_query($db,$s)) or die(mysqli_error($db)); 
	$num = mysqli_num_rows($t);
	$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
	$hash = $r['hash'];
	
	if (password_verify($pass, $hash)) {
		return true;
		}
	else           {return false;}
}

//Safe Function 
function safe($db, $fieldname){
	
	global $gooddata;
	
	$ucid =$_GET["ucid"];
	$ucid = mysqli_real_escape_string($db, $ucid);
	$pass =$_GET["pass"];
	$pass = mysqli_real_escape_string($db, $pass);
	
	$v = $fieldname; 
	
	if($fieldname == "ucid"){
		$v = $ucid;
		$v = filter_var ($v, FILTER_SANITIZE_STRING); 
		$count = preg_match('/^[a-z]{2,6}[0-9]{0,3}$/i', $v, $matches);
		
		if($count == 0)
		{
			$gooddata = false;
		}
		$v = filter_var ($v, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z]{2,6}[0-9]{0,3}$/i"))); 	
	}
	else{
		$v = $pass;
		$v = filter_var ($v, FILTER_SANITIZE_STRING); 
	}
	return $v;
	
}

//List Transactions Wrapper Function
function list_transactions_wrapper($db, $ucid)
{
	global $t;
	$s = "select * from transactions where ucid='$ucid' ";
	($t = mysqli_query($db, $s)) or die (mysqli_error($db));
	$num = mysqli_num_rows($t);
	if($num == 0){ echo "<br>No rows retrieved. <br>"; return; };
	echo "<br> There were $num rows retrieved from the DB table <br>";	
	echo"<table border=2 width=30%>";
	echo"<tr><th>ucid</th><th>amount</th><th>timestamp</th></tr>";
	
	while ($r=mysqli_fetch_array($t, MYSQLI_ASSOC)){
	echo"<tr>";
		$ucid =$r[ "ucid" ]; $amount=$r[ "amount" ]; $timestamp=$r[ "timestamp" ];
		echo "<td>$ucid</td>"; echo"<td>$amount</td>"; echo"<td>$timestamp</td>";
	echo"</tr>";	
	};
		echo"</table>";
}

//Perform Transaction Function
function perform_transaction($db, $ucid, $account, $amount){
$s = "select * from accounts
		where ucid    = '$ucid'              and
	      account = '$account'           and 
		  balance + '$amount'>= 0.00
		  ";
($t = mysqli_query($db,$s)) or die(mysqli_error($db)); 
$num = mysqli_num_rows($t);
if($num == 0){ exit(  "<br>Invalid input or overdraw prevention" );}

//insert transactions
$s = " insert into transactions values('$ucid', '$amount' , '$account' , NOW()) " ;
($t = mysqli_query($db,$s)) or die(mysqli_error($db)); 
//update accounts 
$s = " update accounts
			SET balance = balance+'$amount', mostRecentTrans = NOW()
			where ucid='$ucid'
			and account ='$account'
			and balance +'$amount'>=0.00			
			" ;
($t = mysqli_query($db,$s)) or die(mysqli_error($db)); 	
}

//Reset Account Function
function reset_account($db, $ucid, $account){
	$s = "select * from transactions where ucid = '$ucid' and account = '$account'";
	($t = mysqli_query($db, $s)) or die(mysqlui_error($db));
	$num = mysqli_num_rows($t);
	if($num==0){
		exit("<br> no transactions found");
	}
	$s = "delete from transactions where ucid = '$ucid' and account = '$account'";
	($t = mysqli_query($db, $s))or die(mysqli_error($db));
	
	$s = "update accounts SET balance = 0.00, mostRecentTrans=NOW() where ucid='$ucid' and account='$account'";
	($t = mysqli_query($db, $s)) or die(mysqlui_error($db));	
}

//List Number Transactions
function list_Number_transactions($db, $ucid, $account, $N)
{
	global $t;	
	$s = "select * from transactions where ucid='$ucid' and account = '$account' order by timestamp desc limit $N";
	($t = mysqli_query($db, $s)) or die (mysqli_error($db));
	$num = mysqli_num_rows($t);
	if($num == 0){ echo "<br>No rows retrieved. <br>"; return; };
	echo "<br> There were $num rows retrieved from the DB table <br>";
	
	echo"<table border=2 width=30%>";
	echo"<tr><th>account</th><th>amount</th><th>timestamp</th></tr>";
	while ($r=mysqli_fetch_array($t, MYSQLI_ASSOC)){
	echo"<tr>";
		$account =$r[ "account" ]; $amount=$r[ "amount" ]; $timestamp=$r[ "timestamp" ];
		echo "<td>$account</td>"; echo"<td>$amount</td>"; echo"<td>$timestamp</td>";
	echo"</tr>";	
	};
		echo"</table>";
}

//List Accounts Function
function list_accounts($db, $ucid)
{
	global $t;
	$s = "select * from accounts where ucid='$ucid' ";
	($t = mysqli_query($db, $s)) or die (mysqli_error($db));
	$num = mysqli_num_rows($t);
	if($num == 0){ echo "<br>No rows retrieved. <br>"; return; };
	echo "<br> There were $num rows retrieved from the DB table <br>";
	echo"<table border=2 width=30%>";
	echo"<tr><th>account</th><th>balance</th><th>MostRecentTransaction</th></tr>";
	while ($r=mysqli_fetch_array($t, MYSQLI_ASSOC))
	{
	echo"<tr>";
		$ucid =$r[ "ucid" ]; $account =$r[ "account" ];  $balance=$r[ "balance" ]; $mostRecentTrans=$r[ "mostRecentTrans" ];
		echo "<td>$account</td>"; echo"<td>$balance</td>"; echo"<td>$mostRecentTrans</td>";
	echo"</tr>";	
	};
		echo"</table>";
}
?>