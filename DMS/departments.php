<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
header("location:secured.php");}
include 'header.html'; ?>
<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - Departments</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
    <a href="add_dept.php">CREATE DEPARTMENT</a><br>
    <h6>Clicking the green link above will allow you to create a new department.<br>
        If you click an EDIT link below, you can change the name of a department.</h6>
<table border="1">
  <tr>
    <td align="center"><b>EDIT DEPARTMENTS</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
      <?
	  //List the users and create an edit link
      include"dbconnect.php";//database connection
      $users = "SELECT * FROM departments ORDER BY deptname";
      $result = mysql_query($users);
      while ($row=mysql_fetch_array($result)){
        echo ("<td> $row[deptname] </td>");
        echo ("<td><a href=\"edit_dept.php?id=$row[deptid]\">Edit</a></td></tr>");
      }
      ?>
      </table>
    </td>
   </tr>
</table><br><br>


<?php
include 'footer.php';
?>