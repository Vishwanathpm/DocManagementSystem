<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include 'whoami.php';
$uid = $_GET['id'];
?>
<html>
<head>
<title>DOCUMENT CONTROL - User Edit</title>
</head>

<body>
<table border=1>
  <tr>
    <td align=center>EDIT USER</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?
      include "pdodbconnect.php";//database connection
      $order = $conn->prepare('SELECT * FROM users where `userid` = ?');
	  $order->bindParam(1, $uid, PDO::PARAM_INT);
      $order->execute();
      $row = $order->fetch(PDO::FETCH_ASSOC);
      ?>
      <form method="post" action="user_update.php">
      <input type="hidden" name="id" value="<? echo "$uid"?>">
        <tr>        
          <td>First Name:</td>
          <td>
            <input type="text" name="userfirst" size="40" value="<? echo "$row[userfirst]"?>">
          </td>
        </tr>
        <tr>
          <td>Last Name:</td>
          <td>
            <input type="text" name="userlast" size="40" 
          value="<? echo "$row[userlast]"?>">
          </td>
        </tr>
		<tr>
          <td>Username:</td>
          <td>
            <input type="text" name="username" size="40" 
          value="<? echo "$row[username]"?>">
          </td>
        </tr>
		<tr>
          <td>Password:</td>
          <td>
            <input type="text" name="password" size="40" 
          value="<? echo "$row[password]"?>">
          </td>
        </tr>
		<tr>
          <td>Email:</td>
          <td>
            <input type="text" name="email" size="40" 
          value="<? echo "$row[email]"?>">
          </td>
        </tr>
		<tr>
          <td>Admin:</td>
          <td>
            <select name="admin">
			<?php $isadmin = $row[adminuser] == 1 ? 'selected="selected"' : ''; //If admin, choose the right one in dropdown ?>
				<option value="" <? echo $isadmin; ?>>NO</option>
				<option value="1" <? echo $isadmin; ?>>YES</option>
			</select>
          </td>
        </tr>
				<tr>
          <td>Supervisor:</td>
          <td>
		  <? $issuper = $row[supervisor] == 1 ? 'selected="selected"' : ''; //If super, choose the right one in dropdown ?>
            <select name="super">
				<option value="" <? echo $issuper; ?>>NO</option>
				<option value="1" <? echo $issuper; ?>>YES</option>
			</select>
          </td>
        </tr>
		<tr>
          <td>Manager:</td>
          <td>
		  <? $ismgr = $row[manager] == 1 ? 'selected="selected"' : ''; //If manager, choose the right one in dropdown ?>
            <select name="manager">
				<option value="" <? echo $ismgr; ?>>NO</option>
				<option value="1" <? echo $ismgr; ?>>YES</option>
			</select>
          </td>
        </tr>
		<tr>
          <td>ONLY IF A MANAGER, CHOOSE DEPARTMENTS MANAGED (hold CTRL and choose multiple departments if needed):</td>
          <td>
<?php

			// Retrieve all departments for the dropdown, and whether the user is a manager of it.
			$result3 = $conn->prepare('SELECT deptid, deptname, (select count(*) from mgrdepts where mgrid = ? and deptid = departments.deptid) as selected FROM departments ORDER BY deptname');
			$result3->bindParam(1, $uid, PDO::PARAM_INT);
			$result3->execute();
			$dropdown3 = "<select name='mgrdept[]' size='6' multiple='multiple'>";
			while($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
				$selected3 = $row3[selected]>0 ? 'selected="selected"' : '';
				$dropdown3 .= "\r\n<option value='{$row3['deptid']}' $selected3>{$row3['deptname']}</option>";
				}
			$dropdown3 .= "\r\n</select>";
			echo $dropdown3
			?>
          </td>
        </tr>
		<tr>
          <td>Department:</td>
          <td>
		 <?php 
            
			// Retrieve the departments in order to populate the dropdown list
	        include "dbconnect.php";//database connection
			$query2 = "SELECT * FROM departments ORDER BY deptname";
			$result2 = mysql_query($query2) or die(mysql_error());
			$dropdown = "<select name='deptid'>";
			while($row2 = mysql_fetch_assoc($result2)) {
				$selected = $row2[deptid] == $row[deptid] ? 'selected="selected"' : '';
				$dropdown .= "\r\n<option value='{$row2['deptid']}' $selected>{$row2['deptname']}</option>";
			}
			$dropdown .= "\r\n</select>";
			echo $dropdown
			?>
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