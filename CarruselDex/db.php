<?php
$host = "localhost";
$user = "root";
$pass = ""; // En XAMPP va vacío por defecto
$db   = "carrusel_light_db";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("<h3 style='color:red;'>Error conectando a XAMPP: " . mysqli_connect_error() . "</h3>");
}
mysqli_set_charset($conn, "utf8");
?>