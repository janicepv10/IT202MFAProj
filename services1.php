<style>
form {  margin:   auto		   ;
		width:    50%		   ;
		border:   1px solid red;
		padding:  20px         ;
	 }  
</style>	 

<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);

if (!(isset($_SESSION["pinpassed"]))){
	echo "<br> **** Redirecting to pin1.php <br>";
	header( "refresh: 4 , url=pin1.php "); 
	exit ("");
}

?>
<br><br><br>
<form action = "services2.php" >

<input type=radio id="C" name="menu1" value="C" checked>Choose <br><br>
<input type=radio id="L" name="menu1" value="L" >List <br><br>
<input type=radio id="P" name="menu1" value="P" >Perform <br><br>
<input type=radio id="R" name="menu1" value="R" >Reset <br><br>
<input type=radio id="LT" name="menu1" value="LT" >List Number of Transactions <br><br>
<input type=radio id="LA" name="menu1" value="LA" >List Accounts     <br><br>

<div id="Account" class="toshow" style="display:none">
<input type = text id="ANum" name= "account">Enter Account<br>
</div><br>

<div id="Amount" class="toshow" style="display:none">
<input type = text id="Amt" name= "amount">Enter Amount<br>
</div><br>

<div id="Number" class="toshow" style="display:none">
<input type = text id="NumTr" name= "numTra">Enter Number of Transactions to be listed<br>
</div><br>

<br><input type=submit style="display:block"><br>
</form>

<script type="text/javascript">
// JavaScript controls visibility of some elements based on a group of radio buttons
var ptrC = document.getElementById("C");
var ptrL = document.getElementById("L");
var ptrP = document.getElementById("P");
var ptrR = document.getElementById("R");
var ptrLT = document.getElementById("LT");
var ptrLA = document.getElementById("LA");

var ptrDivAccount = document.getElementById("Account");
var ptrDivAmount = document.getElementById("Amount");
var ptrDivNum = document.getElementById("Number");

ptrC.addEventListener("click", F);
ptrL.addEventListener("click", F);
ptrP.addEventListener("click", F);
ptrR.addEventListener("click", F);
ptrLT.addEventListener("click", F);
ptrLA.addEventListener("click", F);

function F(){
	if(this.value == "P"){
	ptrDivAccount.style = "display: block";
	ptrDivAmount.style = "display: block";
	ptrDivNum.style.display="none";
	
	}
	else if(this.value == "L"){
	ptrDivAccount.style = "display: none";	
	ptrDivAmount.style = "display: none";
	ptrDivNum.style.display="none";
	}
	
	else if(this.value == "R"){
		ptrDivAccount.style = "display: block";	
		ptrDivAmount.style = "display: none";
		ptrDivNum.style.display="none";
	}
	
	else if(this.value == "LT"){
		ptrDivAccount.style = "display: block";	
		ptrDivAmount.style = "display: none";
		ptrDivNum.style.display="block";
	}
	else if(this.value == "LA"){
		ptrDivAccount.style = "display: none";	
		ptrDivAmount.style = "display: none";
		ptrDivNum.style.display="none";
	}
}

</script>

