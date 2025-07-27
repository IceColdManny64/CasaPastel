<?php
require_once 'pwclass.php';

$db = new PWClass();
$conn = $db->obtenerConexion();

$sql = "SELECT id, correo, pass FROM usuarios";

$result = $conn->query($sql);

$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($usuarios);

$db->cerrar();
?>
