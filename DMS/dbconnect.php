<?php
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1-password"; // Mysql password 
$db_name="documents"; // Database name 
$tbl_name="users"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");
?>