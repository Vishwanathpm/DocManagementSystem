<?php

include 'dbconnect.php';

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";

//Run query - this has not been changed to PDO
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If count reveals there is more than 1 user of this name, the login will fail
if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
	session_start();
	$_SESSION["myusername"] = $myusername;
	$_SESSION["mypassword"] = $mypassword; 
	// Assign database records to session
	while ($dbrecord = mysql_fetch_array($result)){
		$_SESSION["admin"] = $dbrecord["adminuser"];
		$_SESSION["super"] = $dbrecord["supervisor"];
		$_SESSION["mgr"] = $dbrecord["manager"];
		$_SESSION["user"] = $dbrecord["userid"];
		$_SESSION["first"] = $dbrecord["userfirst"];
		$_SESSION["dept"] = $dbrecord["deptid"];

	}
	if ($_SESSION["admin"] ==1){
		header("location:login_success.php");}
		else		
			{ if ($_SESSION["mgr"] ==1){
				header("location:mgr_loginsuccess.php");}
				else
					{if ($_SESSION["super"] ==1){
						header("location:super_loginsuccess.php");}
						else
							{header("location:my-acks.php");}
}}}
else {
	echo "<br><link rel='stylesheet' type='text/css' href='style.css'><p><center><b><h1>Document Management System</h1><br><br>Wrong Username or Password</b></p><a href='index.php'>TRY LOGIN AGAIN</a>";
}
?>