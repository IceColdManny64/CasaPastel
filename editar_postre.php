<?php
require_once 'pwclass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id          = $_POST["id"]          ?? null;
    $titulo      = $_POST["titulo"]      ?? "";
    $descripcion = $_POST["descripcion"] ?? "";
    $precio      = $_POST["precio"]      ?? 0;
    $categoria   = $_POST["categoria"]   ?? "";
    $tamanio     = $_POST["tamanio"]     ?? "";
    $sabor       = $_POST["sabor"]       ?? "";
    $imagen      = $_POST["imagen_url"]  ?? "";
    $stock       = $_POST["stock"]       ?? 0;

    if ($id === null) {
        echo "ID de postre no proporcionado.";
        exit;
    }

    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare("UPDATE postresitos 
                            SET titulo = ?, descripcion = ?, precio = ?, categoria = ?, tamanio = ?, sabor = ?, imagen_url = ?, stock = ?
                            WHERE id = ?");
    $stmt->bind_param("ssdssssii", $titulo, $descripcion, $precio, $categoria, $tamanio, $sabor, $imagen, $stock, $id);

    if ($stmt->execute()) {
        echo "Postre actualizado correctamente.";
    } else {
        echo "Error al actualizar el postre.";
    }

    $stmt->close();
    $db->cerrar();
} else {
    echo "Acceso no permitido.";
}
?>
