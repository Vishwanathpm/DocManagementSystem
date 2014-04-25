<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
$uid = $_GET['id'];
?>
<html>
<head>
<title>DOCUMENT CONTROL - REQUEST ACKNOWLEDGEMENT</title>
</head>

<body>
<table border=1>
  <tr>
    <td align=center>MODIFY ACKNOWLEDGEMENT REQUEST</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?
	  echo "The AckID is:".$uid;
      include "dbconnect.php";//database connection
      $order = "SELECT * FROM acks where ackid='$uid'";
      $result = mysql_query($order);
      $row = mysql_fetch_array($result);
      ?>
     
      <form method="post" action="ack_update.php">
	  <input type="hidden" name="id" value="<? echo "$uid"?>">
        <tr>        
          <td>File:</td>
          <td>
            <input type="text" name="file" size="10" value="<? echo "$row[fileid]"?>">
          </td>
        </tr>
        <tr>
          <td>User:</td>
		  <td>
            <input type="text" name="user" size="40" value="<? echo "$row[userid]"?>">
          </td>
        </tr>
        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Update Acknowledgement Request">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>