<?php

require_once 'db.php';

$nombre = $_POST['nombre'];
$email  = $_POST['email'];

$db = conectarDB();

try {
    $sql   = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $query = $db->prepare($sql);

    $resultado = $query->execute([
        'nombre' => $nombre,
        'email'  => $email
    ]);

    if ($resultado) {
        echo "¡Guardado exitosamente! <a href='index.html'>Volver</a>";
    }

} catch (PDOException $e) {
    echo "Error al insertar: " . $e->getMessage();
}

?><?php

require_once 'db.php';

$nombre = $_POST['nombre'];
$email  = $_POST['email'];

$db = conectarDB();

try {
    $sql   = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $query = $db->prepare($sql);

    $resultado = $query->execute([
        'nombre' => $nombre,
        'email'  => $email
    ]);

    if ($resultado) {
        echo "¡Guardado exitosamente! <a href='index.html'>Volver</a>";
    }

} catch (PDOException $e) {
    echo "Error al insertar: " . $e->getMessage();
}

?>
