<?php
require_once 'pwclass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id       = $_POST["id"]       ?? null;
    $nombre   = $_POST["nombre"]   ?? "";
    $edad     = $_POST["edad"]     ?? 0;
    $correo   = $_POST["correo"]   ?? "";
    $password = $_POST["password"] ?? "";

    if ($id === null) {
        echo "ID no proporcionado.";
        exit;
    }

    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, edad = ?, correo = ?, pass = ? WHERE id = ?");
    $stmt->bind_param("sissi", $nombre, $edad, $correo, $password, $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar usuario.";
    }

    $stmt->close();
    $db->cerrar();
} else {
    echo "Acceso no permitido.";
}
?>
