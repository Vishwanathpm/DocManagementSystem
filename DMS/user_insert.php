<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
	header("location:secured.php");
}
include 'header.html';



 //Assign and Insert data into files table
 
include 'dbconnect.php';
$first = $_POST['userfirst'];
$last = $_POST['userlast'];
$uname = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$deptid = $_POST['deptid'];

$sql="INSERT INTO users SET userfirst = '$first', userlast = '$last', username = '$uname', password = '$password', email = '$email', deptid = '$deptid'";

if(isset($_POST['super'])){
$super = $_POST['super'];
$sql.=", supervisor='$super'";}


if(isset($_POST['admin'])){
$admin = $_POST['admin'];
$sql.=", adminuser='$admin'";}


if(isset($_POST['manager'])){
$manager = $_POST['manager'];
$sql.=", manager='$manager'";}



if(isset($_POST['mgrdept'])){
$mgrdept = $_POST['mgrdept'];
}



$result=mysql_query($sql);

// Did it insert correctly
if($result){
	echo "Successfully added $first $last.";
	echo "<BR>";
	echo "<a href='users.php'>Back to Users</a><br>";
	echo "<a href='add_user.php'>Add Another</a>";

}
else {
echo "ERROR";

}
// Get UserID just inserted and enter managed department relationships
if(isset($_POST['manager'])){
	$insertid = mysql_insert_id();
	foreach ($mgrdept as $selectedOption){
		$query = mysql_query("INSERT INTO mgrdepts SET mgrid='$insertid', deptid='$selectedOption'");
		echo "Added to Managed Departments Table:  ".$selectedOption."</br>";
		}}

 include 'footer.php'; ?>
