<?php
// Configuración por defecto de XAMPP
$host = "localhost";
$user = "root";
$pass = "";

$conn = @mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("<h2 style='color:red;'>Error de conexión a XAMPP. ¿Están encendidos Apache y MySQL?</h2>");
}

// 1. Crear Base de Datos
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS aurora_db");
mysqli_select_db($conn, "aurora_db");

// 2. Crear Tablas
$sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $sql_usuarios);

$sql_imagenes = "CREATE TABLE IF NOT EXISTS imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    ruta VARCHAR(255)
)";
mysqli_query($conn, $sql_imagenes);

// 3. Crear carpeta para las fotos
if (!file_exists('img_carrusel')) {
    mkdir('img_carrusel', 0777, true);
}

echo "<div style='background:#0c0a1a; color:white; padding:40px; font-family:sans-serif; text-align:center; height:100vh;'>";
echo "<h2 style='color:#10b981;'>¡Instalación Exitosa! 🚀</h2>";
echo "<p>Base de datos, tablas y carpetas creadas correctamente en XAMPP.</p>";
echo "<p>Por favor, elimina este archivo por seguridad.</p>";
echo "<a href='auth.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#8b5cf6; color:white; text-decoration:none; border-radius:8px;'>Ir al Login</a>";
echo "</div>";
?>