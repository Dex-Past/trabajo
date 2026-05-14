<?php
$host = "localhost";
$user = "dpastrana";
$pass = "1234";
$db   = "dpastrana";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("<h3 style='color:red;'>Error conectando a la base de datos: " . mysqli_connect_error() . "</h3>");
}
mysqli_set_charset($conn, "utf8");
?>
