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
 echo "The file ". basename( $_FILES['uploaded']['name']). " has been uploaded. <br><br>";


 }else {
 echo "Sorry, there was a problem uploading your file.";
 }

 
 //Rename file with FileID and VersionID
	$filename=$_FILES['uploaded']['name'];
	$version=($_POST['version'])+1;
	$newfilename=$_POST['id'] . $version.".doc";
        $summary = $_POST['summary'];
	if (rename("documentdata/".$filename, "documentdata/".$newfilename)){
		echo "File has been renamed to ".$newfilename." and the version marked as ".$version.".";
		}else{
		echo "An error has occured, please call IS.";}

 //echo $version;
 
 //Insert data into files table
	$fid=$_POST['id'];
	$doc=$_POST['docname'];
	//$dir=$_POST['directory'];
	$ownerid=$_POST['user'];

	$sql="UPDATE files SET docname='$doc', filename='$newfilename', ownerid='$ownerid', versionid='$version', summary='$summary' WHERE fileid='$fid'";
	$result=mysql_query($sql);

//Check the results come back as true, meaning it ran right.
if($result){
	echo "<b><br>Successful Update</b><br><br>";
	//echo "<br> $sql";
	echo "<BR><br><br>";
	echo "<a href='docs.php'>Back to Docs</a>";
}

else {
echo "ERROR<br>";
echo "$sql";
}
	


 include 'footer.php'; ?>
