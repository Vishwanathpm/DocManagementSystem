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

 //Get specific file ID from report form
 
include 'dbconnect.php';
$file = $_POST['file'];

//Get Document Name using fileid

$getnames = mysql_query("SELECT * FROM files WHERE fileid = $file");
	while ($rowx=mysql_fetch_array($getnames)){
		$document = $rowx['docname'];
		$currentver = $rowx['versionid'];
	}

//Report Heading

echo ("<h1>Document $document at Version $currentver </h1><br>");
echo  date('l jS \of F Y h:i:s A')."<br>";

//Execute display
echo ("<table border='0'><tr><th>Full Name</th><th>Department<th>Ack Date</th><th>Note</th></tr>");

$sql="SELECT * FROM users, acks, files, departments WHERE files.fileid = '$file' and acks.fileid  = files.fileid and acks.versionid=files.versionid and users.userid = acks.userid and departments.deptid=users.deptid and acks.ackbit=1";
$result=mysql_query($sql);
	while ($row=mysql_fetch_array($result)){
        echo ("<tr><td> $row[userfirst] $row[userlast]</td><td>$row[deptname]</td><td>$row[moddate]</td>");
		if ($row[supervisorset] == 1){
			echo ("<td>Ack by Supervisor: ");

			$supervisorid = $row[superid];

			$getsuper = mysql_query("SELECT * FROM users WHERE userid=$supervisorid");
			while ($rowz=mysql_fetch_array($getsuper)){
				$supername = $rowz[userfirst]." ".$rowz[userlast];
				echo ("$supername</td>");
				}
			}
			
	}
      echo ("</table>");

// Testing for SQL
//if($result){
//	echo "Successful<br>";
//	echo "<br> $sql";
//	echo "<BR>";
//	echo "<a href='login_success.php'>Back to Main</a>";
//}

//else {
//echo "ERROR";
//}


 include 'footer.php'; ?>
