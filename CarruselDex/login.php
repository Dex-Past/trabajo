<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_input = mysqli_real_escape_string($conexion, $_POST['username']);
    $pass_input = $_POST['password'];

    // Usamos 'usuario' que es el nombre en tu BD
    $query = "SELECT * FROM usuarios WHERE usuario = '$user_input'";
    $res = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($res)) {
        // Usamos 'password_hash' que es el nombre en tu BD
        if (password_verify($pass_input, $row['password_hash'])) {
            $_SESSION['usuario'] = $row['usuario'];
            header("Location: admin.php");
            exit();
        }
    }
    $error = "Credenciales incorrectas";
}
?>