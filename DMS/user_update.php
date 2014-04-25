<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
	header("location:secured.php");
}
include 'header.html';



 //Assign and Update data into files table
 
include 'dbconnect.php';
$first = $_POST['userfirst'];
$last = $_POST['userlast'];
$uname = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$userid = $_POST['id'];
$super = $_POST['super'];
$admin = $_POST['admin'];
$deptid = $_POST['deptid'];
$manager = $_POST['manager'];
$mgrdept = $_POST['mgrdept'];

$sql="UPDATE users SET userfirst = '$first', userlast = '$last', username = '$uname', password = '$password', email = '$email', supervisor='$super', manager='$manager', adminuser='$admin', deptid='$deptid' WHERE userid='$userid'";
$result=mysql_query($sql);

// Did it insert correctly
if($result){
	echo "Successful Update of $first $last.<br>";
	echo "<br> $sql";
	echo "<br>";
	echo "<a href='users.php'>Back to Users</a>";
}

else {
echo "ERROR";
}
// Update managed department relationships
$killemall = mysql_query("DELETE FROM mgrdepts WHERE mgrid = '$userid'");

	foreach ($mgrdept as $selectedOption){
		$query = mysql_query("INSERT INTO mgrdepts SET mgrid='$userid', deptid='$selectedOption'");
		//echo "Added to Managed Departments Table:  ".$selectedOption."</br>";
		}

 include 'footer.php'; ?>
