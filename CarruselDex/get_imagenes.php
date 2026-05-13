<?php
include 'db.php';
header('Content-Type: application/json');

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'next';

// 1. Contar el total de registros
$res_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM imagenes");
$row_count = mysqli_fetch_assoc($res_count);
$total = $row_count['total'];

if ($total == 0) {
    echo json_encode(['success' => false, 'error' => 'No hay datos']);
    exit();
}

// 2. Calcular el siguiente índice
if ($direction == 'next') {
    $offset = ($offset + 1) % $total;
} else {
    $offset = ($offset - 1 + $total) % $total;
}

// 3. Obtener la imagen según el desplazamiento
$res = mysqli_query($conn, "SELECT * FROM imagenes LIMIT 1 OFFSET $offset");
$row = mysqli_fetch_assoc($res);

echo json_encode([
    'success' => true,
    'ruta' => $row['ruta'],
    'nombre' => $row['nombre'],
    'new_index' => $offset
]);
