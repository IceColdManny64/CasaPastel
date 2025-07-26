<?php
require_once 'pwclass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo     = $_POST["titulo"]     ?? "";
    $descripcion= $_POST["descripcion"]?? "";
    $precio     = $_POST["precio"]     ?? 0;
    $categoria  = $_POST["categoria"]  ?? "";
    $tamanio    = $_POST["tamanio"]    ?? "";
    $sabor      = $_POST["sabor"]      ?? "";
    $imagen     = $_POST["imagen_url"] ?? "";
    $stock      = $_POST["stock"]      ?? 0;

    $db = new PWClass();
    $conn = $db->obtenerConexion();

    $stmt = $conn->prepare("INSERT INTO postresitos (titulo, descripcion, precio, categoria, tamanio, sabor, imagen_url, stock) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssssi", $titulo, $descripcion, $precio, $categoria, $tamanio, $sabor, $imagen, $stock);

    if ($stmt->execute()) {
        echo "Postre agregado correctamente.";
    } else {
        echo "Error al agregar postre.";
    }

    $stmt->close();
    $db->cerrar();
} else {
    echo "Acceso no permitido.";
}
?>
