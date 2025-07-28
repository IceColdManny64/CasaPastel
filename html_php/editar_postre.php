<?php
require_once 'pwclass.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$id          = intval($_POST['id'] ?? 0);
$titulo      = $_POST['titulo']      ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio      = floatval($_POST['precio'] ?? 0);
$categoria   = $_POST['categoria']   ?? '';
$tamanio     = $_POST['tamanio']     ?? '';
$sabor       = $_POST['sabor']       ?? '';
$imagen_url  = $_POST['imagen_url']  ?? '';
$stock       = intval($_POST['stock'] ?? 0);

if (!$id || !$titulo || !$descripcion) {
    echo "Faltan datos para actualizar.";
    exit;
}

try {
    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare(
        "UPDATE postresitos 
         SET titulo=?, descripcion=?, precio=?, categoria=?, tamanio=?, sabor=?, imagen_url=?, stock=?
         WHERE id=?"
    );
    $stmt->bind_param(
        "ssdssssii",
        $titulo,
        $descripcion,
        $precio,
        $categoria,
        $tamanio,
        $sabor,
        $imagen_url,
        $stock,
        $id
    );

    if ($stmt->execute()) {
        echo "Postre actualizado exitosamente.";
    } else {
        echo "Error al actualizar el postre.";
    }
} catch (Exception $e) {
    echo "Error en el servidor.";
}
