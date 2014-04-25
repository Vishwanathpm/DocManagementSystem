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
<title>DOCUMENT MANAGEMENT SYSTEM - Departments</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body><h6>NOTE:  If you need a Department changed, please contact <a href="mailto:tblanchette@mpm.com">Tammie Blanchette</a></h6>
<table border="1">
  <tr>
    <td align="center"><b>VIEW DEPARTMENTS</b></td>
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
        echo ("<td>No Edit Allowed</td></tr>");
      }
      ?>
      </table>
    </td>
   </tr>
</table><br><br>


<?php
include 'footer.php';
?>