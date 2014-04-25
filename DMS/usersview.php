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
	echo "<br>"; 
?>
<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - USERS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body><h6>NOTE:  If you need a user changed, please contact <a href="mailto:tblanchette@mpm.com">Tammie Blanchette</a></h6>
<table border="1">
  <tr>
    <td align="center"><b>VIEW USERS</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
	  <tr><th>Last Name</th><th>First Name</th><th>Dept</th><th>Edit</th></tr>
      <?
	  //List the users and create an edit link
	  
      include"dbconnect.php";//database connection
      $users = "SELECT * FROM users, departments WHERE users.deptid=departments.deptid ORDER BY users.userlast";
      $result = mysql_query($users);
	  $i = 0;
      while ($row=mysql_fetch_array($result)){
        echo ("<tr style='background-color:".(($i % 2) ? '#e1ddcf' : 'white')."'><td> $row[userlast] </td><td> $row[userfirst] </td><td> $row[deptname] </td>");
        echo ("<td>No Edit Allowed</td></tr>");
		$i++;
      }
      ?>
      </table>
    </td>
   </tr>
</table><br>

<? include 'footer.php'; ?>
</body>
</html>