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
        }else {include 'user-header.html';
        $backlink = "my-acks.php";
        }}}
	echo "<br>"; 



 //Assign and Insert data into files table
 
include 'dbconnect.php';
$ackid = $_GET['id'];

$sql="UPDATE acks SET ackbit = 1, moddate=now() where ackid = '$ackid'";
$result = mysql_query($sql);

// Did it insert correctly
if($result){
	echo "Successful Update.";
	//echo "<br> $sql";
	echo "<BR>";
	echo "<a href='".$backlink."'>Back to Acknowledgements</a>";
}

else {
echo "ERROR";
}


 include 'footer.php'; ?>
