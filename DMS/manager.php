<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include 'pdodbconnect.php';
	
	$result = $conn->prepare('SELECT * FROM users ORDER BY userlast');
	$result->execute();
	
	echo "<form>";
	
	while ($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		echo "<input type='checkbox' name='".$row['username']."' value='".$row['userid']."'> ".$row['userlast'].", ".$row['userfirst']."<br>";

	}


include 'footer.php';

?>