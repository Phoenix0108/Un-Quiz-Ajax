<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "siteajax";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "<script>console.log('Connection OK');</script>";
}
?>
