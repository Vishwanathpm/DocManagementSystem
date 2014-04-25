<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'super-header.html';
?>

<html>
<body>
<center>
<b><h6>Login Successful: </b><i>
<?php 
$currentuser = $_SESSION["user"];
$currentdept = $_SESSION["dept"];

echo ('User: '.$_SESSION["myusername"].'::');
if ($_SESSION["admin"] == 1){
	echo "Admin,  ";
	}
if ($_SESSION["super"] == 1) {
	echo "Supervisor<br>";
	}
	
//List the documents and create an ackbit set link
	echo "</h6></i><b><h3>Your Requests</h3></b><table border='0'><tr><th>User</th><th>Document</th><th>Ack</th><th>Sent</th></tr>";
    
	include"dbconnect.php";//database connection
    $users = "SELECT * FROM acks, users, files where acks.userid = '$currentuser' and acks.userid=users.userid and acks.fileid=files.fileid and acks.ackbit IS NULL";
    $result = mysql_query($users);

	while ($row=mysql_fetch_array($result)){
        echo ("<tr><td> $row[username] </td><td> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\">$row[docname]<a> </td>");
        echo ("<td><a href=\"userack.php?id=$row[ackid]\">Ack</a> </td>");
			if ($row[acksent]==1){
				echo ("<td>Sent $row[moddate]</td></tr>");
			}else{
	    echo ("<td></td></tr>");
		}
      }
      echo ("</table>");
     
 //List all the Acknowledgements for the Department
	
     echo "</i><b><h3>Department Requests</h3></b><table border='0'><tr><th>User</th><th>Document & Version</th><th>Ack</th><th>Sent</th></tr>";
     echo "<h6>The users below are those in your department that have not acknowledged a document change yet.<br>  If you have trained them on this document change, you can click ACK beside the document name. <br> This will record as being clicked by their supervisor.";
	include"dbconnect.php";//database connection
    $users = "SELECT * FROM acks, users, files where users.deptid = '$currentdept' and acks.userid <> '$currentuser' and acks.userid=users.userid and acks.fileid=files.fileid and acks.ackbit IS NULL";
    $result = mysql_query($users);

	while ($row=mysql_fetch_array($result)){
        echo ("<tr><td> $row[username] </td><td> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\">$row[docname] - $row[versionid]<a> </td>");
        echo ("<td><a href=\"supack.php?id=$row[ackid]\">Ack</a> </td>");
			if ($row[acksent]==1){
				echo ("<td>Sent $row[moddate]</td></tr>");
			}else{
	    echo ("<td></td></tr>");
		}
      }
      echo ("</table>");



include 'footer.php'; ?>
</body>
</html>