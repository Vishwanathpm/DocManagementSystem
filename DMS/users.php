<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
	header("location:secured.php");
}
include 'header.html';
?>
<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - USERS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body><a href="add_user.php">ADD NEW USER</a>
<table border="1">
  <tr>
    <td align="center"><b>EDIT USERS</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
	  <tr><th>Last Name</th><th>First Name</th><th>Username</th><th>Dept</th><th>Edit</th></tr>
      <?
	  //List the users and create an edit link
	  
      include"dbconnect.php";//database connection
      $users = "SELECT * FROM users, departments WHERE users.deptid=departments.deptid ORDER BY users.userlast";
      $result = mysql_query($users);
	  $i = 0;
      while ($row=mysql_fetch_array($result)){
        echo ("<tr style='background-color:".(($i % 2) ? '#e1ddcf' : 'white')."'><td> $row[userlast] </td><td> $row[userfirst] </td><td> $row[username] </td><td> $row[deptname] </td>");
        echo ("<td><a href=\"edit_user.php?id=$row[userid]\">Edit</a></td></tr>");
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