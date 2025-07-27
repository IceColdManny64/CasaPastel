<?php
require_once 'pwclass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? null;

    if ($id === null) {
        echo "ID no recibido.";
        exit;
    }

    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario.";
    }

    $stmt->close();
    $db->cerrar();
} else {
    echo "Acceso no autorizado.";
}
?>
