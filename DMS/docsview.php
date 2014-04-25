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
        }else {include 'user-header.html';
        $backlink = "my-acks.php";
        }}}
	echo "<br>"; ?>
<html>
<head>
<title>DOCUMENT MANAGEMENT SYSTEM - DOCUMENTS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body><h6>Below are the current documents in the system.  To view a copy, <br>click on the document name and the current version of that document will download in Word format.</h6>
<table border="1">
  <tr>
    <td align="center"><b>VIEW CONTROLLED DOCUMENTS</b></td>
  </tr>
  <tr>
    <td>
      <table border="0">
	  <tr><th>Document Name</th><th>Current Version</th></tr>
      <?
	  //List the documents and create an edit link
      include"dbconnect.php";//database connection
      $sql = "SELECT * FROM files ORDER BY docname";
      $result = mysql_query($sql);
      while ($row=mysql_fetch_array($result)){
        echo ("<td> <a href=\"http://svweb.monadnock.com/documents/documentdata/$row[filename]\">$row[docname]<a> </td><td>$row[versionid]</td>");
     		echo ("</tr>");
      }
      ?>
      </table>
    </td>
   </tr>
</table>

</body>
</html>
<? include 'footer.php'; ?>