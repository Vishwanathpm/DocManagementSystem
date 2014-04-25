<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';



 //Assign and Insert data into files table
 
include 'dbconnect.php';
$file = $_POST['file'];
$user = $_POST['user'];
$ackid = $_POST['id'];

$sql="UPDATE acks SET fileid = '$file', userid = '$user', moddate = now() WHERE ackid='$ackid'";
$result=mysql_query($sql);

// Did it insert correctly
if($result){
	echo "<b>Successful Update</b><br><br>";
	echo "<br> $sql";
	echo "<BR><br><br>";
	echo "<a href='acks.php'>Back to Acknowledgements</a>";
}

else {
echo "ERROR";
}


 include 'footer.php'; ?>
