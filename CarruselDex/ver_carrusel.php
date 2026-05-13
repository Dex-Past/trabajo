<?php
require 'db.php';
$query = mysqli_query($conn, "SELECT * FROM imagenes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista de Carrusel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        body {
            background: #0f172a;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .swiper {
            width: 80%;
            max-width: 900px;
            height: 500px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .caption {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            font-family: sans-serif;
        }
    </style>
</head>
<body>

    <div class="swiper">
        <div class="swiper-wrapper">
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <div class="swiper-slide">
                    <img src="<?php echo $row['ruta']; ?>" alt="<?php echo $row['nombre']; ?>">
                    <div class="caption"><?php echo htmlspecialchars($row['nombre']); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
        <!-- Controles -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: { delay: 3000 },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    </script>
</body>
</html>