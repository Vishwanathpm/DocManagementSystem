<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
header("location:secured.php");}
include 'header.html';
include "dbconnect.php";//database connection
//Get list of users to assign the owner		
			$query2 = "SELECT userid, userfirst, userlast FROM users ORDER BY userlast";
			$result2 = mysql_query($query2) or die(mysql_error());
			$dropdown2 = "<select name='user'>";
			while($row2 = mysql_fetch_assoc($result2)) {
			$dropdown2 .= "\r\n<option value='{$row2['userid']}'>{$row2['userlast']}, {$row2['userfirst']} </option>";
			}
			$dropdown2 .= "\r\n</select>";
			
      ?> 

<form enctype="multipart/form-data" action="uploader.php" method="POST">

	Document Name:<input name="docname" type="text" id="docname"><br>
	<? //Directory Name: <input name="directory" type="text" id="directory"><br> 
	//<input type="hidden" name="version" value="0">?>
	Owner:  <? echo $dropdown2; ?><br><br>
	Please choose a file: 
	<br><input name="uploaded" type="file" /><br /><br />
	Starting Revision Number: <input name="version" type="text" id="version"><br><br>
        Summary of Changes: <br> <textarea name="summary" ROWS="3" COLS="25" id="summary"></textarea><br><br>
	<input type="submit" value="Upload" />
        
 </form>
 
 <?php
 include 'footer.php'; ?>