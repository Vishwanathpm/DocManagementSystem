<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include 'whoami.php';
?>
<html>
<head>
<title>DOCUMENT CONTROL - REQUEST ACKNOWLEDGMENT</title>
</head>

<body>
<table border=1>
  <tr>
    <td align=center>AUTO GROUP ACK REQUEST</td>
  </tr>
    <tr>
    <td align=center><h6>Use this to create Acknowledgments for a Document that has had a previous version in the system. It will find the last list of people who acknowledge this document and request the new version be acknowledged.</h6></td>
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
      <form method="post" action="auto_ack_insert.php">
        <tr>        
          <td>File:</td>
          <td>
            <? echo $dropdown ?>
          </td>
        </tr>

        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Send Request for Multiple Users">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>