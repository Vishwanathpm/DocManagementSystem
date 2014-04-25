<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';


 //Assign and Insert data into files table
 
include 'dbconnect.php';
$dept = $_POST['deptname'];
$desc = $_POST['desc'];


$sql="INSERT INTO departments SET deptname = '$dept', descript = '$desc'";
$result=mysql_query($sql);

// Did it insert correctly
if($result){
	echo "Successfully added $dept.<br>";
	echo "<br> $sql";
	echo "<BR>";
	echo "<a href='departments.php'>Back to Departments</a><br>";
	echo "<a href='add_dept.php'>Add Another Departments</a>";
}

else {
echo "ERROR";
}


 include 'footer.php'; ?>
