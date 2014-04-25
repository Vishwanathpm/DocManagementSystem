<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include "dbconnect.php";//database connection
$uid = $_GET['id'];

		
?> 

<center><b><h6>NOTE:  By uploading a new Word Document, you are changing the version of this document.  <br>Please click away if this is not what you want.</h6></b></center><br>
<form enctype="multipart/form-data" action="newversion.php" method="POST">
	<input type="hidden" name="id" value="<? echo "$uid"?>">


	<?php
	//Populate the form with stored vaules of the document
	  echo "The Document FileID is:".$uid."<br>";
      $order = "SELECT * FROM files where fileid='$uid'";
      $result = mysql_query($order);
      $row = mysql_fetch_array($result);
      
	echo "Current Version is $row[versionid] <br><br>";
        $summary = $row[summary];
        ?>
        
	
<table><tr>
<td><b>Version:</b></td><td><input type="text" name="version" value="<? echo "$row[versionid]"?>">(This changes automatically, use only if version number is broken)</td></tr>
<tr><td><b>Document Name:</b></td><td><input name="docname" type="text" id="docname" size=80 value="<? echo "$row[docname]"?>"></td></tr>

	<tr><td><b>Owner:</b> </td><td> 
            <?php
			//Get list of users to assign the owner	and select the right dropdown item	
			
			$result2 = mysql_query("SELECT * FROM users ORDER BY userlast") or die(mysql_error());
			$dropdown2 = "<select name='user'>";
			while($row2 = mysql_fetch_assoc($result2)) {
				$selected = $row2[userid] == $row[ownerid] ? 'selected="selected"' : '';
				$dropdown2 .= "\r\n<option value='{$row2['userid']}' $selected >{$row2['userlast']}, {$row2['userfirst']} </option>";
				}
			$dropdown2 .= "\r\n</select>";	
			echo $dropdown2; ?></td></tr>
			
			
        <tr><td><b>Please choose a file:</b></td><td> 
	<input name="uploaded" type="file" /></td> </tr>
        <tr><td><b>Summary of changes in this version:</b></td><td><textarea name="summary" rows="6" cols="60"><? echo $summary;?></textarea></td></tr>
</table>
	<input type="submit" value="Upload New Version" />
 </form>
 
 <?php
 include 'footer.php'; ?>