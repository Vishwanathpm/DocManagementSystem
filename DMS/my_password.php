<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'my-header.html';
include 'whoami.php';
$uname = $_SESSION['myusername'];
?>
<html>
<head>
<title>DOCUMENT CONTROL - User Edit</title>
</head>

<body>
<table border=1>
  <tr>
    <td align=center>CHANGE PASSWORD</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?
	 // echo "The ID is:".$uid;
      include "dbconnect.php";//database connection
      $order = "SELECT * FROM users where username = '$uname'";
      $result = mysql_query($order);
      $row = mysql_fetch_array($result);
      ?>
      <form method="post" action="password_change.php">
      <input type="hidden" name="user" value="<? echo "$uname"?>">
       	<tr>
          <td>Type Password:</td>
          <td>
            <input type="password" name="password" size="40" 
          value="<? echo "$row[password]"?>">
          </td>
        </tr>

        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Update User">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>