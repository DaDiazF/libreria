<?php
$servername = "localhost"; 
$username = "root"; 
$pword = ""; 
$dbname = "libreria"; 

$conn = new mysqli($servername, $username, $pword, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
