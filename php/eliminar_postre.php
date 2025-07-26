<?php
require_once 'pwclass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? null;

    if ($id === null) {
        echo "ID no proporcionado.";
        exit;
    }

    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare("DELETE FROM postresitos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Postre eliminado.";
    } else {
        echo "Error al eliminar postre.";
    }

    $stmt->close();
    $db->cerrar();
} else {
    echo "Acceso no permitido.";
}
?>
