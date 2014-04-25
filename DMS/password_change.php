<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'my-header.html';



 //Assign and Insert data into files table
 
include 'dbconnect.php';
$user = $_POST['user'];
$password = $_POST['password'];


$sql="UPDATE users SET password = '$password' WHERE username='$user'";
$result=mysql_query($sql);

// Did it insert correctly
if($result){
	echo "Successful Update of Password.";
	//echo "<br> $sql";
	echo "<BR><br>";
	echo "<a href='index.php'>Back to Login</a>";
}

else {
echo "ERROR";
}


 include 'footer.php'; ?>
