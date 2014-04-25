<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'mgr-header.html';
include 'whoami.php';
$userid = $_SESSION['user'];
?>
<html>
<head>
<title>MANAGER REQUEST ACKNOWLEDGEMENT</title>
</head>

<body>
<table border=1>
  <tr>
    <td align=center>ADD REQUEST</td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?php
	        include "dbconnect.php";//database connection
			$query = "SELECT fileid, docname FROM files ORDER BY docname";
			$result = mysql_query($query) or die(mysql_error());
			$dropdown = "<select name='file'>";
			while($row = mysql_fetch_assoc($result)) {
			$dropdown .= "\r\n<option value='{$row['fileid']}'>{$row['docname']}</option>";
			}
			$dropdown .= "\r\n</select>";
			
      ?>
      <form method="post" action="ack_insert.php">
        <tr>        
          <td>File:</td>
          <td>
            <? echo $dropdown ?>
          </td>
        </tr>
        <tr>
          <td>User:</td>
	<?php		
			$query2 = "SELECT ux.userid, ux.userfirst, ux.userlast FROM users u
inner join mgrdepts md
on u.userid = md.mgrid
inner join users ux
on md.deptid = ux.deptid
where u.userid = '$userid' ORDER BY ux.userlast";
			$result2 = mysql_query($query2) or die(mysql_error());
			$dropdown2 = "<select name='user'>";
			while($row2 = mysql_fetch_assoc($result2)) {
			$dropdown2 .= "\r\n<option value='{$row2['userid']}'>{$row2['userlast']}, {$row2['userfirst']} </option>";
			}
			$dropdown2 .= "\r\n</select>";
			
      ?>  
		  
		  <td>
            <? echo $dropdown2 ?>
          </td>
        </tr>
        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Request Acknowledgement">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>