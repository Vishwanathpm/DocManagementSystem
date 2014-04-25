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
        }else {}}}


    include"pdodbconnect.php";//database connection
              
//Get the Userid of current session user and FileID and VersionID from previous page
      $fileid = $_GET['fid'];
      $versionid = $_GET['vid']-1;
      $currentuser = $_SESSION['user'];        
                
                
                
	echo "<br>" ?>
<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - CHECKBOX TEST</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form method="post" action="auto_ack_insert.php">
      <?php
      
      

      echo 'File:  '.$fileid.' Version:  '.($versionid+1).' Userid:  '.$currentuser;
      echo '<br><h6>Listed below are the users you can forward this request to.  The ones that are checked are those that have<br>';
      echo 'recieved requests for previous versions of this document.  You can choose to check any who need to see it.</h6>';
          
        //List the users and create an ack link
               
      
      
       
        $result = $conn->prepare('SELECT ux.userid, ux.userfirst, ux.userlast, d.deptname, (select count(*) from acks where fileid = ? and versionid = ? and userid = ux.userid) as selected FROM users u
                        inner join mgrdepts md
                        on u.userid = md.mgrid
                        inner join users ux
                        on md.deptid = ux.deptid
			inner join departments d
			on ux.deptid = d.deptid
                        where u.userid = ? and ux.userid <> ? ORDER BY ux.userlast');
                
	$result->bindParam(1, $fileid, PDO::PARAM_INT);
        $result->bindParam(2, $versionid, PDO::PARAM_INT);
        $result->bindParam(3, $currentuser, PDO::PARAM_INT);
        $result->bindParam(4, $currentuser, PDO::PARAM_INT);
			
        $result->execute();
	
        echo '<table width="300">';
        
        //While Statement loads an array of data and looks to see if user was sent a request for previous version of document, if so, a check is inserted
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$selected = $row[selected]>0 ? 'checked' : '';
                                echo "<tr><td><input type='checkbox' name='requsers[]' value='{$row['userid']}' $selected></td><td><b>{$row['userlast']}, {$row['userfirst']}</b></td><td>{$row['deptname']}</td></tr>";
				}
	echo '</table>';		
			
$versionid = $versionid+1;      
echo "<input type='hidden' name='file' value='{$fileid}'><input type='hidden' name='version' value='{$versionid}'>";
 ?>
    <input type="submit" 
          name="submit value" value="Forward Requests">
</form>

<?php
include 'footer.php';
?>
