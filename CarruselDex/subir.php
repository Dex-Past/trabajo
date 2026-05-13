<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: auth.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagen"])) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $directorio = "img_carrusel/";
    
    // Generar un nombre único para evitar que se sobreescriban fotos iguales
    $nombreArchivo = time() . "_" . basename($_FILES["imagen"]["name"]);
    $rutaFinal = $directorio . $nombreArchivo;

    // Mover archivo físico
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaFinal)) {
        // Guardar ruta en BD
        $sql = "INSERT INTO imagenes (nombre, ruta) VALUES ('$nombre', '$rutaFinal')";
        mysqli_query($conn, $sql);
    }
}

// Regresar al panel
header("Location: admin.php");
exit();
?>