<?php
require_once 'pwclass.php';
$db = new PWClass();
$conn = $db->obtenerConexion();

$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT id, correo, pass FROM usuarios WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($user);
