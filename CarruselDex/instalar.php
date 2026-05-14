<?php
// Credenciales del servidor real
$host = "localhost";
$user = "dpastrana";
$pass = "1234";
$db   = "dpastrana";

$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("<h2 style='color:red;'>Error de conexión: " . mysqli_connect_error() . "</h2>
         <p>Verifica que el usuario <strong>dpastrana</strong> existe en MySQL y tiene permisos sobre la base de datos <strong>dpastrana</strong>.</p>");
}

mysqli_set_charset($conn, "utf8");

// 1. Crear tabla de usuarios
$sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$r1 = mysqli_query($conn, $sql_usuarios);

// 2. Crear tabla de imágenes
$sql_imagenes = "CREATE TABLE IF NOT EXISTS imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    ruta VARCHAR(255)
)";
$r2 = mysqli_query($conn, $sql_imagenes);

// 3. Crear carpeta para las fotos si no existe
if (!file_exists('img_carrusel')) {
    mkdir('img_carrusel', 0755, true);
}

// 4. Resultado
echo "<div style='background:#0c0a1a; color:white; padding:40px; font-family:sans-serif; text-align:center; min-height:100vh;'>";
if ($r1 && $r2) {
    echo "<h2 style='color:#10b981;'>¡Instalación Exitosa! 🚀</h2>";
    echo "<p>Tablas <strong>usuarios</strong> e <strong>imagenes</strong> creadas en la base de datos <strong>dpastrana</strong>.</p>";
    echo "<p style='color:#f59e0b;'>⚠️ <strong>Elimina este archivo (instalar.php) del servidor por seguridad.</strong></p>";
    echo "<a href='auth.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#8b5cf6; color:white; text-decoration:none; border-radius:8px;'>Ir al Login</a>";
} else {
    echo "<h2 style='color:#ef4444;'>Error al crear tablas</h2>";
    echo "<p>" . mysqli_error($conn) . "</p>";
}
echo "</div>";
?>
