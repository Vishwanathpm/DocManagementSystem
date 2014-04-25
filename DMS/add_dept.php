<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
$uid = $_GET['id'];
include 'whoami.php';
?>
<html>
<head>
<title>DOCUMENT CONTROL - ADD USER</title>
</head>

<body>
<table border=1>
  <tr>
    <td align=center>ADD DEPARTMENT</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?
	  include "dbconnect.php";//database connection

      ?>
      <form method="post" action="dept_insert.php">
        <tr>        
          <td>Department Name:</td>
          <td>
            <input type="text" name="deptname" size="40">
          </td>
        </tr>
        <tr>        
          <td>Description:</td>
          <td>
            <input type="text" name="desc" size="40">
          </td>
        </tr>
        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Add Department">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>