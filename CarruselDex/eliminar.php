<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = (int)$_GET['id'];

// 1. Obtener la ruta para borrar el archivo físico
$res = mysqli_query($conn, "SELECT ruta FROM imagenes WHERE id=$id");
if ($row = mysqli_fetch_assoc($res)) {
    $rutaArchivo = $row['ruta'];
    
    // Si el archivo existe en la carpeta, lo borramos
    if (file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
    }
    
    // 2. Borrar de la base de datos
    mysqli_query($conn, "DELETE FROM imagenes WHERE id=$id");
}

header("Location: admin.php");
exit();
?>