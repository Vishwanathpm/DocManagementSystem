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
<title>DOCUMENT CONTROL - Department Edit</title>
</head>

<body>
<table border=1>
  <tr>
    <td align=center>EDIT DEPARTMENT</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?
	  echo "The Department ID is:".$uid;
      include "dbconnect.php";//database connection
      $order = "SELECT * FROM departments where deptid='$uid'";
      $result = mysql_query($order);
      $row = mysql_fetch_array($result);
      ?>
      <form method="post" action="dept_update.php">
      <input type="hidden" name="id" value="<? echo "$uid"?>">
        <tr>        
          <td>Department Name:</td>
          <td>
            <input type="text" name="deptname" size="40" value="<? echo "$row[deptname]"?>">
          </td>
        </tr>
        <tr>
          <td>Description:</td>
          <td>
            <input type="text" name="desc" size="80" 
          value="<? echo "$row[descript]"?>">
          </td>
        </tr>
        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Update Dept">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>