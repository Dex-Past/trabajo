<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = (int)$_GET['id'];

// Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    mysqli_query($conn, "UPDATE imagenes SET nombre='$nuevo_nombre' WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// Obtener datos actuales
$res = mysqli_query($conn, "SELECT * FROM imagenes WHERE id=$id");
$img = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Imagen</title>
    <style>
        body { background: #0c0a1a; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif;}
        .glass-box { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 40px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); width: 300px; text-align: center; }
        input { width: 100%; padding: 12px; margin: 15px 0; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }
        img { width: 100%; border-radius: 8px; margin-bottom: 15px; }
        a { color: #cbd5e1; text-decoration: none; display: block; margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="glass-box">
        <h3>Editar Nombre</h3>
        <img src="<?php echo $img['ruta']; ?>" alt="Preview">
        <form method="POST">
            <input type="text" name="nombre" value="<?php echo $img['nombre']; ?>" required>
            <button type="submit">Actualizar</button>
        </form>
        <a href="admin.php">← Volver al Panel</a>
    </div>
</body>
</html>