<?php
$conn = mysqli_connect("localhost", "root", "", "portafolio");

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$conn->set_charset("utf8mb4");

?>