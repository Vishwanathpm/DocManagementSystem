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
    <td align=center>ADD USER</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?
	        include "dbconnect.php";//database connection

      ?>
      <form method="post" action="user_insert.php">
        <tr>        
          <td>First Name:</td>
          <td>
            <input type="text" name="userfirst" size="40">
          </td>
        </tr>
        <tr>
          <td>Last Name:</td>
          <td>
            <input type="text" name="userlast" size="40">
          </td>
        </tr>
		<tr>
          <td>Username:</td>
          <td>
            <input type="text" name="username" size="40">
          </td>
        </tr>
		<tr>
          <td>Password:</td>
          <td>
            <input type="text" name="password" size="40">
          </td>
        </tr>
		<tr>
          <td>Email:</td>
          <td>
            <input type="text" name="email" size="40">
          </td>
        </tr>
		<tr>
          <td>Admin:</td>
          <td>
            <select name="admin">
				<option value="">NO</option>
				<option value="1">YES</option>
			</select>
          </td>
        </tr>
				<tr>
          <td>Supervisor:</td>
          <td>
            <select name="super">
				<option value="">NO</option>
				<option value="1">YES</option>
			</select>
          </td>
        </tr>
		<tr>
          <td>Department (Use Number, Not Name):</td>
          <td>
		        <?
	        include "dbconnect.php";//database connection
			$query = "SELECT deptid, deptname FROM departments";
			$result = mysql_query($query) or die(mysql_error());
			$dropdown = "<select name='deptid'>";
			while($row = mysql_fetch_assoc($result)) {
			$dropdown .= "\r\n<option value='{$row['deptid']}'>{$row['deptname']}</option>";
			}
			$dropdown .= "\r\n</select>";
			echo $dropdown
      ?>

          </td> 
        </tr>
        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Add User">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>