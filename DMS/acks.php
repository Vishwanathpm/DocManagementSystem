<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
	header("location:secured.php");
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
      include"dbconnect.php";//database connection
      $users = "SELECT * FROM acks, users, files where acks.userid=users.userid and acks.fileid=files.fileid and acks.ackbit IS NULL";
      $result = mysql_query($users);
      while ($row=mysql_fetch_array($result)){
        echo ("<td> $row[username] </td><td><a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\">$row[docname]<a></td>");
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
<a href="add_ack.php">CREATE ACKNOWLEDGEMENT REQUEST HERE</a><br><br>


<?php

include 'footer.php';
?>
