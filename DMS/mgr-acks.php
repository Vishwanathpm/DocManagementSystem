<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'mgr-header.html'; 
include 'whoami.php';
$userid = $_SESSION['user'];?>

<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - Acknowledgement Requests</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body><center><a href="my-acks.php">See Only My Requests</a></center>
<table border="1">
  <tr>
    <td align="center"><b>EDIT ACKNOWLEDGEMENT REQUEST</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
	  <tr><th>User</th><th>Document</th><th>Department</th><th>Edit</th><th>Send</th><th>Ack</th><th>Sent</th></tr>

<?
	  //List the users and create an edit link
	include 'pdodbconnect.php';

    	$result = $conn->prepare('Select u.username, f.docname, a.ackid, a.userid, ux.username AS ackuser, a.acksent, a.moddate, d.deptname
        From	users u
		inner join mgrdepts md
			on u.userid = md.mgrid
		inner join departments d
			on md.deptid = d.deptid
		inner join users ux
			on md.deptid = ux.deptid
		inner join acks a
			on a.userid = ux.userid
		inner join files f
			on a.fileid = f.fileid
        WHERE u.userid = $userid
		and a.ackbit IS NULL');

	$result->execute();
	  
      while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        echo ("<td> $row[ackuser] </td><td> $row[docname] </td><td> $row[deptname]</td>");
        echo ("<td><a href=\"edit_ack.php?id=$row[ackid]\">Edit</a></td><td><a href=\"sendack.php?id=$row[userid]\">Send</a></td><td><a href=\"userack.php?id=$row[ackid]\">Ack</a> </td>");
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



<?php

include 'footer.php';
?>
