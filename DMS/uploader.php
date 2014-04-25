<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include "dbconnect.php"; //database connection

//Actual file storage
 $target = "documentdata/"; 
 $allfiles = glob($target . "*.*");
 
 $target = $target . basename( $_FILES['uploaded']['name']) ; 
 $ok=1; 
 if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
 {
 echo "The file ". basename( $_FILES['uploaded']['name']). " has been uploaded. <br><br><br>";


 }else {
 echo "Sorry, there was a problem uploading your file.";
 }
//Find last fileid to predict the next one
	$runmax = mysql_query("SELECT MAX(fileid) as max_id FROM files");
	while($row = mysql_fetch_array($runmax)) {
			$newfileid = $row['max_id']+1;
			}
	//echo $newfileid;
 
 //Rename file with FileID and VersionID
	$filename=$_FILES['uploaded']['name'];
	$version=($_POST['version']);
	$newfilename=$newfileid . $version.".doc";
	if (rename("documentdata/".$filename, "documentdata/".$newfilename)){
		echo "File has been renamed and the version marked.";
		}else{
		echo "An error has occured, please call IS.";}

 //echo $newfilename;
 
 //Insert data into files table

	$doc=$_POST['docname'];
	//$dir=$_POST['directory'];
	$ownerid=$_POST['user'];
        $summary = $_POST['summary'];


	$sql="INSERT INTO files(docname, filename, ownerid, versionid, summary) VALUES ('$doc', '$newfilename', '$ownerid', '$version', '$summary')";
	$result=mysql_query($sql);

	


 include 'footer.php'; ?>
