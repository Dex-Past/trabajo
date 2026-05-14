<?php
session_start();
require 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Para fines prácticos en XAMPP local, creamos el usuario si no existe, o lo logueamos
    $check = mysqli_query($conn, "SELECT * FROM usuarios WHERE username='$username'");
    
    if (mysqli_num_rows($check) == 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO usuarios (username, password) VALUES ('$username', '$hash')");
        $_SESSION['user'] = $username;
        header("Location: index.php");
    } else {
        $row = mysqli_fetch_assoc($check);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
        } else {
            $error = "Contraseña incorrecta";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Carrusel</title>
    <style>
    body { background: #0a0a0c; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-card { 
        background: #16161e; padding: 40px; border-radius: 15px; 
        border: 1px solid #a855f7; box-shadow: 0 0 20px rgba(168, 85, 247, 0.2); 
        width: 320px; text-align: center;
    }
    h2 { color: #f3f4f6; margin-bottom: 30px; }
    input { 
        width: 100%; padding: 12px; margin: 10px 0; background: #0a0a0c; 
        border: 1px solid #333; color: white; border-radius: 8px; box-sizing: border-box;
    }
    input:focus { border-color: #a855f7; outline: none; }
    .btn-login { 
        background: #a855f7; color: white; width: 100%; padding: 12px; 
        border: none; border-radius: 8px; font-weight: bold; cursor: pointer;
    }
</style>
</head>
<body>
    <div class="login-card">
        <h2>Bienvenido</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar / Registrarse</button>
            <?php if($error) echo "<div class='error'>$error</div>"; ?>
        </form>
    </div>
</body>
</html>