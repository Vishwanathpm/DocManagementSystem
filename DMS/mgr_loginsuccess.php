<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'mgr-header.html';
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
	echo "Admin:  ";
	}
if ($_SESSION["super"] == 1) {
	echo "Supervisor:";
	}
if ($_SESSION["mgr"] == 1) {
	echo "Manager";}
	echo "<br>";
	
//List the documents and create an ackbit set link
	echo "</h6></i><b><h3>Your Requests</h3></b>";
        echo "<h6><font color='red'><b>NOTE:  FORWARD the request before you ACKNOWLEDGE it, as it will disappear from the list.</h6></font></b>";
        echo "<table border='0'><tr style='background-color: #e1ddcf'><th>User</th><th>Document</th><th>Ack</th><th>Forward</th><th>Sent</th></tr>";
        
	include"dbconnect.php";//database connection
    $myacks = "SELECT * FROM acks, users, files where acks.userid = '$currentuser' and acks.userid=users.userid and acks.fileid=files.fileid and acks.ackbit IS NULL";
    $result = mysql_query($myacks);
	$i = 0;
	while ($row=mysql_fetch_array($result)){
        echo ("<tr style='background-color:".(($i % 2) ? '#e1ddcf' : 'white')."'><td> $row[username] </td><td> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\">$row[docname]</a></td>");
        echo ("<td><a href=\"userack.php?id=$row[ackid]\">Ack</a> </td>");
        echo ("<td><a href=\"checkboxtest.php?fid=$row[fileid]&vid=$row[versionid]\">Forward On</a>");
			if ($row[acksent]==1){
				echo ("<td>Sent $row[moddate]</td></tr>");
			}else{
	    echo ("<td></td></tr>");
		}
		$i++;
      }
      echo ("</table>");
	  
     
 //List all the Acknowledgements for the Departments, by Department
	
     echo "</i><b><h3>Requests in Your Department</h3></b>";
 ?>   
	<table border="0">
	  <tr style="background-color: #e1ddcf"><th>User</th><th>Document</th><th>Department</th><th>Resend</th><th>Ack</th><th>Sent</th></tr>

<?php
	  //List the users and create an edit link
	include 'pdodbconnect.php';

     
	$result = $conn->prepare('Select u.username, f.docname, a.ackid, a.userid, ux.username AS ackuser, a.acksent, a.moddate, d.deptname
        From	users u
		inner join mgrdepts md
			on u.userid = md.mgrid
		inner join departments d
			on md.deptid = d.deptid
		inner join users ux
			on md.deptid = ux.deptid
		inner join acks a
			on a.userid = ux.userid
		inner join files f
			on a.fileid = f.fileid
        WHERE u.userid = ?
		and a.ackbit IS NULL and ux.userid <> ?');
	$result->bindParam(1, $currentuser, PDO::PARAM_INT);
        $result->bindParam(2, $currentuser, PDO::PARAM_INT);
	$result->execute();
	$i = 0;
      while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        echo ("<tr style='background-color:".(($i % 2) ? '#e1ddcf' : 'white')."'><td> $row[ackuser] </td><td> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\">$row[docname] </a></td><td> $row[deptname]</td>");
        echo ("<td><a href=\"sendack.php?id=$row[userid]\">Send</a></td><td><a href=\"supack.php?id=$row[ackid]\">Ack</a> </td>");
		if ($row[acksent]==1){
			echo ("<td>Sent $row[moddate]</td></tr>");
			
			}else{
	    echo ("<td></td></tr>");
		}
		$i++;
		}
      
      ?>
      </table>



<? include 'footer.php'; ?>
</body>
</html>