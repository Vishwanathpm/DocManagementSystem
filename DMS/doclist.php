<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
}
include 'header.html';
include 'filelist.php';
include 'footer.php';
?>
