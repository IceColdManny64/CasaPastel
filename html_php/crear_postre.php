<?php
require_once 'pwclass.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$titulo      = $_POST['titulo']      ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio      = floatval($_POST['precio'] ?? 0);
$categoria   = $_POST['categoria']   ?? '';
$tamanio     = $_POST['tamanio']     ?? '';
$sabor       = $_POST['sabor']       ?? '';
$imagen_url  = $_POST['imagen_url']  ?? '';
$stock       = intval($_POST['stock'] ?? 0);

if (!$titulo || !$descripcion) {
    echo "Faltan datos obligatorios.";
    exit;
}

try {
    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare(
        "INSERT INTO postresitos 
         (titulo, descripcion, precio, categoria, tamanio, sabor, imagen_url, stock) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssdssssi",
        $titulo,
        $descripcion,
        $precio,
        $categoria,
        $tamanio,
        $sabor,
        $imagen_url,
        $stock
    );

    if ($stmt->execute()) {
        echo "Postre creado exitosamente.";
    } else {
        echo "Error al crear el postre.";
    }
} catch (Exception $e) {
    echo "Error en el servidor.";
}
