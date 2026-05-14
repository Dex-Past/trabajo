<?php
session_start();
require 'db.php';

// 1. Verificación de sesión
if (!isset($_SESSION['user'])) {
    header("Location: auth.php");
    exit();
}

// 2. Lógica para eliminar imagen
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $res = mysqli_query($conn, "SELECT ruta FROM imagenes WHERE id = $id");
    if ($img = mysqli_fetch_assoc($res)) {
        if (file_exists($img['ruta'])) unlink($img['ruta']);
        mysqli_query($conn, "DELETE FROM imagenes WHERE id = $id");
    }
    header("Location: index.php");
    exit();
}

// 3. Lógica para subir imágenes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagen"])) {
    $directorio = "img_carrusel/";
    if (!file_exists($directorio)) mkdir($directorio, 0777, true);
    
    $nombreArchivo = time() . "_" . basename($_FILES["imagen"]["name"]);
    $rutaFinal = $directorio . $nombreArchivo;
    
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaFinal)) {
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        mysqli_query($conn, "INSERT INTO imagenes (nombre, ruta) VALUES ('$nombre', '$rutaFinal')");
    }
    header("Location: index.php");
    exit();
}

// 4. Obtener imágenes para el carrusel y la galería
$query = mysqli_query($conn, "SELECT * FROM imagenes ORDER BY id DESC");
$imagenes_carrusel = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPanel - Deep Purple Edition</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        :root {
            --bg-dark: #0a0a0c;
            --card-bg: #16161e;
            --accent: #a855f7; 
            --accent-hover: #c084fc;
            --danger: #ef4444;
            --text-main: #f3f4f6;
            --text-dim: #9ca3af;
        }
        body { background: var(--bg-dark); font-family: 'Segoe UI', sans-serif; color: var(--text-main); margin: 0; padding: 20px; }
        .main-wrapper { max-width: 1100px; margin: auto; }
        
        .header { 
            display: flex; justify-content: space-between; align-items: center; 
            background: #111118; padding: 15px 30px; border-radius: 12px; 
            border: 1px solid #222; margin-bottom: 25px;
        }
        .header h2 { margin: 0; font-size: 1.5rem; }
        .header h2 span { color: var(--accent); }
        .btn-logout { 
            border: 1px solid var(--danger); color: var(--danger); 
            padding: 8px 18px; text-decoration: none; border-radius: 8px; font-size: 0.85rem;
            transition: 0.3s;
        }
        .btn-logout:hover { background: var(--danger); color: white; }

        /* CARRUSEL ADAPTABLE */
        .swiper { 
            width: 100%; height: 450px; border-radius: 15px; 
            background: #000; border: 1px solid #222; margin-bottom: 30px;
        }
        .swiper-slide { display: flex; align-items: center; justify-content: center; position: relative; }
        .swiper-slide img { 
            max-width: 100%; max-height: 100%; 
            object-fit: contain; 
        }
        .caption {
            position: absolute; bottom: 20px; left: 20px;
            background: rgba(168, 85, 247, 0.7); padding: 5px 15px;
            border-radius: 5px; font-weight: bold; backdrop-filter: blur(5px);
        }

        .dashboard-grid { display: grid; grid-template-columns: 320px 1fr; gap: 20px; }
        @media (max-width: 800px) { .dashboard-grid { grid-template-columns: 1fr; } }

        .card { background: var(--card-bg); padding: 25px; border-radius: 15px; border: 1px solid #222; }
        h3 { color: var(--accent); margin-top: 0; border-left: 4px solid var(--accent); padding-left: 12px; margin-bottom: 20px; }

        input[type="text"], input[type="file"] { 
            width: 100%; padding: 12px; background: #0a0a0c; 
            border: 1px solid #333; border-radius: 8px; color: white; margin-bottom: 15px; 
            box-sizing: border-box;
        }
        input:focus { border-color: var(--accent); outline: none; }

        button { 
            width: 100%; background: var(--accent); border: none; padding: 12px; 
            color: white; font-weight: bold; border-radius: 8px; cursor: pointer; 
            transition: 0.3s;
        }
        button:hover { background: var(--accent-hover); transform: translateY(-2px); }
        
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 15px; }
        .img-item { background: #0a0a0c; border-radius: 12px; overflow: hidden; border: 1px solid #333; position: relative; }
        .img-item img { width: 100%; height: 110px; object-fit: cover; opacity: 0.8; transition: 0.3s; }
        .img-item:hover img { opacity: 1; }
        .img-item .name { padding: 8px; font-size: 0.75rem; text-align: center; color: var(--text-dim); }
        .btn-delete { 
            background: var(--danger); color: white; text-decoration: none; 
            display: block; text-align: center; padding: 6px; font-size: 0.75rem; 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="header">
            <h2>Admin<span>Panel</span></h2>
            <div class="user">
                <span style="color:var(--text-dim); margin-right:15px;">Hola, <b><?php echo $_SESSION['user']; ?></b></span>
                <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
            </div>
        </div>

        <!-- CARRUSEL -->
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($imagenes_carrusel as $img): ?>
                    <div class="swiper-slide">
                        <img src="<?php echo $img['ruta']; ?>">
                        <div class="caption"><?php echo htmlspecialchars($img['nombre']); ?></div>
                    </div>
                <?php endforeach; ?>
                <?php if(empty($imagenes_carrusel)): ?>
                    <div class="swiper-slide">
                        <p style="color:var(--text-dim)">No hay imágenes aún</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next" style="color:var(--accent)"></div>
            <div class="swiper-button-prev" style="color:var(--accent)"></div>
        </div>

        <div class="dashboard-grid">
            <!-- FORMULARIO -->
            <div class="card">
                <h3>Subir Nueva</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="nombre" placeholder="Título de la imagen..." required>
                    <input type="file" name="imagen" accept="image/*" required>
                    <button type="submit">Agregar al Carrusel</button>
                </form>
            </div>

            <!-- GALERÍA -->
            <div class="card">
                <h3>Gestión de Galería</h3>
                <div class="gallery-grid">
                    <?php foreach ($imagenes_carrusel as $img): ?>
                        <div class="img-item">
                            <img src="<?php echo $img['ruta']; ?>">
                            <div class="name"><?php echo htmlspecialchars($img['nombre']); ?></div>
                            <a href="?eliminar=<?php echo $img['id']; ?>" class="btn-delete" onclick="return confirm('¿Seguro que quieres eliminarla?')">Eliminar</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        new Swiper('.swiper', { 
            loop: true, 
            autoplay: { delay: 3000 }, 
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
        });
    </script>
</body>
</html>