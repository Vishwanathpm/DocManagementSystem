<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
?>
<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - DOCUMENTS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body><center><h6>Below are a list of Documents currently tracked by the system.</br>  To upload a NEW VERSION, click the EDIT link beside the Document Name.<br></h6>
<table border="1">
  <tr>
    <td align="center"><b>EDIT DOCUMENTS</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
	  <tr><th>Document Name</th><th>Current Version</th><th>Edit</th></tr>
      <?php
	  //List the documents and create an edit link
      include"dbconnect.php";//database connection
      $sql = "SELECT * FROM files ORDER BY docname";
      $result = mysql_query($sql);
      while ($row=mysql_fetch_array($result)){
        echo ("<td> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\">$row[docname]<a> </td><td>$row[versionid]</td>");
        echo ("<td><a href=\"edit_doc.php?id=$row[fileid]\">Edit</a></td></tr>");
		//echo ("<td><a href=\"del_doc.php?id=$row[fileid]\">Delete</a></td></tr>");
      }
      ?>
      </table>
    </td>
   </tr>
</table>

</body>
</html>
<? include 'footer.php'; ?>