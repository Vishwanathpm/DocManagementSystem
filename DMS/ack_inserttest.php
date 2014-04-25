<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if ($_SESSION["admin"] == 1){
	include 'header.html';
	$backlink = "login_success.php";
	} else {
		if ($_SESSION["super"] == 1) {
			include 'super-header.html';
			$backlink = "super_loginsuccess.php";
			} else {
				if ($_SESSION["mgr"] == 1) {
				include 'mgr-header.html';
				$backlink = "mgr_loginsuccess.php";
                                $addanother = "mgr_add_ack.php";
				}}}
	echo "<br>";




 //Assign and Insert data into files table
 
include 'dbconnect.php';
$file = $_POST['file'];
$user = $_POST['user'];

//Find current version of the selected file

$getver = mysql_query("SELECT versionid FROM files WHERE fileid = '$file'");

			while($row = mysql_fetch_assoc($getver)) {
			$versionid = $row['versionid'];
			}

//Execute insert into table

$sql="INSERT INTO acks SET userid = '$user', versionid = '$versionid', fileid = '$file', createdate=now() ";
$result=mysql_query($sql);

// Did it insert correctly
if($result){
	echo "Successful Update.<br>";
	//echo "<br> $sql";
	echo "<BR>";
	echo "<a href='".$addanother."'>Add Another Request</a><br><br>";
	echo "<a href='".$backlink."'>Back to Acknowledgement List</a>";
}

else {
echo "ERROR";
}


 include 'footer.php'; ?>
