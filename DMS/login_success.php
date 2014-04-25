<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
if($_SESSION['admin'] == 0){
header("location:secured.php");}
include 'header.html';
include 'whoami.php';
?>

<html>
<body>
    <a href="add_ack.php">CREATE NEW REQUEST</a><br><br>
<?php 

//List the documents and create an ackbit set link
	echo "</h6></i><b><h3>All Open Requests</h3></b>";
        echo "<h6> This table lists ALL open requests that have not been responded to.  It is in order of Document name, so that you can see<br> how many people are needed to respond to get a specific document complete.";
        echo "<br> You can respond FOR the user by clicking ACK.  You can change the Document in a request <br>by clicking EDIT, but you must then click SEND afterwards to be sure they see the update.<br>";
        echo "<table border='0'><tr><th>User</th><th>Document</th><th>Edit</th><th>Send</th><th>Ack</th><th>Sent</th></tr>";
    
	include"dbconnect.php";//database connection
   // $users = "SELECT * FROM acks, users, files where acks.userid=users.userid and acks.fileid=files.fileid and acks.ackbit IS NULL ORDER BY docname";
        $users = "select a.ackid, a.acksent, a.ackbit, a.versionid, a.moddate, f.filename, f.docname, f.summary, u.email, u.username, a.userid FROM acks a 
inner join files f
on a.fileid = f.fileid
inner join users u
on a.userid = u.userid
where a.ackbit IS NULL ORDER BY f.docname";
    $result = mysql_query($users);

	while ($row=mysql_fetch_array($result)){
        echo ("<tr><td> $row[username] </td><td> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\"> $row[docname] VERSION: $row[versionid]</a> </td>");
        echo ("<td><a href=\"edit_ack.php?id=$row[ackid]\">Edit</a></td><td><a href=\"sendack.php?id=$row[userid]_$row[ackid]\">Send</a></td><td><a href=\"supack.php?id=$row[ackid]\">Ack</a> </td>");
			if ($row[acksent]==1){
				echo ("<td>Sent $row[moddate]</td></tr>");
			}else{
	    echo ("<td></td></tr>");
		}
      }
      echo ("</table>");
     
    
      



include 'footer.php'; ?>
