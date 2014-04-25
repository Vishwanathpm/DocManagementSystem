<?php
$db = new PDO('mysql:host=localhost;dbname=documents;charset=utf8', 'root', '1-password');

try {
    //connect as appropriate as above
    $db->query('hi'); //invalid query!
} catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    some_logging_function($ex->getMessage());
}
?>