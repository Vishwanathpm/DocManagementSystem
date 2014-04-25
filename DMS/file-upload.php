<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
header("location:secured.php");}

include 'header.html';
include "pdodbconnect.php";//database connection
//
//Get list of users to assign the owner		

$result = $conn->prepare("SELECT userid, userfirst, userlast FROM users ORDER BY userlast");
$result -> execute();
$dropdown = "<table class='small'>";
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$dropdown .= "<tr><td>\r\n<input type='checkbox' name='user[]' value='{$row['userid']}'></td><td>{$row['userlast']}, {$row['userfirst']} </td></tr>";
			}
                        $dropdown .="</table>";
						
      ?> 

<form enctype="multipart/form-data" action="uploader.php" method="POST">

	Document Name:<input name="docname" type="text" id="docname"><br>
	
	Owner:  <?php echo $dropdown; ?><br><br>
	Please choose a file: 
	<br><input name="uploaded" type="file" /><br /><br />
	Starting Revision Number: <input name="version" type="text" id="version"><br><br>
        Summary of Changes: <br> <textarea name="summary" ROWS="3" COLS="25" id="summary"></textarea><br><br>
	<input type="submit" value="Upload" />
        
 </form>
 
 <?php
 include 'footer.php'; ?>