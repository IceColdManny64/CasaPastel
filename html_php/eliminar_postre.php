<?php
require_once 'pwclass.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$id = intval($_POST['id'] ?? 0);
if (!$id) {
    echo "ID inválido.";
    exit;
}

try {
    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare("DELETE FROM postresitos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Postre eliminado exitosamente.";
    } else {
        echo "Error al eliminar el postre.";
    }
} catch (Exception $e) {
    echo "Error en el servidor.";
}
