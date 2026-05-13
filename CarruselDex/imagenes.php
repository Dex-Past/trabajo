<?php
// Permite que otras páginas lean esta respuesta JSON
header('Content-Type: application/json');
require 'db.php';

$sql = "SELECT id, nombre, ruta FROM imagenes ORDER BY id DESC";
$resultado = mysqli_query($conn, $sql);

$imagenes = array();

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $imagenes[] = $row;
    }
}

// Imprime todo el arreglo en formato JSON
echo json_encode($imagenes);
?>