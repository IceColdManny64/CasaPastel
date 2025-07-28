<?php
require_once 'pwclass.php';
$db = new PWClass();
$conn = $db->obtenerConexion();

$res = $conn->query("SELECT id, correo, pass FROM usuarios");
$users = $res->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($users);
