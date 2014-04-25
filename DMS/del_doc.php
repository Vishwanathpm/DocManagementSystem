<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include "dbconnect.php";//database connection
$uid = $_GET['id'];

		
?> 

<center><b>NOTE:  YOU ARE ABOUT TO DELETE A DOCUMENT!  <br>
Please click away if this is not what you want.</b></center><br>
<form enctype="multipart/form-data" action="deldocument.php" method="POST">
	<input type="hidden" name="id" value="<? echo "$uid"?>">

	<input type="submit" value="DELETE THIS FILE - CANNOT UNDO" />
 </form>
 
 <?php
 include 'footer.php'; ?>