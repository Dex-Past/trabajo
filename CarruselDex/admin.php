<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: auth.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM imagenes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Aurora</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0c0a1a; color: white; margin: 0; padding: 20px; }
        body::before { content: ''; position: fixed; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at 50% 50%, rgba(139, 92, 246, 0.15), transparent 60%); z-index: -1; }
        .header { display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 15px 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .btn-logout { background: rgba(239, 68, 68, 0.8); color: white; padding: 8px 15px; text-decoration: none; border-radius: 8px; }
        .container { display: flex; gap: 20px; flex-wrap: wrap; }
        .glass-panel { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); flex: 1; min-width: 300px; }
        input[type="text"], input[type="file"] { width: 100%; padding: 12px; margin: 10px 0; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 8px; box-sizing: border-box;}
        button { background: linear-gradient(90deg, #8b5cf6, #ec4899); color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .img-preview { width: 80px; height: 50px; object-fit: cover; border-radius: 5px; }
        .btn-edit { background: #3b82f6; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 13px;}
        .btn-delete { background: #ef4444; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 13px;}
    </style>
</head>
<body>
    <div class="header">
        <h2>Panel Administrativo Aurora</h2>
        <span>Bienvenido, <b><?php echo $_SESSION['user']; ?></b> | <a href="auth.php" class="btn-logout">Cerrar Sesión</a></span>
    </div>
    <div class="container">
        <div class="glass-panel" style="flex: 0.5;">
            <h3>Subir Nueva Imagen</h3>
            <form action="subir.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Nombre de la imagen" required>
                <input type="file" name="imagen" accept="image/*" required>
                <button type="submit">Subir al Servidor</button>
            </form>
        </div>
        <div class="glass-panel" style="flex: 1.5;">
            <h3>Imágenes Registradas</h3>
            <table>
                <tr><th>Vista</th><th>Nombre</th><th>Acciones</th></tr>
                <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><img src="<?php echo $row['ruta']; ?>" class="img-preview"></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn-edit">Editar</a>
                        <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('¿Seguro que deseas eliminarla?');">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>