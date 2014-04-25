<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include "dbconnect.php"; //database connection

//Remove from Files Table
	$fid=$_POST['id'];
	$sql="DELETE FROM files WHERE fileid='$fid'";
	$result=mysql_query($sql);

//Check the results come back as true, meaning it ran right.
if($result){
	echo "<b>Successful Deletion</b><br><br>";
	echo "<br> $sql";
	echo "<BR><br><br>";
	echo "<a href='docs.php'>Back to Docs</a>";
}

else {
echo "ERROR<br>";
echo "$sql";
}
	


 include 'footer.php'; ?>
