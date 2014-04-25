<?php 
session_start();
if(!isset($_SESSION['myusername'])){
    header("location:index.php");
} 
include 'super-header.html';

echo "Terribly sorry, $first.  You do not have permission to view this page.";

include 'footer.php'; ?>