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
      <td align=center><b>ADD ACKNOWLEDGMENT REQUEST</b></td>
  </tr>
  <tr>
    <td>
      <table border=0>
      <?php
	
      //Create dropdown of all files in alphabetical order
      include "dbconnect.php";//database connection
			$query = "SELECT fileid, docname, versionid FROM files ORDER BY docname";
			$result = mysql_query($query) or die(mysql_error());
			$dropdown = "<select name='fileandversion'>";
			while($row = mysql_fetch_assoc($result)) {
                        $dropdown .= "\r\n<option value='{$row['fileid']}_{$row['versionid']}'>{$row['docname']}</option>";
			}
			$dropdown .= "\r\n</select>";
			
      ?>
      <form method="post" action="auto_ack_insert2.php">
        <tr>        
            <td><b>File:</b></td>
          <td>
            
            <?php
            // Shows the list of files pulled from database on line 23-30
            echo $dropdown ?>
              
          </td>
        </tr>
        <tr>
            <td valign="top"><b>User:</b></td>
	<?php		
        include "pdodbconnect.php";//database connection

//Get list of users to assign the owner		

        $result2 = $conn->prepare("SELECT userid, userfirst, userlast FROM users WHERE manager=1 ORDER BY userlast");
        $result2 -> execute();
        $dropdown2 = "<table class='small'>";
			while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
			$dropdown2 .= "<tr><td>\r\n<input type='checkbox' name='requsers[]' value='{$row2['userid']}'></td><td>{$row2['userlast']}, {$row2['userfirst']} </td></tr>";
			}
                        $dropdown2 .="</table>";
			
      ?>  
		  
		  <td>
            <?php echo $dropdown2 ?>
          </td>
        </tr>
        <tr>
          <td align="right">
            <input type="submit" 
          name="submit value" value="Request Acknowledgment">
          </td>
        </tr>
      </form>
      </table>
    </td>
  </tr>
</table>
<?php include 'footer.php'; ?>