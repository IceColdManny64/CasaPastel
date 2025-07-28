<?php
require_once 'pwclass.php';
header('Content-Type: application/json; charset=UTF-8');

try {
    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $sql = "SELECT * FROM postresitos";
    $result = $conn->query($sql);

    $postres = [];
    while ($row = $result->fetch_assoc()) {
        $postres[] = $row;
    }

    echo json_encode($postres);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al listar postres']);
}
