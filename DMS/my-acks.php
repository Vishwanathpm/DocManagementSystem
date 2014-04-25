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
	echo "<br>"; ?>
<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - My Acknowledgements</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table border="1">
  <tr>
    <td align="center"><b>DOCUMENT ACKNOWLEDGEMENT REQUESTS</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
	  <tr><th>User</th><th>Document</th><th>Ack</th><th>Recvd</th></tr>
      <?
	  //List the users and create an ack link
      include"dbconnect.php";//database connection
	  $currentuser = $_SESSION['user'];
      $users = "SELECT * FROM acks, users, files where acks.userid='$currentuser' and acks.userid=users.userid and acks.fileid=files.fileid and acks.ackbit IS NULL";
      $result = mysql_query($users);
      while ($row=mysql_fetch_array($result)){
        echo ("<td> $row[username] </td><td><a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\"> $row[docname]</a> </td>");
        echo ("<td><a href=\"userack.php?id=$row[ackid]\">Ack</a> </td>");
		if ($row[acksent]==1){
			echo ("<td>Sent $row[moddate]</td></tr>");
			
			}else{
	    echo ("<td></td></tr>");
		}
      }
      ?>
      </table>
    </td>
   </tr>
</table>
    <h6><a href="logout.php">LOGOUT</a></h6>


<?php
include 'footer.php';
?>
