<?php

$pdo = new PDO('mysql: host=localhost; port=3306; dbname=questiontest','question', 'test');
?>
<?php
$host = 'localhost';
$dbname = 'questiontest';
$port = '3306';
$username = 'question';
$password = 'test';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} 
catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
?>