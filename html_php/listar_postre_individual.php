<?php
require_once 'pwclass.php';
header('Content-Type: application/json; charset=UTF-8');

if (empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta el parámetro id']);
    exit;
}

$id = intval($_GET['id']);

try {
    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare("SELECT * FROM postresitos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Postre no encontrado']);
    } else {
        echo json_encode($res->fetch_assoc());
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar el postre']);
}
