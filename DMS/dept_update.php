<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';



 //Assign and Insert data into files table
 
include 'dbconnect.php';
$deptname = $_POST['deptname'];
$desc = $_POST['desc'];
$deptid = $_POST['id'];

$sql="UPDATE departments SET deptname='$deptname', descript = '$desc' WHERE deptid='$deptid'";
$result=mysql_query($sql);

// Did it insert correctly
if($result){
	echo "<b>Successful Update</b><br><br>";
	echo "<br> $sql";
	echo "<BR><br><br>";
	echo "<a href='departments.php'>Back to Departments</a>";
}

else {
echo "ERROR<br>";
echo "$sql";
}


 include 'footer.php'; ?>
