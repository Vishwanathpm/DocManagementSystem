<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html'; ?>

<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - Acknowledgements</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body><center><a href="my-acks.php">See Only My Acknowledgments</a></center>
<table border="1">
  <tr>
    <td align="center"><b>EDIT ACKNOWLEDGEMENT REQUEST</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
	  <tr><th>User</th><th>Document</th><th>Edit</th><th>Send</th><th>Ack</th><th>Sent</th></tr>

<?
	  //List the users and create an edit link
	include 'pdodbconnect.php';

      $result = $conn->prepare('SELECT * FROM acks, users, files where acks.userid=users.userid and acks.fileid=files.fileid and acks.ackbit IS NULL');
	  $result->execute();
	  
      while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        echo ("<td> $row[username] </td><td> $row[docname] </td>");
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
<a href="add_ack.php">CREATE ACKNOWLEDGEMENT REQUEST HERE</a><br>
<a href="auto_add_ack.php">AUTO ACK FOR NEW VERSION</a>

<?php

include 'footer.php';
?>
